<?php

namespace App\Services\Import\ContractPayments1C\ReadProperties;

use App\Services\Import\Abstractions\ReadProperty;
use App\Services\Import\ContractPayments1C\ImportModels\ContractPayment;

/**
 * @property  ContractPayment $continuousData
 */
class Amount extends ReadProperty
{
    /**
     * @inheritDoc
     */
    protected function setName(): string
    {
        return 'amount';
    }

    /**
     * @inheritDoc
     */
    public function read(): bool
    {
        $this->continuousData->amount = $this->getProperty();
        return true;
    }
}