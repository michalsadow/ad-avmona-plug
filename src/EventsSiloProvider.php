<?php

declare(strict_types=1);

namespace Przeslijmi\AgileDataAvmonaPlug;

use Przeslijmi\AgileData\Configure\SiloProviders\SiloProviderInterface;

/**
 * Deliver silo content of avmona_events table.
 */
class EventsSiloProvider implements SiloProviderInterface
{

    /**
     * Deliver silo content of avmona_events table.
     *
     * @return array
     */
    public static function provide(): array
    {

        // Define class.
        $class = (object) [
            'item' => 'AvmonaEvent',
            'collection' => 'AvmonaEvents',
            'tableName' => 'avmona_events',
            'namespace' => 'Przeslijmi\AgileDataAvmonaPlug\Models\\',
        ];

        // Define fields.
        $fields             = [];
        $fields['HIgFyX0K'] = (object) [
            'name' => 'avmona_events_pk',
            'isPrimaryKey' => true,
            'type' => 'int',
            'length' => 9,
            'isAutoIncrement' => true,
        ];
        $fields['24OFtkri'] = (object) [
            'name' => 'category',
            'type' => 'text',
            'length' => 255,
        ];
        $fields['zSlHa2vH'] = (object) [
            'name' => 'name',
            'type' => 'text',
            'length' => 255,
        ];
        $fields['2ayWt0gD'] = (object) [
            'name' => 'amount',
            'type' => 'float',
            'length' => 15,
            'decimalPlaces' => 2,
        ];
        $fields['OaZvt5Pq'] = (object) [
            'name' => 'date',
            'type' => 'date',
        ];

        // Define silo.
        $silo = (object) [
            'class' => $class,
            'fields' => $fields,
        ];

        return [
            '7ovKUsAQ' => $silo,
        ];
    }
}
