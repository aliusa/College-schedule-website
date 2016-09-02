<?php
/**
 * Created by PhpStorm.
 * User: alius
 * Date: 2015.11.15
 * Time: 13:21
 */


/**
 * @return array
 */
function getWeekdays(): array
{
    return [1 => 'Pirmadienis', 2 => 'Antradienis', 3 => 'Trečiadienis', 4 => 'Ketvirtadienis', 5 => 'Penktadienis',
        6 => 'Šeštadienis', 7 => 'Sekmadienis'];
}

function getMonths(): array
{
    return [1 => 'Sausis', 2 => 'Vasaris', 3 => 'Kovas', 4 => 'Balandis', 5 => 'Gegužė', 6 => 'Birželis', 7 => 'Liepa',
        8 => 'Rugpjūtis', 9 => 'Rugsėjis', 10 => 'Spalis', 11 => 'Lapkritis', 12 => 'Gruodis'];
}

function getMonthName(int $num): string
{
    return getMonths()[$num];
}

function issetor(&$var, $default = false)
{
    return isset($var) ? $var : $default;
}


/**
 * @param $string string String to be checked for
 * @param $len integer Preferred length
 * @return string|null string of $len if equal, or else null
 */
function isNotEmptyOr(string $string, int $len)
{
    return strlen($string) <= $len ? null : $string;
}

function currentDateTime(): string
{
    return date('Y-m-d H:i:s');
}

function getDuration(string $timeFrom, string $timeTo): string
{
    $timeTo = date('H:i', strtotime('-' . substr($timeFrom, 0, 2) . ' hours', strtotime($timeTo)));
    $timeTo = date('H:i', strtotime('-' . substr($timeFrom, 3, 5) . ' minutes', strtotime($timeTo)));
    return $timeTo;
}

function getWeekDaysStarting(string $date = NULL, int $weeks = 1): array
{
    $mCalendar = new \aliuscore\Calendar($date);
    $mStartDate = $mCalendar->getDate();
    $mEndDate = $mCalendar->getDateAfterXDays(7 * $weeks - 1);
    $mLastWeekToday = $mCalendar->getDateBeforeXDays(7 * $weeks);
    $mNextWeekToday = $mCalendar->getDateAfterXDays(7 * $weeks);
    return [$mStartDate, $mEndDate, $mLastWeekToday, $mNextWeekToday];
}

function getWeekDaysFromDate(string $date = NULL, int $weeks = 1): array
{
    $mDays = [];
    $date = $date ?? 'today';
    $mDayCount = 0;
    for ($j = 1; $j <= $weeks; $j++) {
        for ($i = 0; $i <= 6; $i++, $mDayCount++) {
            // 'N' - 1 (for Monday) through 7 (for Sunday).
            $mDaysTemp[$i]['day'] = date('N', strtotime($date . ' + ' . $mDayCount . " days"));
            $mDaysTemp[$i]['date'] = date('Y-m-d', strtotime($date . ' + ' . $mDayCount . " days"));
            // Gets full name week day.
            $mDaysTemp[$i]['fullName'] = getWeekdays()[$mDaysTemp[$i]['day']];
            $mDays[] = $mDaysTemp[$i];
        }
    }
    return $mDays;
}


function CheckInput($value = NULL, string $msg)
{
    if (!isset($value)) {
        echo json_encode([
            "success" => false,
            "msg" => $msg
        ]);
        die;
    } else
        return $value;
}

function jsonResponse(bool $success, $msg = "Sėkmingai išsaugota", int $code = null)
{
    echo json_encode([
        "success" => $success,
        "msg" => $msg,
        "code" => $code,
    ]);
    if (!$success) {
        die;
    }
}


function getOS()
{
    $os = null;
    $os_array = [
        '/windows nt 10/i' => 'Windows 10',
        '/windows nt 6.3/i' => 'Windows 8.1',
        '/windows nt 6.2/i' => 'Windows 8',
        '/windows nt 6.1/i' => 'Windows 7',
        '/windows nt 6.0/i' => 'Windows Vista',
        '/windows nt 5.2/i' => 'Windows Server 2003/XP x64',
        '/windows nt 5.1/i' => 'Windows XP',
        '/windows xp/i' => 'Windows XP',
        '/windows nt 5.0/i' => 'Windows 2000',
        '/windows me/i' => 'Windows ME',
        '/win98/i' => 'Windows 98',
        '/win95/i' => 'Windows 95',
        '/win16/i' => 'Windows 3.11',
        '/macintosh|mac os x/i' => 'Mac OS X',
        '/mac_powerpc/i' => 'Mac OS 9',
        '/linux/i' => 'Linux',
        '/ubuntu/i' => 'Ubuntu',
        '/iphone/i' => 'iPhone',
        '/ipod/i' => 'iPod',
        '/ipad/i' => 'iPad',
        '/android/i' => 'Android',
        '/blackberry/i' => 'BlackBerry',
        '/webos/i' => 'Mobile'
    ];
    foreach ($os_array as $regex => $value)
        if (preg_match($regex, $_SERVER['HTTP_USER_AGENT']))
            $os = $value;
    return $os;
}

function getBrowser()
{
    $browser = null;
    $browser_array = [
        '/msie/i' => 'Internet Explorer',
        '/firefox/i' => 'Firefox',
        '/safari/i' => 'Safari',
        '/chrome/i' => 'Chrome',
        '/edge/i' => 'Edge',
        '/opera/i' => 'Opera',
        '/netscape/i' => 'Netscape',
        '/maxthon/i' => 'Maxthon',
        '/konqueror/i' => 'Konqueror',
        '/mobile/i' => 'Handheld Browser'
    ];
    foreach ($browser_array as $regex => $value)
        if (preg_match($regex, $_SERVER['HTTP_USER_AGENT']))
            $browser = $value;
    return $browser;
}

function getAndroidVersion()
{
    $browser = null;
    $browser_array = [
        '/android ([0-9.*]*);/i' => 'Internet Explorer'
    ];
    foreach ($browser_array as $regex => $value)
        if (preg_match($regex, $_SERVER['HTTP_USER_AGENT'], $matches))
            $browser = $matches[1];
    return $browser;
}


/**
 * @param string $date date
 * @return int day of week 1-7
 */
function getWeekdayOfDate(string $date): int
{
    return date('N', strtotime($date));
}

/**
 * @param string $dateOne
 * @param string $dateTwo
 * @return int
 * -1 - First date is smaller
 * 0 - Dates are equal
 * 1 - First date is bigger
 */
function compareDates(string $dateOne, string $dateTwo):int
{
    return strtotime($dateOne) <=> strtotime($dateTwo);
}

function cacheShort()
{
    header("Cache-Control: max-age=60, must-revalidate");
}

function cacheLong()
{
    $ExpStr = "Expires: " . gmdate("D, d M Y 23:59:59", time()) . " GMT";
    header($ExpStr);
}