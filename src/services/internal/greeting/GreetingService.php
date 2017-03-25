<?php
/**
 * Created by PhpStorm.
 * User: Norbi
 * Date: 2017. 03. 11.
 * Time: 8:30
 */

namespace services\internal\greeting;

use services\internal\greeting\executing_task\GreetingForDayPeriod;

class GreetingService
{
    /**
     * @var DayPeriodService
     */
    private $dayPeriodService;

    public function __construct($dayPeriodService)
    {
        $this->dayPeriodService = $dayPeriodService;
    }

    public function greetingAt(\DateTime $dateTime)
    {
        $dayPeriod = $this->dayPeriodService->getDayPeriodForTime($dateTime);
        // NOT DO - nem módosíthatok állapotot itt sem
		//$dayPeriod->var = 10;
        $greetingForTime = new GreetingForDayPeriod();
        return $greetingForTime->greetinForDayPeriod($dayPeriod);
    }
}