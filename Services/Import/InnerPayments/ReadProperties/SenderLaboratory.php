<?php

namespace App\Services\Import\InnerPayments\ReadProperties;

use App\HelpModels\Laboratory;
use App\Services\Import\Abstractions\ReadProperty;
use App\Services\Import\InnerPayments\ImportModels\InnerPayment;

/**
 * @property InnerPayment $continuousData
 */
class SenderLaboratory extends ReadProperty
{
    /**
     * @inheritDoc
     */
    protected function setName(): string
    {
        return 'sender_laboratory';
    }

    /**
     * @inheritDoc
     */
    public function read(): bool
    {
        // Если поле не передано или лаборатория не указана - не проверять наличие в БД.
        if (!$this->isInArray() or !$this->getProperty())
            return true;

        // Попытаться найти переданную лабораторию или отклонить направление внутреннего платёжа.
        $senderLaboratory = Laboratory::where('legal_entity_id', $this->continuousData->senderLegalEntityID)
            ->where('name', trim($this->getProperty()) )
            ->first();

        if ($senderLaboratory)
            $this->continuousData->senderLaboratoryID = $senderLaboratory->id;

        return !is_null($senderLaboratory);
    }

    /**
     * @inheritDoc
     */
    protected function errorText(): string
    {
        return 'Лаборатория-отправитель [' . $this->name . '] не найдена в БД.';
    }
}