<?php

declare(strict_types=1);

namespace Przeslijmi\AgileDataAvmonaPlug\Operations;

use Przeslijmi\AgileData\Operations\OperationsInterface as MyInterface;
use Przeslijmi\AgileData\Operations\OperationsParent as MyParent;
use Przeslijmi\AgileDataAvmonaPlug\Models\AvmonaEvents as EventsCollection;
use stdClass;

/**
 * Operation that adds source data into available money analysis.
 */
class AddToEventsList extends MyParent implements MyInterface
{

    /**
     * Operation key.
     *
     * @var string
     */
    protected static $opKey = 'fAEaA4YO';

    /**
     * Only those fields are accepted for this operation.
     *
     * @var array
     */
    public static $operationFields = [
        'categorySource',
        'nameSource',
        'dateSource',
        'dateAsPeriod',
        'amountSource',
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
        $locSta = 'Przeslijmi.AgileDataAvmonaPlug.Operations.AddToEventsList.';

        // Lvd.
        $result           = new stdClass();
        $result->name     = $_ENV['LOCALE']->get($locSta . 'title');
        $result->vendor   = 'Przeslijmi\AgileDataAvmonaPlug';
        $result->class    = self::class;
        $result->depr     = false;
        $result->category = 800;

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
        $locSta = 'Przeslijmi.AgileDataAvmonaPlug.Operations.AddToEventsList.fields.';

        // Prepare number names.
        $numberNames = [];
        foreach (self::$numberNames as $key) {
            $numberNames[$key] = $loc->get('Przeslijmi.AgileDataAvmonaPlug.numberNames.' . $key);
        }

        // Add fields.
        $fields[] = [
            'type' => 'select',
            'id' => 'categorySource',
            'value' => ( $step->categorySource ?? '' ),
            'name' => $loc->get($locSta . 'categorySource.name'),
            'desc' => $loc->get($locSta . 'categorySource.desc'),
            'options' => [],
            'isAvailablePropChooser' => true,
            'group' => $loc->get('Przeslijmi.AgileData.tabs.operation'),
        ];
        $fields[] = [
            'type' => 'select',
            'id' => 'nameSource',
            'value' => ( $step->nameSource ?? '' ),
            'name' => $loc->get($locSta . 'nameSource.name'),
            'desc' => $loc->get($locSta . 'nameSource.desc'),
            'options' => [],
            'isAvailablePropChooser' => true,
            'group' => $loc->get('Przeslijmi.AgileData.tabs.operation'),
        ];
        $fields[] = [
            'type' => 'select',
            'id' => 'dateSource',
            'value' => ( $step->dateSource ?? '' ),
            'name' => $loc->get($locSta . 'dateSource.name'),
            'desc' => $loc->get($locSta . 'dateSource.desc'),
            'options' => [],
            'isAvailablePropChooser' => true,
            'group' => $loc->get('Przeslijmi.AgileData.tabs.operation'),
        ];
        $fields[] = [
            'type' => 'switch',
            'id' => 'dateAsPeriod',
            'value' => 'yes',
            'checked' => ( self::$yn[( $step->dateAsPeriod ?? 'no' )] ?? false ),
            'name' => $loc->get($locSta . 'dateAsPeriod.name'),
            'desc' => $loc->get($locSta . 'dateAsPeriod.desc'),
            'group' => $loc->get('Przeslijmi.AgileData.tabs.operation'),
        ];
        $fields[] = [
            'type' => 'select',
            'id' => 'amountSource',
            'value' => ( $step->amountSource ?? '' ),
            'name' => $loc->get($locSta . 'amountSource.name'),
            'desc' => $loc->get($locSta . 'amountSource.desc'),
            'options' => [],
            'isAvailablePropChooser' => true,
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
     * Validates plug definition.
     *
     * @return void
     */
    public function validate(): void
    {

        // Lvd.
        $existingProps = array_column($this->getPropsAvailableBefore($this->getStepId()), 'name');

        // Test nodes.
        $this->testNodes($this->getStepPathInPlug(), $this->getStep(), [
            'categorySource' => [ 'stringEnum', $existingProps ],
            'nameSource' => [ '!stringEnum', $existingProps ],
            'dateSource' => [ '!stringEnum', $existingProps ],
            'dateAsPeriod' => [ 'stringEnum', [ 'yes', 'no' ] ],
            'amountSource' => [ '!stringEnum', $existingProps ],
            'numberName' => [ 'stringEnum', self::$numberNames ],
        ]);
    }

    /**
     * Add NIPs to queue.
     *
     * @return void
     */
    public function perform(): void
    {

        // Lvd.
        $collection = new EventsCollection();

        // Create events.
        foreach ($this->getCallingTask()->getRecords() as $record) {

            // Add this record.
            $collection->putRecord([
                'category' => ( $record->properties->{$this->getStep()->categorySource} ?? null ),
                'name' => (string) $record->properties->{$this->getStep()->nameSource},
                'amount' => (string) $record->properties->{$this->getStep()->amountSource},
                'date' => (string) $record->properties->{$this->getStep()->dateSource},
            ]);
        }

        // Create collection.
        $collection->save();
    }
}
