<?php

namespace App\Services\Import\ContractExecutions\CheckProperties;

use App\Services\Import\Abstractions\CheckProperty;

class ContractID extends CheckProperty
{
    /**
     * @inheritDoc
     */
    protected function setName(): string
    {
        return 'contract_id';
    }

    /**
     * @inheritDoc
     */
    public function check(): bool
    {
        return  $this->isInArray()
                and
                (   is_string( $this->getProperty() )
                    and
                    strlen( $this->getProperty() )  > 0
                );
    }

    /**
     * @inheritDoc
     */
    protected function errorText(): string
    {
        return 'Не удалось прочитать [' . $this->name . '] ID контракта.';
    }
}