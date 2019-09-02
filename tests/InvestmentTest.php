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
    public function createInvestment(): void
    {
        $investment = new Investment(100, 1);

        $this->assertEquals(100, $investment->getAmount());
        $this->assertEquals(1, $investment->getRating());
    }

    /**
     * @test
     * @dataProvider ratingShouldBeBetween1And5DataProvider
     */
    public function ratingShouldBeBetween1And5(int $validRating): void
    {
        $investment = new Investment(100, $validRating);
        $this->assertEquals($validRating, $investment->getRating());
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

        new Investment(100, $invalidRating);
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
        $investment = new Investment(100, 1);
        $this->assertEquals(100, $investment->getAmount());
    }

    /**
     * @test
     */
    public function negativeAmountShouldRaiseAnException(): void
    {
        $this->expectException(\Soisy\Exceptions\InvalidAmountException::class);
        new Investment(-100, 1);
    }

    /**
     * @test
     */
    public function zeroAmountShouldRaiseAnException(): void
    {
        $this->expectException(\Soisy\Exceptions\InvalidAmountException::class);
        new Investment(0, 1);
    }
}
