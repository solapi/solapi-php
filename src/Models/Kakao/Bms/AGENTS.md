# Kakao BMS (Brand Message Service)

**Parent:** See root `AGENTS.md` for SDK overview.

## OVERVIEW

14-file subsystem for Kakao Brand Message Service. Supports 8 chatBubbleTypes with type-specific required fields and validation.

## STRUCTURE

```
Bms/
├── BmsChatBubbleType.php   # 8 type constants + values()
├── BmsValidator.php        # Validates fields by chatBubbleType
├── BmsButton.php           # Button with 8 linkTypes
├── BmsCarousel.php         # head + list[] + tail
├── BmsCarouselHead.php     # Carousel header
├── BmsCarouselTail.php     # Carousel footer
├── BmsCarouselFeedItem.php # Feed carousel item
├── BmsCarouselCommerceItem.php # Commerce carousel item
├── BmsCommerce.php         # Product info with pricing
├── BmsCoupon.php           # Coupon with 5 title formats
├── BmsVideo.php            # Video (Kakao TV only)
├── BmsMainWideItem.php     # WIDE_ITEM_LIST main item
├── BmsSubWideItem.php      # WIDE_ITEM_LIST sub items (min 3)
└── BmsButtonLinkType.php   # 8 link type constants
```

## CHAT BUBBLE TYPES

| Type | Required Fields | Notes |
|------|-----------------|-------|
| `TEXT` | (none) | Uses Message.text |
| `IMAGE` | imageId | |
| `WIDE` | imageId | |
| `WIDE_ITEM_LIST` | header, mainWideItem, subWideItemList | subWideItemList min 3 items |
| `COMMERCE` | imageId, commerce, buttons | |
| `CAROUSEL_FEED` | carousel | Uses BmsCarouselFeedItem[] |
| `CAROUSEL_COMMERCE` | carousel | Uses BmsCarouselCommerceItem[] |
| `PREMIUM_VIDEO` | video | videoUrl must start with `https://tv.kakao.com/` |

## VALIDATION RULES

**BmsValidator.php** enforces:

1. **Required fields** by chatBubbleType (see table above)
2. **WIDE_ITEM_LIST**: `subWideItemList` minimum 3 items
3. **Commerce pricing** (mutually exclusive):
   - Cannot use both `discountRate` AND `discountFixed`
   - If `discountPrice` set, must have `discountRate` OR `discountFixed`
   - If `discountRate`/`discountFixed` set, must have `discountPrice`
4. **PREMIUM_VIDEO**: `videoUrl` must start with `https://tv.kakao.com/`

## BUTTON LINK TYPES

| Type | Description | Required Fields |
|------|-------------|-----------------|
| `WL` | Web Link | linkMobile |
| `AL` | App Link | linkMobile |
| `AC` | App Channel | (none) |
| `BK` | Bot Keyword | (none) |
| `MD` | Message Delivery | (none) |
| `BC` | Bot Channel | (none) |
| `BT` | Bot Talk | (none) |
| `BF` | Business Form | (none) |

## TARGETING TYPES

- `M`: Marketing consent + Kakao channel friend
- `N`: Marketing consent only
- `I`: Kakao channel friend only

## USAGE PATTERN

```php
use Nurigo\Solapi\Models\Kakao\KakaoBms;
use Nurigo\Solapi\Models\Kakao\Bms\BmsChatBubbleType;
use Nurigo\Solapi\Models\Kakao\Bms\BmsValidator;

$bms = new KakaoBms();
$bms->setTargeting('I')
    ->setChatBubbleType(BmsChatBubbleType::IMAGE)
    ->setImageId('uploaded-image-id');

// Validate before sending
BmsValidator::validate($bms);  // Throws BmsValidationException on failure
```

## ANTI-PATTERNS

- **Missing validation:** Always call `BmsValidator::validate()` before sending
- **Wrong type combinations:** Each chatBubbleType has specific required fields
- **Invalid video URL:** PREMIUM_VIDEO only accepts Kakao TV URLs
- **Insufficient sub items:** WIDE_ITEM_LIST requires exactly 3+ subWideItemList items
