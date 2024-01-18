<?php

namespace App\Services\Import\SubContractors\CheckProperties\SubInfo;

use App\Services\Import\Abstractions\CheckProperty;
use App\Services\Import\SubContractors\ImportModels\SubInfo;

class SubContractorID extends CheckProperty
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
    public function check(): bool
    {
        return  $this->isInArray()
                and
                (   is_string( $this->getProperty() )
                    and
                    strlen( $this->getProperty() )  > 0
                );
    }

    /**
     * @inheritDoc
     */
    protected function errorText(): string
    {
        return 'Не удалось прочитать [' . $this->name . '] ID соисполнителя.';
    }
}