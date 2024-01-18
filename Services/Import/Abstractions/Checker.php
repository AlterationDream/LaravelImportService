<?php

namespace App\Services\Import\Abstractions;

use App\Services\Import\ImportFrom1CService;

/**
 * Фасадный класс для анализа данных импорта.
 * Задаёт методы для последовательной проверки и вывода ошибок на каждом этапе в лог.
 */
class Checker
{
    /** @var bool */        protected $pass;
    /** @var mixed */       protected $data;
    /** @var string[] */    protected $errors;
    /** @var int */         protected $key;
    /** @var array */       public $checkProperties;

    /**
     * Фасадный класс для анализа данных импорта. <br>
     * Задаёт методы для последовательной проверки и вывода ошибок на каждом этапе в лог.
     *
     * @param mixed $data               Данные для последовательной проверки.
     * @param int $key                  Ключ в массиве исходных данных для логирования.
     * @param array $checkProperties    Массив с дополнительными свойствами для проверки.
     */
    public function __construct(&$data, int $key, array $checkProperties = [])
    {
        $this->data = &$data;
        $this->key = $key + 1;
        $this->checkProperties['parentID'] = null;
        $this->assignCheckProperties($checkProperties);

        $this->errors = [];
        $this->pass = true;
    }

    /**
     * Сохранить значения дополнительных свойств для проверки.
     * @param array $checkProperties
     * @return void
     */
    protected function assignCheckProperties(array $checkProperties)
    {
        if (count($checkProperties) == 0) return;

        if (!$this->array_has_string_keys($checkProperties))
            dd('Переданные параметры проверки должны быть ассоциативным массивом.');

        $this->checkProperties = array_merge($this->checkProperties, $checkProperties);
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
     * Метод для проверки свойства переданных данных. <br>
     * Проверяет переданное свойство данных на пригодность для импорта, запуская проверку, объявленную в его классе. <br>
     * Пропускает последующие чтения, если на предыдущем этапе цепочки чтение уже было провалено. <br>
     * Сохраняет опциональный текст ошибки для вывода в последнем методе цепочки.
     *
     * @param string $propertyClassName
     * @return $this
     */
    public function checkData(string $propertyClassName): Checker
    {
        if (!$this->pass)
            return $this;

        // Проверяет, является ли переданная строка названием свойства
        if (!is_subclass_of($propertyClassName, CheckProperty::class)) {
            $this->errors[] = 'Класс параметра не найден для текущего импорта: '. $propertyClassName;
            return $this;
        }

        // Запускает проверку, указанную в классе свойства.
        /** @var CheckProperty $property */
        $property = new $propertyClassName(
            $this->data,
            $this->key,
            $this->checkProperties
        );

        if (!$property->check())
        {
            $this->pass = false;
            $this->errors[] = $property->returnError();
        }

        return $this;
    }

    /**
     * Возвращает результат успешности анализа (bool).
     * Записывает в лог текст ошибки, если он был указан на проваленном этапе проверки.
     * Вызывается последним в цепочке.
     *
     * @return bool
     */
    public function check(): bool
    {
        foreach ($this->errors as $errorText)
            ImportFrom1CService::logError($errorText);

        return $this->pass;
    }
}