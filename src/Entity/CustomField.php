<?php

namespace mb24dev\AmoCRM\Entity;

/**
 * Class CustomField
 * @package mb24dev\AmoCRM\Entity
 */
class CustomField implements AmoEntityInterface
{
    private $id;
    private $values;

    /**
     * CustomField constructor.
     * @param $id
     * @param $values
     */
    public function __construct($id, $values)
    {
        $this->id = $id;
        $this->values = $values;
    }

    /**
     * @return array
     */
    public function toAmoArray()
    {
        return [
            'id' => $this->id,
            'values' => array_map(function ($value) {
                /** @var Value $value */
                return $value->toAmoArray();
            }, $this->values)
        ];
    }


}