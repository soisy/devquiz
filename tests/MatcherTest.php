<?php

use PHPUnit\Framework\TestCase;
use Soisy\Investment;
use Soisy\Loan;
use Soisy\Matcher;

/**
 * Class MatcherTest
 */
class MatcherTest extends TestCase
{

    /**
     * @test
     */
    public function createMatcher(): void
    {
        $matcher = new Matcher();

        $this->assertInstanceOf(\Soisy\Matcher::class, $matcher);
    }

    /**
     * @test
     */
    public function addLoan(): void
    {
        $loan = new Loan(20000, 4);
        $matcher = new Matcher();
        $matcher->addLoan($loan);

        $this->assertEquals(new \ArrayObject([$loan]), $matcher->getLoans());
    }

    /**
     * @test
     */
    public function addInvestment(): void
    {
        $investment = new Investment(20000, 4);
        $matcher = new Matcher();
        $matcher->addInvestment($investment);

        $this->assertEquals(new \ArrayObject([$investment]), $matcher->getInvestments());
    }

    /**
     * @test
     */
    public function addMatch(): void
    {
        $investment = new Investment(20000, 4);
        $loan = new Loan(20000, 4);
        $matcher = new Matcher();

        $matcher->addMatch($loan, $investment);

        $this->assertEquals(new ArrayObject([
            [
                'loan' => $loan,
                'investment' => $investment,
            ]
        ]), $matcher->getMatches());
    }

    /**
     * @test
     */
    public function itShouldMatchOnSameRating(): void
    {
        $loan = new Loan(50000, 2);
        $investment = new Investment(75000, 2);

        $matcher = new Matcher();

        $matcher->addLoan($loan);
        $matcher->addInvestment($investment);

        $matcher->run();

        $result = $matcher->getMatches();

        $this->assertEquals(1, $result->count());
        $this->assertEquals(new \ArrayObject([
            [
                'loan'       => $loan,
                'investment' => $investment,
            ]
        ]), $result);
    }

    /**
     * @test
     */
    public function itShouldNotMatchIfLoanIsGreaterThanInvestment(): void
    {
        $loan = new Loan(500000, 2);
        $investment = new Investment(75000, 2);

        $matcher = new Matcher();

        $matcher->addLoan($loan);
        $matcher->addInvestment($investment);

        $matcher->run();

        $result = $matcher->getMatches();

        $this->assertEquals(0, $result->count());
    }

    /**
     * @test
     */
    public function itShouldNotMatchOnDifferentRating(): void
    {
        $loan = new Loan(50000, 3);
        $investment = new Investment(75000, 2);

        $matcher = new Matcher();

        $matcher->addLoan($loan);
        $matcher->addInvestment($investment);

        $matcher->run();

        $result = $matcher->getMatches();

        $this->assertEquals(0, $result->count());
    }

    /**
     * @test
     */
    public function itShouldMatchSeveralLoansAndInvestments(): void
    {
        $loan1 = new Loan(1000, 1);
        $loan2 = new Loan(750, 2);
        $loan3 = new Loan(500, 3);

        $investment1 = new Investment(900, 1);
        $investment2 = new Investment(1200, 1);
        $investment3 = new Investment(790, 2);
        $investment4 = new Investment(500, 4);
        $investment5 = new Investment(800, 5);

        $matcher = new Matcher();
        $matcher->addLoan($loan1);
        $matcher->addLoan($loan2);
        $matcher->addLoan($loan3);

        $matcher->addInvestment($investment1);
        $matcher->addInvestment($investment2);
        $matcher->addInvestment($investment3);
        $matcher->addInvestment($investment4);
        $matcher->addInvestment($investment5);

        $matcher->run();

        $result = $matcher->getMatches();

        $this->assertEquals(new \ArrayObject([
            ['loan' => $loan1, 'investment' => $investment2],
            ['loan' => $loan2, 'investment' => $investment3],
        ]), $result);
    }
}
