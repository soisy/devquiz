<?php

use PHPUnit\Framework\TestCase;
use Soisy\Loan;
use Soisy\ValueObject\Amount;
use Soisy\ValueObject\Rating;
use Soisy\ValueObject\LoanId;

/**
 * Class LoanTest
 */
class LoanTest extends TestCase
{

    /**
     * @test
     */
    public function createLoan(): void
    {
        $loan = new Loan(
            new LoanId(1),
            new Amount(100),
            new Rating(1)
        );

        $this->assertEquals(100, $loan->getAmount()->getValue());
        $this->assertEquals(1, $loan->getRating()->getValue());
    }

    /**
     * @test
     * @dataProvider ratingShouldBeBetween1And5DataProvider
     *
     * @param $validRating
     */
    public function ratingShouldBeBetween1And5(int $validRating): void
    {
        $loan = new Loan(
            new LoanId(1),
            new Amount(100),
            new Rating($validRating)
        );
        $this->assertEquals($validRating, $loan->getRating()->getValue());
    }

    public function ratingShouldBeBetween1And5DataProvider(): array
    {
        return [[1], [2], [3], [4], [5]];
    }

    /**
     * @test
     * @dataProvider ratingShouldBeGreaterThanZeroDataProviderDataProvider
     *
     * @param $invalidRating
     */
    public function invalidRatingsShouldRaiseAnException(int $invalidRating): void
    {
        $this->expectException(\Soisy\Exceptions\InvalidRatingException::class);

        new Loan(
            new LoanId(1),
            new Amount(100),
            new Rating($invalidRating)
        );
    }

    public function ratingShouldBeGreaterThanZeroDataProviderDataProvider(): array
    {
        return [[-1], [0], [6], [100]];
    }

    /**
     * @test
     */
    public function amountShouldBePositive(): void
    {
        $loan = new Loan(
            new LoanId(1),
            new Amount(100),
            new Rating(1)
        );
        $this->assertEquals(100, $loan->getAmount()->getValue());
    }

    /**
     * @test
     */
    public function negativeAmountShouldRaiseAnException(): void
    {
        $this->expectException(\Soisy\Exceptions\InvalidAmountException::class);

        new Loan(new Amount(-100), new Rating(1));
    }

    /**
     * @test
     */
    public function zeroAmountShouldRaiseAnException(): void
    {
        $this->expectException(\Soisy\Exceptions\InvalidAmountException::class);

        new Loan(new Amount(0), new Rating(1));
    }
}
