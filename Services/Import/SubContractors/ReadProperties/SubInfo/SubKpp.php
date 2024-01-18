<?php

namespace App\Services\Import\SubContractors\ReadProperties\SubInfo;

use App\Services\Import\Abstractions\ReadProperty;
use App\Services\Import\SubContractors\ImportModels\SubInfo;

/**
 * @property SubInfo $continuousData
 */
class SubKpp extends ReadProperty
{

    /**
     * @inheritDoc
     */
    protected function setName(): string
    {
        return 'sub_kpp';
    }

    /**
     * @inheritDoc
     */
    public function read(): bool
    {
        $this->continuousData->subKpp = $this->getProperty() ?? null;

        return true;
    }
}