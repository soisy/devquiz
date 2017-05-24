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
    public function createLoan()
    {
        $loan = new Loan(100, 1);

        $this->assertEquals(100, $loan->getAmount());
        $this->assertEquals(1, $loan->getRating());
    }

    /**
     * @test
     * @dataProvider ratingShouldBeBetween1And5DataProvider
     *
     * @param $validRating
     */
    public function ratingShouldBeBetween1And5($validRating)
    {
        $loan = new Loan(100, $validRating);
        $this->assertEquals($validRating, $loan->getRating());
    }

    public function ratingShouldBeBetween1And5DataProvider()
    {
        return [[1], [2], [3], [4], [5]];
    }

    /**
     * @test
     * @expectedException Soisy\Exceptions\InvalidRatingException
     * @dataProvider ratingShouldBeGreaterThanZeroDataProviderDataProvider
     *
     * @param $invalidRating
     */
    public function invalidRatingsShouldRaiseAnException($invalidRating)
    {
        new Loan(100, $invalidRating);
    }

    public function ratingShouldBeGreaterThanZeroDataProviderDataProvider()
    {
        return [[-1], [0], [6], [100]];
    }

    /**
     * @test
     */
    public function amountShouldBePositive()
    {
        $loan = new Loan(100, 1);
        $this->assertEquals(100, $loan->getAmount());
    }

    /**
     * @test
     * @expectedException Soisy\Exceptions\InvalidAmountException
     */
    public function negativeAmountShouldRaiseAnException()
    {
        new Loan(-100, 1);
    }

    /**
     * @test
     * @expectedException Soisy\Exceptions\InvalidAmountException
     */
    public function zeroAmountShouldRaiseAnException()
    {
        new Loan(0, 1);
    }
}
