<?php
/**
 * Created by PhpStorm.
 * User: Norbi
 * Date: 2017. 03. 14.
 * Time: 7:56
 */

namespace services\internal\day_period\executing_task;


use PHPUnit\Framework\TestCase;

class TimeToDayPeriodTest extends TestCase
{
    public function dayPeriodProvider() {
        return [
            'morning test 1' => [8, 10, DayPeriod::MORNING],
            'last minute of morning' => [9, 59, DayPeriod::MORNING],
            'first minute of day' => [10, 0, DayPeriod::DAY],
            'day test 1' => [10, 20, DayPeriod::DAY],
            'day test 2' => [12, 0, DayPeriod::DAY],
            'day test 3' => [16, 23, DayPeriod::DAY],
            'last minute of the day' => [19, 59, DayPeriod::DAY],
            'first minute of the evening' => [20, 0, DayPeriod::EVENING],
            'evening test 1' => [23, 59, DayPeriod::EVENING],
            'evening test 2' => [0, 0, DayPeriod::EVENING],
            'last minute of the evening' => [4, 59, DayPeriod::EVENING],
            'first minute of morning' => [5, 0, DayPeriod::MORNING]
        ];
    }

    /**
     * @dataProvider dayPeriodProvider
     * @param $hour
     * @param $minute
     */
    public function testDayPeriodCalculation($hour, $minute, $expecterDayPerod) {
        $timeToDayPeriod = new TimeToDayPeriod();
        $testTime = new \DateTime();
        $testTime->setTime($hour,$minute);
        $dayPeriod = $timeToDayPeriod->dayPeriodOfTime($testTime);
        $this->assertEquals($expecterDayPerod, $dayPeriod, "Wrong day period");
    }


}
