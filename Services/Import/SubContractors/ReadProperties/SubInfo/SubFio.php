<?php

namespace App\Services\Import\SubContractors\ReadProperties\SubInfo;

use App\Services\Import\Abstractions\ReadProperty;
use App\Services\Import\SubContractors\ImportModels\SubInfo;

/**
 * @property SubInfo $continuousData
 */
class SubFio extends ReadProperty
{

    /**
     * @inheritDoc
     */
    protected function setName(): string
    {
        return 'sub_fio';
    }

    /**
     * @inheritDoc
     */
    public function read(): bool
    {
        $this->continuousData->subFio = $this->continuousData ?? null;

        return true;
    }
}