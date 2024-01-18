<?php

namespace App\Services\Import\ContractExecutions;

use App\HelpModels\ContractExecutions1C;
use App\HelpModels\ContractPayment1C;
use App\Services\Import\Abstractions\DBWriteService;
use App\Services\Import\ContractExecutions\ImportModels\ContractExecution;
use Exception;

/**
 * @inheritDoc
 * @see ImportFrom1CService     Вызывающий класс.
 * @property ContractExecution[] $importedData
 */
class WriteService extends DBWriteService
{
    private $touchedContractsIDs;

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function importRecords()
    {
        foreach ($this->importedData as $importedExecution)
        {
            ContractExecutions1C::firstOrCreate(
                $importedExecution->getDBData()
            );
        }
    }
}