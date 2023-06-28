<?php

declare(strict_types=1);

namespace Przeslijmi\AgileDataAvmonaPlug\Operations;

use Przeslijmi\AgileData\Operations\CommonMethodsForTests as MyParent;
use Przeslijmi\AgileData\Operations\OperationsInterface as MyInterface;
use Przeslijmi\AgileDataAvmonaPlug\Analysis\ForecastFinancialAgreements as Analysis;
use Przeslijmi\AgileDataAvmonaPlug\Models\AvmonaEvents as EventsCollection;
use stdClass;

/**
 * Operation that adds events based on forecasting financial agreement.
 */
class ForecastFinancialAgreements extends MyParent implements MyInterface
{

    /**
     * Operation key.
     *
     * @var string
     */
    protected static $opKey = 'RSyfaQ4W';

    /**
     * Only those fields are accepted for this operation.
     *
     * @var array
     */
    public static $operationFields = [
        'capitalRules_type_*',
        'capitalRules_frstParamType_*',
        'capitalRules_frstParamProp_*',
        'capitalRules_frstParamText_*',
        'capitalRules_scndParamType_*',
        'capitalRules_scndParamProp_*',
        'capitalRules_scndParamText_*',
        'incomesRules_type_*',
        'incomesRules_frstParamType_*',
        'incomesRules_frstParamProp_*',
        'incomesRules_frstParamText_*',
        'incomesRules_scndParamType_*',
        'incomesRules_scndParamProp_*',
        'incomesRules_scndParamText_*',
        'expendituresRules_type_*',
        'expendituresRules_frstParamType_*',
        'expendituresRules_frstParamProp_*',
        'expendituresRules_frstParamText_*',
        'expendituresRules_scndParamType_*',
        'expendituresRules_scndParamProp_*',
        'expendituresRules_scndParamText_*',
        'filtering',
    ];

    /**
     * Get info (mainly name and category of this operation).
     *
     * @return stdClass
     */
    public static function getInfo(): stdClass
    {

        // Lvd.
        $locSta = 'Przeslijmi.AgileDataAvmonaPlug.Operations.ForecastFinancialAgreements.';

        // Lvd.
        $result           = new stdClass();
        $result->name     = $_ENV['LOCALE']->get($locSta . 'title');
        $result->vendor   = 'Przeslijmi\AgileDataAvmonaPlug';
        $result->class    = self::class;
        $result->depr     = false;
        $result->category = 410;

        return $result;
    }

    /**
     * Deliver fields to edit settings of this operation.
     *
     * @param string        $taskId Id of task in which edited step is present.
     * @param stdClass|null $step   Opt. Only when editing step (when creating it is null).
     *
     * @return array
     *
     * @phpcs:disable Generic.CodeAnalysis.UnusedFunctionParameter
     */
    public static function getStepFormFields(string $taskId, ?stdClass $step = null): array
    {

        // Lvd.
        $fields = [];
        $loc    = $_ENV['LOCALE'];
        $locSta = 'Przeslijmi.AgileDataAvmonaPlug.Operations.ForecastFinancialAgreements.fields.';

        // Define capitalRules records.
        if (isset($step->capitalRules) === true) {
            $step->capitalRules = self::translateRule(
                $step->capitalRules,
                'frequency',
                'frst',
                $locSta . 'capitalRulesType.',
                false
            );
        }

        // Add fields.
        $fields[] = self::getRulesField($step, 'capitalRules');
        $fields[] = self::getRulesField($step, 'incomesRules');
        $fields[] = self::getRulesField($step, 'expendituresRules');
        $fields[] = [
            'type' => 'contentDesigner',
            'designerJsClass' => 'LogicDesignerField',
            'id' => 'filtering',
            'value' => ( $step->filtering ?? null ),
            'name' => $loc->get($locSta . 'filtering.name'),
            'desc' => $loc->get($locSta . 'filtering.desc'),
            'group' => $loc->get('Przeslijmi.AgileData.tabs.filtering'),
        ];

        return $fields;
    }

