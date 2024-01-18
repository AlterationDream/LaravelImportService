<?php

namespace App\Services\Import\ContractPayments1C\ReadProperties;

use App\Services\Import\Abstractions\ReadProperty;
use App\Services\Import\ContractPayments1C\ImportModels\ContractPayment;

/**
 * @property  ContractPayment $continuousData
 */
class Description extends ReadProperty
{
    /**
     * @inheritDoc
     */
    protected function setName(): string
    {
        return 'description';
    }

    /**
     * @inheritDoc
     */
    public function read(): bool
    {
        $this->continuousData->description = $this->getProperty();
        return true;
    }
}