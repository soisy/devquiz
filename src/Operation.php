<?php

namespace Soisy;

/**
 * Class Operation
 *
 * @package Soisy
 */
class Operation
{

  private $amount;
  private $rating;

  public function __construct($amount, $rating)
  {
    if($rating < 1 || $rating > 5) throw new Exceptions\InvalidRatingException("Rating is not valid");
    if($amount <= 0) throw new Exceptions\InvalidAmountException("Amount is not valid");
    $this->amount = $amount;
    $this->rating = $rating;
  }

  public function getAmount()
  {
    return $this->amount;
  }

  public function getRating()
  {
    return $this->rating;
  }

}
