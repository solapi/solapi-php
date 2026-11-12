<?php

namespace Nurigo\Solapi\Tests\Models\Response;

use Nurigo\Solapi\Models\Response\CommonCashResponse;
use Nurigo\Solapi\Models\Response\ErrorResponse;
use Nurigo\Solapi\Models\Response\FailedMessage;
use Nurigo\Solapi\Models\Response\GetBalanceResponse;
use Nurigo\Solapi\Models\Response\GetGroupMessagesResponse;
use Nurigo\Solapi\Models\Response\GetGroupsResponse;
use Nurigo\Solapi\Models\Response\GetMessagesResponse;
use Nurigo\Solapi\Models\Response\GetStatisticsResponse;
use Nurigo\Solapi\Models\Response\GroupCount;
use Nurigo\Solapi\Models\Response\GroupCountForCharge;
use Nurigo\Solapi\Models\Response\GroupMessageResponse;
use Nurigo\Solapi\Models\Response\MessageType;
use Nurigo\Solapi\Models\Response\SendResponse;
use Nurigo\Solapi\Models\Response\StatisticsDayPeriod;
use Nurigo\Solapi\Models\Response\StatisticsMonthPeriod;
use Nurigo\Solapi\Models\Response\UploadFileResponse;
use PHPUnit\Framework\TestCase;
use stdClass;

class ResponseConstructorTest extends TestCase
{
    private function obj(array $data): stdClass
    {
        // Cast to object first so an empty array still becomes an empty stdClass
        // (json_decode of "[]" would otherwise produce an array, not a stdClass).
        return json_decode(json_encode((object) $data));
    }

    // ---------- Flat leaf classes: map fields from stdClass with null fallback ----------

    public function testGroupCountMapsAllFieldsAndFallsBackToNull(): void
    {
        $c = new GroupCount($this->obj([
            'total' => 10, 'sendTotal' => 9, 'sentFailed' => 1, 'sentSuccess' => 8,
            'sentPending' => 0, 'sentReplacement' => 0, 'refund' => 0,
            'registeredFailed' => 2, 'registeredSuccess' => 8,
        ]));

        $this->assertSame(10, $c->total);
        $this->assertSame(8, $c->registeredSuccess);

        $empty = new GroupCount($this->obj([]));
        $this->assertNull($empty->total);
        $this->assertNull($empty->registeredSuccess);
    }

    public function testCommonCashResponseMapsCashFields(): void
    {
        $c = new CommonCashResponse($this->obj(['requested' => 100, 'replacement' => 5, 'refund' => 0, 'sum' => 105]));
        $this->assertSame(100, $c->requested);
        $this->assertSame(105, $c->sum);
    }

    public function testMessageTypeMapsAllMessageCategoryCounts(): void
    {
        $m = new MessageType($this->obj([
            'total' => 100, 'sms' => 50, 'lms' => 30, 'mms' => 5,
            'ata' => 10, 'cta' => 5, 'cti' => 0, 'nsa' => 0,
            'rcs_sms' => 0, 'rcs_lms' => 0, 'rcs_mms' => 0, 'rcs_tpl' => 0,
        ]));
        $this->assertSame(100, $m->total);
        $this->assertSame(50, $m->sms);
        $this->assertSame(30, $m->lms);
    }

    public function testFailedMessageMapsFieldsAndFallsBackToNullWhenMissing(): void
    {
        $f = new FailedMessage($this->obj(['to' => '01012345678', 'from' => '01087654321']));
        $this->assertSame('01012345678', $f->to);
        $this->assertSame('01087654321', $f->from);
        $this->assertNull($f->statusCode);
        $this->assertNull($f->accountId);
    }

    public function testErrorResponseMapsMissingFieldsToNull(): void
    {
        $e = new ErrorResponse($this->obj([]));

        $this->assertNull($e->errorCode);
        $this->assertNull($e->errorMessage);
    }

    public function testUploadFileResponseMapsMissingFieldsToNull(): void
    {
        $u = new UploadFileResponse($this->obj(['fileId' => 'FILE123']));

        $this->assertSame('FILE123', $u->fileId);
        $this->assertNull($u->type);
        $this->assertNull($u->dateUpdated);
    }

