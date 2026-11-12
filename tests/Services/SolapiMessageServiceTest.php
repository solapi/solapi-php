<?php

namespace Nurigo\Solapi\Tests\Services;

use Nurigo\Solapi\Libraries\Fetcher;
use Nurigo\Solapi\Models\Response\GetBalanceResponse;
use Nurigo\Solapi\Models\Response\GetGroupMessagesResponse;
use Nurigo\Solapi\Models\Response\GetGroupsResponse;
use Nurigo\Solapi\Models\Response\GetMessagesResponse;
use Nurigo\Solapi\Models\Response\GetStatisticsResponse;
use Nurigo\Solapi\Models\Response\GroupCount;
use Nurigo\Solapi\Models\Response\GroupMessageResponse;
use Nurigo\Solapi\Models\Response\MessageType;
use Nurigo\Solapi\Models\Response\StatisticsMonthPeriod;
use Nurigo\Solapi\Services\SolapiMessageService;
use PHPUnit\Framework\TestCase;

class SolapiMessageServiceTest extends TestCase
{
    /** @var FakeHttpClient */
    private $http;

    /** @var SolapiMessageService */
    private $service;

    protected function setUp(): void
    {
        Fetcher::resetForTesting();
        $this->http = new FakeHttpClient();
        $this->service = new SolapiMessageService('TEST_KEY', 'TEST_SECRET', $this->http);
    }

    protected function tearDown(): void
    {
        Fetcher::resetForTesting();
    }

    // ---------- Regression: issue #26 (TypeError on get* methods) ----------

    /**
     * @return array<string, array{0:string,1:string,2:string,3:string,4:string}>
     */
    public function provideGetMethodsRegression(): array
    {
        return [
            'getBalance returns GetBalanceResponse, not stdClass' => [
                'getBalance',
                'GET',
                '/cash/v1/balance',
                '{"balance":1500.5,"point":200}',
                GetBalanceResponse::class,
            ],
            'getGroup returns GroupMessageResponse, not stdClass' => [
                'getGroup',
                'GET',
                '/messages/v4/groups/fast/G4V01',
                '{"groupId":"G4V01","status":"COMPLETE","accountId":"129"}',
                GroupMessageResponse::class,
            ],
            'getGroupMessages returns GetGroupMessagesResponse, not stdClass' => [
                'getGroupMessages',
                'GET',
                '/messages/v4/groups/fast/G4V01/messages',
                '{"limit":20,"messageList":{},"startKey":null,"nextKey":"abc"}',
                GetGroupMessagesResponse::class,
            ],
            'getStatistics returns GetStatisticsResponse, not stdClass' => [
                'getStatistics',
                'GET',
                '/messages/v4/statistics',
                '{"balance":1000,"point":100,"monthPeriod":[]}',
                GetStatisticsResponse::class,
            ],
        ];
    }

    /**
     * @dataProvider provideGetMethodsRegression
     */
    public function testGetMethodsReturnTypedResponseObjectAndNotStdClass(
        string $method,
        string $httpMethod,
        string $path,
        string $body,
        string $expectedClass
    ): void {
        $this->http->respondTo($httpMethod, $path, 200, $body);

        $arg = $method === 'getGroup' || $method === 'getGroupMessages' ? 'G4V01' : null;
        $result = $arg !== null ? $this->service->$method($arg) : $this->service->$method();

        $this->assertInstanceOf($expectedClass, $result);
    }

    // ---------- Success path: field mapping ----------

    public function testGetBalanceMapsBalanceAndPointFromApiResponse(): void
    {
        $this->http->respondTo('GET', '/cash/v1/balance', 200, '{"balance":1500.5,"point":200.25}');

        $response = $this->service->getBalance();

        $this->assertSame(1500.5, $response->balance);
        $this->assertSame(200.25, $response->point);
    }

    public function testGetGroupConvertsNestedCountIntoGroupCountInstance(): void
    {
        $body = json_encode([
            'groupId' => 'G4V01',
            'status' => 'COMPLETE',
            'count' => [
                'total' => 10,
                'registeredFailed' => 2,
                'registeredSuccess' => 8,
            ],
        ]);
        $this->http->respondTo('GET', '/messages/v4/groups/fast/G4V01', 200, $body);

        $response = $this->service->getGroup('G4V01');

        $this->assertInstanceOf(GroupCount::class, $response->count);
        $this->assertSame(10, $response->count->total);
        $this->assertSame(2, $response->count->registeredFailed);
        $this->assertSame(8, $response->count->registeredSuccess);
    }

