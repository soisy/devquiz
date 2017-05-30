<?php

namespace Soisy;

/**
 * Class Matcher
 *
 * @package Soisy
 */
class Matcher
{

  private $loans;
  private $investments;
  private $matches;

  public function addLoan($loan)
  {
    $this->loans[] = $loan;
  }

  public function getLoans()
  {
    return $this->loans;
  }

  public function addInvestment($investment)
  {
    $this->investments[] = $investment;
  }

  public function getInvestments()
  {
    return $this->investments;
  }

  public function addMatch($loan, $investment)
  {
    $this->matches[] = array(
      "loan" => $loan,
      "investment" => $investment
    );
  }

  public function getMatches()
  {
    return $this->matches;
  }

  public function run()
  {
    $investments = $this->investments;
    foreach ($this->loans as $i => $loan) {
      foreach ($investments as $j => $investment) {
        if ($loan->getRating() == $investment->getRating() && $loan->getAmount() <= $investment->getAmount()) {
          $this->addMatch($loan, $investment);
          unset($investments[$j]);
          break;
        }
      }
    }
  }
}