    /**
     * @return array<string, array{0:string}>
     */
    public function providePublicResponseClasses(): array
    {
        return [
            'CommonCashResponse' => [CommonCashResponse::class],
            'ErrorResponse' => [ErrorResponse::class],
            'FailedMessage' => [FailedMessage::class],
            'GetBalanceResponse' => [GetBalanceResponse::class],
            'GetGroupMessagesResponse' => [GetGroupMessagesResponse::class],
            'GetGroupsResponse' => [GetGroupsResponse::class],
            'GetMessagesResponse' => [GetMessagesResponse::class],
            'GetStatisticsResponse' => [GetStatisticsResponse::class],
            'GroupCount' => [GroupCount::class],
            'GroupCountForCharge' => [GroupCountForCharge::class],
            'GroupMessageResponse' => [GroupMessageResponse::class],
            'MessageType' => [MessageType::class],
            'SendResponse' => [SendResponse::class],
            'StatisticsDayPeriod' => [StatisticsDayPeriod::class],
            'StatisticsMonthPeriod' => [StatisticsMonthPeriod::class],
            'UploadFileResponse' => [UploadFileResponse::class],
        ];
    }

    /**
     * @dataProvider providePublicResponseClasses
     */
    public function testPublicResponseClassesRemainDefaultConstructible(string $class): void
    {
        $response = new $class();

        $this->assertInstanceOf($class, $response);
        if ($response instanceof SendResponse) {
            $this->assertSame([], $response->failedMessageList);
        }
    }

    public function testGroupCountForChargeMapsObjectFieldsAndKeepsStdClass(): void
    {
        $g = new GroupCountForCharge($this->obj([
            'sms' => ['requested' => 10],
            'lms' => ['requested' => 5],
        ]));
        $this->assertNotNull($g->sms);
        $this->assertNotNull($g->lms);
        $this->assertNull($g->mms);
    }

    // ---------- GetBalanceResponse ----------

    public function testGetBalanceResponseMapsBalanceAndPointWithNullFallback(): void
    {
        $r = new GetBalanceResponse($this->obj(['balance' => 1500.5, 'point' => 200.25]));
        $this->assertSame(1500.5, $r->balance);
        $this->assertSame(200.25, $r->point);

        $empty = new GetBalanceResponse($this->obj([]));
        $this->assertNull($empty->balance);
        $this->assertNull($empty->point);
    }

    // ---------- GroupMessageResponse: nested object conversion ----------

    public function testGroupMessageResponseConvertsCountIntoGroupCountInstance(): void
    {
        $r = new GroupMessageResponse($this->obj([
            'groupId' => 'G4V01',
            'count' => ['total' => 10, 'registeredFailed' => 2],
        ]));

        $this->assertSame('G4V01', $r->groupId);
        $this->assertInstanceOf(GroupCount::class, $r->count);
        $this->assertSame(10, $r->count->total);
    }

    public function testGroupMessageResponseConvertsBalanceAndPointIntoCommonCashResponse(): void
    {
        $r = new GroupMessageResponse($this->obj([
            'balance' => ['requested' => 100, 'sum' => 100],
            'point' => ['requested' => 10, 'sum' => 10],
        ]));

        $this->assertInstanceOf(CommonCashResponse::class, $r->balance);
        $this->assertInstanceOf(CommonCashResponse::class, $r->point);
        $this->assertSame(100, $r->balance->requested);
    }

    public function testGroupMessageResponseLeavesAllNestedFieldsNullWhenMissing(): void
    {
        $r = new GroupMessageResponse($this->obj([]));

        $this->assertNull($r->count);
        $this->assertNull($r->countForCharge);
        $this->assertNull($r->balance);
        $this->assertNull($r->point);
        $this->assertNull($r->groupId);
        $this->assertNull($r->allowDuplicates);
    }

    // ---------- GetStatisticsResponse: array<StatisticsMonthPeriod> conversion ----------

    public function testGetStatisticsResponseConvertsMonthPeriodArrayElements(): void
    {
        $r = new GetStatisticsResponse($this->obj([
            'balance' => 1000,
            'monthPeriod' => [
                ['date' => '2026-04'],
                ['date' => '2026-05'],
            ],
            'total' => ['total' => 100, 'sms' => 50],
        ]));

        $this->assertIsArray($r->monthPeriod);
        $this->assertCount(2, $r->monthPeriod);
        $this->assertContainsOnlyInstancesOf(StatisticsMonthPeriod::class, $r->monthPeriod);
        $this->assertSame('2026-04', $r->monthPeriod[0]->date);

        $this->assertInstanceOf(MessageType::class, $r->total);
        $this->assertSame(100, $r->total->total);
    }

