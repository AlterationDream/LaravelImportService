<?php

namespace App\Services\Import\SubContractors\ImportModels;

use App\Services\Import\Abstractions\ContinuousImportModel;

class SubContract extends ContinuousImportModel
{
    /** @var string */          public $externalID1C;
    /** @var int  */            public $contractID;
    /** @var null|string  */    public $name;
    /** @var SubInfo[] */       public $subInfo;
    /** @var SubPayment[] */    public $subPayments;
    /** @var int */             public $subContractorID;
    /** @var int */             public $subContractDBID;

    public function __construct()
    {
        $this->subPayments = [];
    }

    /**
     * @inheritDoc
     */
    public function getDBData(): array
    {
        return [
            'contract_id' => $this->contractID,
            'sub_contract_name' => $this->name,
            'sub_contractor_id' => $this->subContractorID
        ];
    }

    /**
     * Возвращает единственный элемент массива информации о соисполнителе.
     * @return SubInfo
     */
    public function getSubInfo(): SubInfo
    {
        return $this->subInfo[0];
    }

    /**
     * Подготовить оплаты к записи в БД.
     * @return void
     */
    public function setPaymentsData()
    {
        foreach ($this->subPayments as $subPayment) {
            $subPayment->subContractID = $this->subContractDBID;
        }
    }
}