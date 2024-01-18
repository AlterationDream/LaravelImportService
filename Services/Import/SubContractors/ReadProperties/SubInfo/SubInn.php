<?php

namespace App\Services\Import\SubContractors\ReadProperties\SubInfo;

use App\Services\Import\Abstractions\ReadProperty;
use App\Services\Import\SubContractors\ImportModels\SubInfo;

/**
 * @property SubInfo $continuousData
 */
class SubInn extends ReadProperty
{

    /**
     * @inheritDoc
     */
    protected function setName(): string
    {
        return 'sub_inn';
    }

    /**
     * @inheritDoc
     */
    public function read(): bool
    {
        $this->continuousData->subInn = $this->getProperty() ?? 'Нет';

        return true;
    }

    protected function errorText(): string
    {
        return 'ИНН соисполнителя [' . $this->name . '] должен быть непустой строкой.';
    }


}