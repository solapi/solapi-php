# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

SOLAPI PHP SDK - A zero-dependency messaging SDK for Korean telecommunications (SMS, LMS, MMS, Kakao Alimtalk, Voice, Fax). Version 5.0.6, requires PHP 7.1+ with curl and json extensions.

## Commands

```bash
# Install dependencies (none required, autoloader only)
composer install

# There are no local tests - see https://github.com/solapi/solapi-php-examples for usage examples
```

## Architecture

**Entry Point:** `SolapiMessageService` in `src/Services/` - all public API methods

**Call Flow:**
```
SolapiMessageService → Fetcher (singleton) → Authenticator (static) → CURL → api.solapi.com
```

**Key Classes:**
- `SolapiMessageService` - Primary API: send(), uploadFile(), getMessages(), getGroups(), getBalance()
- `Message` (`Models/Message.php`) - Fluent builder for message construction
- `Fetcher` (`Libraries/Fetcher.php`) - Singleton HTTP client
- `Authenticator` (`Libraries/Authenticator.php`) - HMAC-SHA256 auth header generation

**Models Structure:**
- `Models/Request/` - 7 request DTOs (SendRequest, GetMessagesRequest, etc.)
- `Models/Response/` - 17 response DTOs (SendResponse, GroupMessageResponse, etc.)
- `Models/Kakao/` - Kakao message options (pfId, templateId, buttons)
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

## Important Behaviors

- **Singleton State:** Fetcher singleton retains credentials - don't mix different API keys in the same process
- **Null Returns:** Many get* methods return `null` on any exception instead of throwing - always check response validity
- **No Interfaces:** Service/Fetcher lack contracts - mocking requires concrete class extension
- **SSL Verification:** Disabled in Fetcher (`CURLOPT_SSL_VERIFYPEER = false`)

## External Resources

- API Documentation: https://developers.solapi.com
- Examples Repository: https://github.com/solapi/solapi-php-examples
