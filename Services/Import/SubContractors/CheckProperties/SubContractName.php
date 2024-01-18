<?php

namespace App\Services\Import\SubContractors\CheckProperties;

use App\Services\Import\Abstractions\CheckProperty;

class SubContractName extends CheckProperty
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
        return 'Название под-контракта [' . $this->name . '] должно быть непустой строкой.';
    }
}