    /**
     * Prevalidator is optional in operation class and converts step if it is needed.
     *
     * @param stdClass $step Original step.
     *
     * @return stdClass Converted step.
     */
    public function preValidation(stdClass $step): stdClass
    {

        // Unpack and translate capitalRules.
        if (isset($step->capitalRules) === false) {

            // Unpack fields.
            $step = $this->unpackMultiFieldsToRecords($step, 'capitalRules');

            // Prepare locale prefix for translation.
            $locSta = 'Przeslijmi.AgileDataAvmonaPlug.Operations.ForecastFinancialAgreements.fields.capitalRulesType.';

            // Translate.
            $step->capitalRules = self::translateRule($step->capitalRules, 'frequency', 'frst', $locSta, true);
        }

        // Unpack and translate incomesRules.
        if (isset($step->incomesRules) === false) {

            // Unpack fields.
            $step = $this->unpackMultiFieldsToRecords($step, 'incomesRules');
        }

        // Unpack and translate expendituresRules.
        if (isset($step->expendituresRules) === false) {

            // Unpack fields.
            $step = $this->unpackMultiFieldsToRecords($step, 'expendituresRules');
        }

        return $step;
    }

    /**
     * Returns one of three rules multi-fields (ie. `capitalRules`, `incomesRules`, `expendituresRules`).
     *
     * @param null|stdClass $step   Step definition from AgileData.
     * @param string        $prefix Which of three fields to create.
     *
     * @return array
     */
    private static function getRulesField(?stdClass $step, string $prefix): array
    {

        // Lvd.
        $loc    = $_ENV['LOCALE'];
        $locSta = 'Przeslijmi.AgileDataAvmonaPlug.Operations.ForecastFinancialAgreements.fields.';

        // Pack records.
        $records = self::packMultiFieldsIntoRecord($step, $prefix, [
            'type' => '',
            'frstParamType' => '',
            'frstParamProp' => '',
            'frstParamText' => '',
            'scndParamType' => '',
            'scndParamProp' => '',
            'scndParamText' => '',
        ]);

        return [
            'type' => 'multi',
            'id' => $prefix,
            'allowAdding' => true,
            'allowDeleting' => true,
            'allowReorder' => true,
            'name' => $loc->get($locSta . $prefix . '.name'),
            'desc' => $loc->get($locSta . $prefix . '.desc'),
            'subFields' => [
                [
                    'type' => 'select',
                    'id' => $prefix . '_type',
                    'name' => $loc->get($locSta . $prefix . '.type.name'),
                    'options' => self::getRules($prefix),
                    'dependsOnField' => $prefix . '_sourceProp_*',
                    'htmlData' => [
                        'show-none-one-two-params' => $prefix,
                    ],
                ],
                [
                    'type' => 'toggle',
                    'value' => 'yes',
                    'id' => $prefix . '_frstParamType',
                    'name' => $loc->get($locSta . $prefix . '.frstParamType.name'),
                    'myToggle' => $loc->get($locSta . $prefix . '.frstParamType.toggle'),
                    'htmlData' => [
                        'toggle-param-content' => 'frstParam',
                    ],
                ],
                [
                    'type' => 'select',
                    'id' => $prefix . '_frstParamProp',
                    'name' => $loc->get($locSta . $prefix . '.frstParam.name'),
                    'options' => [],
                    'isAvailablePropChooser' => true,
                ],
                [
                    'type' => 'text',
                    'id' => $prefix . '_frstParamText',
                    'name' => false,
                ],
                [
                    'type' => 'toggle',
                    'value' => 'yes',
                    'id' => $prefix . '_scndParamType',
                    'name' => $loc->get($locSta . $prefix . '.scndParamType.name'),
                    'myToggle' => $loc->get($locSta . $prefix . '.scndParamType.toggle'),
                    'htmlData' => [
                        'toggle-param-content' => 'scndParam',
                    ],
                ],
                [
                    'type' => 'select',
                    'id' => $prefix . '_scndParamProp',
                    'name' => $loc->get($locSta . $prefix . '.scndParam.name'),
                    'options' => [],
                    'isAvailablePropChooser' => true,
                ],
                [
                    'type' => 'text',
                    'id' => $prefix . '_scndParamText',
                    'name' => false,
                ],
            ],
            'values' => $records,
            'group' => $loc->get('Przeslijmi.AgileData.tabs.' . $prefix),
        ];
    }

