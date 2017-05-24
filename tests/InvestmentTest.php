<?php

use PHPUnit\Framework\TestCase;
use Soisy\Investment;

/**
 * Class InvestmentTest
 */
class InvestmentTest extends TestCase
{

    /**
     * @test
     */
    public function createInvestment()
    {
        $investment = new Investment(100, 1);

        $this->assertEquals(100, $investment->getAmount());
        $this->assertEquals(1, $investment->getRating());
    }

    /**
     * @test
     * @dataProvider ratingShouldBeBetween1And5DataProvider
     *
     * @param $validRating
     */
    public function ratingShouldBeBetween1And5($validRating)
    {
        $investment = new Investment(100, $validRating);
        $this->assertEquals($validRating, $investment->getRating());
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
        new Investment(100, $invalidRating);
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
        $investment = new Investment(100, 1);
        $this->assertEquals(100, $investment->getAmount());
    }

    /**
     * @test
     * @expectedException Soisy\Exceptions\InvalidAmountException
     */
    public function negativeAmountShouldRaiseAnException()
    {
        new Investment(-100, 1);
    }

    /**
     * @test
     * @expectedException Soisy\Exceptions\InvalidAmountException
     */
    public function zeroAmountShouldRaiseAnException()
    {
        new Investment(0, 1);
    }
}
