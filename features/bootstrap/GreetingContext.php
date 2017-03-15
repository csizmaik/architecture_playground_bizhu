<?php
/**
 * Created by PhpStorm.
 * User: Norbi
 * Date: 2017. 03. 12.
 * Time: 8:43
 */
use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;
use services\internal\greeting\GreetingService;

class GreetingContext extends SymfonyDIContainerAwareContext implements Context
{
    private $visitTime;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        $this->visitTime = new DateTime("today");
    }

    /**
     * @Given /^the time is "([^"]*)"$/
     */
    public function theTimeIs($timeString)
    {
        $timeParts = explode(":",$timeString);
        $this->visitTime->setTime($timeParts[0],$timeParts[1]);
    }

    /**
     * @When /^I visit the webpage$/
     */
    public function iVisitTheWebpage()
    {

    }

    /**
     * @Then /^The webpage says "([^"]*)"$/
     */
    public function theWebpageSays($expectedGreeting)
    {
        /** @var GreetingService $greetingService */
        $greetingService = parent::getService('greeting_service');
        $greeting = $greetingService->greetingAt($this->visitTime);
        Assert::assertEquals(
            $greeting,
            $expectedGreeting,
            "Wrong greeting ".$greeting." at ".$this->visitTime->format("H:i")." - expected greeting: ".$expectedGreeting
        );
    }
}