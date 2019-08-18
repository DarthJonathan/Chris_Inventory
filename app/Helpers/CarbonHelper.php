<?php


namespace App\Helpers;


class CarbonHelper
{
    private static $monthlist = [
      'januari'         => 'January',
      'februari'        => 'February',
      'maret'           => 'March',
      'april'           => 'April',
      'mei'             => 'May',
      'juni'            => 'June',
      'juli'            => 'July',
      'agustus'         => 'August',
      'september'       => 'September',
      'oktober'         => 'October',
      'november'        => 'November',
      'desember'        => 'December'
    ];

    /**
     * Translate month name to english
     * @param string $monthName
     * @return mixed|string
     */
    public static function translateMonth(string $monthName) {
        try {
            return CarbonHelper::$monthlist[$monthName];
        }catch(\Exception $e) {
            return 'Cannot Parse Month!';
        }
    }

    /**
     * Replace the the month to string
     * @param string $dateString
     * @return mixed
     */
    public static function replaceMonthToEnglish(string $dateString): string {
        $lowerDateString = strtolower($dateString);
        $englishMonth = '';

        foreach(CarbonHelper::$monthlist as $monthIndo => $monthEnglish) {
            if(strpos($lowerDateString, $monthIndo) !== false) {
                $englishMonth = str_replace(strtolower($monthIndo), strtoupper($monthEnglish), $lowerDateString);
            }
        }

        return $englishMonth;
    }
}
