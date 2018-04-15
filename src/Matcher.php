<?php

namespace Soisy;

use Soisy\Investment;
use Soisy\Loan;

/**
 * Class Investment
 *
 * @package Soisy
 */
class Matcher {

    /**
     *
     * @var Array $loans
     */
    private $loans = [];

    /**
     *
     * @var Array $investments
     */
    private $investments = [];

    /**
     *
     * @var Array $matches
     */
    private $matches = [];

    /**
     * 
     * @return array
     */
    public function getLoans() {
        return $this->loans;
    }

    /**
     * 
     * @return array
     */
    public function getInvestments() {
        return $this->investments;
    }

    /**
     * 
     * @return array
     */
    public function getMatches() {
        return $this->matches;
    }

    /**
     * 
     * @param Loan $loan
     */
    public function addLoan(Loan $loan) {
        $this->loans[] = $loan;
    }

    /**
     * 
     * @param Investment $investment
     */
    public function addInvestment(Investment $investment) {
        $this->investments[] = $investment;
    }

    /**
     * 
     * @param Loan $loan
     * @param Investment $investment
     */
    public function addMatch(Loan $loan, Investment $investment) {
        $this->matches[] = ['loan' => $loan, 'investment' => $investment,];
    }

    public function run() {
        foreach ($this->investments as $investment) {
            foreach ($this->loans as $loan) {
                if ($investment->getRating() === $loan->getRating() && $loan->getAmount() <= $investment->getAmount()) {
                    $this->addMatch($loan, $investment);
                }
            }
        }
    }

}
