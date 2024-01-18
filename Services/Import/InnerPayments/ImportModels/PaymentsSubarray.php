<?php

namespace App\Services\Import\InnerPayments\ImportModels;

use App\Services\Import\Abstractions\ContinuousImportModel;

/**
 * Вспомогательный класс для хранения частных оплат по направлению оплаты.
 *
 * @see InnerPayment      Класс для хранения непрерывных данных по направлению внутренних платежей.
 */
class PaymentsSubarray extends ContinuousImportModel
{
    public $receiverLegalEntityID;
    public $receiverLaboratoryID = null;
    public $date;
    public $amount;

    public function getDBData(): array
    {
        return [];
    }
}