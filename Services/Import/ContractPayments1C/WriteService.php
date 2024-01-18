<?php

namespace App\Services\Import\ContractPayments1C;

use App\HelpModels\ContractPayment1C;
use App\Services\Import\Abstractions\DBWriteService;
use App\Services\Import\ContractPayments1C\ImportModels\ContractPayment;
use Exception;

/**
 * @inheritDoc
 * @see ImportFrom1CService     Вызывающий класс.
 * @property ContractPayment[] $importedData
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
        foreach ($this->importedData as $importedPayment)
        {
            ContractPayment1C::firstOrCreate(
                $importedPayment->getDBData()
            );
        }
    }
}