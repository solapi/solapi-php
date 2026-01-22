# SOLAPI PHP SDK

**Generated:** 2026-01-21  
**Commit:** b68825d  
**Branch:** master

## OVERVIEW

PHP SDK for SOLAPI messaging API (SMS, LMS, MMS, Kakao Alimtalk, Voice, Fax) targeting Korean telecom. Zero external dependencies, PHP 7.1+.

## STRUCTURE

```
solapi-php/
├── src/
│   ├── Services/           # Entry point (SolapiMessageService)
│   ├── Libraries/          # HTTP client, auth, utilities
│   ├── Models/
│   │   ├── Request/        # API request DTOs (7 files)
│   │   ├── Response/       # API response DTOs (17 files)
│   │   ├── Kakao/          # Kakao message options
│   │   ├── Voice/          # Voice message options
│   │   └── Fax/            # Fax message options
│   └── Exceptions/         # Custom exceptions (4 files)
├── composer.json           # PSR-4: Nurigo\Solapi\ → src/
└── README.md
```

## WHERE TO LOOK

| Task | Location | Notes |
|------|----------|-------|
| Send messages | `Services/SolapiMessageService.php` | Main entry point, all public methods |
| Build message | `Models/Message.php` | Fluent builder, extends BaseMessage |
| HTTP requests | `Libraries/Fetcher.php` | Singleton, CURL-based |
| Auth header | `Libraries/Authenticator.php` | HMAC-SHA256, static method |
| Kakao options | `Models/Kakao/KakaoOption.php` | pfId, templateId, buttons, bms |
| Voice options | `Models/Voice/VoiceOption.php` | voiceType, headerMessage, tailMessage |
| Error handling | `Exceptions/` | BaseException, CurlException, MessageNotReceivedException |
| Request params | `Models/Request/` | SendRequest, GetMessagesRequest, etc. |
| Response parsing | `Models/Response/` | SendResponse, GroupMessageResponse, etc. |

## CODE MAP

**Entry Point:**
```php
$service = new SolapiMessageService($apiKey, $apiSecret);
$response = $service->send($message);
```

**Call Flow:**
```
SolapiMessageService → Fetcher (singleton) → Authenticator (static)
                                          → CURL → api.solapi.com
                                          → Response DTOs
```

**Key Classes:**
| Class | Type | Role |
|-------|------|------|
| `SolapiMessageService` | Service | Primary API (send, uploadFile, getMessages, getGroups, getBalance) |
| `Message` | Model | Message builder with fluent setters |
| `Fetcher` | Library | HTTP client singleton, handles all API requests |
| `Authenticator` | Library | Generates HMAC-SHA256 auth headers |
| `NullEliminator` | Library | Removes null values before JSON serialization |

## CONVENTIONS

**Namespace:** `Nurigo\Solapi\*` (PSR-4 from `src/`)

**Patterns:**
- Fluent builder: `$msg->setTo("...")->setFrom("...")->setText("...")`
- Singleton: `Fetcher::getInstance($key, $secret)`
- Public properties with getters/setters on models
- Korean PHPDoc comments (domain-specific)

**Type Safety:**
- Full type hints on method params/returns
- PHPDoc `@var`, `@param`, `@return`, `@throws` annotations

**Tidy First (Kent Beck):**
- Separate structural and behavioral changes into distinct commits
- Tidy related code before making feature changes
- Guard clauses, helper variables/functions, code proximity, symmetry normalization, delete unused code

## ANTI-PATTERNS

- **Avoid catch-all nulls:** Many get* methods return `null` on any exception — check response validity
- **Singleton state:** Fetcher singleton retains credentials — don't mix different API keys in same process
- **No interfaces:** Service/Fetcher have no contracts — mocking requires concrete class extension
- **SSL verification disabled:** `CURLOPT_SSL_VERIFYPEER = false` in Fetcher

## UNIQUE STYLES

- **Korean comments:** PHPDoc descriptions in Korean (수신번호, 발신번호, 메시지 내용)
- **Default country:** `"82"` (Korea) hardcoded in BaseMessage
- **Timezone:** `Asia/Seoul` set in Authenticator

## COMMANDS

```bash
# Install
composer require solapi/sdk

# No local tests — see solapi-php-examples repo
```

## NOTES

- **Examples:** External repo at `github.com/solapi/solapi-php-examples`
- **API docs:** `developers.solapi.com`
- **PHP requirement:** 7.1+ (ext-curl, ext-json required)
- **TODO in README:** Missing documentation link (line 19)
