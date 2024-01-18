<?php

namespace App\Services\Import\InnerPayments;

use App\ContractInnerPayment;
use App\Services\Import\Abstractions\DBWriteService;
use App\Services\Import\ImportFrom1CService;
use App\Services\Import\InnerPayments\ImportModels\InnerPayment;
use Exception;

/**
 * @inheritDoc
 * @see ImportFrom1CService Вызывающий класс.
 * @property InnerPayment[] $importedData
 */
class WriteService extends DBWriteService
{
    /** @var int[] */                       private $touchedContractsIDs;

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function importRecords()
    {
        foreach ($this->importedData as $importedPaymentDirection)
        {
            foreach ($importedPaymentDirection->getDBData() as $importedPayment)
            {
                ContractInnerPayment::firstOrCreate(
                    $importedPayment
                );
            }
        }
    }
}