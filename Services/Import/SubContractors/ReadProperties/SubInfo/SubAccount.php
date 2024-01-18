<?php

namespace App\Services\Import\SubContractors\ReadProperties\SubInfo;

use App\Services\Import\Abstractions\ReadProperty;
use App\Services\Import\SubContractors\ImportModels\SubInfo;

/**
 * @property SubInfo $continuousData
 */
class SubAccount extends ReadProperty
{

    /**
     * @inheritDoc
     */
    protected function setName(): string
    {
        return 'sub_account';
    }

    /**
     * @inheritDoc
     */
    public function read(): bool
    {
        $this->continuousData->subAccount = $this->getProperty() ?? null;

        return true;
    }
}