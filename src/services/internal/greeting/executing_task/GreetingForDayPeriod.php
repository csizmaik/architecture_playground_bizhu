<?php
/**
 * Created by PhpStorm.
 * User: Norbi
 * Date: 2017. 03. 12.
 * Time: 7:30
 */

namespace services\internal\greeting\executing_task;


use services\internal\day_period\executing_task\DayPeriod;

class GreetingForDayPeriod
{
    const MORNING_GREETING = "Good Morning!";
    const DAY_GREETING = "Hello!";
    const EVENING_GREETING = "Good Evening!";

    public function greetinForDayPeriod($dayPeriod)
    {
        switch ($dayPeriod)
        {
            case DayPeriod::MORNING:
                return self::MORNING_GREETING;
                break;
            case DayPeriod::DAY:
                return self::DAY_GREETING;
                break;
            case DayPeriod::EVENING:
                return self::EVENING_GREETING;
                break;
            default:
                throw new \InvalidArgumentException("Unknown day period: ".$dayPeriod);
                break;
        }
    }
}