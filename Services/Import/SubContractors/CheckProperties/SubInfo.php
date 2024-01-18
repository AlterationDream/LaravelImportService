<?php

namespace App\Services\Import\SubContractors\CheckProperties;

use App\Services\Import\Abstractions\Checker;
use App\Services\Import\Abstractions\CheckProperty;
use App\Services\Import\SubContractors\CheckProperties\SubInfo\SubContractorID;

class SubInfo extends CheckProperty
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
    public function check(): bool
    {
        return  $this->isInArray()
                and
                is_array($this->getProperty())
                and
                count($this->getProperty()) > 0
                and
                $this->checkInfo();
    }

    /**
     * Обработчик проверки каждого элемента массива информации соисполнителя.
     */
    public function checkInfo(): bool
    {
        $checker = new Checker($info, $this->key, [ 'parentID' => $this->getParentID() ]);
        $checker->checkData(SubContractorID::class);

        return $checker->check();
    }

    /**
     * Информация-идентификатор родительского массива платежей.
     * @return string|null
     */
    public function getParentID(): string
    {
        return 'sub_contract_id: ' .$this->data['sub_contract_id'];
    }

    /**
     * @inheritDoc
     */
    protected function errorText(): string
    {
        return 'Должен быть передан массив ['. $this->name .'] с информацией соисполнителя и обязательным полем [sub_contractor_id].';
    }
}