    public function testGetStatisticsConvertsTotalIntoMessageTypeAndMonthPeriodArray(): void
    {
        $body = json_encode([
            'balance' => 1000,
            'point' => 100,
            'total' => ['total' => 50, 'sms' => 30, 'lms' => 20],
            'monthPeriod' => [
                ['date' => '2026-04', 'balance' => 100],
                ['date' => '2026-05', 'balance' => 200],
            ],
        ]);
        $this->http->respondTo('GET', '/messages/v4/statistics', 200, $body);

        $response = $this->service->getStatistics();

        $this->assertInstanceOf(MessageType::class, $response->total);
        $this->assertSame(50, $response->total->total);
        $this->assertSame(30, $response->total->sms);

        $this->assertIsArray($response->monthPeriod);
        $this->assertCount(2, $response->monthPeriod);
        $this->assertContainsOnlyInstancesOf(StatisticsMonthPeriod::class, $response->monthPeriod);
        $this->assertSame('2026-04', $response->monthPeriod[0]->date);
    }

    // ---------- Boundary: missing fields, null values, empty bodies ----------

    public function testGetBalanceHandlesMissingFieldsAsNull(): void
    {
        $this->http->respondTo('GET', '/cash/v1/balance', 200, '{}');

        $response = $this->service->getBalance();

        $this->assertInstanceOf(GetBalanceResponse::class, $response);
        $this->assertNull($response->balance);
        $this->assertNull($response->point);
    }

    public function testGetGroupHandlesMissingNestedObjectsAsNull(): void
    {
        $this->http->respondTo('GET', '/messages/v4/groups/fast/G4V01', 200, '{"groupId":"G4V01"}');

        $response = $this->service->getGroup('G4V01');

        $this->assertSame('G4V01', $response->groupId);
        $this->assertNull($response->count);
        $this->assertNull($response->countForCharge);
        $this->assertNull($response->balance);
        $this->assertNull($response->point);
    }

    public function testGetStatisticsHandlesMissingMonthPeriodAsNull(): void
    {
        $this->http->respondTo('GET', '/messages/v4/statistics', 200, '{}');

        $response = $this->service->getStatistics();

        $this->assertNull($response->monthPeriod);
        $this->assertNull($response->total);
    }

    public function testGetGroupsConvertsObjectShapedGroupListIntoArrayOfGroupMessageResponse(): void
    {
        // SOLAPI returns groupList as an object keyed by groupId, not as an array
        $body = json_encode([
            'limit' => 20,
            'groupList' => [
                'G4V01' => ['groupId' => 'G4V01', 'status' => 'COMPLETE'],
                'G4V02' => ['groupId' => 'G4V02', 'status' => 'PENDING'],
            ],
        ]);
        $this->http->respondTo('GET', '/messages/v4/groups', 200, $body);

        $response = $this->service->getGroups();

        $this->assertInstanceOf(GetGroupsResponse::class, $response);
        $this->assertIsArray($response->groupList);
        $this->assertCount(2, $response->groupList);
        $this->assertContainsOnlyInstancesOf(GroupMessageResponse::class, $response->groupList);
    }

    public function testGetMessagesNormalizesObjectShapedMessageListAndPreservesResponseFields(): void
    {
        $body = json_encode([
            'limit' => 20,
            'messageList' => [
                'M4V01' => ['messageId' => 'M4V01', 'statusCode' => '2000'],
                'M4V02' => ['messageId' => 'M4V02', 'statusCode' => '4000'],
            ],
        ]);
        $this->http->respondTo('GET', '/messages/v4/list', 200, $body);

        $response = $this->service->getMessages();

        $this->assertInstanceOf(GetMessagesResponse::class, $response);
        $this->assertIsArray($response->messageList);
        $this->assertCount(2, $response->messageList);
        $this->assertSame('M4V01', $response->messageList[0]->messageId);
        $this->assertSame('4000', $response->messageList[1]->statusCode);
    }

    // ---------- Failure path: get* methods swallow exceptions and return null ----------

