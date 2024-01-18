<?php

namespace App\Services\Import\Abstractions;

/**
 * Сервис анализа и чтения полученных при импорте данных.
 */
abstract class ReadService
{
    /** @var array */   protected $importJSON;
    /** @var array */   protected $importedData;

    public function __construct(&$validatedDataArray)
    {
        $this->importedData = [];
        $this->importJSON = $validatedDataArray;
    }

    /**
     * Запускает чтение сырых данных импорта, проверяя данные,
     * фильтруя несостоятельные элементы и переводя их на язык приложения.
     *
     * @return array
     */
    public function read(): array
    {
        foreach ($this->importJSON as $key => &$importedElementJson)
        {   // Проверки данных импорта на валидный формат и содержание. Заполняется массив $this->importedData.
            $this->isValidImportStatement($importedElementJson, $key)
            and
            $this->isContinuousDataServed($importedElementJson, $key);

            // Обнуление прочитанных данных для экономии оперативной памяти.
            $importedElementJson = null;
        }

        return $this->importedData;
    }

    /**
     * Первостепенный анализ данных импорта: соответствует ли массив принимаемой импортом форме?
     * Также убирает несостоятельные элементы массива импорта, если в них допущена опечатка.
     * <br>
     * Предполагается, что в реализации будет вызван читатель данных импорта, возвращающий bool значение.
     *
     * @param mixed $importedElementJson    Данные импорта
     * @param int $key                      Порядковый ключ массива для логирования ошибки
     * @return bool                         Прошло ли чтение успешно
     */
    abstract protected function isValidImportStatement(&$importedElementJson, int $key): bool;

    /**
     * Анализ на целостность данных импорта: существуют ли все необходимые ссылки на данные в БД?
     * Возвращает непрерывные данные в массив класса $this->importedData
     * <br>
     * Предполагается, что в реализации будет вызван читатель непрерывных данных импорта, возвращающий bool значение и
     * заполняющий массив $this->importedData [например, как ссылочную переменную]
     *
     * @param array $importedElementJson    Валидный массив импорта
     * @param int $key                      Порядковый ключ массива для логирования ошибки
     * @return bool                         Прошло ли чтение успешно
     */
    abstract protected function isContinuousDataServed(array &$importedElementJson, int $key): bool;
}