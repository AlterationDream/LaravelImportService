<?php

namespace App\Services\Import\InnerPayments\ImportModels;

use App\Services\Import\Abstractions\ContinuousImportModel;

/**
 * Класс для хранения ключевой информации импорта по внутренним платежам.
 *
 * @see PaymentsSubarray              Вспомогательный класс для хранения непрерывных данных частных оплат
 *                                               по [$this] направлению оплаты.
 *
 */
class InnerPayment extends ContinuousImportModel
{
    /** @var int */                             public $contractID;
    /** @var int */                             public $senderLegalEntityID;
    /** @var int|null */                        public $senderLaboratoryID = null;
    /** @var PaymentsSubarray[] */    public $payments;

    public function __construct()
    {
        $this->payments = [];
    }

    /**
     * Превращает импортированные непрерывные данные в массив готовых для импорта в БД записей.
     *
     * @return array
     */
    public function getDBData(): array
    {
        $innerPaymentsArray = [];
        foreach ($this->payments as $innerPayment)
        {
            $innerPaymentsArray[] = [
                'contract_id'               => $this->contractID,
                'sender_legal_entity_id'    => $this->senderLegalEntityID,
                'sender_laboratory_id'      => $this->senderLaboratoryID,

                'receiver_legal_entity_id'  => $innerPayment->receiverLegalEntityID,
                'receiver_laboratory_id'    => $innerPayment->receiverLaboratoryID,
                'date'                      => $innerPayment->date->format('Y-m-d'),
                'amount'                    => $innerPayment->amount,

                'type' => 2,
            ];
        }

        return $innerPaymentsArray;
    }
}