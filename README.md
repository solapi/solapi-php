# SOLAPI SDK for PHP

You can send text messages(SMS, LMS, MMS), Kakao friendtalk(include notification friendtalk) in Korea using this
package.  
This package is 100% compatible with SOLAPI family services (Purple Book, Nurigo, etc.).

## Requirements

- PHP 7.1 or higher
- `ext-json` extension
- `allow_url_fopen` enabled in php.ini (for the default HTTP client)

> **Note:** If `allow_url_fopen` is disabled in your environment (common in shared hosting), you can inject a custom PSR-18 HTTP client (e.g., Guzzle) via the `Fetcher` constructor or `getInstance()` method.

## Installing

To use the SDK, simply use Composer. Type the following into a terminal window.

```bash
composer require solapi/sdk
```

## Usage

See [examples repository](https://github.com/solapi/solapi-php-examples)

[//]: # (TODO: Need to add next solapi document link)

## Opening Issues

If you encounter a bug with the SOLAPI SDK for PHP we would like to hear about it.  
Search the [existing issues](https://github.com/solapi/solapi-php/issues) and try to make sure your problem doesn’t
already exist before opening a new issue, It’s helpful if you include the version of the SDK you are using.  
Please include a stack trace and reduced repro case when appropriate, too.

## License

Licensed under the MIT License.
