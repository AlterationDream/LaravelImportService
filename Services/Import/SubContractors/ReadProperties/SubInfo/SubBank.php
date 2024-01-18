<?php

namespace App\Services\Import\SubContractors\ReadProperties\SubInfo;

use App\Services\Import\Abstractions\ReadProperty;
use App\Services\Import\SubContractors\ImportModels\SubInfo;

/**
 * @property SubInfo $continuousData
 */
class SubBank extends ReadProperty
{

    /**
     * @inheritDoc
     */
    protected function setName(): string
    {
        return 'sub_bank';
    }

    /**
     * @inheritDoc
     */
    public function read(): bool
    {
        $this->continuousData->subBank = $this->getProperty() ?? null;

        return true;
    }
}