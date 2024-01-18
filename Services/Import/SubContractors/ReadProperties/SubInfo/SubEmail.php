<?php

namespace App\Services\Import\SubContractors\ReadProperties\SubInfo;

use App\Services\Import\Abstractions\ReadProperty;
use App\Services\Import\SubContractors\ImportModels\SubInfo;

/**
 * @property SubInfo $continuousData
 */
class SubEmail extends ReadProperty
{

    /**
     * @inheritDoc
     */
    protected function setName(): string
    {
        return 'sub_email';
    }

    /**
     * @inheritDoc
     */
    public function read(): bool
    {
        $this->continuousData->subEmail = $this->getProperty() ?? null;

        return true;
    }
}