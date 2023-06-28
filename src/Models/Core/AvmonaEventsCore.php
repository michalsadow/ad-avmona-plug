<?php

declare(strict_types=1);

namespace Przeslijmi\AgileDataAvmonaPlug\Models\Core;

use Przeslijmi\AgileDataAvmonaPlug\Models\Core\AvmonaEventModel;
use Przeslijmi\Shortquery\Data\Collection;
use Przeslijmi\Shortquery\Data\Field;

/**
 * ShortQuery Collection Core class for AvmonaEvent Model Collection.
 *
 * This is a `<shortquery-role:collection-core>`.
 */
class AvmonaEventsCore extends Collection
{

    /**
     * Constructor.
     */
    public function __construct()
    {

        // Define Model.
        $this->model = AvmonaEventModel::getInstance();

        // Call parent (set additional logics).
        parent::__construct(...func_get_args());
    }
}