    /**
     * @return array<string, array{0:string,1:string,2:int,3:string}>
     */
    public function provideHttpErrors(): array
    {
        return [
            'getBalance 4xx returns null'   => ['getBalance', '/cash/v1/balance', 400, '{"errorCode":"E400","errorMessage":"bad"}'],
            'getBalance 5xx returns null'   => ['getBalance', '/cash/v1/balance', 500, ''],
            'getGroup 404 returns null'     => ['getGroup', '/messages/v4/groups/fast/G4V01', 404, '{"errorCode":"NotFound","errorMessage":"missing"}'],
            'getGroupMessages 4xx null'     => ['getGroupMessages', '/messages/v4/groups/fast/G4V01/messages', 401, '{"errorCode":"Unauthorized","errorMessage":"x"}'],
            'getStatistics 5xx null'        => ['getStatistics', '/messages/v4/statistics', 502, ''],
            'getMessages 4xx null'          => ['getMessages', '/messages/v4/list', 403, '{"errorCode":"Forbidden","errorMessage":"x"}'],
            'getGroups 5xx null'            => ['getGroups', '/messages/v4/groups', 500, ''],
        ];
    }

    /**
     * @dataProvider provideHttpErrors
     */
    public function testGetMethodsReturnNullOnHttpError(
        string $method,
        string $path,
        int $status,
        string $body
    ): void {
        $this->http->respondTo('GET', $path, $status, $body);

        $arg = $method === 'getGroup' || $method === 'getGroupMessages' ? 'G4V01' : null;
        $result = $arg !== null ? $this->service->$method($arg) : $this->service->$method();

        $this->assertNull($result);
    }

    public function testGetStatisticsReturnsNullWhenBodyIsNotJson(): void
    {
        // 200 OK with a non-JSON body causes Fetcher to return null
        // (json_decode failure), which the service guards by returning null
        // instead of constructing a Response object with all-null fields.
        $this->http->respondTo('GET', '/messages/v4/statistics', 200, 'not json');

        $result = $this->service->getStatistics();

        $this->assertNull($result);
    }

    public function testGetBalanceReturnsNullForEmptyServerErrorBodyWithoutPhpWarning(): void
    {
        $errors = [];
        set_error_handler(static function ($severity, $message) use (&$errors) {
            $errors[] = $message;
            return true;
        });

        try {
            $this->http->respondTo('GET', '/cash/v1/balance', 500, '');

            $result = $this->service->getBalance();
        } finally {
            restore_error_handler();
        }

        $this->assertNull($result);
        $this->assertSame([], $errors);
    }

    public function testGetBalanceReturnsNullWhenHttpClientThrows(): void
    {
        $this->http->throwOnceOnNextRequest(new class extends \RuntimeException implements \Psr\Http\Client\ClientExceptionInterface {});

        $result = $this->service->getBalance();

        $this->assertNull($result);
    }

    // ---------- Regression: send() must not NPE when groupInfo is missing ----------

    public function testSendDoesNotThrowWhenApiResponseOmitsGroupInfo(): void
    {
        $message = new \Nurigo\Solapi\Models\Message();
        $message->setTo('01000000000')->setFrom('01087654321')->setText('hi');

        $this->http->respondTo(
            'POST',
            '/messages/v4/send-many/fast',
            200,
            '{"failedMessageList":[]}'
        );

        $response = $this->service->send($message);

        $this->assertInstanceOf(\Nurigo\Solapi\Models\Response\SendResponse::class, $response);
        $this->assertNull($response->groupInfo);
        $this->assertSame([], $response->failedMessageList);
    }

    public function testSendThrowsMessageNotReceivedExceptionOnlyWhenAllRegistrationsFailed(): void
    {
        $message = new \Nurigo\Solapi\Models\Message();
        $message->setTo('01000000000')->setFrom('01087654321')->setText('hi');

        $body = json_encode([
            'groupInfo' => [
                'groupId' => 'G4V01',
                'count' => ['total' => 1, 'registeredFailed' => 1, 'registeredSuccess' => 0],
            ],
            'failedMessageList' => [
                ['to' => '01000000000', 'statusCode' => 'N000'],
            ],
        ]);
        $this->http->respondTo('POST', '/messages/v4/send-many/fast', 200, $body);

        $this->expectException(\Nurigo\Solapi\Exceptions\MessageNotReceivedException::class);

        $this->service->send($message);
    }

    // ---------- Side-effect verification: SDK actually issues the documented request ----------

    public function testGetBalanceIssuesGetRequestToCashBalanceEndpoint(): void
    {
        $this->http->respondTo('GET', '/cash/v1/balance', 200, '{"balance":0,"point":0}');

        $this->service->getBalance();

        $this->assertCount(1, $this->http->receivedRequests);
        $req = $this->http->receivedRequests[0];
        $this->assertSame('GET', $req->getMethod());
        $this->assertSame('/cash/v1/balance', $req->getUri()->getPath());
        $this->assertNotEmpty($req->getHeaderLine('Authorization'));
    }

