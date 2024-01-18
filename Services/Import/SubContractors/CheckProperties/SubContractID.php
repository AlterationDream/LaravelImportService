<?php

namespace App\Services\Import\SubContractors\CheckProperties;

use App\Services\Import\Abstractions\CheckProperty;

class SubContractID extends CheckProperty
{
    /**
     * @inheritDoc
     */
    protected function setName(): string
    {
        return 'sub_contract_id';
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
        return 'Не удалось прочитать [' . $this->name . '] ID под-контракта.';
    }
}