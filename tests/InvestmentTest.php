<?php

use PHPUnit\Framework\TestCase;
use Soisy\Investment;
use Soisy\ValueObject\Amount;
use Soisy\ValueObject\Rating;
use Soisy\ValueObject\InvestmentId;

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
        $investment = new Investment(new InvestmentId(1), new Amount(100), new Rating(1));

        $this->assertEquals(100, $investment->getAmount()->getValue());
        $this->assertEquals(1, $investment->getRating()->getValue());
    }

    /**
     * @test
     * @dataProvider ratingShouldBeBetween1And5DataProvider
     *
     * @param int $validRating
     */
    public function ratingShouldBeBetween1And5(int $validRating): void
    {
        $investment = new Investment(new InvestmentId(1), new Amount(100), new Rating($validRating));
        $this->assertEquals($validRating, $investment->getRating()->getValue());
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

        new Investment(new InvestmentId(1), new Amount(100), new Rating($invalidRating));

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
        $investment = new Investment(new InvestmentId(1), new Amount(100), new Rating(1));
        $this->assertEquals(100, $investment->getAmount()->getValue());
    }

    /**
     * @test
     */
    public function negativeAmountShouldRaiseAnException(): void
    {
        $this->expectException(\Soisy\Exceptions\InvalidAmountException::class);

        new Investment(new InvestmentId(1), new Amount(-100), new Rating(1));
    }

    /**
     * @test
     */
    public function zeroAmountShouldRaiseAnException(): void
    {
        $this->expectException(\Soisy\Exceptions\InvalidAmountException::class);

        new Investment(new InvestmentId(1), new Amount(0), new Rating(1));
    }
}
