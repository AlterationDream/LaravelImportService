<?php

namespace App\Services\Import\SubContractors\ImportModels;

use App\Services\Import\Abstractions\ContinuousImportModel;

class SubPayment extends ContinuousImportModel
{
    public $subContractID;
    public $subCost;
    public $subDate;

    /**
     * @inheritDoc
     */
    public function getDBData(): array
    {
        return [
            'sub_contract_id' => $this->subContractID,
            'sub_cost'        => $this->subCost,
            'sub_date'        => $this->subDate->format('Y-m-d'),
        ];
    }
}