    public function testGetGroupMessagesAppendsGroupIdToPath(): void
    {
        $this->http->respondTo('GET', '/messages/v4/groups/fast/G4V123/messages', 200, '{"limit":20,"messageList":{}}');

        $this->service->getGroupMessages('G4V123');

        $this->assertCount(1, $this->http->receivedRequests);
        $this->assertSame(
            '/messages/v4/groups/fast/G4V123/messages',
            $this->http->receivedRequests[0]->getUri()->getPath()
        );
    }

    // ---------- Idempotency: repeated calls return equivalent results ----------

    public function testGetBalanceIsIdempotentWhenApiResponseUnchanged(): void
    {
        $this->http->respondTo('GET', '/cash/v1/balance', 200, '{"balance":1000,"point":50}');

        $a = $this->service->getBalance();
        $this->http->respondTo('GET', '/cash/v1/balance', 200, '{"balance":1000,"point":50}');
        $b = $this->service->getBalance();

        $this->assertEquals($a, $b);
        $this->assertNotSame($a, $b, 'Each call should return a fresh instance');
    }

    // ---------- Fast intake routing: send / getGroup / getGroupMessages use the fast endpoints ----------

    private function fastSendResponseBody(): string
    {
        return file_get_contents(__DIR__ . '/../assets/fast-send-response.json');
    }

    public function testSendIssuesPostToSendManyFastEndpoint(): void
    {
        $message = new \Nurigo\Solapi\Models\Message();
        $message->setTo('01000000000')->setFrom('01087654321')->setText('hi');
        $this->http->respondTo('POST', '/messages/v4/send-many/fast', 200, $this->fastSendResponseBody());

        $this->service->send($message);

        $this->assertCount(1, $this->http->receivedRequests);
        $req = $this->http->receivedRequests[0];
        $this->assertSame('POST', $req->getMethod());
        $this->assertSame('/messages/v4/send-many/fast', $req->getUri()->getPath());
        $this->assertSame('', $req->getUri()->getQuery());
        $body = json_decode((string) $req->getBody(), true);
        $this->assertSame('01000000000', $body['messages'][0]['to']);
    }

    public function testSendDecodesFastResponseWithoutCtaCtiAndReportsSendRequested(): void
    {
        $message = new \Nurigo\Solapi\Models\Message();
        $message->setTo('01000000000')->setFrom('01087654321')->setText('hi');
        $this->http->respondTo('POST', '/messages/v4/send-many/fast', 200, $this->fastSendResponseBody());

        $errors = [];
        set_error_handler(static function ($severity, $message) use (&$errors) {
            $errors[] = $message;
            return true;
        });
        try {
            $response = $this->service->send($message);
        } finally {
            restore_error_handler();
        }

        $this->assertSame([], $errors);
        $this->assertSame('SEND-REQUESTED', $response->groupInfo->status);
        $this->assertSame(1, $response->groupInfo->count->sentPending);
        $this->assertSame([], get_object_vars($response->groupInfo->countForCharge->cta));
        $this->assertSame([], get_object_vars($response->groupInfo->countForCharge->cti));
        $this->assertSame(0, $response->groupInfo->app->profit->cta);
        $this->assertSame(0, $response->groupInfo->app->profit->cti);
        $this->assertSame([], $response->failedMessageList);
    }

    public function testSendDoesNotFallBackToDetailEndpointWhenFastEndpointFails(): void
    {
        $message = new \Nurigo\Solapi\Models\Message();
        $message->setTo('01000000000')->setFrom('01087654321')->setText('hi');
        $this->http->respondTo('POST', '/messages/v4/send-many/detail', 200, $this->fastSendResponseBody());
        $this->http->respondTo('POST', '/messages/v4/send-many/fast', 400, '{"errorCode":"ValidationError","errorMessage":"bad"}');

        try {
            $this->service->send($message);
            $this->fail('send() must surface the fast endpoint error');
        } catch (\Nurigo\Solapi\Exceptions\BaseException $e) {
            $this->assertSame('ValidationError', $e->errorCode);
        }

        $this->assertCount(1, $this->http->receivedRequests);
        $this->assertSame('/messages/v4/send-many/fast', $this->http->receivedRequests[0]->getUri()->getPath());
    }

