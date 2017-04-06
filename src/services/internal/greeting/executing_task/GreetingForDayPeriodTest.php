<?php
/**
 * Created by PhpStorm.
 * User: Norbi
 * Date: 2017. 03. 15.
 * Time: 6:43
 */

namespace services\internal\greeting\executing_task;

use PHPUnit\Framework\TestCase;
use services\internal\day_period\executing_task\DayPeriod;

class GreetingForDayPeriodTest extends TestCase
{
    /**
     * @var GreetingForDayPeriod
     */
    private $greetingForDayPeriod;

    public function setUp()
    {
        $this->greetingForDayPeriod = new GreetingForDayPeriod();
    }

    public function testGreetinInTheMorning() {
        $greeting = $this->greetingForDayPeriod
                                ->greetinForDayPeriod(DayPeriod::MORNING);
        $this->assertEquals("Good Morning!",$greeting);
    }

    public function testGreetingDuringDay() {
        $greeting = $this->greetingForDayPeriod
                                ->greetinForDayPeriod(DayPeriod::DAY);
        $this->assertEquals("Hello!",$greeting);
    }

    public function testGreetingInTheEvening() {
        $greeting = $this->greetingForDayPeriod
            ->greetinForDayPeriod(DayPeriod::EVENING);
        $this->assertEquals("Good Evening!",$greeting);
    }
}
