<?php

namespace App\Services\Import\SubContractors\ReadProperties\SubInfo;

use App\Services\Import\Abstractions\ReadProperty;
use App\Services\Import\SubContractors\ImportModels\SubInfo;

/**
 * @property SubInfo $continuousData
 */
class SubUrAddress extends ReadProperty
{

    /**
     * @inheritDoc
     */
    protected function setName(): string
    {
        return 'sub_ur_address';
    }

    /**
     * @inheritDoc
     */
    public function read(): bool
    {
        $this->continuousData->subUrAddress = $this->getProperty() ?? 'Нет';

        return true;
    }
}