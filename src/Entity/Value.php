<?php

namespace mb24dev\AmoCRM\Entity;

/**
 * Class Value
 *
 * @package mb24dev\AmoCRM\Entity
 */
class Value implements AmoEntityInterface
{
    private $value;
    private $enum;
    /**
     * @var null
     */
    private $subtype;

    /**
     * Value constructor.
     *
     * @param      $value
     * @param      $enum
     * @param null $subtype
     */
    public function __construct($value, $enum = null, $subtype = null)
    {
        $this->value = $value;
        $this->enum = $enum;
        $this->subtype = $subtype;
    }

    /**
     * @return array
     */
    public function toAmoArray()
    {
        return [
            'value' => $this->value,
            'enum' => $this->enum,
            'subtype' => $this->subtype,
        ];
    }
}
