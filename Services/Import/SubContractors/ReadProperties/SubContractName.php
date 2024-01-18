<?php

namespace App\Services\Import\SubContractors\ReadProperties;

use App\HelpModels\Contract;
use App\Services\Import\Abstractions\ReadProperty;
use App\Services\Import\InnerPayments\ImportModels\InnerPayment;
use App\Services\Import\SubContractors\ImportModels\SubContract;

/**
 * @property SubContract $continuousData
 */
class SubContractName extends ReadProperty
{
    /**
     * @inheritDoc
     */
    protected function setName(): string
    {
        return 'sub_contract_name';
    }

    /**
     * @inheritDoc
     */
    public function read(): bool
    {
        if ($this->isInArray() and is_string( $this->getProperty() ))
        {
            $this->continuousData->name = trim( $this->getProperty() );
        } else
        {
            $this->continuousData->name = 'Не указан';
        }

        return true;
    }
}