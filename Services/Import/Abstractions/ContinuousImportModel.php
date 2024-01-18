<?php

namespace App\Services\Import\Abstractions;

/**
 * Модель для хранения непрерывных данных, полученных из импорта элементов, для простоты обновления их в БД.
 */
abstract class ContinuousImportModel
{
    /**
     * Возвращает массив данных, пригодных для передачи методу Laravel Eloquent для внесения данных в БД;
     * @return array
     */
    abstract public function getDBData(): array;
}