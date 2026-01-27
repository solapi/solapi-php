# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

SOLAPI PHP SDK - A messaging SDK for Korean telecommunications (SMS, LMS, MMS, Kakao Alimtalk, Kakao BMS, Voice, Fax). Version 5.1.0, requires PHP 7.1+ with json extension and `allow_url_fopen` enabled (or a custom PSR-18 HTTP client).

**Dependencies:** PSR HTTP interfaces (psr/http-client, psr/http-message) + nyholm/psr7

## Commands

```bash
# Install dependencies
composer install

# Run all tests
composer test

# Unit tests only (no API calls required)
composer test:unit

# E2E tests (requires environment variables - see below)
composer test:e2e

# Run with coverage report
composer test:coverage

# Run a single test
./vendor/bin/phpunit --filter testName
```

### E2E Test Environment Variables

```bash
SOLAPI_API_KEY=xxx
SOLAPI_API_SECRET=xxx
SOLAPI_KAKAO_PF_ID=xxx
SOLAPI_SENDER_NUMBER=01012345678
SOLAPI_RECIPIENT_NUMBER=01087654321
```

## Architecture

**Entry Point:** `SolapiMessageService` in `src/Services/` - all public API methods

**Call Flow:**
```
SolapiMessageService → Fetcher (singleton) → Authenticator (static) → HttpClient (stream_context) → api.solapi.com
```

**Key Classes:**
- `SolapiMessageService` - Primary API: send(), uploadFile(), getMessages(), getGroups(), getBalance()
- `Message` (`Models/Message.php`) - Fluent builder for message construction
- `Fetcher` (`Libraries/Fetcher.php`) - Singleton HTTP client orchestrator
- `HttpClient` (`Libraries/HttpClient.php`) - PSR-18 implementation using `stream_context` + `file_get_contents`
- `Authenticator` (`Libraries/Authenticator.php`) - HMAC-SHA256 auth header generation

**Models Structure:**
- `Models/Request/` - 7 request DTOs (SendRequest, GetMessagesRequest, etc.)
- `Models/Response/` - 17 response DTOs (SendResponse, GroupMessageResponse, etc.)
- `Models/Kakao/` - Kakao message options (pfId, templateId, buttons)
- `Models/Kakao/Bms/` - Kakao Brand Message Service (14 files, 8 chatBubbleTypes) - see `src/Models/Kakao/Bms/AGENTS.md`
- `Models/Voice/` - Voice message options
- `Models/Fax/` - Fax message options

## Code Conventions

**Namespace:** `Nurigo\Solapi\*` (PSR-4 autoload from `src/`)

**Patterns:**
- Fluent builder: `$msg->setTo("...")->setFrom("...")->setText("...")`
- Singleton: `Fetcher::getInstance($apiKey, $apiSecret)`
- Public properties with getters/setters on all model classes
- Full type hints on method params/returns with PHPDoc annotations

**Language Notes:**
- PHPDoc comments are in Korean (수신번호, 발신번호, 메시지 내용)
- Default country code is "82" (Korea) in BaseMessage
- Timezone hardcoded to Asia/Seoul in Authenticator

## Tidy First Principles

Follow Kent Beck's "Tidy First" principles when making code changes:

**Core Principles:**
- **Separate Structure from Behavior**: Separate structural changes (tidying) and behavioral changes (features) into distinct commits
- **Tidy First**: Tidy related code before making feature changes to improve changeability
- **Small Steps**: Keep tidying work completable within minutes to hours

**Practical Techniques:**
- Use guard clauses for early returns to eliminate nested if statements
- Use helper variables/functions to clarify complex expressions
- Keep related code physically close together
- Express identical logic in identical ways (normalize symmetry)
- Delete unused code immediately

**When to Apply:**
- Before adding new features, tidy the affected area
- Before fixing bugs, clarify related code
- During code review, identify tidying opportunities

## Important Behaviors

- **Singleton State:** Fetcher singleton retains credentials - don't mix different API keys in the same process
- **Null Returns:** Many get* methods return `null` on any exception instead of throwing - always check response validity
- **No Interfaces:** Service/Fetcher lack contracts - mocking requires concrete class extension
- **PSR-18 HTTP Client:** Default HttpClient uses `stream_context` + `file_get_contents`. A custom PSR-18 client can be injected if needed (e.g., for cURL or Guzzle)
- **SSL Verification:** Enabled by default in HttpClient; can be disabled via constructor options

## External Resources

- API Documentation: https://developers.solapi.com
- Examples Repository: https://github.com/solapi/solapi-php-examples
