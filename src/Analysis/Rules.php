<?php

declare(strict_types=1);

namespace Przeslijmi\AgileDataAvmonaPlug\Analysis;

use DateTime;
use stdClass;

/**
 * Abstract parent class for every analysis method basing on rules.
 */
abstract class Rules
{

    /**
     * Set of rules.
     *
     * @var stdClass[]
     */
    private $rules = [];

    /**
     * ID of record that is currently forcasted.
     *
     * @var integer
     */
    protected $currRecordId;

    /**
     * Properties of record that is currently forcasted.
     *
     * @var stdClass
     */
    protected $currProp;

    /**
     * All records for which forcast will be created.
     *
     * @var array
     */
    protected $records = [];

    /**
     * Sets rules.
     *
     * @param array $rules Set of rules.
     *
     * @return void
     */
    public function setRules(array $rules): void
    {

        $this->rules = $rules;
    }

    /**
     * Sets recrods to forcast.
     *
     * @param array $records All records for which forcast will be created.
     *
     * @return void
     */
    public function setRecords(array $records): void
    {

        $this->records = $records;
    }

    /**
     * Get rules of given type.
     *
     * @param string $ruleType Type of rules to return.
     *
     * @return array
     */
    protected function getRules(string $ruleType): array
    {

        // Lvd.
        $result = [];

        // Scan.
        foreach ($this->rules as $rule) {
            if ($rule->type === $ruleType) {
                $result[] = $rule;
            }
        }

        return $result;
    }

    /**
     * Returns if for current record - given type of rule has been defined.
     *
     * @param string $ruleType Type of rules to check.
     *
     * @return boolean
     */
    protected function isCurrRule(string $ruleType): bool
    {

        return (bool) count($this->getRules($ruleType));
    }

    /**
     * Returns value for current record and for given rule type (frstParam only).
     *
     * @param string      $ruleType Type of rules to check.
     * @param null|string $fallback Optional, null. Fallback value if rule is not present.
     *
     * @return null|string
     */
    protected function getCurrValueForRule(string $ruleType, ?string $fallback = null): ?string
    {

        // Find value scanning rules and return first that fits.
        foreach ($this->getRules($ruleType) as $rule) {

            // First variant for `field` rule, second for `text` rule.
            if (
                $rule->frstParamType === 'yes'
                && ( (string) $this->currProp->{$rule->frstParamProp} ?? '' ) !== ''
            ) {
                return (string) $this->currProp->{$rule->frstParamProp};

            } elseif (
                $rule->frstParamType === 'no'
                && (string) $rule->frstParamText !== ''
            ) {
                return (string) $rule->frstParamText;

            }
        }

        return $fallback;
    }

    /**
     * Returns values for current record and for given rule type (frstParam and scndParam).
     *
     * @param string      $ruleType     Type of rules to check.
     * @param null|string $frstFallback Optional, null. Fallback for first param value if rule is not present.
     * @param null|string $scndFallback Optional, null. Fallback for second param value if rule is not present.
     *
     * @return arrray
     */
    protected function getCurrValuesForRule(
        string $ruleType,
        ?string $frstFallback = null,
        ?string $scndFallback = null
    ): array {

        // Lvd.
        $result = [];

        // Find value scanning rules and return first that fits.
        foreach ($this->getRules($ruleType) as $rule) {

            // First variant for `field` rule, second for `text` rule.
            if (
                isset($result[0]) === false
                && $rule->frstParamType === 'yes'
                && ( (string) $this->currProp->{$rule->frstParamProp} ?? '' ) !== ''
            ) {
                $result[0] = (string) $this->currProp->{$rule->frstParamProp};

            } elseif (
                isset($result[0]) === false
                && $rule->frstParamType === 'no'
                && (string) $rule->frstParamText !== ''
            ) {
                $result[0] = (string) $rule->frstParamText;

            }

            // First variant for `field` rule, second for `text` rule.
            if (
                isset($result[1]) === false
                && $rule->scndParamType === 'yes'
                && ( (string) $this->currProp->{$rule->scndParamProp} ?? '' ) !== ''
            ) {
                $result[1] = (string) $this->currProp->{$rule->scndParamProp};

            } elseif (
                isset($result[1]) === false
                && $rule->scndParamType === 'no'
                && (string) $rule->scndParamText !== ''
            ) {
                $result[1] = (string) $rule->scndParamText;

            }
        }//end foreach

        return [
            0 => ( $result[0] ?? $frstFallback ),
            1 => ( $result[1] ?? $scndFallback ),
        ];
    }

    /**
     * Return lenght of given period in days.
     *
     * @param array $periodDef Which period.
     *
     * @return integer
     */
    protected function getPeriodLenght(array $periodDef): int
    {

        // Lvd.
        $start = new DateTime($periodDef['start']);
        $end   = new DateTime($periodDef['end']);

        return ( 1 + $start->diff($end)->format('%a') );
    }
}
