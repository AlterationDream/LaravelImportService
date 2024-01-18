<?php

namespace App\Services\Import\ContractPayments1C\CheckProperties;

use App\Services\Import\Abstractions\CheckProperty;

class IsArray extends CheckProperty
{
    /**
     * @inheritDoc
     */
    protected function setName(): string
    {
        return 'array';
    }

    /**
     * @inheritDoc
     */
    public function check(): bool
    {
        return is_array($this->data);
    }

    /**
     * @inheritDoc
     */
    protected function errorText(): string
    {
        return 'Переданные данные для импорта не являются массивом.';
    }
}