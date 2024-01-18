<?php

namespace App\Services\Import\InnerPayments\ReadProperties\Payments;

use App\Services\Import\Abstractions\ReadProperty;
use App\Services\Import\InnerPayments\ImportModels\PaymentsSubarray;

/**
 * @property PaymentsSubarray $continuousData
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