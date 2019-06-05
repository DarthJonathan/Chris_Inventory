<?php


namespace App\Helpers;


class StringUtil
{
    /**
     * Creates Currency string based on money amount
     * @param $currency
     * @param $amount
     * @return string
     */
    static public function formatMoney($currency, $amount) {
        $currencies = [
            'rupiah'    => 'Rp.'
        ];

        return $currencies[$currency] . number_format($amount);
    }
}