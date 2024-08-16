<?php

declare(strict_types=1);

namespace App\Constants;

use Hyperf\Constants\Annotation\Constants;
use Hyperf\Constants\Annotation\Message;
use Hyperf\Constants\EnumConstantsTrait;

#[Constants]
enum PayType: int
{
    use EnumConstantsTrait;

    #[Message("微信")]
    case WECHAT_PAY = 1;

    #[Message("支付宝")]
    case ALI_PAY = 2;

    #[Message("苹果内购")]
    case IOS_PAY = 3;

    #[Message("银联")]
    case UNION_PAY = 4;

    #[Message("钱包")]
    case WALLET_PAY = 5;
}
