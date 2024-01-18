<?php

namespace App\Services\Import\InnerPayments\CheckProperties;

use App\Services\Import\Abstractions\Checker;
use App\Services\Import\Abstractions\CheckProperty;
use App\Services\Import\InnerPayments\CheckProperties\Payments\Amount;
use App\Services\Import\InnerPayments\CheckProperties\Payments\Date;
use App\Services\Import\InnerPayments\CheckProperties\Payments\ReceiverLegalEntity;

class Payments extends CheckProperty
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
    public function check(): bool
    {
        return  $this->isInArray()
                and
                is_array( $this->getProperty() )
                and
                count( $this->getProperty() ) > 0
                and
                $this->checkSubArray( [$this, 'checkPayments'] );
    }

    /**
     * Обработчик проверки каждого элемента массива платежей.
     */
    public function checkPayments($payment): bool
    {
        $checker = new Checker($payment, $this->key, ['parentID' => $this->getParentID()]);
        $checker->checkData(ReceiverLegalEntity::class)
            ->checkData(Date::class)
            ->checkData(Amount::class);

        return $checker->check();
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

    /**
     * @inheritDoc
     */
    protected function errorText(): string
    {
        return 'Не удалось считать массив внутренних переводов.';
    }
}