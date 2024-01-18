<?php

namespace App\Services\Import\SubContractors\ReadProperties\SubInfo;

use App\Services\Import\Abstractions\ReadProperty;
use App\Services\Import\SubContractors\ImportModels\SubInfo;

/**
 * @property SubInfo $continuousData$
 */
class SubContractorName extends ReadProperty
{
    /**
     * @inheritDoc
     */
    protected function setName(): string
    {
        return 'sub_contractor_name';
    }

    /**
     * @inheritDoc
     */
    public function read(): bool
    {
        //if ($this->continuousData->subContractorFound) return true;
        $this->continuousData->subContractorName = $this->getProperty() ?? 'Нет';

        return true;
    }

    /**
     * @inheritDoc
     */
    protected function errorText(): string
    {
        return 'Имя соисполнителя [' . $this->name . '] должно быть непустой строкой.';
    }
}