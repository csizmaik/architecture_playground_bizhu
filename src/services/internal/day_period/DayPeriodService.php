<?php
/**
 * Created by PhpStorm.
 * User: Norbi
 * Date: 2017. 03. 12.
 * Time: 12:38
 */

namespace services\internal\day_period;


use services\internal\day_period\executing_task\TimeToDayPeriod;

class DayPeriodService
{
    public function getDayPeriodForTime(\DateTime $dateTime) {
        $timeToDayPeriod = new TimeToDayPeriod();
        return $timeToDayPeriod->dayPeriodOfTime($dateTime);
    }
}