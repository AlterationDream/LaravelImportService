<?php

namespace App\Services\Import\ContractPayments1C;

use App\Services\Import\Abstractions\ReadService as AbstractReadService;
use App\Services\Import\Abstractions\Checker;
use App\Services\Import\Abstractions\Reader;
use App\Services\Import\ImportFrom1CService;
use App\Services\Import\ContractPayments1C\ImportModels\ContractPayment;

use App\Services\Import\ContractPayments1C\ReadProperties\Amount;
use App\Services\Import\ContractPayments1C\ReadProperties\ContractID;
use App\Services\Import\ContractPayments1C\ReadProperties\Date;
use App\Services\Import\ContractPayments1C\ReadProperties\Description;
use App\Services\Import\ContractPayments1C\ReadProperties\PaymentNum;

use App\Services\Import\ContractPayments1C\CheckProperties\IsArray as IsArrayCheck;
use App\Services\Import\ContractPayments1C\CheckProperties\ContractID as ContractIDCheck;
use App\Services\Import\ContractPayments1C\CheckProperties\Date as DateCheck;
use App\Services\Import\ContractPayments1C\CheckProperties\Amount as AmountCheck;
use App\Services\Import\ContractPayments1C\CheckProperties\PaymentNum as PaymentNumCheck;

/**
 * @inheritDoc
 * @see ImportFrom1CService Вызывающий класс.
 */
class ReadService extends AbstractReadService
{
    /**
     * Первостепенный анализ данных импорта: соответствует ли массив принимаемой импортом форме?
     * Также убирает несостоятельные элементы массива платежей, если в них допущена опечатка.
     *
     * @param mixed $importedElementJson    Данные импорта
     * @param mixed $key                      Порядковый ключ массива для логирования ошибки
     * @return bool                         Прошло ли чтение успешно
     */
    protected function isValidImportStatement(&$importedElementJson, $key): bool
    {
        $checker = new Checker($importedElementJson, $key);
        $checker->checkData(IsArrayCheck::class)
                ->checkData(ContractIDCheck::class)
                ->checkData(DateCheck::class)
                ->checkData(AmountCheck::class)
                ->checkData(PaymentNumCheck::class);

        return $checker->check();
    }

    /**
     * Анализ на целостность данных импорта: существуют ли все необходимые ссылки на данные в БД?
     * Возвращает непрерывные данные в массив класса $this->importedData
     *
     * @param array $importedElementJson    Валидный массив импорта
     * @param mixed $key                      Порядковый ключ массива для логирования ошибки
     * @return bool                         Прошло ли чтение успешно
     */
    protected function isContinuousDataServed(array &$importedElementJson, $key): bool
    {
        $reader = new Reader(
            $importedElementJson,
            $key,
            $this->importedData,
            ContractPayment::class);

        $reader->readProperty(ContractID::class)
               ->readProperty(Date::class)
               ->readProperty(Amount::class)
               ->readProperty(Description::class)
               ->readProperty(PaymentNum::class);

        return $reader->read();
    }
}