<?php

namespace App\Datamodels;

use \MyCLabs\Enum\Enum;

final class CommonEnums extends Enum {
    // SALES
    const SALES         = "Sales";

    // PURCHASES
    const PURCHASE      = "Purchase";

    /**
     * Parse string into enums
     * @param string $transaction
     * @return string
     */
    public static function parseEnum(string $transaction) {
        if($transaction == self::SALES) {
            return self::SALES;
        }else if($transaction == self::PURCHASE) {
            return self::PURCHASE;
        }else {
            return "";
        }
    }
}
