<?php

declare(strict_types=1);

namespace Przeslijmi\AgileDataAvmonaPlug\Analysis;

use Przeslijmi\AgileData\Tools\CalcDate;
use Przeslijmi\AgileData\Tools\PeriodCalc;
use Przeslijmi\AgileDataAvmonaPlug\Analysis\Rules;
use Przeslijmi\AgileDataAvmonaPlug\Statistics\NormalDistribution;

/**
 * Forecasts capitals, interests, provisions and losses for a financial agreement.
 */
class ForecastFinancialAgreements extends Rules
{

    /**
     * Final result of this analysis - events to sand to available money analysis.
     *
     * @var array
     */
    private $events = [];

    /**
     * Main working method - creating a forecast.
     *
     * @return array
     */
    public function forecast(): array
    {

        // Forecast every record.
        foreach ($this->records as $record) {

            // Define.
            $this->currRecordId = $record->info->rowId;
            $this->currProp     = $record->properties;

            // Forcast this one.
            $this->forecastOne();

            // Add to events.
            foreach ($this->currMatrix as $period => $def) {

                if (isset($def['capitalPayment']) === true && (float) $def['capitalPayment'] !== 0.0) {
                    $this->events[] = [
                        'date' => $def['start'],
                        'name' => 'wypłata kapitału',
                        'amount' => ( -1 * $def['capitalPayment'] ),
                    ];
                }

                if (isset($def['capitalToBeRepayed']) === true && (float) $def['capitalToBeRepayed'] !== 0.0) {
                    $this->events[] = [
                        'date' => $def['end'],
                        'name' => 'spłata kapitału',
                        'amount' => $def['capitalToBeRepayed'],
                    ];
                }

                if (isset($def['interestsOwed']) === true && (float) $def['interestsOwed'] !== 0.0) {
                    $this->events[] = [
                        'date' => $def['end'],
                        'name' => 'spłata odsetek od kapitału',
                        'amount' => $def['interestsOwed'],
                    ];
                }

                if (isset($def['oneTimeFixedFee']) === true && (float) $def['oneTimeFixedFee'] !== 0.0) {
                    $this->events[] = [
                        'date' => $def['end'],
                        'name' => 'prowizja (kwotowa)',
                        'amount' => $def['oneTimeFixedFee'],
                    ];
                }

                if (isset($def['oneTimePercFee']) === true && (float) $def['oneTimePercFee'] !== 0.0) {
                    $this->events[] = [
                        'date' => $def['end'],
                        'name' => 'prowizja (procentowa)',
                        'amount' => $def['oneTimePercFee'],
                    ];
                }

                if (isset($def['feeAnnualPerc']) === true && (float) $def['feeAnnualPerc'] !== 0.0) {
                    $this->events[] = [
                        'date' => $def['end'],
                        'name' => 'wynagrodzenie (roczna stawka od portfela)',
                        'amount' => ( -1 * $def['feeAnnualPerc'] ) ,
                    ];
                }

                if (isset($def['feeLimitPerc']) === true && (float) $def['feeLimitPerc'] !== 0.0) {
                    $this->events[] = [
                        'date' => $def['start'],
                        'name' => 'wynagrodzenie (pełny limit)',
                        'amount' => ( -1 * $def['feeLimitPerc'] ) ,
                    ];
                }

                if (isset($def['feePercOfPayments']) === true && (float) $def['feePercOfPayments'] !== 0.0) {
                    $this->events[] = [
                        'date' => $def['end'],
                        'name' => 'wynagrodzenie (od wypłat)',
                        'amount' => ( -1 * $def['feePercOfPayments'] ) ,
                    ];
                }

                if (isset($def['feePercOfRepayments']) === true && (float) $def['feePercOfRepayments'] !== 0.0) {
                    $this->events[] = [
                        'date' => $def['end'],
                        'name' => 'wynagrodzenie (od spłat)',
                        'amount' => ( -1 * $def['feePercOfRepayments'] ) ,
                    ];
                }
            }//end foreach
        }//end foreach

        // Order events.
        $dates = array_column($this->events, 'date');
        array_multisort($dates, SORT_ASC, SORT_STRING, $this->events);

        return $this->events;
    }

