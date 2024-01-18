<?php

namespace App\Services\Import\Abstractions;

abstract class CheckProperty
{
    /** @var string  */     public $name;
    /** @var mixed */       protected $data;
    /** @var int */         protected $key;
    /** @var array */       public $checkProperties;

    /**
     * Конструктор проверки свойства обрабатываемых данных на целостность.
     *
     * @param mixed $data               Передаваемые для проверки данные.
     * @param mixed $key                Индекс массива в обрабатываемых данных.
     * @param array $checkProperties    Массив с дополнительными свойствами для проверки.
     */
    public function __construct(&$data, &$key, array $checkProperties)
    {
        $this->name = $this->setName();
        $this->data = &$data;
        $this->key = &$key;
        $this->checkProperties = $checkProperties;
    }

    /**
     * Возвращает строковый индекс свойства в переданном массиве.
     * @return string
     */
    abstract protected function setName(): string;

    /**
     * Запускает проверку целостности свойства.
     * @return bool
     */
    abstract public function check(): bool;

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
     * Запускает проверку свойства-массива, используя переданный метод,
     * который будет применяться для каждого элемента. <br>
     * Элементы, провалившие проверку, будут отсеяны.
     *
     * @param callable $callableChecker     Метод, исполняющий проверку.
     *                                      Передаваемый параметр - обрабатываемый элемент под-массива.
     * @return bool                         Результат проверки
     */
    protected function checkSubArray(callable $callableChecker): bool
    {
        // Замена исходных данных массива на отфильтрованные
        $this->data[ $this->name ] = array_filter( $this->data[ $this->name ],
            function ($element) use ($callableChecker)
            {   // Проверка под-массива на валидность запроса.
                return $callableChecker($element);
            }
        );

        // Остались ли после фильтрации хоть какие-то элементы массива?
        return count( $this->getProperty() ) > 0;
    }

    /**
     * Возвращает ошибку при её наличии.
     * @return string
     */
    public function returnError(): string
    {
        $parentMessage = '';
        if ($this->checkProperties['parentID'])
            $parentMessage = PHP_EOL . 'ID родительского массива: ' . $this->checkProperties['parentID'];

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