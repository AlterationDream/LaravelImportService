<?php

namespace App\Services\Import\InnerPayments\CheckProperties;

use App\Services\Import\Abstractions\CheckProperty;

class SenderLegalEntity extends CheckProperty
{
    /**
     * @inheritDoc
     */
    protected function setName(): string
    {
        return 'sender_legal_entity';
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
                    strlen( $this->getProperty() ) > 0
                );
    }

    protected function errorText(): string
    {
        return 'Поле [' . $this->name . '] подразделения-отправителя должно быть непустой строкой.';
    }
}