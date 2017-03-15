<?php
/**
 * Created by PhpStorm.
 * User: Norbi
 * Date: 2017. 03. 12.
 * Time: 12:27
 */

namespace services\internal\day_period\executing_task;


class TimeToDayPeriod
{
    const MORNING_START_TIME = "05:00";

    const MORNING_END_TIME = '09:59';

    const EVENING_START_TIME = '20:00';

    public function dayPeriodOfTime(\DateTime $dateTime) {
        $timePart = $dateTime->format("H:i");
        if ($timePart >= self::EVENING_START_TIME || $timePart < self::MORNING_START_TIME) {
            return DayPeriod::EVENING;
        } else if ($timePart <= self::MORNING_END_TIME) {
            return DayPeriod::MORNING;
        } else {
            return DayPeriod::DAY;
        }
    }
}