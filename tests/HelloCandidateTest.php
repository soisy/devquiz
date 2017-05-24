<?php

use PHPUnit\Framework\TestCase;
use Soisy\HelloCandidate;

/**
 * Class HelloCandidateTest
 */
class HelloCandidateTest extends TestCase
{

    /**
     * @test
     */
    public function welcome()
    {
        $helloCandidate = new HelloCandidate();

        $this->assertEquals('Your adventure with Soisy starts here', $helloCandidate->welcome());
    }
}
