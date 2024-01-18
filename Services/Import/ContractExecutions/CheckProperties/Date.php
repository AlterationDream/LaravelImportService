<?php

namespace App\Services\Import\ContractExecutions\CheckProperties;

use App\Services\Import\Abstractions\CheckProperty;
use Carbon\Carbon;

class Date extends CheckProperty
{
    /**
     * @inheritDoc
     */
    protected function setName(): string
    {
        return 'date';
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
                    Carbon::createFromFormat('Y-m-d', $this->getProperty() )
                );
    }

    /**
     * @inheritDoc
     */
    protected function errorText(): string
    {
        return 'Поле [' . $this->name . '] дата платежа должно быть строкой и соответствовать формату Y-m-d';
    }
}