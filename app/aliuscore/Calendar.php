<?php
/**
 * Created by PhpStorm.
 * User: alius
 * Date: 2015.12.25
 * Time: 15:16
 */

namespace aliuscore;

class Calendar
{
    private $datetime;

    private $mUtils;

    public function __construct($date = NULL)
    {
        $this->datetime = new \DateTime();

        if ($date == NULL) {
            $this->datetime->setTimestamp(strtotime('now'));
        } else {
            $this->datetime->setDate(
                date('Y', strtotime($date)),
                date('m', strtotime($date)),
                date('d', strtotime($date))
            );
            $this->datetime->setTime(
                date('H', strtotime($date)),
                date('i', strtotime($date)),
                date('s', strtotime($date))
            );
        }

        $this->mUtils = new Utils();
    }

    /**
     * @return \DateTime
     */
    public function getDatetime(): \DateTime
    {
        return $this->datetime;
    }

    /**
     * @param \DateTime $datetime
     */
    public function setDatetime($datetime)
    {
        $this->datetime = $datetime;
    }

    public function getMonth(): int
    {
        return $this->datetime->format("m");
    }

    public function setMonth(int $month)
    {
        $this->datetime->setDate($this->datetime->format("Y"), $month, $this->datetime->format("d"));
    }

    public function setYear(int $year)
    {
        $this->datetime->setDate($year, $this->datetime->format("m"), $this->datetime->format("d"));
    }

    public function setDay(int $day)
    {
        $this->datetime->setDate($this->datetime->format("Y"), $this->datetime->format("m"), $day);
    }

    public function setDate(string $date)
    {
        $this->datetime->setDate(
            date('Y', strtotime($date)),
            date('m', strtotime($date)),
            date('d', strtotime($date))
        );
    }

    /**
     * @return string
     * Example output: 2016-01-08
     */
    public function getDate(): string
    {
        return $this->datetime->format($this->mUtils->DATE_FORMAT);
    }

    /**
     * @param string|NULL $format
     * @return string
     * Example output "2016-01-08 20:27"
     */
    public function getDateTimeString(string $format = NULL): string
    {
        if ($format == NULL)
            $format = $this->mUtils->DATETIME_FORMAT;
        return $this->datetime->format($format);
    }

    /**
     * @param int $days
     * @return string
     * Example output "2016-01-08"
     */
    public function getDateBeforeXDays(int $days): string
    {
        return date($this->mUtils->DATE_FORMAT, strtotime('-' . strval($days) . ' days', strtotime($this->datetime->format($this->mUtils->DATE_FORMAT))));
    }

    /**
     * @param int $days
     * @return string
     * Example output "2016-01-08
     */
    public function getDateAfterXDays(int $days): string
    {
        return date($this->mUtils->DATE_FORMAT, strtotime('+' . strval($days) . ' days', strtotime($this->datetime->format($this->mUtils->DATE_FORMAT))));
    }
}