<?php

namespace App\Services\Import\SubContractors\ReadProperties\SubInfo;

use App\Services\Import\Abstractions\ReadProperty;
use App\Services\Import\SubContractors\ImportModels\SubInfo;

/**
 * @property SubInfo $continuousData
 */
class SubBik extends ReadProperty
{

    /**
     * @inheritDoc
     */
    protected function setName(): string
    {
        return 'sub_bik';
    }

    /**
     * @inheritDoc
     */
    public function read(): bool
    {
        $this->continuousData->subBik = $this->getProperty() ?? null;

        return true;
    }
}