    public function testGetStatisticsResponseAcceptsEmptyMonthPeriodArray(): void
    {
        $r = new GetStatisticsResponse($this->obj(['monthPeriod' => []]));

        $this->assertIsArray($r->monthPeriod);
        $this->assertSame([], $r->monthPeriod);
    }

    public function testGetStatisticsResponseLeavesMonthPeriodNullWhenAbsent(): void
    {
        $r = new GetStatisticsResponse($this->obj([]));
        $this->assertNull($r->monthPeriod);
        $this->assertNull($r->total);
    }

    // ---------- StatisticsMonthPeriod and StatisticsDayPeriod ----------

    public function testStatisticsMonthPeriodConvertsDayPeriodIntoStatisticsDayPeriodArray(): void
    {
        $p = new StatisticsMonthPeriod($this->obj([
            'date' => '2026-05',
            'dayPeriod' => [
                ['month' => '2026-05-01'],
                ['month' => '2026-05-02'],
            ],
        ]));

        $this->assertIsArray($p->dayPeriod);
        $this->assertCount(2, $p->dayPeriod);
        $this->assertContainsOnlyInstancesOf(StatisticsDayPeriod::class, $p->dayPeriod);
    }

    public function testStatisticsDayPeriodConvertsStatusCodeArrayIntoMessageTypeInstances(): void
    {
        $d = new StatisticsDayPeriod($this->obj([
            'month' => '2026-05-01',
            'statusCode' => [
                ['total' => 10],
                ['total' => 20],
            ],
            'total' => ['total' => 30],
        ]));

        $this->assertIsArray($d->statusCode);
        $this->assertCount(2, $d->statusCode);
        $this->assertContainsOnlyInstancesOf(MessageType::class, $d->statusCode);
        $this->assertSame(10, $d->statusCode[0]->total);
        $this->assertInstanceOf(MessageType::class, $d->total);
    }

    // ---------- GetGroupsResponse: object-shaped groupList ----------

    public function testGetGroupsResponseHandlesObjectKeyedGroupList(): void
    {
        $r = new GetGroupsResponse($this->obj([
            'limit' => 20,
            'groupList' => [
                'G4V01' => ['groupId' => 'G4V01'],
                'G4V02' => ['groupId' => 'G4V02'],
            ],
        ]));

        $this->assertIsArray($r->groupList);
        $this->assertCount(2, $r->groupList);
        $this->assertContainsOnlyInstancesOf(GroupMessageResponse::class, $r->groupList);
        $this->assertSame('G4V01', $r->groupList[0]->groupId);
        $this->assertSame('G4V02', $r->groupList[1]->groupId);
    }

    public function testGetGroupsResponseHandlesArrayShapedGroupList(): void
    {
        // Explicit JSON-array input path (vs object-keyed input)
        $value = new stdClass();
        $value->limit = 20;
        $value->groupList = [
            $this->obj(['groupId' => 'G4V01']),
            $this->obj(['groupId' => 'G4V02']),
        ];

        $r = new GetGroupsResponse($value);

        $this->assertCount(2, $r->groupList);
        $this->assertContainsOnlyInstancesOf(GroupMessageResponse::class, $r->groupList);
    }

    public function testGetGroupsResponseLeavesGroupListNullWhenAbsent(): void
    {
        $r = new GetGroupsResponse($this->obj([]));
        $this->assertNull($r->groupList);
    }

    // ---------- Message list responses: normalize object-keyed lists without losing fields ----------

    public function testGetMessagesResponseNormalizesObjectKeyedMessageList(): void
    {
        $r = new GetMessagesResponse($this->obj([
            'messageList' => [
                'M4V01' => ['messageId' => 'M4V01', 'statusCode' => '2000'],
                'M4V02' => ['messageId' => 'M4V02', 'statusCode' => '4000'],
            ],
        ]));

        $this->assertIsArray($r->messageList);
        $this->assertCount(2, $r->messageList);
        $this->assertSame('M4V01', $r->messageList[0]->messageId);
        $this->assertSame('2000', $r->messageList[0]->statusCode);
        $this->assertSame('M4V02', $r->messageList[1]->messageId);
    }

