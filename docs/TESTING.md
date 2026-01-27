# Testing Guide

## Quick Start

```bash
# Run all tests
composer test

# Run only unit tests
composer test:unit

# Run only E2E tests
composer test:e2e

# Run tests with coverage report
composer test:coverage
```

## Test Structure

```
tests/
├── Models/           # Unit tests (validation, model behavior)
│   └── Kakao/
│       └── Bms/
│           ├── BmsModelsTest.php
│           └── BmsValidatorTest.php
└── E2E/              # End-to-end tests (actual API calls)
    └── BmsFreeSendTest.php
```

## E2E Tests Configuration

E2E tests require environment variables to connect to the SOLAPI API:

```bash
export SOLAPI_API_KEY="your-api-key"
export SOLAPI_API_SECRET="your-api-secret"
export SOLAPI_KAKAO_PF_ID="your-kakao-pf-id"
export SOLAPI_SENDER_NUMBER="01012345678"
export SOLAPI_RECIPIENT_NUMBER="01087654321"
export SOLAPI_TEST_IMAGE_PATH="/path/to/test/image.jpg"  # Optional
```

Without these variables, E2E tests will be skipped automatically.

### Running E2E Tests

```bash
# Set environment variables and run
SOLAPI_API_KEY=xxx SOLAPI_API_SECRET=xxx \
SOLAPI_KAKAO_PF_ID=xxx \
SOLAPI_SENDER_NUMBER=01012345678 \
SOLAPI_RECIPIENT_NUMBER=01087654321 \
composer test:e2e
```

Or use a `.env` file with a tool like `dotenv`:

```bash
# .env.test (do not commit this file)
SOLAPI_API_KEY=your-api-key
SOLAPI_API_SECRET=your-api-secret
SOLAPI_KAKAO_PF_ID=your-pf-id
SOLAPI_SENDER_NUMBER=01012345678
SOLAPI_RECIPIENT_NUMBER=01087654321
```

## PHPUnit Direct Commands

```bash
# Run specific test file
./vendor/bin/phpunit tests/E2E/BmsFreeSendTest.php

# Run specific test method
./vendor/bin/phpunit --filter testSendBmsTextMinimal

# Run with verbose output
./vendor/bin/phpunit --testdox

# List all available tests
./vendor/bin/phpunit --list-tests
```

## Test Suites

| Suite | Command | Description |
|-------|---------|-------------|
| All | `composer test` | Run all tests |
| Unit | `composer test:unit` | Unit tests only (no API calls) |
| E2E | `composer test:e2e` | E2E tests (requires env vars) |

## E2E Test Cases

| Test | BMS Type | Description |
|------|----------|-------------|
| `testSendBmsTextMinimal` | TEXT | Minimal text message |
| `testSendBmsTextWithButtons` | TEXT | Text with buttons and coupon |
| `testSendBmsImage` | IMAGE | Image message |
| `testSendBmsWide` | WIDE | Wide format message |
| `testSendBmsCommerce` | COMMERCE | Commerce/product message |
| `testSendBmsWideItemList` | WIDE_ITEM_LIST | Wide item list (main + 3 sub items) |
| `testSendBmsCarouselFeed` | CAROUSEL_FEED | Carousel feed message |
| `testSendBmsCarouselCommerce` | CAROUSEL_COMMERCE | Carousel commerce message |
| `testSendBmsPremiumVideo` | PREMIUM_VIDEO | Premium video message |
