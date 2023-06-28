<?php

declare(strict_types=1);

namespace Przeslijmi\AgileDataAvmonaPlug\Analysis;

use DateTime;
use Przeslijmi\AgileData\Tools\CalcDate;
use Przeslijmi\AgileData\Tools\PeriodCalc;
use stdClass;

/**
 * Performs free money analisys based on given list of events.
 */
class FinalAnalysis
{

    /**
     * Possible period types.
     *
     * @var string
     */
    public const PERIOD_TYPES = [ 'M',  'Q',  'H',  'Y' ];

    /**
     * First day of analysis in YYYY-MM-DD format.
     *
     * @var string
     */
    private $firstDay;

    /**
     * Number of periods to analyse.
     *
     * @var integer
     */
    private $periods;

    /**
     * Optional starting amonut of money for analysis.
     *
     * @var float
     */
    private $startingMoney = 0.0;

    /**
     * Type of period to use.
     *
     * @var string
     */
    private $periodType;

    /**
     * Actual contents of analysis.
     *
     * @var array
     */
    private $matrix = [];

    /**
     * Constructor.
     */
    public function __construct()
    {

        // Define standard settings.
        $this->firstDay   = date('Y-m-d');
        $this->periods    = 12;
        $this->periodType = 'M';
    }

    /**
     * Performs analysis on given set of events.
     *
     * @param array $events Events to use in analyse.
     *
     * @return array
     */
    public function perform(array $events): array
    {

        // Prepare matrix.
        $this->prepareMatrix();

        // Count every events to matrix.
        foreach ($events as $event) {

            // Find proper period.
            $period = PeriodCalc::getFor($event['date'], $this->periodType);

            // Ignore this event if this period is not in matrix.
            if (isset($this->matrix[$period]) === false) {
                continue;
            }

            // Add to matrix.
            if ($event['amount'] > 0) {
                $this->matrix[$period]['inPlus'] += $event['amount'];
            } else {
                $this->matrix[$period]['inMinus'] += $event['amount'];
            }
        }

        // Count final values.
        $periods = array_keys($this->matrix);
        foreach ($periods as $periodOrder => $period) {

            // Calc.
            $this->matrix[$period]['onFinish']  = $this->matrix[$period]['onStart'];
            $this->matrix[$period]['onFinish'] += $this->matrix[$period]['inPlus'];
            $this->matrix[$period]['onFinish'] += $this->matrix[$period]['inMinus'];

            // Move onFinish as onStart to next period - if that period exists.
            $nextPeriod = ( $periods[( $periodOrder + 1 )] ?? null );
            if ($nextPeriod !== null) {
                $this->matrix[$nextPeriod]['onStart'] = $this->matrix[$period]['onFinish'];
            }
        }

        return $this->matrix;
    }

    /**
     * Sets first day.
     *
     * @param string $firstDay YYYY-MM-DD date of a first day of analisys.
     *
     * @return void
     */
    public function setFirstDay(string $firstDay): void
    {

        // Check if date is proper.
        CalcDate::validate($firstDay);

        // Save.
        $this->firstDay = $firstDay;
    }

    /**
     * Sets length of periods to analyse.
     *
     * @param integer $periods How many periods to analise (more than 0, no more than 600).
     *
     * @throws PeriodsOtoranException When number of periods is below 1 or above 600.
     * @return void
     */
    public function setPeriods(int $periods): void
    {

        // Throw.
        if ($periods < 1 || $periods > 600) {
            throw new PeriodsOtoranException([ (string) $periods ]);
        }

        // Save.
        $this->periods = $periods;
    }

    /**
     * Sets type of period (Y, H, Q, M).
     *
     * @param string $periodType Type of period (Y, H, Q, M).
     *
     * @throws PeriodTypeUnknownException When period type is unknown.
     * @return void
     */
    public function setPeriodsType(string $periodType): void
    {

        // Throw.
        if (in_array($periodType, self::PERIOD_TYPES) === false) {
            throw new PeriodTypeUnknownException([ $periodType ]);
        }

        // Save.
        $this->periodType = $periodType;
    }

    /**
     * Sets starting money (optional).
     *
     * @param float $startingMoney Starting money.
     *
     * @return void
     */
    public function setStartingMoney(float $startingMoney): void
    {

        $this->startingMoney = $startingMoney;
    }

    /**
     * Prepares matrix of data.
     *
     * ## Matrix example
     * ```
     * [
     *     '2020Q1' => [
     *         'period' => '2020Q1',
     *         'start' => '2020-01-01',
     *         'stop' => '2020-03-31',
     *         'onStart' => 0.0,
     *         'inPlus' => 0.0,
     *         'inMinus' => 0.0,
     *         'onFinish' => 0.0,
     *     ],
     *     '2020Q2' => ...
     * ]
     * ```
     *
     * @return void
     */
    private function prepareMatrix(): void
    {

        // For every period.
        for ($p = 0; $p < $this->periods; ++$p) {

            // Calc date that is `$p` periods from first day.
            $movedDate = CalcDate::add($this->firstDay, $p, $this->periodType);

            // Create period element.
            $period             = PeriodCalc::getPeriodAndDates($movedDate, $this->periodType);
            $period['onStart']  = 0.0;
            $period['inPlus']   = 0.0;
            $period['inMinus']  = 0.0;
            $period['onFinish'] = 0.0;

            // Save this period to matrix.
            $this->matrix[$period['period']] = $period;
        }

        // Get first period id.
        $firstPeriod = array_slice(array_keys($this->matrix), 0, 1)[0];

        // Fix first day and add amount.
        $this->matrix[$firstPeriod]['start']   = $this->firstDay;
        $this->matrix[$firstPeriod]['onStart'] = $this->startingMoney;
    }
}
