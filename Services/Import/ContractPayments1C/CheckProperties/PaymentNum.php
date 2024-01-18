<?php

namespace App\Services\Import\ContractPayments1C\CheckProperties;

use App\Services\Import\Abstractions\CheckProperty;

class PaymentNum extends CheckProperty
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
    public function check(): bool
    {
        return  $this->isInArray()
                and
                (
                    (   is_string( $this->getProperty() )
                        and
                        strlen( $this->getProperty() ) > 0
                    )
                    or
                    is_null( $this->getProperty() )
                );
    }

    /**
     * @inheritDoc
     */
    protected function errorText(): string
    {
        return 'Не удалось прочитать [' . $this->name . '] номер поступления.';
    }
}