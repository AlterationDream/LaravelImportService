<?php

namespace App\Services\Import\SubContractors\ImportModels;

use App\Services\Import\Abstractions\ContinuousImportModel;

class SubInfo extends ContinuousImportModel
{
    public $subContractorFound;

    public $subContractorID;
    public $subContractorName;
    public $subInn;
    public $subKpp;
    public $subBik;
    public $subBank;
    public $subAccount;
    public $subUrAddress;
    public $subFactAddress;
    public $subFio;
    public $subPosition;
    public $subPhone;
    public $subEmail;

    public $userID;

    public function __construct()
    {
        $this->subContractorFound = false;
    }

    /**
     * @inheritDoc
     */
    public function getDBData(): array
    {
        $presidentName = 'Нет';
        if ($this->subPosition and $this->subFio)
            $presidentName = $this->subPosition . ' ' . $this->subFio;

        return [
            'external_id_1c'        => $this->subContractorID,
            'name'                  => $this->subContractorName,
            'phone'                 => $this->subPhone,
            'address'               => $this->subUrAddress,
            'region_id'             => 107,       // TODO: Находить ID по полю sub_fact_address
            'town'                  => $this->subFactAddress,
            'president_name'        => $presidentName,
            'user_id'               => $this->userID,
            'moderator_id'          => 1338,
            'inn'                   => $this->subInn,
            'kpp'                   => $this->subKpp,
            'contract_name'         => $this->subFio,
            'president_appointed'   => 'Устава',
            'payment_check'         => $this->subAccount,
            'bik'                   => $this->subBik,
            'bank'                  => $this->subBank,
        ];
    }
}