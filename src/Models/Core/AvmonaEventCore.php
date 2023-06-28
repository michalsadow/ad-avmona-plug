<?php

declare(strict_types=1);

namespace Przeslijmi\AgileDataAvmonaPlug\Models\Core;

use Przeslijmi\AgileDataAvmonaPlug\Models\AvmonaEvent;
use Przeslijmi\AgileDataAvmonaPlug\Models\AvmonaEvents;
use Przeslijmi\AgileDataAvmonaPlug\Models\Core\AvmonaEventModel;
use Przeslijmi\Shortquery\Data\Instance;
use Przeslijmi\Shortquery\Exceptions\Data\CollectionSliceNotPossibleException;
use Przeslijmi\Shortquery\Tools\InstancesFactory;
use stdClass;

/**
 * ShortQuery Instance Core class for AvmonaEvent Model.
 *
 * This is a `<shortquery-role:instance-core>`.
 */
class AvmonaEventCore extends Instance
{

    /**
     * Field `avmona_events_pk`.
     *
     * @var integer
     */
    private $avmonaEventsPk;

    /**
     * Field `category`.
     *
     * @var null|string
     */
    private $category;

    /**
     * Field `name`.
     *
     * @var null|string
     */
    private $name;

    /**
     * Field `amount`.
     *
     * @var null|float
     */
    private $amount;

    /**
     * Field `date`.
     *
     * @var null|string
     */
    private $date;

    /**
     * Constructor.
     *
     * @param string $database Optional, `null`. In which database this field is defined.
     */
    public function __construct(?string $database = null)
    {

        // Get model Instance.
        $this->model = AvmonaEventModel::getInstance();

        // Set database if given.
        $this->database = $database;
    }

    /**
     * Fast data injector.
     *
     * @param array $inject Data to be injected to object.
     *
     * @return self
     */
    public function injectData(array $inject): self
    {

        // Inject properties.
        if (isset($inject['avmona_events_pk']) === true && $inject['avmona_events_pk'] !== null) {
            $this->avmonaEventsPk = (int) $inject['avmona_events_pk'];
        }
        if (isset($inject['category']) === true && $inject['category'] !== null) {
            $this->category = (string) $inject['category'];
        }
        if (isset($inject['name']) === true && $inject['name'] !== null) {
            $this->name = (string) $inject['name'];
        }
        if (isset($inject['amount']) === true && $inject['amount'] !== null) {
            $this->amount = (float) $inject['amount'];
        }
        if (isset($inject['date']) === true && $inject['date'] !== null) {
            $this->date = (string) $inject['date'];
        }

        // Mark all fields set.
        $this->setFields = array_keys($inject);

        return $this;
    }

    /**
     * Returns info if primary key for this record has been given.
     *
     * @return boolean
     */
    public function hasPrimaryKey(): bool
    {

        if ($this->avmonaEventsPk === null) {
            return false;
        }

        return true;
    }

    /**
     * Resets primary key into null - like the record is not existing in DB.
     *
     * @return self
     */
    protected function resetPrimaryKey(): self
    {

        $this->avmonaEventsPk = null;

        $noInSet = array_search('avmona_events_pk', $this->setFields);

        if (is_int($noInSet) === true) {
            unset($this->setFields[$noInSet]);
        }

        return $this;
    }

    /**
     * Getter for `avmona_events_pk` field value.
     *
     * @return integer
     */
    public function getAvmonaEventsPk(): int
    {

        return $this->getCoreAvmonaEventsPk(...func_get_args());
    }

    /**
     * Core getter for `avmona_events_pk` field value.
     *
     * @return integer
     */
    public function getCoreAvmonaEventsPk(): int
    {

        return $this->avmonaEventsPk;
    }


    /**
     * Setter for `avmona_events_pk` field value.
     *
     * @param integer $avmonaEventsPk Value to be set.
     *
     * @return AvmonaEvent
     */
    public function setAvmonaEventsPk(int $avmonaEventsPk): AvmonaEvent
    {

        return $this->setCoreAvmonaEventsPk($avmonaEventsPk);
    }

    /**
     * Core setter for `avmona_events_pk` field value.
     *
     * @param integer $avmonaEventsPk Value to be set.
     *
     * @return AvmonaEvent
     */
    public function setCoreAvmonaEventsPk(int $avmonaEventsPk): AvmonaEvent
    {

        // Test value.
        $this->grabField('avmona_events_pk')->isValueValid($avmonaEventsPk);

        // If there is nothing to be changed.
        if ($this->avmonaEventsPk === $avmonaEventsPk) {
            return $this;
        }

        // Save.
        $this->avmonaEventsPk = $avmonaEventsPk;

        // Note that was set.
        $this->setFields[]     = 'avmona_events_pk';
        $this->changedFields[] = 'avmona_events_pk';

        // Note that was changed.
        if (isset($this->fieldsValuesHistory['avmona_events_pk']) === false) {
            $this->fieldsValuesHistory['avmona_events_pk'] = [];
        }
        $this->fieldsValuesHistory['avmona_events_pk'][] = $avmonaEventsPk;

        return $this;
    }

    /**
     * Getter for `category` field value.
     *
     * @return null|string
     */
    public function getCategory(): ?string
    {

        return $this->getCoreCategory(...func_get_args());
    }

    /**
     * Core getter for `category` field value.
     *
     * @return null|string
     */
    public function getCoreCategory(): ?string
    {

        return $this->category;
    }


