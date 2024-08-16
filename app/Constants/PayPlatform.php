<?php

declare(strict_types=1);

namespace App\Constants;

use Hyperf\Constants\Annotation\Constants;
use Hyperf\Constants\Annotation\Message;
use Hyperf\Constants\EnumConstantsTrait;

#[Constants]
enum PayPlatform: int
{
    use EnumConstantsTrait;

    #[Message("微信官方")]
    case WECHAT_PAY_OFFICIAL = 1;

    #[Message("支付宝官方")]
    case ALI_PAY_OFFICIAL = 2;

    #[Message("苹果官方")]
    case APPLE_PAY_OFFICIAL = 3;
}
