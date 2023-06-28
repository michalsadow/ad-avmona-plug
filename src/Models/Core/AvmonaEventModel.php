<?php

declare(strict_types=1);

namespace Przeslijmi\AgileDataAvmonaPlug\Models\Core;

use Przeslijmi\Shortquery\Data\Field\DateField;
use Przeslijmi\Shortquery\Data\Field\DecimalField;
use Przeslijmi\Shortquery\Data\Field\EnumField;
use Przeslijmi\Shortquery\Data\Field\IntField;
use Przeslijmi\Shortquery\Data\Field\JsonField;
use Przeslijmi\Shortquery\Data\Field\VarCharField;
use Przeslijmi\Shortquery\Data\Field\SetField;
use Przeslijmi\Shortquery\Data\Model;
use Przeslijmi\Shortquery\Data\Relation\HasManyRelation;
use Przeslijmi\Shortquery\Data\Relation\HasOneRelation;

/**
 * ShortQuery Model definition for AvmonaEvent.
 *
 * This is a `<shortquery-role:model>`.
 */
class AvmonaEventModel extends Model
{

    /**
     * Holder of model (to prevent multicreation).
     *
     * @var AvmonaEventModel
     */
    private static $instance;

    /**
     * Retrieves only one instance to prevent multicreation.
     *
     * @return AvmonaEventModel
     */
    public static function getInstance(): AvmonaEventModel
    {

        if (is_null(self::$instance) === true) {
            self::$instance = new AvmonaEventModel();
        }

        return self::$instance;
    }

    /**
     * Constructor.
     */
    public function __construct()
    {

        // Define Model.
        $this->setName('avmona_events');
        $this->setDatabases('JwVBpcSi');
        $this->setNamespace('Przeslijmi\AgileDataAvmonaPlug\Models');
        $this->setInstanceClassName('AvmonaEvent');
        $this->setCollectionClassName('AvmonaEvents');

        // Define Fields of Model.
        $this->addField(
            ( new IntField('avmona_events_pk', true) )
                ->setMaxLength(9)
                ->setPk(true)
        );
        $this->addField(
            ( new VarCharField('category', false) )
                ->setMaxLength(255)
                ->setPk(false)
        );
        $this->addField(
            ( new VarCharField('name', false) )
                ->setMaxLength(255)
                ->setPk(false)
        );
        $this->addField(
            ( new DecimalField('amount', false) )
                ->setSize(15, 2)
                ->setPk(false)
        );
        $this->addField(
            ( new DateField('date', false) )
                ->setPk(false)
        );
    }
}
