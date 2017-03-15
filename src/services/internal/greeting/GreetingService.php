<?php
/**
 * Created by PhpStorm.
 * User: Norbi
 * Date: 2017. 03. 11.
 * Time: 8:30
 */

namespace services\internal\greeting;

use services\internal\day_period\DayPeriodService;
use services\internal\greeting\executing_task\GreetingForDayPeriod;

class GreetingService
{
    /**
     * @var DayPeriodService
     */
    private $dayPeriodService;

    public function __construct(DayPeriodService $dayPeriodService)
    {
        $this->dayPeriodService = $dayPeriodService;
    }

    public function greetingAt(\DateTime $dateTime)
    {
        $dayPeriod = $this->dayPeriodService->getDayPeriodForTime($dateTime);
        $greetingForTime = new GreetingForDayPeriod();
        return $greetingForTime->greetinForDayPeriod($dayPeriod);
    }
}