    public function testGetGroupMessagesResponseNormalizesArrayShapedMessageList(): void
    {
        $value = new stdClass();
        $value->messageList = [
            $this->obj(['messageId' => 'M4V01', 'statusCode' => '2000']),
            $this->obj(['messageId' => 'M4V02', 'statusCode' => '4000']),
        ];

        $r = new GetGroupMessagesResponse($value);

        $this->assertIsArray($r->messageList);
        $this->assertCount(2, $r->messageList);
        $this->assertSame('M4V01', $r->messageList[0]->messageId);
        $this->assertSame('4000', $r->messageList[1]->statusCode);
    }

    // ---------- SendResponse: groupInfo + failedMessageList conversion ----------

    public function testSendResponseConvertsGroupInfoAndFailedMessageList(): void
    {
        $r = new SendResponse($this->obj([
            'groupInfo' => [
                'groupId' => 'G4V01',
                'count' => ['total' => 1, 'registeredFailed' => 0],
            ],
            'failedMessageList' => [
                ['to' => '01000000000', 'statusCode' => 'N000'],
            ],
        ]));

        $this->assertInstanceOf(GroupMessageResponse::class, $r->groupInfo);
        $this->assertInstanceOf(GroupCount::class, $r->groupInfo->count);
        $this->assertSame(1, $r->groupInfo->count->total);

        $this->assertIsArray($r->failedMessageList);
        $this->assertCount(1, $r->failedMessageList);
        $this->assertContainsOnlyInstancesOf(FailedMessage::class, $r->failedMessageList);
        $this->assertSame('01000000000', $r->failedMessageList[0]->to);
    }

    public function testSendResponseDefaultsFailedMessageListToEmptyArray(): void
    {
        $r = new SendResponse($this->obj(['groupInfo' => ['groupId' => 'G4V01']]));

        $this->assertSame([], $r->failedMessageList);
        $this->assertInstanceOf(GroupMessageResponse::class, $r->groupInfo);
    }

    public function testSendResponseJsonSerializeRoundTrip(): void
    {
        $r = new SendResponse($this->obj([
            'groupInfo' => ['groupId' => 'G4V01'],
            'failedMessageList' => [],
        ]));

        $json = json_encode($r);
        $this->assertJson($json);
        $decoded = json_decode($json, true);
        $this->assertArrayHasKey('groupInfo', $decoded);
        $this->assertArrayHasKey('failedMessageList', $decoded);
    }

    // ---------- Fast intake (send-many/fast, groups/fast): deprecated cta/cti keys are absent ----------

    private function fastSendResponseFixture(): stdClass
    {
        return json_decode(file_get_contents(__DIR__ . '/../../assets/fast-send-response.json'));
    }

    public function testGroupCountForChargeDefaultsAbsentCtaCtiToEmptyObject(): void
    {
        $g = new GroupCountForCharge($this->obj(['sms' => ['82' => 1], 'lms' => []]));

        $this->assertInstanceOf(stdClass::class, $g->cta);
        $this->assertInstanceOf(stdClass::class, $g->cti);
        $this->assertSame([], get_object_vars($g->cta));
        $this->assertSame([], get_object_vars($g->cti));
    }

    public function testGroupCountForChargeKeepsCtaCtiWhenServerReturnsThem(): void
    {
        $g = new GroupCountForCharge($this->obj(['cta' => ['82' => 3], 'cti' => ['82' => 2]]));

        $this->assertSame(3, $g->cta->{'82'});
        $this->assertSame(2, $g->cti->{'82'});
    }

    public function testGroupCountForChargeDefaultsCtaCtiEvenWhenValueIsEmptyObject(): void
    {
        $g = new GroupCountForCharge($this->obj([]));

        $this->assertSame([], get_object_vars($g->cta));
        $this->assertSame([], get_object_vars($g->cti));
        $this->assertNull($g->sms);
    }

    public function testGroupMessageResponseDefaultsAbsentAppProfitCtaCtiToZero(): void
    {
        $r = new GroupMessageResponse($this->obj([
            'app' => ['profit' => ['sms' => 0, 'lms' => 0], 'appId' => null, 'version' => null],
        ]));

        $this->assertSame(0, $r->app->profit->cta);
        $this->assertSame(0, $r->app->profit->cti);
        $this->assertSame(0, $r->app->profit->sms);
        $this->assertNull($r->app->appId);
    }

