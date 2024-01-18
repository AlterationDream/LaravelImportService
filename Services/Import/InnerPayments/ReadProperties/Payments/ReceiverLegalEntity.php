<?php

namespace App\Services\Import\InnerPayments\ReadProperties\Payments;

use App\LegalEntity;
use App\Services\Import\Abstractions\ReadProperty;
use App\Services\Import\InnerPayments\ImportModels\PaymentsSubarray;

/**
 * @property PaymentsSubarray $continuousData
 */
class ReceiverLegalEntity extends ReadProperty
{
    /**
     * @inheritDoc
     */
    protected function setName(): string
    {
        return 'receiver_legal_entity';
    }

    /**
     * @inheritDoc
     */
    public function read(): bool
    {
        $receiverLegalEntity = LegalEntity::where('name', trim($this->getProperty()) )->first();
        if ($receiverLegalEntity)
            $this->continuousData->receiverLegalEntityID = $receiverLegalEntity->id;

        return !is_null($receiverLegalEntity);
    }

    /**
     * @inheritDoc
     */
    protected function errorText(): string
    {
        return 'Подразделение-получатель [' . $this->name . '] не найдено в БД';
    }
}