    /**
     * Returns rules of give type with translated frstParamText and scndParamText (eg. `monthly` to `M`).
     *
     * @param array   $rules    Set of rules.
     * @param string  $ruleType Rule type (eg. `loss`).
     * @param string  $param    Which param: `frst` or `scnd`.
     * @param string  $locSta   Prefix of locale name.
     * @param boolean $flip     Flip translation from locale (`true` means to convert `M` to `monthly`).
     *
     * @return array
     */
    private static function translateRule(
        array $rules,
        string $ruleType,
        string $param,
        string $locSta,
        bool $flip
    ): array {

        // Lvd.
        $translation = $_ENV['LOCALE']->getSub($locSta . $ruleType . '.' . $param . 'Param.options');
        if ($flip === true) {
            $translation = array_flip($translation);
        }

        // Scan all rules.
        foreach ($rules as $ruleId => $rule) {

            // Only in proper rule type.
            if ($rule->type === $ruleType) {
                $rules[$ruleId]->{$param . 'ParamText'} = ( $translation[$rule->{$param . 'ParamText'}] ?? null );
            }
        }

        return $rules;
    }

    /**
     * Validates plug definition.
     *
     * @return void
     */
    public function validate(): void
    {

        // Test nodes.
        $this->testNodes($this->getStepPathInPlug(), $this->getStep(), [
            'filtering' => 'string',
            'capitalRules' => '!array',
        ]);
    }

    /**
     * Perform analysis.
     *
     * @return void
     */
    public function perform(): void
    {

        // Lvd.
        $records = [];
        $locale  = $_ENV['LOCALE']->getSub('Przeslijmi.AgileDataAvmonaPlug.Events.column');

        // Start and define analysis.
        $anal = new Analysis();
        $anal->setRules(array_merge(
            $this->getStep()->capitalRules,
            $this->getStep()->incomesRules,
            $this->getStep()->expendituresRules
        ));
        $anal->setRecords($this->getCallingTask()->getRecordsFiltered($this->getStep()));

        // Get forecast and convert it to real records.
        foreach ($anal->forecast() as $eventId => $event) {
            $records[] = $this->createEmptyRecord(( $eventId + 1 ), [
                $locale['date'] => $event['date'],
                $locale['name'] => $event['name'],
                $locale['amount'] => $event['amount'],
            ]);
        }

        $this->getCallingTask()->replaceRecords($records, $this->getDataTypes());
    }

    /**
     * Delivers simple list of props that is available after this operation finishes work.
     *
     * @param array $inputProps Properties available in previous operation.
     *
     * @return string[]
     */
    public function getPropsAvailableAfter(array $inputProps): array
    {

        // Add all properties.
        foreach ($this->getDataTypes() as $field => $dataType) {
            $result[$field] = [
                'dataType' => $dataType,
            ];
        }

        return $result;
    }

