# SOLAPI PHP SDK

**Generated:** 2026-01-27  
**Commit:** a27d32f  
**Branch:** master

## OVERVIEW

PHP SDK for SOLAPI messaging API (SMS, LMS, MMS, Kakao Alimtalk/BMS, Voice, Fax) targeting Korean telecom. PSR-18 HTTP client abstraction, PHP 7.1+.

## STRUCTURE

```
solapi-php/
├── src/
│   ├── Services/           # Entry point (SolapiMessageService)
│   ├── Libraries/          # HTTP client, auth, utilities (4 files)
│   ├── Models/
│   │   ├── Request/        # API request DTOs (7 files)
│   │   ├── Response/       # API response DTOs (17 files)
│   │   ├── Kakao/          # Kakao options (4 files)
│   │   │   └── Bms/        # Brand Message Service (14 files) ← See Bms/AGENTS.md
│   │   ├── Voice/          # Voice options (3 files)
│   │   └── Fax/            # Fax options (1 file)
│   └── Exceptions/         # Custom exceptions (5 files)
├── tests/
│   ├── Models/             # Unit tests
│   └── E2E/                # Integration tests
├── composer.json           # PSR-4: Nurigo\Solapi\ → src/
└── phpunit.xml             # Test configuration
```

## WHERE TO LOOK

| Task | Location | Notes |
|------|----------|-------|
| Send messages | `Services/SolapiMessageService.php` | Main entry point, all public methods |
| Build message | `Models/Message.php` | Fluent builder, extends BaseMessage |
| HTTP requests | `Libraries/Fetcher.php` | Singleton, PSR-18 client |
| Auth header | `Libraries/Authenticator.php` | HMAC-SHA256, static method |
| HTTP transport | `Libraries/HttpClient.php` | stream_context-based, PSR-18 compliant |
| Kakao Alimtalk | `Models/Kakao/KakaoOption.php` | pfId, templateId, buttons, variables |
| Kakao BMS | `Models/Kakao/KakaoBms.php` | Brand messages, 8 chatBubbleTypes |
| BMS validation | `Models/Kakao/Bms/BmsValidator.php` | Field requirements by type |
| Voice options | `Models/Voice/VoiceOption.php` | voiceType, headerMessage, tailMessage |
| Fax options | `Models/Fax/FaxOption.php` | fileIds array |
| Error handling | `Exceptions/` | BaseException, HttpException, BmsValidationException |
| Request DTOs | `Models/Request/` | SendRequest, GetMessagesRequest, etc. |
| Response DTOs | `Models/Response/` | SendResponse, GroupMessageResponse, etc. |

## CODE MAP

**Entry Point:**
```php
$service = new SolapiMessageService($apiKey, $apiSecret);
$response = $service->send($message);
```

**Call Flow:**
```
SolapiMessageService
    → Fetcher::getInstance() [singleton]
        → Authenticator::getAuthorizationHeaderInfo() [static]
        → NullEliminator::array_null_eliminate() [static]
        → HttpClient::sendRequest() [PSR-18]
            → stream_context + file_get_contents
        → Response DTOs
```

**Key Classes:**
| Class | Type | Role |
|-------|------|------|
| `SolapiMessageService` | Service | Primary API (send, uploadFile, getMessages, getGroups, getBalance) |
| `Message` | Model | Fluent builder with 12 setters |
| `Fetcher` | Library | Singleton HTTP client, credential storage |
| `HttpClient` | Library | PSR-18 stream-based implementation |
| `Authenticator` | Library | HMAC-SHA256 auth header generation |
| `NullEliminator` | Library | Recursive null removal for JSON |
| `BmsValidator` | Validator | BMS field validation by chatBubbleType |

**Model Hierarchy:**
```
BaseMessage → Message (fluent builder)
BaseKakaoOption → KakaoOption (fluent builder)
                   └── KakaoBms (fluent builder, 8 types)
                        └── Bms/* components (14 files)
```

## CONVENTIONS

**Namespace:** `Nurigo\Solapi\*` (PSR-4 from `src/`)

**Patterns:**
- Fluent builder: `$msg->setTo("...")->setFrom("...")->setText("...")`
- Singleton: `Fetcher::getInstance($key, $secret)`
- Public properties with getter/setter pairs on models
- Korean PHPDoc comments (수신번호, 발신번호, 메시지 내용)

**Type Safety:**
- Full type hints on method params/returns
- PHPDoc `@var`, `@param`, `@return`, `@throws` annotations
- PHP 7.1 compatible (no union types, no enums)

**Enum-Like Constants:**
- `VoiceType::FEMALE`, `VoiceType::MALE`
- `BmsChatBubbleType::TEXT`, `IMAGE`, `WIDE`, etc.
- All have `values()` static method

**Tidy First (Kent Beck):**
- Separate structural and behavioral changes into distinct commits
- Tidy related code before making feature changes
- Guard clauses, helper variables/functions, code proximity

## ANTI-PATTERNS

- **Silent null returns:** get* methods return `null` on any exception — always check response validity
- **Singleton state:** Fetcher retains credentials — don't mix API keys in same process
- **No interfaces:** Service/Fetcher have no contracts — mocking requires concrete class extension
- **Hardcoded timezone:** `Asia/Seoul` set in Authenticator — affects global timezone
- **Hardcoded country:** `"82"` default in BaseMessage — Korean-only by default

## UNIQUE STYLES

- **Korean comments:** PHPDoc descriptions in Korean
- **PSR-18 via stream:** Uses `file_get_contents` + `stream_context_create`, not cURL
- **Null elimination:** Removes nulls before JSON serialization

## COMMANDS

```bash
# Install
composer require solapi/sdk

# Run all tests
composer test

# Run unit tests only
composer test:unit

# Run E2E tests only
composer test:e2e

# Run with coverage
composer test:coverage
```

## NOTES

- **Examples:** External repo at `github.com/solapi/solapi-php-examples`
- **API docs:** `developers.solapi.com`
- **PHP requirement:** 7.1+ (ext-json, allow_url_fopen or custom PSR-18 client)
- **Dependencies:** psr/http-client, psr/http-message, nyholm/psr7
- **BMS details:** See `src/Models/Kakao/Bms/AGENTS.md` for Brand Message Service specifics
