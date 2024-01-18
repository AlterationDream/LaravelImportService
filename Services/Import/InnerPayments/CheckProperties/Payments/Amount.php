<?php

namespace App\Services\Import\InnerPayments\CheckProperties\Payments;

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

    /**
     * @inheritDoc
     */
    protected function errorText(): string
    {
        return 'Поле [' . $this->name . '] сумма платежа должно быть числом';
    }
}