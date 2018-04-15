<?php

namespace Soisy;

use Soisy\Exceptions\InvalidRatingException;
use Soisy\Exceptions\InvalidAmountException;

/**
 * Class Investment
 *
 * @package Soisy
 */
class Loan {

    /**
     *
     * @var integer $amount
     */
    private $amount;
    
    /**
     *
     * @var integer $rating
     */
    private $rating;

    /**
     * 
     * @param integer $amount
     * @param integer $rating
     * @throws InvalidRatingException
     * @throws InvalidAmountException
     */
    public function __construct($amount, $rating) {
        if ($rating < 1 || $rating > 5) {
            throw new InvalidRatingException("rating must be >= 1 and <= 5");
        }
        if ($amount <= 0) {
            throw new InvalidAmountException("amount must be positive");
        }
        $this->amount = $amount;
        $this->rating = $rating;
    }

    /**
     * 
     * @return integer
     */
    public function getAmount() {
        return $this->amount;
    }

    /**
     * 
     * @return integer
     */
    public function getRating() {
        return $this->rating;
    }

}
