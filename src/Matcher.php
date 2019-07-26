<?php


namespace Soisy;

class Matcher
{
    protected $loans;
    protected $investments;
    protected $matches;

    public function __construct()
    {
        $this->loans = [];
        $this->investments = [];
        $this->matches = [];
    }

    /**
     * Returns all loans
     * @return array|Loan[]
     */
    public function getLoans()
    {
        return $this->loans;
    }

    /**
     * Add a loan
     * @param Loan $loan
     */
    public function addLoan(Loan $loan)
    {
        $this->loans[] = $loan;
    }

    /**
     * Returns all loans
     * @return array|Investment[]
     */
    public function getInvestments()
    {
        return $this->investments;
    }

    /**
     * Add an investment
     * @param Investment $investment
     */
    public function addInvestment(Investment $investment)
    {
        $this->investments[] = $investment;
    }

    /**
     * Add a match
     * @TODO: Should throw an exception if the match is invalid ?
     *
     * @param Loan $loan
     * @param Investment $investment
     */
    public function addMatch(Loan $loan, Investment $investment)
    {
        $this->matches[] = [
            'loan' => $loan,
            'investment' => $investment
        ];
    }

    /**
     * Check if there are any match in the current loan/investment set
     * @TODO: Should it preserve the current matches array ?
     * @TODO: Can, an investment, match multiple loans if the sum of the loans is greater than the investment ?
     */
    public function run()
    {
        $this->matches = [];
        foreach ($this->investments as $investment) {
            foreach ($this->loans as $loan) {
                /**
                 * An investment and a loan are a match if the share the same rating and the investment's amount is
                 * greater or equal of the loan's amount
                 *
                 * @var Investment $investment
                 * @var Loan $loan
                 */
                if ($investment->getRating() === $loan->getRating() && $investment->getAmount() >= $loan->getAmount()) {
                    $this->matches[] = [
                        'loan' => $loan,
                        'investment' => $investment
                    ];
                }
            }
        }
    }

    /**
     * Returns all investment/loan match present
     * @return array
     */
    public function getMatches()
    {
        return $this->matches;
    }
}
