<?php

namespace mb24dev\AmoCRM\Entity;

/**
 * Class Value
 * @package mb24dev\AmoCRM\Entity
 */
class Value implements AmoEntityInterface
{
    private $value;
    private $enum;

    /**
     * Value constructor.
     * @param $value
     * @param $enum
     */
    public function __construct($value, $enum = null)
    {
        $this->value = $value;
        $this->enum = $enum;
    }

    /**
     * @return array
     */
    public function toAmoArray()
    {
        return [
            'value' => $this->value,
            'enum' => $this->enum
        ];
    }


}