    /**
     * Setter for `category` field value.
     *
     * @param null|string $category Value to be set.
     *
     * @return AvmonaEvent
     */
    public function setCategory(?string $category): AvmonaEvent
    {

        return $this->setCoreCategory($category);
    }

    /**
     * Core setter for `category` field value.
     *
     * @param null|string $category Value to be set.
     *
     * @return AvmonaEvent
     */
    public function setCoreCategory(?string $category): AvmonaEvent
    {

        // Test value.
        $this->grabField('category')->isValueValid($category);

        // If there is nothing to be changed.
        if ($this->category === $category) {
            return $this;
        }

        // Save.
        $this->category = $category;

        // Note that was set.
        $this->setFields[]     = 'category';
        $this->changedFields[] = 'category';

        // Note that was changed.
        if (isset($this->fieldsValuesHistory['category']) === false) {
            $this->fieldsValuesHistory['category'] = [];
        }
        $this->fieldsValuesHistory['category'][] = $category;

        return $this;
    }

    /**
     * Getter for `name` field value.
     *
     * @return null|string
     */
    public function getName(): ?string
    {

        return $this->getCoreName(...func_get_args());
    }

    /**
     * Core getter for `name` field value.
     *
     * @return null|string
     */
    public function getCoreName(): ?string
    {

        return $this->name;
    }


    /**
     * Setter for `name` field value.
     *
     * @param null|string $name Value to be set.
     *
     * @return AvmonaEvent
     */
    public function setName(?string $name): AvmonaEvent
    {

        return $this->setCoreName($name);
    }

    /**
     * Core setter for `name` field value.
     *
     * @param null|string $name Value to be set.
     *
     * @return AvmonaEvent
     */
    public function setCoreName(?string $name): AvmonaEvent
    {

        // Test value.
        $this->grabField('name')->isValueValid($name);

        // If there is nothing to be changed.
        if ($this->name === $name) {
            return $this;
        }

        // Save.
        $this->name = $name;

        // Note that was set.
        $this->setFields[]     = 'name';
        $this->changedFields[] = 'name';

        // Note that was changed.
        if (isset($this->fieldsValuesHistory['name']) === false) {
            $this->fieldsValuesHistory['name'] = [];
        }
        $this->fieldsValuesHistory['name'][] = $name;

        return $this;
    }

    /**
     * Getter for `amount` field value.
     *
     * @return null|float
     */
    public function getAmount(): ?float
    {

        return $this->getCoreAmount(...func_get_args());
    }

    /**
     * Core getter for `amount` field value.
     *
     * @return null|float
     */
    public function getCoreAmount(): ?float
    {

        return $this->amount;
    }


    /**
     * Setter for `amount` field value.
     *
     * @param null|float $amount Value to be set.
     *
     * @return AvmonaEvent
     */
    public function setAmount(?float $amount): AvmonaEvent
    {

        return $this->setCoreAmount($amount);
    }

    /**
     * Core setter for `amount` field value.
     *
     * @param null|float $amount Value to be set.
     *
     * @return AvmonaEvent
     */
    public function setCoreAmount(?float $amount): AvmonaEvent
    {

        // Test value.
        $this->grabField('amount')->isValueValid($amount);

        // If there is nothing to be changed.
        if (
            $this->amount === $amount
            || (string) $this->amount === (string) $amount
        ) {
            return $this;
        }

        // Save.
        $this->amount = $amount;

        // Note that was set.
        $this->setFields[]     = 'amount';
        $this->changedFields[] = 'amount';

        // Note that was changed.
        if (isset($this->fieldsValuesHistory['amount']) === false) {
            $this->fieldsValuesHistory['amount'] = [];
        }
        $this->fieldsValuesHistory['amount'][] = $amount;

        return $this;
    }

    /**
     * Getter for `date` field value.
     *
     * @return null|string
     */
    public function getDate(): ?string
    {

        return $this->getCoreDate(...func_get_args());
    }

    /**
     * Core getter for `date` field value.
     *
     * @return null|string
     */
    public function getCoreDate(): ?string
    {

        if (empty($this->date) === true) {
            $this->date = null;
        }

        if ($this->date !== null && func_num_args() > 0 && func_get_arg(0) === 'excel') {
            return (string) $this->grabField('date')
                ->formatToExcel($this->date);
        }

        return $this->date;
    }


    /**
     * Setter for `date` field value.
     *
     * @param null|string $date Value to be set.
     *
     * @return AvmonaEvent
     */
    public function setDate(?string $date): AvmonaEvent
    {

        return $this->setCoreDate($date);
    }

    /**
     * Core setter for `date` field value.
     *
     * @param null|string $date Value to be set.
     *
     * @return AvmonaEvent
     */
    public function setCoreDate(?string $date): AvmonaEvent
    {

        // Test value.
        $this->grabField('date')->isValueValid($date);

        // If there is nothing to be changed.
        if ($this->date === $date) {
            return $this;
        }

        // Save.
        $this->date = $date;

        // Note that was set.
        $this->setFields[]     = 'date';
        $this->changedFields[] = 'date';

        // Note that was changed.
        if (isset($this->fieldsValuesHistory['date']) === false) {
            $this->fieldsValuesHistory['date'] = [];
        }
        $this->fieldsValuesHistory['date'][] = $date;

        return $this;
    }
}
