<?php

use PHPUnit\Framework\TestCase;
use Soisy\Investment;
use Soisy\Loan;
use Soisy\Matcher;
use Soisy\ValueObject\Amount;
use Soisy\ValueObject\Rating;
use Soisy\ValueObject\LoanId;
use Soisy\ValueObject\InvestmentId;

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
        $loanId = new LoanId(1);
        $loan = $this->getMockLoan($loanId, new Amount(20000), new Rating(3));

        $matcher = new Matcher();
        $matcher->addLoan($loan);

        $this->assertEquals([(string)$loanId => $loan], $matcher->getLoans()->getArrayCopy());
    }

    /**
     * @test
     */
    public function itShouldNotAddSameLoanTwice(): void
    {
        $this->expectException(\Soisy\Exceptions\AddException::class);

        $loan = $this->getMockLoan(new LoanId(1), new Amount(20000), new Rating(3));

        $matcher = new Matcher();
        $matcher->addLoan($loan);
        $matcher->addLoan($loan);
    }

    /**
     * @test
     */
    public function addInvestment(): void
    {
        $investmentId = new InvestmentId(1);
        $investment = $this->getMockInvestment($investmentId, new Amount(20000), new Rating(4));

        $matcher = new Matcher();
        $matcher->addInvestment($investment);

        $this->assertEquals([(string)$investmentId => $investment], $matcher->getInvestments()->getArrayCopy());
    }

    /**
     * @test
     */
    public function itShouldNotAddSameInvestmentTwice(): void
    {
        $this->expectException(\Soisy\Exceptions\AddException::class);

        $investment = $this->getMockInvestment(new InvestmentId(1), new Amount(20000), new Rating(4));

        $matcher = new Matcher();
        $matcher->addInvestment($investment);
        $matcher->addInvestment($investment);
    }

    /**
     * @test
     */
    public function itShouldMatchOnSameRating(): void
    {
        $loan = $this->getMockLoan(new LoanId(1), new Amount(50000), new Rating(2));
        $investment = $this->getMockInvestment(new InvestmentId(1), new Amount(75000), new Rating(2));

        $matcher = new Matcher();

        $matcher->addLoan($loan);
        $matcher->addInvestment($investment);

        $matcher->run();

        $result = $matcher->getMatches();

        $this->assertEquals(1, $result->count());
        $this->assertEquals([
            [
                'loan'       => $loan,
                'investment' => $investment,
            ]
        ], $result->getArrayCopy());
    }

    /**
     * @test
     */
    public function itShouldNotMatchIfLoanIsGreaterThanInvestment(): void
    {
        $loan = $this->getMockLoan(new LoanId(1), new Amount(500000), new Rating(2));
        $investment = $this->getMockInvestment(new InvestmentId(1), new Amount(75000), new Rating(2));

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
        $loan = $this->getMockLoan(new LoanId(1), new Amount(500000), new Rating(3));
        $investment = $this->getMockInvestment(new InvestmentId(1), new Amount(75000), new Rating(2));

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
        $loan1 = $this->getMockLoan(new LoanId(1), new Amount(1000), new Rating(1));
        $loan2 = $this->getMockLoan(new LoanId(2), new Amount(750), new Rating(2));
        $loan3 = $this->getMockLoan(new LoanId(3), new Amount(500), new Rating(3));

        $investment1 = $this->getMockInvestment(new InvestmentId(1), new Amount(900), new Rating(1));
        $investment2 = $this->getMockInvestment(new InvestmentId(2), new Amount(1200), new Rating(1));
        $investment3 = $this->getMockInvestment(new InvestmentId(3), new Amount(790), new Rating(2));
        $investment4 = $this->getMockInvestment(new InvestmentId(4), new Amount(500), new Rating(4));
        $investment5 = $this->getMockInvestment(new InvestmentId(5), new Amount(800), new Rating(5));

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

        $this->assertEquals([
            ['loan' => $loan1, 'investment' => $investment2],
            ['loan' => $loan2, 'investment' => $investment3],
        ], $result->getArrayCopy());
    }

    private function getMockLoan(LoanId $id, Amount $amount, Rating $rating): Loan
    {
        /** @var Loan $loan */
        $loan = $this->prophesize(Loan::class);
        $loan->getId()->willReturn($id);
        $loan->getAmount()->willReturn($amount);
        $loan->getRating()->willReturn($rating);

        return $loan->reveal();
    }

    private function getMockInvestment(InvestmentId $id, Amount $amount, Rating $rating): Investment
    {
        /** @var Investment $investment */
        $investment = $this->prophesize(Investment::class);
        $investment->getId()->willReturn($id);
        $investment->getAmount()->willReturn($amount);
        $investment->getRating()->willReturn($rating);

        return $investment->reveal();
    }
}