    /**
     * Forecast one (current) record.
     *
     * @return void
     */
    private function forecastOne()
    {

        // Lvd.
        $startDate  = $this->getCurrValueForRule('startDate');
        $endDate    = $this->getCurrValueForRule('endDate');
        $periodType = $this->getCurrValueForRule('frequency', 'M');
        $amount     = $this->getCurrValueForRule('amount');

        // Get matrix.
        $this->currMatrix = PeriodCalc::getMatrixForDates($startDate, $endDate, $periodType);
        $periods          = array_keys($this->currMatrix);
        $this->addGracePeriodToMatrix();
        $firstPeriod = array_values(array_slice(array_keys($this->currMatrix), 0, 1))[0];

        // Add capital payment.
        $this->currMatrix[$firstPeriod]['capitalPayment'] = $amount;

        // Calc capital repayment distribution.
        if ($this->isCurrRule('distributionNormal') === true) {
            $this->addNormalDistribtion();
        } else {
            $this->addLinearDistribtion();
        }

        // Add incomes.
        $this->addInterests();
        $this->addFixedFee();
        $this->addPercentageFee();

        // Add expenditures.
        $this->addFeeAnnualPerc();
        $this->addFeeLimitPerc();
        $this->addFeePercOfPayments();
        $this->addFeePercOfRepyments();
    }

    /**
     * Mark every period in matrix is that a grace period or not.
     *
     * @return void
     */
    private function addGracePeriodToMatrix(): void
    {

        // Lvd.
        $startDate   = $this->getCurrValueForRule('startDate');
        $gracePeriod = (int) $this->getCurrValueForRule('gracePeriod', '0');
        $endOfGrace  = CalcDate::add(CalcDate::add($startDate, $gracePeriod, 'M'), -1, 'D');

        // Mark periods.
        foreach ($this->currMatrix as $period => $def) {

            // Check if this is grace or not.
            if (
                $endOfGrace >= $def['start'] && $endOfGrace <= $def['end']
                || $endOfGrace >= $def['end']
            ) {
                $setTo = true;
            } else {
                $setTo = false;
            }

            // Set.
            $this->currMatrix[$period]['grace'] = $setTo;
        }

        // Check - if all periods are grace periods - than force last period not do be a grace period.
        if ($setTo === true) {
            $this->currMatrix[$period]['grace'] = false;
        }
    }

    /**
     * Adds capital repayment in linear distribution calculation.
     *
     * @return void
     */
    private function addLinearDistribtion(): void
    {

        // Lvd.
        $loss         = (float) $this->getCurrValueForRule('loss', '0');
        $amount       = ( $this->getCurrValueForRule('amount') * ( 1 - $loss ) );
        $gracePeriods = array_sum(array_column($this->currMatrix, 'grace'));
        $repayPeriods = ( count($this->currMatrix) - $gracePeriods );
        $installement = ( $amount / $repayPeriods );
        $ngpc         = 0;

        // Add to matrix.
        foreach (array_keys($this->currMatrix) as $period) {

            // Numeric representation of grace period (1 / 0).
            $isGrace = (int) ( ! $this->currMatrix[$period]['grace'] );

            // Calc.
            $this->currMatrix[$period]['capitalOutstandingAtStart'] = ( $amount - ( $installement * $ngpc ) );
            $this->currMatrix[$period]['capitalToBeRepayed']        = ( $installement * $isGrace );

            // Increase non-grace periods counter.
            if ($isGrace === 1) {
                ++$ngpc;
            }
        }
    }

    /**
     * Adds capital repayment in normal distribution calculation.
     *
     * @return void
     */
    private function addNormalDistribtion(): void
    {

        // Distribution definition.
        list($average, $variance) = $this->getCurrValuesForRule('distributionNormal');
        $average                  = (int) $average;
        $variance                 = (int) $variance;

        // Lvd.
        $loss           = (float) $this->getCurrValueForRule('loss', '0');
        $amount         = ( $this->getCurrValueForRule('amount') * ( 1 - $loss ) );
        $gracePeriods   = array_sum(array_column($this->currMatrix, 'grace'));
        $repayPeriods   = ( count($this->currMatrix) - $gracePeriods );
        $periodLength   = (float) ( 1 / $repayPeriods );
        $ngpc           = 0;
        $prevCumulative = 0.0;
        $lastPeriodsKey = max(array_keys($this->currMatrix));

        // Add to matrix.
        foreach (array_keys($this->currMatrix) as $period) {

            // Numeric representation of grace period (1 / 0).
            $isGrace = (int) ( ! $this->currMatrix[$period]['grace'] );

            // Increase non-grace periods counter.
            if ($isGrace === 1) {
                ++$ngpc;
            }

            // How much capital will be repayed at the end of period cumulative.
            if ($period === $lastPeriodsKey) {
                $cumulative = NormalDistribution::getCum(1, $average, $variance);
            } else {
                $cumulative = NormalDistribution::getCum(( $ngpc * $periodLength ), $average, $variance);
            }
            $cumulative = ( $isGrace * ( $cumulative * $amount ) );

            // Calc.
            $this->currMatrix[$period]['capitalOutstandingAtStart'] = $prevCumulative;
            $this->currMatrix[$period]['capitalToBeRepayed']        = ( $cumulative - $prevCumulative );

            // Save for next iteration.
            $prevCumulative = $cumulative;
        }//end foreach
    }

