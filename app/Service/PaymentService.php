<?php
declare(strict_types=1);

namespace App\Service;

use App\Constants\PayPlatform;
use App\Constants\PayType;
use App\Service\Admin\BaseService;
use Hyperf\Collection\Arr;

class PaymentService extends BaseService
{
    public function getPayPlatform()
    {
        $result = [];
        foreach (PayPlatform::cases() as $case) {
            $row = [
                'id' => $case->value,
                'name' => PayPlatform::getMessage($case->value),
            ];
            $result[] = $row;
        }
        return $result;
    }

    public function getPayType()
    {
        $result = [];
        foreach (PayType::cases() as $case) {
            $row = [
                'id' => $case->value,
                'name' => PayType::getMessage($case->value),
            ];
            $result[] = $row;
        }
        return $result;
    }
}