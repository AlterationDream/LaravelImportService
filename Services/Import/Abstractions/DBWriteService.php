<?php

namespace App\Services\Import\Abstractions;

/**
 * Сервис, запускающий действия, необходимые для внесения полученных из импорта данных в БД.
 */
abstract class DBWriteService
{
    /** @var ContinuousImportModel[] */ protected $importedData;

    /**
     * Сервис, запускающий действия, необходимые для внесения полученных из импорта данных в БД.
     * @param array $importedData - Подготовленные для импорта элементы.
     */
    public function __construct(array &$importedData)
    {
        $this->importedData = &$importedData;
    }

    /**
     * Запускает импорт.
     * @return mixed
     */
    abstract public function importRecords();
}