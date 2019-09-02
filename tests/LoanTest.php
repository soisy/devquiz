<?php

use PHPUnit\Framework\TestCase;
use Soisy\Loan;

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
        $loan = new Loan(100, 1);

        $this->assertEquals(100, $loan->getAmount());
        $this->assertEquals(1, $loan->getRating());
    }

    /**
     * @test
     * @dataProvider ratingShouldBeBetween1And5DataProvider
     */
    public function ratingShouldBeBetween1And5(int $validRating): void
    {
        $loan = new Loan(100, $validRating);
        $this->assertEquals($validRating, $loan->getRating());
    }

    public function ratingShouldBeBetween1And5DataProvider(): array
    {
        return [[1], [2], [3], [4], [5]];
    }

    /**
     * @test
     * @dataProvider ratingShouldBeGreaterThanZeroDataProviderDataProvider
     */
    public function invalidRatingsShouldRaiseAnException(int $invalidRating): void
    {
        $this->expectException(\Soisy\Exceptions\InvalidRatingException::class);

        new Loan(100, $invalidRating);
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
        $loan = new Loan(100, 1);
        $this->assertEquals(100, $loan->getAmount());
    }

    /**
     * @test
     */
    public function negativeAmountShouldRaiseAnException(): void
    {
        $this->expectException(\Soisy\Exceptions\InvalidAmountException::class);

        new Loan(-100, 1);
    }

    /**
     * @test
     */
    public function zeroAmountShouldRaiseAnException(): void
    {
        $this->expectException(\Soisy\Exceptions\InvalidAmountException::class);

        new Loan(0, 1);
    }
}
