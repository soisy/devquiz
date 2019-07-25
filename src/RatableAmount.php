<?php


namespace Soisy;

use Soisy\Exceptions\InvalidAmountException;
use Soisy\Exceptions\InvalidRatingException;

class RatableAmount
{
    /**
     * @var int
     */
    protected $amount;

    /**
     * @var int
     */
    protected $rating;

    /**
     * RatableAmount constructor.
     * @param $amount
     * @param $rating
     * @throws InvalidAmountException
     * @throws InvalidRatingException
     */
    public function __construct($amount, $rating)
    {
        // Amount must be an positive integer
        if (! is_int($amount) || $amount <= 0) {
            throw new InvalidAmountException();
        }
        $this->amount = $amount;

        // Rating must be an integer between 1 and 5
        if (! is_int($rating) || $rating > 5 || $rating < 1) {
            throw new InvalidRatingException();
        }
        $this->rating = $rating;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @return mixed
     */
    public function getRating()
    {
        return $this->rating;
    }
}
