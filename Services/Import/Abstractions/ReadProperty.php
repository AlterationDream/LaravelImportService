<?php

namespace App\Services\Import\Abstractions;

abstract class ReadProperty
{
    /** @var string  */                 public $name;
    /** @var array */                   protected $data;
    /** @var int */                     protected $key;
    /** @var ContinuousImportModel */   public $continuousData;
    /** @var mixed */                   public $readProperties;

    /**
     * Конструктор чтения свойства обрабатываемых данных в непрерывный формат, удобный для импорта.
     *
     * @param array $data                               Передаваемые для проверки данные.
     * @param mixed $key                                Индекс массива в обрабатываемых данных.
     * @param ContinuousImportModel $continuousData     Модель непрерывных данных.
     * @param array $readProperties                     Массив с дополнительными свойствами для проверки.
     */
    public function __construct(
        array &$data,
        int &$key,
        ContinuousImportModel &$continuousData,
        array $readProperties
    )
    {
        $this->name = $this->setName();
        $this->data = &$data;
        $this->key = &$key;
        $this->continuousData = &$continuousData;
        $this->readProperties = $readProperties;
    }

    /**
     * Возвращает строковый индекс свойства в переданном массиве.
     * @return string
     */
    abstract protected function setName(): string;

    /**
     * Запускает чтение свойства. (Предполагается, что они записываются в $this->continuousData)
     * @return bool
     */
    abstract public function read(): bool;

    /**
     * Есть ли объявленное свойство в составе переданного массива?
     * @return bool
     */
    protected function isInArray(): bool
    {
        return array_key_exists($this->name, $this->data);
    }

    /**
     * Возвращает значение свойства.
     * @return mixed
     */
    protected function getProperty()
    {
        return $this->data[ $this->name ];
    }

    /**
     * Возвращает ошибку при её наличии.
     * @return string
     */
    public function returnError(): string
    {
        $parentMessage = '';
        if ($this->readProperties['parentID'])
            $parentMessage = PHP_EOL . 'ID родительского массива: ' . $this->readProperties['parentID'];

        return $this->errorText() .
            $parentMessage .
            PHP_EOL . 'Порядок в массиве: ' . $this->key . '.' .
            PHP_EOL . 'Читаемый элемент: ' . print_r($this->data, true);
    }

    /**
     * Возвращает общий текст ошибки, без технических данных.
     * @return string
     */
    protected function errorText(): string
    {
        return 'Произошла ошибка при чтении свойства [' . $this->name. '].';
    }
}