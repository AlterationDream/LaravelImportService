<?php

namespace App\Services\Import\SubContractors\CheckProperties;

use App\Services\Import\Abstractions\CheckProperty;

class SubPayments extends CheckProperty
{
    /**
     * @inheritDoc
     */
    protected function setName(): string
    {
        return 'sub_payments';
    }

    /**
     * @inheritDoc
     */
    public function check(): bool
    {
        return $this->isInArray();
    }
}