    public function testGetGroupIssuesGetToFastGroupEndpoint(): void
    {
        $groupId = 'G4V20260101000000TESTGROUP00000';
        $groupBody = json_encode(json_decode($this->fastSendResponseBody())->groupInfo);
        $this->http->respondTo('GET', "/messages/v4/groups/fast/$groupId", 200, $groupBody);

        $response = $this->service->getGroup($groupId);

        $this->assertCount(1, $this->http->receivedRequests);
        $req = $this->http->receivedRequests[0];
        $this->assertSame('GET', $req->getMethod());
        $this->assertSame("/messages/v4/groups/fast/$groupId", $req->getUri()->getPath());
        $this->assertSame('', $req->getUri()->getQuery());
        $this->assertSame('SEND-REQUESTED', $response->status);
        $this->assertSame([], get_object_vars($response->countForCharge->cta));
        $this->assertSame(0, $response->app->profit->cti);
    }

    public function testGetGroupReturnsNullForNonExistentGroupOnFastEndpoint(): void
    {
        $this->http->respondTo(
            'GET',
            '/messages/v4/groups/fast/G4VNOPE',
            404,
            '{"errorCode":"ResourceNotFound","errorMessage":"리소스를 찾을 수 없습니다."}'
        );

        $this->assertNull($this->service->getGroup('G4VNOPE'));
        $this->assertSame('/messages/v4/groups/fast/G4VNOPE', $this->http->receivedRequests[0]->getUri()->getPath());
    }

    public function testGetGroupMessagesIssuesGetToFastGroupMessagesEndpointWithUnchangedQuery(): void
    {
        $this->http->respondTo('GET', '/messages/v4/groups/fast/G4V123/messages', 200, '{"limit":2,"messageList":{},"startKey":"M4V01","nextKey":null}');
        $parameter = new \Nurigo\Solapi\Models\Request\GetGroupMessagesRequest();
        $parameter->setStartKey('M4V01')->setLimit(2);

        $response = $this->service->getGroupMessages('G4V123', $parameter);

        $this->assertCount(1, $this->http->receivedRequests);
        $req = $this->http->receivedRequests[0];
        $this->assertSame('GET', $req->getMethod());
        $this->assertSame('/messages/v4/groups/fast/G4V123/messages', $req->getUri()->getPath());
        parse_str($req->getUri()->getQuery(), $query);
        $this->assertSame(['startKey' => 'M4V01', 'limit' => '2'], $query);
        $this->assertSame(2, $response->limit);
        $this->assertSame('M4V01', $response->startKey);
    }

    public function testGetGroupMessagesReturnsEmptyListForNonExistentGroupOnFastEndpoint(): void
    {
        $this->http->respondTo('GET', '/messages/v4/groups/fast/G4VNOPE/messages', 200, '{"startKey":null,"limit":20,"messageList":{}}');

        $response = $this->service->getGroupMessages('G4VNOPE');

        $this->assertInstanceOf(GetGroupMessagesResponse::class, $response);
        $this->assertSame([], $response->messageList);
    }

    public function testGetGroupMessagesExposesCustomFieldsOnFastItems(): void
    {
        $body = json_encode([
            'limit' => 20,
            'messageList' => [
                'M4V01' => ['messageId' => 'M4V01', 'statusCode' => '2000', 'customFields' => ['orderId' => '42']],
            ],
        ]);
        $this->http->respondTo('GET', '/messages/v4/groups/fast/G4V123/messages', 200, $body);

        $response = $this->service->getGroupMessages('G4V123');

        $this->assertCount(1, $response->messageList);
        $this->assertSame('42', $response->messageList[0]->customFields->orderId);
    }

    public function testGetMessagesAndStatisticsStillUseLegacyEndpoints(): void
    {
        $this->http->respondTo('GET', '/messages/v4/list', 200, '{"limit":20,"messageList":{}}');
        $this->http->respondTo('GET', '/messages/v4/groups', 200, '{"limit":20,"groupList":{}}');
        $this->http->respondTo('GET', '/messages/v4/statistics', 200, '{"balance":0,"point":0}');

        $this->service->getMessages();
        $this->service->getGroups();
        $this->service->getStatistics();

        $paths = array_map(static function ($req) {
            return $req->getUri()->getPath();
        }, $this->http->receivedRequests);
        $this->assertSame(['/messages/v4/list', '/messages/v4/groups', '/messages/v4/statistics'], $paths);
    }
}
