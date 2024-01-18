<?php

namespace App\Services\Import\ContractExecutions\ReadProperties;

use App\Services\Import\Abstractions\ReadProperty;
use App\Services\Import\ContractExecutions\ImportModels\ContractExecution;
use App\Services\Import\ContractPayments1C\ImportModels\ContractPayment;

/**
 * @property  ContractExecution $continuousData
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