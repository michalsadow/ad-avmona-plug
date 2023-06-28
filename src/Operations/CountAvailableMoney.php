<?php

declare(strict_types=1);

namespace Przeslijmi\AgileDataAvmonaPlug\Operations;

use Przeslijmi\AgileData\Operations\OperationsInterface as MyInterface;
use Przeslijmi\AgileData\Operations\OperationsParent as MyParent;
use Przeslijmi\AgileDataAvmonaPlug\Analysis\FinalAnalysis as Analysis;
use Przeslijmi\AgileDataAvmonaPlug\Models\Core\AvmonaEventModel;
use Przeslijmi\Shortquery\Engine\MySql\Queries\SelectQuery;
use stdClass;

/**
 * Operation that count how many money will be available at which time.
 */
class CountAvailableMoney extends MyParent implements MyInterface
{

    /**
     * Operation key.
     *
     * @var string
     */
    protected static $opKey = 'QxIdfVS4';

    /**
     * Only those fields are accepted for this operation.
     *
     * @var array
     */
    public static $operationFields = [
        'firstDay',
        'startingAmount',
        'frequency',
        'length',
        'numberName'
    ];

    /**
     * Possible number names.
     *
     * @var string[]
     */
    private static $numberNames = [ '0', '3', '6' ];

    /**
     * Get info (mainly name and category of this operation).
     *
     * @return stdClass
     */
    public static function getInfo(): stdClass
    {

        // Lvd.
        $locSta = 'Przeslijmi.AgileDataAvmonaPlug.Operations.CountAvailableMoney.';

        // Lvd.
        $result             = new stdClass();
        $result->name       = $_ENV['LOCALE']->get($locSta . 'title');
        $result->vendor     = 'Przeslijmi\AgileDataAvmonaPlug';
        $result->class      = self::class;
        $result->depr       = false;
        $result->category   = 100;
        $result->sourceName = $_ENV['LOCALE']->get($locSta . 'sourceName');

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
        $locSta = 'Przeslijmi.AgileDataAvmonaPlug.Operations.CountAvailableMoney.fields.';

        // Prepare number names.
        $numberNames = [];
        foreach (self::$numberNames as $key) {
            $numberNames[$key] = $loc->get('Przeslijmi.AgileDataAvmonaPlug.numberNames.' . $key);
        }

        // Prepare frequency.
        $frequency = [];
        foreach (Analysis::PERIOD_TYPES as $key) {
            $frequency[$key] = $loc->get('Przeslijmi.AgileDataAvmonaPlug.frequency.' . $key);
        }

        // Add fields.
        $fields[] = [
            'type' => 'date',
            'id' => 'firstDay',
            'value' => ( $step->firstDay ?? date('Y-m-d') ),
            'name' => $loc->get($locSta . 'firstDay.name'),
            'desc' => $loc->get($locSta . 'firstDay.desc'),
            'maxlength' => 10,
            'group' => $loc->get('Przeslijmi.AgileData.tabs.operation'),
        ];
        $fields[] = [
            'type' => 'text',
            'id' => 'startingAmount',
            'value' => ( $step->startingAmount ?? '' ),
            'name' => $loc->get($locSta . 'startingAmount.name'),
            'desc' => $loc->get($locSta . 'startingAmount.desc'),
            'maxlength' => 20,
            'group' => $loc->get('Przeslijmi.AgileData.tabs.operation'),
        ];
        $fields[] = [
            'type' => 'select',
            'id' => 'frequency',
            'value' => ( $step->frequency ?? 'Q' ),
            'name' => $loc->get($locSta . 'frequency.name'),
            'desc' => $loc->get($locSta . 'frequency.desc'),
            'options' => $frequency,
            'group' => $loc->get('Przeslijmi.AgileData.tabs.operation'),
        ];
        $fields[] = [
            'type' => 'text',
            'id' => 'length',
            'value' => ( $step->length ?? '20' ),
            'name' => $loc->get($locSta . 'length.name'),
            'desc' => $loc->get($locSta . 'length.desc'),
            'maxlength' => 3,
            'group' => $loc->get('Przeslijmi.AgileData.tabs.operation'),
        ];
        $fields[] = [
            'type' => 'select',
            'id' => 'numberName',
            'value' => ( $step->numberName ?? '0' ),
            'name' => $loc->get($locSta . 'numberName.name'),
            'desc' => $loc->get($locSta . 'numberName.desc'),
            'options' => $numberNames,
            'group' => $loc->get('Przeslijmi.AgileData.tabs.operation'),
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

        // Convert numeric length to integer length.
        if (isset($step->length) === true) {
            $step->length = (int) $step->length;
        }

        // Convert numeric startingAmount to integer startingAmount.
        if (isset($step->startingAmount) === true) {
            $step->startingAmount = str_replace(',', '.', (string) $step->startingAmount);
            $step->startingAmount = preg_replace('/([^0-9.])/', '', $step->startingAmount);
            $step->startingAmount = (float) $step->startingAmount;
        }

        return $step;
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
            'firstDay' => 'string',
            'startingAmount' => 'double',
            'frequency' => [ '!stringEnum', Analysis::PERIOD_TYPES ],
            'length' => '!integer',
            'numberName' => [ '!stringEnum', self::$numberNames ],
        ]);
    }

    /**
     * Add NIPs to queue.
     *
     * @return void
     */
    public function perform(): void
    {

        // Prepare analysis.
        $analisys = new Analysis();
        $analisys->setFirstDay($this->getStep()->firstDay);
        $analisys->setPeriods($this->getStep()->length);
        $analisys->setPeriodsType($this->getStep()->frequency);
        $analisys->setStartingMoney($this->getStep()->startingAmount);

        // Create Query.
        $query = new SelectQuery(new AvmonaEventModel());
        $query->call();

        // Lvd.
        $records = [];
        $rowId   = 0;
        $locale  = $_ENV['LOCALE']->getSub('Przeslijmi.AgileDataAvmonaPlug.Analysis.column');

        // Convert analysis result into records.
        foreach ($analisys->perform($query->read()) as $period => $def) {

            // Calc divisor.
            $divisor = pow(10, (int) $this->getStep()->numberName);

            // Recalc all values.
            $def['onStart']  = round(( $def['onStart'] / $divisor ), 2);
            $def['inPlus']   = round(( $def['inPlus'] / $divisor ), 2);
            $def['inMinus']  = round(( $def['inMinus'] / $divisor ), 2);
            $def['onFinish'] = round(( $def['onFinish'] / $divisor ), 2);

            // Change column names.
            $defLoc = [];
            foreach ($def as $key => $value) {
                $defLoc[$locale[$key]] = $value;
            }

            // Create and save record.
            $records[] = $this->createEmptyRecord(( ++$rowId ), $defLoc);
        }

        // Free memory.
        unset($analisys);

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

        // Lvd.
        $result = $this->getParamAsAvailableProp($this->getTask());

        // Add all properties.
        foreach ($this->getDataTypes() as $field => $dataType) {
            $result[$field] = [
                'dataType' => $dataType,
            ];
        }

        return $result;
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
        $locale    = $_ENV['LOCALE']->getSub('Przeslijmi.AgileDataAvmonaPlug.Analysis.column');

        // Define data types.
        $dataTypes[$locale['period']] = 'txt';
        $dataTypes[$locale['start']]  = 'dateYmd';
        $dataTypes[$locale['stop']]   = 'dateYmd';

        // Add currency fields.
        if ((int) $this->getStep()->numberName === 6) {
            $dataTypes[$locale['onStart']]  = 'currPLNM';
            $dataTypes[$locale['inPlus']]   = 'currPLNM';
            $dataTypes[$locale['inMinus']]  = 'currPLNM';
            $dataTypes[$locale['onFinish']] = 'currPLNM';
        } elseif ((int) $this->getStep()->numberName === 3) {
            $dataTypes[$locale['onStart']]  = 'currPLNK';
            $dataTypes[$locale['inPlus']]   = 'currPLNK';
            $dataTypes[$locale['inMinus']]  = 'currPLNK';
            $dataTypes[$locale['onFinish']] = 'currPLNK';
        } else {
            $dataTypes[$locale['onStart']]  = 'currPLN';
            $dataTypes[$locale['inPlus']]   = 'currPLN';
            $dataTypes[$locale['inMinus']]  = 'currPLN';
            $dataTypes[$locale['onFinish']] = 'currPLN';
        }

        return $dataTypes;
    }
}
