<?php

namespace App\Services\Import\ContractExecutions\CheckProperties;

use App\Services\Import\Abstractions\CheckProperty;

class Amount extends CheckProperty
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
    public function check(): bool
    {
        return  $this->isInArray()
                and
                is_numeric( $this->getProperty() );
    }
}