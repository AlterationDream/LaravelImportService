<?php

namespace App\Services\Import\InnerPayments\ReadProperties\Payments;

use App\HelpModels\Laboratory;
use App\Services\Import\Abstractions\ReadProperty;
use App\Services\Import\InnerPayments\ImportModels\PaymentsSubarray;

/**
 * @property PaymentsSubarray $continuousData
 */
class ReceiverLaboratory extends ReadProperty
{
    /**
     * @inheritDoc
     */
    protected function setName(): string
    {
        return 'receiver_laboratory';
    }

    /**
     * @inheritDoc
     */
    public function read(): bool
    {
        // Если поле не передано или лаборатория не указана - не проверять наличие в БД.
        if (!$this->isInArray() or !$this->data['receiver_laboratory'])
            return true;

        // Попытаться найти переданную лабораторию или отклонить внутренний платёж.
        $receiverLaboratory = Laboratory::where('legal_entity_id', $this->continuousData->receiverLegalEntityID)
            ->where('name', trim($this->getProperty()) )
            ->first();

        if ($receiverLaboratory)
            $this->continuousData->receiverLaboratoryID = $receiverLaboratory->id;

        return !is_null($receiverLaboratory);
    }

    /**
     * @inheritDoc
     */
    protected function errorText(): string
    {
        return 'Лаборатория-получатель [' . $this->name . '] не найдена в БД';
    }
}