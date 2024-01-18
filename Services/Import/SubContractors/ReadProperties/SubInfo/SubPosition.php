<?php

namespace App\Services\Import\SubContractors\ReadProperties\SubInfo;

use App\Services\Import\Abstractions\ReadProperty;
use App\Services\Import\SubContractors\ImportModels\SubInfo;

/**
 * @property SubInfo $continuousData
 */
class SubPosition extends ReadProperty
{

    /**
     * @inheritDoc
     */
    protected function setName(): string
    {
        return 'sub_position';
    }

    /**
     * @inheritDoc
     */
    public function read(): bool
    {
        $this->continuousData->subPosition = $this->getProperty() ?? 'Нет';

        return true;
    }
}