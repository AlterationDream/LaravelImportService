<?php

namespace App\Services\Import\InnerPayments\ReadProperties\Payments;

use App\Services\Import\Abstractions\ReadProperty;
use App\Services\Import\InnerPayments\ImportModels\PaymentsSubarray;
use Carbon\Carbon;

/**
 * @property PaymentsSubarray $continuousData;
 */
class Date extends ReadProperty
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
    public function read(): bool
    {
        $this->continuousData->date = Carbon::createFromFormat('Y-m-d', $this->getProperty() );
        return true;
    }
}