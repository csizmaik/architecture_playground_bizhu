<?php
/**
 * Created by PhpStorm.
 * User: csizmarik
 * Date: 4/5/2017
 * Time: 10:32 AM
 */

namespace services\external\time;


use services\internal\time\TimeService;

class SystemTimeService implements TimeService
{
	public function getCurrentDateTime()
	{
		return new \DateTime("now");
	}
}