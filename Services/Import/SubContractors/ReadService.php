<?php

namespace App\Services\Import\SubContractors;

use App\Services\Import\Abstractions\Reader;
use App\Services\Import\Abstractions\ReadService as AbstractReadService;
use App\Services\Import\Abstractions\Checker;

use App\Services\Import\SubContractors\CheckProperties\ContractID as ContractIDCheck;
use App\Services\Import\SubContractors\CheckProperties\SubContractID as SubContractIDCheck;
use App\Services\Import\SubContractors\CheckProperties\SubContractName as SubContractNameCheck;
use App\Services\Import\SubContractors\CheckProperties\SubInfo as SubInfoCheck;
use App\Services\Import\SubContractors\CheckProperties\SubPayments as SubPaymentsCheck;

use App\Services\Import\SubContractors\ImportModels\SubContract;
use App\Services\Import\SubContractors\ReadProperties\ContractID;
use App\Services\Import\SubContractors\ReadProperties\SubContractID;
use App\Services\Import\SubContractors\ReadProperties\SubContractName;
use App\Services\Import\SubContractors\ReadProperties\SubInfo;
use App\Services\Import\SubContractors\ReadProperties\SubPayments;

/**
 * @inheritDoc
 * @see ImportFrom1CService     Вызывающий класс
 */
class ReadService extends AbstractReadService
{
    /**
     * @inheritDoc
     */
    protected function isValidImportStatement(&$importedElementJson, int $key): bool
    {
        $checker = new Checker($importedElementJson, $key);
        $checker->checkData(ContractIDCheck::class)
                ->checkData(SubContractIDCheck::class)
                //->checkData(SubContractNameCheck::class)
                ->checkData(SubInfoCheck::class);
                //->checkData(SubPaymentsCheck::class);

        return $checker->check();
    }

    /**
     * @inheritDoc
     */
    protected function isContinuousDataServed(array &$importedElementJson, int $key): bool
    {
        $reader = new Reader(
            $importedElementJson, $key,
            $this->importedData,
            SubContract::class
        );
        $reader->readProperty(ContractID::class)
                ->readProperty(SubContractID::class)
                ->readProperty(SubContractName::class)
                ->readProperty(SubInfo::class)
                ->readProperty(SubPayments::class);

        return $reader->read();
    }
}