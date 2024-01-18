<?php

namespace App\Services\Import\Abstractions;

use App\Services\Import\ImportFrom1CService;

/**
 * Фасадный класс для читателя данных импорта.
 * Задаёт методы для последовательной проверки и вывода ошибок на каждом этапе в лог.
 */
class Reader
{
    /** @var bool */                    protected $pass;
    /** @var mixed */                   protected $data;
    /** @var string[] */                protected $errors;
    /** @var int */                     protected $key;
    /** @var ContinuousImportModel */   protected $continuousData;
    /** @var array */                   protected $importedData;
    /** @var array */                   public $readProperties;

    /**
     * Фасадный класс читателя данных импорта.
     * Задаёт методы для последовательной проверки и вывода ошибок на каждом этапе в лог.
     *
     * @param array $data                       Передаваемые для проверки данные.
     * @param int $key                          Индекс массива в обрабатываемых данных.
     * @param array $importedData               Массив обработанных данных. Пополняется в случае успешного чтения непрерывной модели.
     * @param string $continuousImportModel     Название класса модели непрерывных данных.
     * @param array $checkProperties            Массив с дополнительными свойствами для проверки.
     */
    public function __construct(
        array &$data,
        int $key,
        array &$importedData,
        string $continuousImportModel,
        array $checkProperties = []
    )
    {
        if (!is_subclass_of($continuousImportModel, ContinuousImportModel::class))
            dd('Модель данных для импорта не найдена: ' . $continuousImportModel);

        $this->data = &$data;
        $this->key = $key + 1;
        $this->importedData = &$importedData;
        $this->continuousData = new $continuousImportModel();

        $this->readProperties['parentID'] = null;
        $this->assignCheckProperties($checkProperties);

        $this->errors = [];
        $this->pass = true;
    }

    /**
     * Сохранить значения дополнительных свойств для чтения.
     * @param array $checkProperties
     * @return void
     */
    protected function assignCheckProperties(array $checkProperties)
    {
        if (count($checkProperties) == 0) return;

        if (!$this->array_has_string_keys($checkProperties))
            dd('Переданные параметры проверки должны быть ассоциативным массивом.');

        foreach ($checkProperties as $name => $value) {
            $this->readProperties[$name] = $value;
        }
    }

    /**
     * Проверка на ассоциативный массив.
     * @param $array
     * @return bool
     */
    protected function array_has_string_keys($array): bool
    {
        return count(
                array_filter(
                    array_keys($array),
                    'is_string'
                )
            ) > 0;
    }

    /**
     * Читает свойство элемента [ReadProperty], переданного конструктору класса.
     * Запускает метод чтения этого элемента и логирует ошибку при её наличии.
     * Пропускает последующие проверки, если хоть одна была провалена.
     *
     * @param string $propertyClassName
     * @return $this
     */
    public function readProperty(string $propertyClassName): Reader
    {
        if (!$this->pass)
            return $this;

        // Проверяет, является ли переданная строка названием свойства
        if (!is_subclass_of($propertyClassName, ReadProperty::class)) {
            $this->errors[] = 'Класс параметра не найден для текущего импорта: '. $propertyClassName;
            return $this;
        }

        /** @var ReadProperty $property */
        $property = new $propertyClassName(
            $this->data,
            $this->key,
            $this->continuousData,
            $this->readProperties
        );

        // Запускает проверку, объявленную в классе свойства.
        if (!$property->read())
        {
            $this->pass = false;
            $this->errors[] = $property->returnError();
        }

        return $this;
    }

    /**
     * Возвращает результат успешности чтения (bool).
     * Записывает в лог текст ошибки, если он был указан на проваленном этапе проверки.
     * Вызывается последним в цепочке.
     *
     * @return bool
     */
    public function read(): bool
    {
        foreach ($this->errors as $errorText)
            ImportFrom1CService::logError($errorText);

        if ($this->pass)
            $this->importedData[] = $this->continuousData;

        return $this->pass;
    }
}