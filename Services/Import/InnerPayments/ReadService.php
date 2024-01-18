<?php

namespace App\Services\Import\InnerPayments;

use App\Services\Import\Abstractions\Checker;
use App\Services\Import\Abstractions\Reader;
use App\Services\Import\Abstractions\ReadService as AbstractReadService;
use App\Services\Import\ImportFrom1CService;
use App\Services\Import\InnerPayments\ImportModels\InnerPayment;

use App\Services\Import\ContractPayments1C\CheckProperties\ContractID as ContractIDCheck;
use App\Services\Import\ContractPayments1C\CheckProperties\IsArray as IsArrayCheck;
use App\Services\Import\InnerPayments\CheckProperties\SenderLegalEntity as SenderLegalEntityCheck;
use App\Services\Import\InnerPayments\CheckProperties\Payments as PaymentsCheck;
use App\Services\Import\InnerPayments\ReadProperties\ContractID;
use App\Services\Import\InnerPayments\ReadProperties\Payments;
use App\Services\Import\InnerPayments\ReadProperties\SenderLaboratory;
use App\Services\Import\InnerPayments\ReadProperties\SenderLegalEntity;

/**
 * @inheritDoc
 * @see ImportFrom1CService     Вызывающий класс
 */
class ReadService extends AbstractReadService
{
    /**
     * Первостепенный анализ данных импорта: соответствует ли массив принимаемой импортом форме?
     * Также убирает несостоятельные элементы массива платежей, если в них допущена опечатка.
     *
     * @param mixed $importedElementJson   Данные импорта
     * @param int $key                  Порядковый ключ массива для логирования ошибки
     * @return bool                     Прошло ли чтение успешно
     */
    protected function isValidImportStatement(&$importedElementJson, int $key): bool
    {
        $checker = new Checker($importedElementJson, $key);
        $checker->checkData(IsArrayCheck::class)
                ->checkData(ContractIDCheck::class)
                ->checkData(SenderLegalEntityCheck::class)
                ->checkData(PaymentsCheck::class);

        return $checker->check();
    }

    /**
     * Анализ на целостность данных импорта: существуют ли все необходимые ссылки на данные в БД?
     * Возвращает непрерывные данные в массив класса $this->importedData
     *
     * @param array $importedElementJson    Валидный массив импорта
     * @param int $key                      Порядковый ключ массива для логирования ошибки
     * @return bool                         Прошло ли чтение успешно
     */
    protected function isContinuousDataServed(array &$importedElementJson, int $key): bool
    {
        $reader = new Reader(
            $importedElementJson, $key,
            $this->importedData,
            InnerPayment::class
        );
        $reader->readProperty(ContractID::class)
                ->readProperty(SenderLegalEntity::class)
                ->readProperty(SenderLaboratory::class)
                ->readProperty(Payments::class);

        return $reader->read();
    }
}