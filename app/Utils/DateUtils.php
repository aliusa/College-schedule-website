<?php
/**
 * Created by PhpStorm.
 * User: alius
 * Date: 2017-03-29
 * Time: 22:14
 */

namespace App\Utils;


class DateUtils extends Utils
{
    const FORMAT_DATE = "YYYY-mm-dd";
    const FORMAT_TIME_SHORT = "HH:ii";
    const FORMAT_TIME_LONG = "HH:ii:ss";
    const FORMAT_DATETIME_SHORT = self::FORMAT_DATE . ' ' . self::FORMAT_TIME_SHORT;
    const FORMAT_DATETIME_LONG = self::FORMAT_DATE . ' ' . self::FORMAT_TIME_LONG;

    /**
     * @link  http://stackoverflow.com/a/41503772
     * @param \string[] ...$values
     * @return bool
     */
    public static function isValid(string... $values)
    {
        foreach ($values as $value) {
            if (!$value) {
                return false;
            }

            try {
                new \DateTime($value);
            } catch (\Exception $exception) {
                return false;
            }
        }

        return true;
    }
}
