<?php

namespace App\Services\Import\SubContractors\ReadProperties;

use App\Services\Import\Abstractions\Reader;
use App\Services\Import\Abstractions\ReadProperty;
use App\Services\Import\InnerPayments\ImportModels\PaymentsSubarray;
use App\Services\Import\InnerPayments\ReadProperties\Payments\Amount;
use App\Services\Import\InnerPayments\ReadProperties\Payments\Date;
use App\Services\Import\InnerPayments\ReadProperties\Payments\ReceiverLaboratory;
use App\Services\Import\InnerPayments\ReadProperties\Payments\ReceiverLegalEntity;
use App\Services\Import\SubContractors\ImportModels\SubContract;
use App\Services\Import\SubContractors\ImportModels\SubInfo as ContinuousSubInfo;
use App\Services\Import\SubContractors\ReadProperties\SubInfo\SubAccount;
use App\Services\Import\SubContractors\ReadProperties\SubInfo\SubBank;
use App\Services\Import\SubContractors\ReadProperties\SubInfo\SubBik;
use App\Services\Import\SubContractors\ReadProperties\SubInfo\SubContractorID;
use App\Services\Import\SubContractors\ReadProperties\SubInfo\SubContractorName;
use App\Services\Import\SubContractors\ReadProperties\SubInfo\SubEmail;
use App\Services\Import\SubContractors\ReadProperties\SubInfo\SubFactAddress;
use App\Services\Import\SubContractors\ReadProperties\SubInfo\SubFio;
use App\Services\Import\SubContractors\ReadProperties\SubInfo\SubInn;
use App\Services\Import\SubContractors\ReadProperties\SubInfo\SubKpp;
use App\Services\Import\SubContractors\ReadProperties\SubInfo\SubPhone;
use App\Services\Import\SubContractors\ReadProperties\SubInfo\SubPosition;
use App\Services\Import\SubContractors\ReadProperties\SubInfo\SubUrAddress;

/**
 * @property SubContract $continuousData
 */
class SubInfo extends ReadProperty
{
    /**
     * @inheritDoc
     */
    protected function setName(): string
    {
        return 'sub_info';
    }

    /**
     * @inheritDoc
     */
    public function read(): bool
    {
        $subInfo = $this->getProperty();
        $reader = new Reader(
            $subInfo, $this->key,
            $this->continuousData->subInfo,
            ContinuousSubInfo::class,
            [ 'parentID' => $this->getParentID() ]
        );
        $reader->readProperty(SubContractorID::class)
            ->readProperty(SubContractorName::class)
            ->readProperty(SubInn::class)
            ->readProperty(SubKpp::class)
            ->readProperty(SubBik::class)
            ->readProperty(SubBank::class)
            ->readProperty(SubAccount::class)
            ->readProperty(SubUrAddress::class)
            ->readProperty(SubFactAddress::class)
            ->readProperty(SubFio::class)
            ->readProperty(SubPosition::class)
            ->readProperty(SubPhone::class)
            ->readProperty(SubEmail::class);

        return $reader->read();
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