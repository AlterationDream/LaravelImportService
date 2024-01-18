<?php

namespace App\Services\Import\InnerPayments\ReadProperties;

use App\Services\Import\Abstractions\Reader;
use App\Services\Import\Abstractions\ReadProperty;
use App\Services\Import\InnerPayments\ImportModels\InnerPayment;
use App\Services\Import\InnerPayments\ImportModels\PaymentsSubarray;
use App\Services\Import\InnerPayments\ReadProperties\Payments\Amount;
use App\Services\Import\InnerPayments\ReadProperties\Payments\Date;
use App\Services\Import\InnerPayments\ReadProperties\Payments\ReceiverLaboratory;
use App\Services\Import\InnerPayments\ReadProperties\Payments\ReceiverLegalEntity;

/**
 * @property InnerPayment $continuousData
 */
class Payments extends ReadProperty
{
    /**
     * @inheritDoc
     */
    protected function setName(): string
    {
        return 'payments';
    }

    /**
     * @inheritDoc
     */
    public function read(): bool
    {
        // Чтение частных внутренних платежей
        foreach ($this->getProperty() as $payment)
        {
            (
                new Reader(
                    $payment,
                    $this->key,
                    $this->continuousData->payments,
                    PaymentsSubarray::class,
                    [ 'parentID' => $this->getParentID() ]
                )
            )
                ->readProperty(ReceiverLegalEntity::class)
                ->readProperty(ReceiverLaboratory::class)
                ->readProperty(Date::class)
                ->readProperty(Amount::class)
                ->read();
        }

        return count($this->continuousData->payments) > 0;
    }

    /**
     * Информация-идентификатор родительского массива платежей.
     * @return string|null
     */
    private function getParentID(): ?string
    {
        return  'contract_id: ' . $this->data['contract_id'] .
                ', sender_legal_entity: ' . $this->data['sender_legal_entity'] .
                ($this->data['sender_laboratory'])
                    ? ', sender_laboratory: ' . $this->data['sender_laboratory']
                    : null;
    }
}