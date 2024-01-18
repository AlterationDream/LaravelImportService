<?php

namespace App\Services\Import\SubContractors\ReadProperties;

use App\HelpModels\Contract;
use App\Services\Import\Abstractions\ReadProperty;
use App\Services\Import\InnerPayments\ImportModels\InnerPayment;
use App\Services\Import\SubContractors\ImportModels\SubContract;

/**
 * @property SubContract $continuousData
 */
class SubContractID extends ReadProperty
{
    /**
     * @inheritDoc
     */
    protected function setName(): string
    {
        return 'sub_contract_id';
    }

    /**
     * @inheritDoc
     */
    public function read(): bool
    {
        $contract = Contract::where('contract_1c_id', trim($this->getProperty()) )->first();
        if ($contract)
            $this->continuousData->externalID1C = $contract->id;

        return !is_null($contract);
    }

    /**
     * @inheritDoc
     */
    protected function errorText(): string
    {
        return 'ID под-контракта [' . $this->name . '] не найден в БД.';
    }
}