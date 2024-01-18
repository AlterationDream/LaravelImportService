<?php

namespace App\Services\Import\ContractPayments1C\ImportModels;

use App\Services\Import\Abstractions\ContinuousImportModel;
use Carbon\Carbon;

class ContractPayment extends ContinuousImportModel
{
    /** @var int */         public $contractID;
    /** @var Carbon */      public $date;
    /** @var float */       public $amount;
    /** @var string */      public $description;
    /** @var null|string */ public $paymentNum;

    /**
     * Превращает импортированные непрерывные данные в массив готовых для импорта в БД записей.
     *
     * @return array
     */
    public function getDBData(): array
    {
        return [
            'contract_id'   => $this->contractID,
            'amount'        => $this->amount,
            'date_payment'  => $this->date->format('Y-m-d'),
            'description'   => $this->description,
            'payment_num'   => $this->paymentNum,
        ];
    }
}