    /**
     * Adds `interestsRate` calculation.
     *
     * @return void
     */
    private function addInterests(): void
    {

        // Lvd.
        $interestsRate = (float) $this->getCurrValueForRule('interestsRate', '0');

        // Shortcut.
        if ($interestsRate === (float) 0.0) {
            return;
        }

        // Add interests to every period.
        foreach ($this->currMatrix as $period => $def) {

            // Lvd.
            $capitalOwed = (float) ( $def['capitalOutstandingAtStart'] ?? 0.0 );

            // Calc interests.
            $amount = ( $capitalOwed * ( $interestsRate / 365 ) * $this->getPeriodLenght($def) );

            // Save interests.
            $this->currMatrix[$period]['interestsOwed'] = $amount;
        }
    }

    /**
     * Adds `oneTimeFixedFee` calculation.
     *
     * @return void
     */
    private function addFixedFee(): void
    {

        // Lvd.
        $fixedFee = (float) $this->getCurrValueForRule('oneTimeFixedFee', '0');

        // Shortcut.
        if ($fixedFee === (float) 0.0) {
            return;
        }

        // Calc fee.
        $firstPeriod = array_values(array_slice(array_keys($this->currMatrix), 0, 1))[0];

        // Save fee.
        $this->currMatrix[$firstPeriod]['oneTimeFixedFee'] = $fixedFee;
    }

    /**
     * Adds `oneTimePercFee` calculation.
     *
     * @return void
     */
    private function addPercentageFee(): void
    {

        // Lvd.
        $amount  = $this->getCurrValueForRule('amount');
        $percFee = (float) $this->getCurrValueForRule('oneTimePercFee', '0');

        // Shortcut.
        if ($percFee === (float) 0.0) {
            return;
        }

        // Calc fee.
        $firstPeriod = array_values(array_slice(array_keys($this->currMatrix), 0, 1))[0];

        // Save fee.
        $this->currMatrix[$firstPeriod]['oneTimePercFee'] = ( $percFee * $amount );
    }

    /**
     * Adds `feeAnnualPerc` calculation.
     *
     * @return void
     */
    private function addFeeAnnualPerc(): void
    {

        // Lvd.
        $feeAnnualPerc = (float) $this->getCurrValueForRule('feeAnnualPerc', '0');

        // Shortcut.
        if ($feeAnnualPerc === (float) 0.0) {
            return;
        }

        // Add fee to every period.
        foreach ($this->currMatrix as $period => $def) {

            // Calc fee.
            $fee = ( $def['capitalOutstandingAtStart'] * ( $feeAnnualPerc / 365 ) * $this->getPeriodLenght($def) );

            // Save fee.
            $this->currMatrix[$period]['feeAnnualPerc'] = $fee;
        }
    }

    /**
     * Adds `feeLimitPerc` calculation.
     *
     * @return void
     */
    private function addFeeLimitPerc(): void
    {

        // Lvd.
        list($feeLimitPerc, $amount) = $this->getCurrValuesForRule('feeLimitPerc', '0', '0');

        // Shortcut.
        if ((float) $feeLimitPerc === (float) 0.0) {
            return;
        }

        // Lvd.
        $feeLimitPerc = (float) $feeLimitPerc;
        $amount       = (float) $amount;
        $firstPeriod  = array_values(array_slice(array_keys($this->currMatrix), 0, 1))[0];

        // Calc and save fee.
        $this->currMatrix[$firstPeriod]['feeLimitPerc'] = ( $amount * $feeLimitPerc );
    }

    /**
     * Adds `feePercOfPayments` calculation.
     *
     * @return void
     */
    private function addFeePercOfPayments(): void
    {

        // Lvd.
        $feePercOfPayments = (float) $this->getCurrValueForRule('feePercOfPayments', '0', '0');
        $amount            = (float) $this->getCurrValueForRule('amount');

        // Shortcut.
        if ($feePercOfPayments === (float) 0.0) {
            return;
        }

        // Lvd.
        $firstPeriod = array_values(array_slice(array_keys($this->currMatrix), 0, 1))[0];

        // Calc and save fee.
        $this->currMatrix[$firstPeriod]['feePercOfPayments'] = ( $amount * $feePercOfPayments );
    }

    /**
     * Adds `feePercOfRepayments` calculation.
     *
     * @return void
     */
    private function addFeePercOfRepyments(): void
    {

        // Lvd.
        $feePercOfRepayments = (float) $this->getCurrValueForRule('feePercOfRepayments', '0', '0');

        // Shortcut.
        if ($feePercOfRepayments === (float) 0.0) {
            return;
        }

        // Calc and save fee for every period.
        foreach ($this->currMatrix as $period => $def) {
            $this->currMatrix[$period]['feePercOfRepayments'] = ( $def['capitalToBeRepayed'] * $feePercOfRepayments );
        }
    }
}