    /**
     * Deliver rules for given prefix (capitalRules, incomesRules, expendituresRules).
     *
     * @param string $prefix One of prefixes (see above).
     *
     * @throws PrefixUnknownException When given prefix is not one of those three.
     * @return array
     */
    private static function getRules(string $prefix): array
    {

        // Lvd.
        $loc    = $_ENV['LOCALE'];
        $locSta = 'Przeslijmi.AgileDataAvmonaPlug.Operations.ForecastFinancialAgreements.fields.' . $prefix . 'Type.';

        if ($prefix === 'capitalRules') {
            return [
                'amount' => [
                    'text' => $loc->get($locSta . 'amount'),
                    'data' => [
                        'data-fields' => 1,
                    ],
                ],
                'startDate' => [
                    'text' => $loc->get($locSta . 'startDate'),
                    'data' => [
                        'data-fields' => 1,
                    ],
                ],
                'endDate' => [
                    'text' => $loc->get($locSta . 'endDate'),
                    'data' => [
                        'data-fields' => 1,
                    ],
                ],
                'gracePeriod' => [
                    'text' => $loc->get($locSta . 'gracePeriod'),
                    'data' => [
                        'data-fields' => 1,
                        'data-frstParam-info' => $loc->get($locSta . 'gracePeriod.frstParam.info'),
                    ],
                ],
                'frequency' => [
                    'text' => $loc->get($locSta . 'frequency'),
                    'data' => [
                        'data-fields' => 1,
                        'data-frstParam-info' => $loc->get($locSta . 'frequency.frstParam.info'),
                        'data-frstParam-options' => implode(';', $loc->getSub($locSta . 'frequency.frstParam.options')),
                    ],
                ],
                'distributionLinear' => [
                    'text' => $loc->get($locSta . 'distributionLinear'),
                    'data' => [
                        'data-fields' => 0,
                    ],
                ],
                'distributionNormal' => [
                    'text' => $loc->get($locSta . 'distributionNormal'),
                    'data' => [
                        'data-fields' => 2,
                        'data-frstParam-info' => $loc->get($locSta . 'distributionNormal.frstParam.info'),
                        'data-scndParam-info' => $loc->get($locSta . 'distributionNormal.scndParam.info'),
                    ],
                ],
                'loss' => [
                    'text' => $loc->get($locSta . 'loss'),
                    'data' => [
                        'data-fields' => 1,
                        'data-frstParam-info' => $loc->get($locSta . 'loss.frstParam.info'),
                    ],
                ],
            ];
        } elseif ($prefix === 'incomesRules') {
            return [
                'interestsRate' => [
                    'text' => $loc->get($locSta . 'interestsRate'),
                    'data' => [
                        'data-fields' => 1,
                        'data-frstParam-info' => $loc->get($locSta . 'interestsRate.frstParam.info'),
                    ],
                ],
                'oneTimeFixedFee' => [
                    'text' => $loc->get($locSta . 'oneTimeFixedFee'),
                    'data' => [
                        'data-fields' => 1,
                    ],
                ],
                'oneTimePercFee' => [
                    'text' => $loc->get($locSta . 'oneTimePercFee'),
                    'data' => [
                        'data-fields' => 1,
                    ],
                ],
            ];
        } elseif ($prefix === 'expendituresRules') {
            return [
                'feeAnnualPerc' => [
                    'text' => $loc->get($locSta . 'feeAnnualPerc'),
                    'data' => [
                        'data-fields' => 1,
                        'data-frstParam-info' => $loc->get($locSta . 'feeAnnualPerc.frstParam.info'),
                    ],
                ],
                'feeLimitPerc' => [
                    'text' => $loc->get($locSta . 'feeLimitPerc'),
                    'data' => [
                        'data-fields' => 2,
                        'data-frstParam-info' => $loc->get($locSta . 'feeLimitPerc.frstParam.info'),
                    ],
                ],
                'feePercOfPayments' => [
                    'text' => $loc->get($locSta . 'feePercOfPayments'),
                    'data' => [
                        'data-fields' => 1,
                        'data-frstParam-info' => $loc->get($locSta . 'feePercOfPayments.frstParam.info'),
                    ],
                ],
                'feePercOfRepayments' => [
                    'text' => $loc->get($locSta . 'feePercOfRepayments'),
                    'data' => [
                        'data-fields' => 1,
                        'data-frstParam-info' => $loc->get($locSta . 'feePercOfRepayments.frstParam.info'),
                    ],
                ],
            ];
        }//end if

        throw new PrefixUnknownException([ $prefix ]);
    }

    /**
     * Deliver data types for all fields returned by this operation.
     *
     * @return array
     */
    private function getDataTypes(): array
    {

        // Lvd.
        $dataTypes = [];
        $locale    = $_ENV['LOCALE']->getSub('Przeslijmi.AgileDataAvmonaPlug.Events.column');

        // Define data types.
        $dataTypes[$locale['date']]   = 'dateYmd';
        $dataTypes[$locale['name']]   = 'txt';
        $dataTypes[$locale['amount']] = 'currPLN';

        return $dataTypes;
    }
}
