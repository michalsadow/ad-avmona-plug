<?php

declare(strict_types=1);

namespace Przeslijmi\AgileDataAvmonaPlug\Statistics;

/**
 * Deliver comulative distribution value for normal distribution function.
 */
class NormalDistribution
{

    /**
     * Normal distribution array loaded on first use.
     *
     * @var array
     */
    private static $array = [];

    /**
     * Get comulative distribution value for give word, average and variance.
     *
     * @param float   $percentage Advanced of agreement from 0.00 to 1.00.
     * @param integer $average    Avarage value (5 ... 15).
     * @param integer $variance   Variance value (1 ... 10).
     *
     * @throws NormalDistributionWordOtoranException When percentage is out of range.
     * @throws NormalDistributionAverageOtoranException When average is out of range.
     * @throws NormalDistributionVarianceOtoranException When variance is out of range.
     * @return float
     */
    public static function getCum(float $percentage, int $average, int $variance): float
    {

        // Validate.
        if ($percentage < 0 || $percentage > 1) {
            throw new NormalDistributionWordOtoranException([ (string) $percentage ]);
        }
        if ($average < 5 || $average > 15) {
            throw new NormalDistributionAverageOtoranException([ (string) $average ]);
        }
        if ($variance < 1 || $variance > 10) {
            throw new NormalDistributionVarianceOtoranException([ (string) $variance ]);
        }

        // Load array.
        self::load();

        // Recalc percentage to word.
        $word = (float) ( $percentage * 19 );

        // Shortcut.
        if ($word === 19.0) {
            return 1.0;
        }

        // Simplier method.
        if ((float) ( (int) $word ) === $word) {
            return self::$array[$average][$variance][(int) $word];
        }

        // Lvd.
        $lower    = self::$array[$average][$variance][(int) $word];
        $higher   = self::$array[$average][$variance][( (int) $word + 1 )];
        $fraction = ( $word - (int) $word );

        return ( ( $fraction * $higher ) + ( ( 1 - $fraction ) * $lower ) );
    }

    /**
     * Loads array into memory if not loaded.
     *
     * @return void
     */
    private static function load(): void
    {

        // If it is loaded - do not continue the work.
        if (empty(self::$array) === false) {
            return;
        }

        // Lvd.
        $arrayUri = dirname(dirname(dirname(__FILE__))) . '/resources/normalDistribution.php';

        // Add array.
        self::$array = include $arrayUri;
    }
}
