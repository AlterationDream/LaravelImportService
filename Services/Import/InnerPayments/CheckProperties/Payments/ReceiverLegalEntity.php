<?php

namespace App\Services\Import\InnerPayments\CheckProperties\Payments;

use App\Services\Import\Abstractions\CheckProperty;

class ReceiverLegalEntity extends CheckProperty
{

    /**
     * @inheritDoc
     */
    protected function setName(): string
    {
        return 'receiver_legal_entity';
    }

    /**
     * @inheritDoc
     */
    public function check(): bool
    {
        return  $this->isInArray()
                and
                (   is_string($this->getProperty())
                    and
                    strlen( $this->getProperty() ) > 0
                );
    }

    /**
     * @inheritDoc
     */
    protected function errorText(): string
    {
        return 'Поле [' . $this->name . '] подразделения-отправителя должно быть непустой строкой.';
    }
}