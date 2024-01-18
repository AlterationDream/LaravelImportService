<?php

namespace App\Services\Import\ContractPayments1C\ReadProperties;

use App\Services\Import\Abstractions\ReadProperty;
use App\Services\Import\ContractPayments1C\ImportModels\ContractPayment;

/**
 * @property  ContractPayment $continuousData
 */
class PaymentNum extends ReadProperty
{
    /**
     * @inheritDoc
     */
    protected function setName(): string
    {
        return 'payment_num';
    }

    /**
     * @inheritDoc
     */
    public function read(): bool
    {
        $this->continuousData->paymentNum = $this->getProperty();
        return true;
    }
}