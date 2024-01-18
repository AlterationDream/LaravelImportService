<?php

namespace App\Services\Import\ContractExecutions\ImportModels;

use App\Services\Import\Abstractions\ContinuousImportModel;
use Carbon\Carbon;

class ContractExecution extends ContinuousImportModel
{
    /** @var int */     public $contractID;
    /** @var Carbon */  public $date;
    /** @var float */   public $amount;

    /**
     * @inheritDoc
     */
    public function getDBData(): array
    {
        return [
            'contract_id'   => $this->contractID,
            'date_payment'  => $this->date->format('Y-m-d'),
            'amount'        => $this->amount,
        ];
    }
}