<?php
/**
 * Created by PhpStorm.
 * User: csizmarik
 * Date: 3/30/2017
 * Time: 6:33 PM
 */

namespace services\external\time;

class SystemTimeService implements TimeService
{

	public function getCurrentDateTime()
	{
		return new \DateTime("now");
	}
}