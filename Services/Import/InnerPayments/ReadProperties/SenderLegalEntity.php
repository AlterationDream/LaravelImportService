<?php

namespace App\Services\Import\InnerPayments\ReadProperties;

use App\LegalEntity;
use App\Services\Import\Abstractions\ReadProperty;
use App\Services\Import\InnerPayments\ImportModels\InnerPayment;

/**
 * @property InnerPayment $continuousData
 */
class SenderLegalEntity extends ReadProperty
{
    /**
     * @inheritDoc
     */
    protected function setName(): string
    {
        return 'sender_legal_entity';
    }

    /**
     * @inheritDoc
     */
    public function read(): bool
    {
        $senderLegalEntity = LegalEntity::where('name', trim($this->getProperty()) )->first();
        if ($senderLegalEntity)
            $this->continuousData->senderLegalEntityID = $senderLegalEntity->id;

        return !is_null($senderLegalEntity);
    }

    /**
     * @inheritDoc
     */
    protected function errorText(): string
    {
        return 'Подразделение-отправитель [' . $this->name . '] не найдено в БД';
    }
}