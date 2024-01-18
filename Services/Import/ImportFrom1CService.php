<?php

namespace App\Services\Import;

use App\Services\Import\InnerPayments\WriteService as InnerPaymentsWriteService;
use App\Services\Import\InnerPayments\ReadService as InnerPaymentsReadService;
use App\Services\Import\ContractPayments1C\ReadService as ContractPaymentsReadService;
use App\Services\Import\ContractPayments1C\WriteService as ContractPaymentsWriteService;
use App\Services\Import\ContractExecutions\ReadService as ContractExecutionsReadService;
use App\Services\Import\ContractExecutions\WriteService as ContractExecutionsWriteService;

use Exception;

/**
 * Сервис импорта данных из 1С.
 *
 * @see InnerPaymentsReadService        Сервис чтения импорта внутренних платежей.
 * @see InnerPaymentsWriteService       Сервис записи подготовленных данных внутренних платежей.
 * @see ContractPaymentsReadService     Сервис чтения импорта поступлений на расчётный счёт.
 * @see ContractPaymentsWriteService    Сервис записи подготовленных данных поступлений на расчётный счёт.
 * @see ContractExecutionsReadService   Сервис чтения импорта актов выполнения.
 * @see ContractExecutionsWriteService  Сервис записи подготовленных данных актов выполнения.
 *
 */
class ImportFrom1CService
{
    /**
     * Сервис импорта данных из 1С.
     *
     * @see InnerPaymentsReadService        Сервис чтения импорта внутренних платежей.
     * @see InnerPaymentsWriteService       Сервис записи подготовленных данных внутренних платежей.
     * @see ContractPaymentsReadService     Сервис чтения импорта поступлений на расчётный счёт.
     * @see ContractPaymentsWriteService    Сервис записи подготовленных данных поступлений на расчётный счёт.
     * @see ContractExecutionsReadService   Сервис чтения импорта актов выполнения.
     * @see ContractExecutionsWriteService  Сервис записи подготовленных данных актов выполнения.
     */
    public function __construct() {}

    /**
     * Запустить импорт внутренних платежей.
     *
     * @param array $validatedDataArray Типовой массив данных, полученных из запроса импорта.
     * @return void
     * @throws Exception
     */
    public function importInnerPayments(array &$validatedDataArray): void
    {
        self::logInfo('Начало выгрузки внутренних платежей.');
        $importedData = (new InnerPaymentsReadService($validatedDataArray))->read();
        (new InnerPaymentsWriteService($importedData))->importRecords();
        self::logInfo('Выгрузка внутренних платежей закончена.');
    }

    /**
     * Запустить импорт поступлений на расчётный счёт.
     *
     * @param array $validatedDataArray Типовой массив данных, полученных из запроса импорта.
     * @return void
     * @throws Exception
     */
    public function importContractPayments1C(array &$validatedDataArray): void
    {
        self::logInfo('Начало выгрузки поступлений на расчётный счёт.');
        $importedData = (new ContractPaymentsReadService($validatedDataArray))->read();
        (new ContractPaymentsWriteService($importedData))->importRecords();
        self::logInfo('Выгрузка поступлений на расчётный счёт закончена.');
    }

    /**
     * Запустить импорт актов выполнения.
     *
     * @param array $validatedDataArray
     * @return void
     * @throws Exception
     */
    public function importContractExecutions(array &$validatedDataArray): void
    {
        self::logInfo('Начало выгрузки актов выполнения.');
        $importedData = (new ContractExecutionsReadService($validatedDataArray))->read();
        (new ContractExecutionsWriteService($importedData))->importRecords();
        self::logInfo('Выгрузка актов выполнения закончена.');
    }

    /**
     * Метод логирования информации о работе сервиса.
     *
     * @param string $infoText
     * @return void
     */
    public static function logInfo(string $infoText)
    {
        \Log::info($infoText);
    }

    /**
     * Метод логирования ошибок в работе сервиса.
     *
     * @param string $errorText
     * @return void
     */
    public static function logError(string $errorText)
    {
        \Log::error($errorText);
    }
}