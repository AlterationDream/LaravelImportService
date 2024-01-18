<?php

namespace App\Services\Import\ContractPayments1C\ReadProperties;

use App\Services\Import\Abstractions\ReadProperty;
use App\Services\Import\ContractPayments1C\ImportModels\ContractPayment;
use Carbon\Carbon;

/**
 * @property  ContractPayment $continuousData
 */
class Date extends ReadProperty
{
    /**
     * @inheritDoc
     */
    protected function setName(): string
    {
        return 'date';
    }

    /**
     * @inheritDoc
     */
    public function read(): bool
    {
        $this->continuousData->date = Carbon::createFromFormat('Y-m-d', $this->getProperty());
        return true;
    }
}