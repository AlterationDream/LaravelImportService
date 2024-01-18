<?php

namespace App\Services\Import\ContractExecutions;

use App\Services\Import\ImportFrom1CService;
use App\Services\Import\Abstractions\ReadService as AbstractReadService;
use App\Services\Import\Abstractions\Checker;
use App\Services\Import\Abstractions\Reader;

use App\Services\Import\ContractExecutions\CheckProperties\ContractID as ContractIDCheck;
use App\Services\Import\ContractExecutions\CheckProperties\Date as DateCheck;
use App\Services\Import\ContractExecutions\CheckProperties\Amount as AmountCheck;

use App\Services\Import\ContractExecutions\ImportModels\ContractExecution;
use App\Services\Import\ContractExecutions\ReadProperties\ContractID;
use App\Services\Import\ContractExecutions\ReadProperties\Date;
use App\Services\Import\ContractExecutions\ReadProperties\Amount;

/**
 * @inheritDoc
 * @see ImportFrom1CService Вызывающий класс
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
                ->checkData(DateCheck::class)
                ->checkData(AmountCheck::class);

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
            ContractExecution::class
        );
        $reader->readProperty(ContractID::class)
            ->readProperty(Date::class)
            ->readProperty(Amount::class);

        return $reader->read();
    }
}