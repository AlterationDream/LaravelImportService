<?php

namespace App\Services\Import\SubContractors\ReadProperties;

use App\Services\Import\Abstractions\Reader;
use App\Services\Import\Abstractions\ReadProperty;
use App\Services\Import\SubContractors\ImportModels\SubContract;
use App\Services\Import\SubContractors\ImportModels\SubPayment;
use App\Services\Import\SubContractors\ReadProperties\SubPayments\SubCost;
use App\Services\Import\SubContractors\ReadProperties\SubPayments\SubDate;

/**
 * @property SubContract $continuousData
 */
class SubPayments extends ReadProperty
{

    /**
     * @inheritDoc
     */
    protected function setName(): string
    {
        return 'sub_payments';
    }

    /**
     * @inheritDoc
     */
    public function read(): bool
    {
        foreach ($this->getProperty() as $payment) {
            $reader = new Reader(
                $payment, $this->key,
                $this->continuousData->subPayments,
                SubPayment::class,
                [ 'parentID' => $this->getParentID() ]
            );
            $reader->readProperty(SubCost::class)
                ->readProperty(SubDate::class)
                ->read();
        }

        return true;
    }

    /**
     * Информация-идентификатор родительского массива платежей.
     * @return string|null
     */
    private function getParentID(): ?string
    {
        return  'contract_id: ' . $this->data['contract_id'] .
            ', sub_contract_id: ' . $this->data['sub_contract_id'];
    }
}