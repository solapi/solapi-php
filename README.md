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

Examples live in `examples/` and are self-contained CLI scripts that load the root autoloader.

Run an example:

```bash
php examples/send_sms.php
```

Each example contains placeholders like `ENTER_YOUR_API_KEY` and `ENTER_YOUR_API_SECRET`.
Replace those values before running.
Image assets used by some examples are in `examples/images/`.

**Examples**
Inquiry:
- `examples/get_balance.php` — get account balance
- `examples/get_messages.php` — query message list with filters
- `examples/get_statistics.php` — get message statistics

SMS / LMS / MMS:
- `examples/send_sms.php` — send SMS (auto-upgrades to LMS by length)
- `examples/send_lms.php` — send LMS
- `examples/send_mms.php` — send MMS with image
- `examples/send_overseas_sms.php` — send overseas SMS

Voice:
- `examples/send_voice_message.php` — send voice message

Kakao Alimtalk:
- `examples/send_alimtalk.php` — send Alimtalk

Kakao Brand Message (BMS):
- `examples/send_brand_message.php` — send Brand Message
- `examples/send_bms_free_text.php` — BMS FREE TEXT
- `examples/send_bms_free_image.php` — BMS FREE IMAGE
- `examples/send_bms_free_commerce.php` — BMS FREE COMMERCE
- `examples/send_bms_free_carousel_feed.php` — BMS FREE CAROUSEL_FEED
- `examples/send_bms_free_premium_video.php` — BMS FREE PREMIUM_VIDEO
- `examples/send_bms_free_wide_item_list.php` — BMS FREE WIDE_ITEM_LIST

## Opening Issues

If you encounter a bug with the SOLAPI SDK for PHP we would like to hear about it.  
Search the [existing issues](https://github.com/solapi/solapi-php/issues) and try to make sure your problem doesn’t
already exist before opening a new issue, It’s helpful if you include the version of the SDK you are using.  
Please include a stack trace and reduced repro case when appropriate, too.

## License

Licensed under the MIT License.
