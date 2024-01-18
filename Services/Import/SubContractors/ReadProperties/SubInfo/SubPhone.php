<?php

namespace App\Services\Import\SubContractors\ReadProperties\SubInfo;

use App\Services\Import\Abstractions\ReadProperty;
use App\Services\Import\SubContractors\ImportModels\SubInfo;

/**
 * @property SubInfo $continuousData
 */
class SubPhone extends ReadProperty
{

    /**
     * @inheritDoc
     */
    protected function setName(): string
    {
        return 'sub_phone';
    }

    /**
     * @inheritDoc
     */
    public function read(): bool
    {
        $this->continuousData->subPhone = $this->getProperty() ?? 'Нет';

        return true;
    }
}