    public function testGroupMessageResponseKeepsAppProfitCtaCtiWhenPresent(): void
    {
        $r = new GroupMessageResponse($this->obj([
            'app' => ['profit' => ['sms' => 0, 'cta' => 7, 'cti' => 9]],
        ]));

        $this->assertSame(7, $r->app->profit->cta);
        $this->assertSame(9, $r->app->profit->cti);
    }

    /**
     * @return array<string, array{0:array}>
     */
    public function provideAppShapesWithoutProfitObject(): array
    {
        return [
            'app absent' => [[]],
            'app null' => [['app' => null]],
            'app without profit' => [['app' => ['appId' => 'A1', 'version' => null]]],
            'profit null' => [['app' => ['profit' => null]]],
            'profit scalar' => [['app' => ['profit' => 5]]],
        ];
    }

    /**
     * @dataProvider provideAppShapesWithoutProfitObject
     */
    public function testGroupMessageResponseLeavesAppUntouchedWhenProfitIsNotAnObject(array $data): void
    {
        $errors = [];
        set_error_handler(static function ($severity, $message) use (&$errors) {
            $errors[] = $message;
            return true;
        });

        try {
            $r = new GroupMessageResponse($this->obj($data));
        } finally {
            restore_error_handler();
        }

        $this->assertSame([], $errors);
        $expected = $this->obj($data);
        $this->assertEquals($expected->app ?? null, $r->app);
    }

    public function testSendResponseDecodesFastSendFixtureWithoutPhpNotices(): void
    {
        $errors = [];
        set_error_handler(static function ($severity, $message) use (&$errors) {
            $errors[] = $message;
            return true;
        });

        try {
            $r = new SendResponse($this->fastSendResponseFixture());
        } finally {
            restore_error_handler();
        }

        $this->assertSame([], $errors);
        $this->assertSame('SEND-REQUESTED', $r->groupInfo->status);
        $this->assertSame('G4V20260101000000TESTGROUP00000', $r->groupInfo->groupId);
        $this->assertSame(1, $r->groupInfo->count->sentPending);
        $this->assertSame([], $r->failedMessageList);
    }

    public function testSendResponseFillsFastSendDefaultsForDeprecatedCtaCti(): void
    {
        $r = new SendResponse($this->fastSendResponseFixture());

        $this->assertSame([], get_object_vars($r->groupInfo->countForCharge->cta));
        $this->assertSame([], get_object_vars($r->groupInfo->countForCharge->cti));
        $this->assertSame(1, $r->groupInfo->countForCharge->sms->{'82'});
        $this->assertSame(0, $r->groupInfo->app->profit->cta);
        $this->assertSame(0, $r->groupInfo->app->profit->cti);
    }

    public function testSendResponseJsonSerializeIncludesDefaultedCtaCtiKeys(): void
    {
        $decoded = json_decode(json_encode(new SendResponse($this->fastSendResponseFixture())), true);

        $this->assertSame([], $decoded['groupInfo']['countForCharge']['cta']);
        $this->assertSame([], $decoded['groupInfo']['countForCharge']['cti']);
        $this->assertSame(0, $decoded['groupInfo']['app']['profit']['cta']);
        $this->assertSame(0, $decoded['groupInfo']['app']['profit']['cti']);
    }

    // ---------- GroupCount: server key is sentTotal, SDK property is sendTotal ----------

    /**
     * @return array<string, array{0:array,1:?int}>
     */
    public function provideSentTotalKeyVariants(): array
    {
        return [
            'server sentTotal lands in sendTotal' => [['sentTotal' => 7], 7],
            'legacy sendTotal still accepted' => [['sendTotal' => 4], 4],
            'sentTotal wins over sendTotal when both present' => [['sentTotal' => 7, 'sendTotal' => 4], 7],
            'sentTotal zero is kept as zero' => [['sentTotal' => 0], 0],
            'neither key gives null' => [['total' => 1], null],
        ];
    }

    /**
     * @dataProvider provideSentTotalKeyVariants
     */
    public function testGroupCountPopulatesSendTotalFromServerSentTotalKey(array $data, ?int $expected): void
    {
        $c = new GroupCount($this->obj($data));

        $this->assertSame($expected, $c->sendTotal);
    }

    public function testSendResponseFixtureSentTotalReachesGroupCountSendTotal(): void
    {
        $r = new SendResponse($this->fastSendResponseFixture());

        $this->assertSame(0, $r->groupInfo->count->sendTotal);
    }
}
