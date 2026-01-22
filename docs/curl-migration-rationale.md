# CURL에서 PSR-18 HTTP 클라이언트로의 마이그레이션

## 개요

SOLAPI PHP SDK v5.1.0부터 HTTP 클라이언트가 raw CURL에서 PSR-18 호환 구현으로 변경되었습니다.

## 기존 CURL 구현의 문제점

### 1. 보안 취약점: SSL 인증서 검증 비활성화

```php
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
```

- MITM 공격에 취약
- PCI-DSS, SOC2 등 보안 규정 위반 가능성

### 2. 타임아웃 설정 부재

- `CURLOPT_TIMEOUT`, `CURLOPT_CONNECTTIMEOUT` 미설정
- 서버 무응답 시 무한 대기

### 3. ext-curl 필수 의존성

- 공유 호스팅, Docker, Serverless 환경에서 문제 발생 가능
- 환경별 호환성 이슈

### 4. Guzzle 버전 충돌

- Guzzle 6.x 사용 프로젝트와 충돌
- Guzzle 7.x만 지원 시 기존 사용자 업그레이드 강제

---

## 새로운 PSR-18 기반 구현

### 장점

| 항목 | 설명 |
|------|------|
| **Guzzle 독립적** | Guzzle 6.x, 7.x 모두와 충돌 없음 |
| **PSR-18 호환** | 표준 인터페이스로 다른 HTTP 클라이언트 주입 가능 |
| **순수 PHP** | ext-curl 불필요, PHP streams 사용 |
| **보안 강화** | SSL 검증 기본 활성화 |
| **타임아웃 설정** | 30초 기본 타임아웃 |

### 의존성

```json
{
  "require": {
    "php": ">=7.1",
    "psr/http-client": "^1.0",
    "psr/http-message": "^1.0 || ^2.0",
    "nyholm/psr7": "^1.5"
  }
}
```

- `psr/http-client`: PSR-18 HTTP Client 인터페이스
- `psr/http-message`: PSR-7 HTTP Message 인터페이스
- `nyholm/psr7`: 경량 PSR-7 구현 (126M+ 다운로드)

---

## 커스텀 HTTP 클라이언트 사용

Guzzle이나 다른 PSR-18 호환 클라이언트를 사용하려면:

```php
use GuzzleHttp\Client as GuzzleClient;
use Nurigo\Solapi\Libraries\Fetcher;

// Guzzle 클라이언트 생성
$guzzle = new GuzzleClient([
    'timeout' => 60,
    'verify' => true,
]);

// Fetcher에 주입
$fetcher = new Fetcher('API_KEY', 'API_SECRET', $guzzle);
```

### 지원되는 PSR-18 클라이언트

- Guzzle 7.x (`guzzlehttp/guzzle`)
- Symfony HttpClient (`symfony/http-client`)
- 기타 PSR-18 호환 클라이언트

---

## 하위 호환성

### 변경 없음

- `SolapiMessageService`의 모든 public 메서드
- `Message` fluent builder
- 예외 처리 (`catch (CurlException $e)`)

### 변경됨

| 항목 | 이전 | 이후 |
|------|------|------|
| PHP 버전 | >= 7.1 | >= 7.1 (유지) |
| HTTP 클라이언트 | raw CURL | PSR-18 (PHP streams) |
| ext-curl | 필수 | 불필요 |
| SSL 검증 | 비활성화 | 활성화 |
| 타임아웃 | 없음 | 30초 |

---

## 참고 자료

- [PSR-18: HTTP Client](https://www.php-fig.org/psr/psr-18/)
- [PSR-7: HTTP Message Interface](https://www.php-fig.org/psr/psr-7/)
- [nyholm/psr7](https://github.com/Nyholm/psr7)
