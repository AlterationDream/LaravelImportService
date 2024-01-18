<?php

namespace App\Services\Import\SubContractors\ReadProperties\SubInfo;

use App\Contractor;
use App\Services\Import\Abstractions\ReadProperty;
use App\Services\Import\SubContractors\ImportModels\SubInfo;

/**
 * @property SubInfo $continuousData
 */
class SubContractorID extends ReadProperty
{
    /**
     * @inheritDoc
     */
    protected function setName(): string
    {
        return 'sub_contractor_id';
    }

    /**
     * @inheritDoc
     */
    public function read(): bool
    {
        $contractor = Contractor::where('external_id_1c', $this->getProperty() )->first();
        if ($contractor) {
            $this->continuousData->subContractorFound = true;
            $this->continuousData->subContractorID = $contractor->id;
        } else {
            $this->continuousData->subContractorID = $this->getProperty();
        }

        return true;
    }
}