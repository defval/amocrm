<?php

namespace mb24dev\AmoCRM\Entity;

/**
 * Class Contact
 * @package mb24dev\AmoCRM\Entity
 */
class Contact implements AmoEntityInterface, AmoIdentity
{

    private $id;
    private $name;
    private $requestID;
    private $dateCreate;
    private $lastModified;
    private $responsibleUserID;
    private $linkedLeadsID;
    private $companyName;
    private $customFields = [];
    private $tags;

    /**
     * Contact constructor.
     * @param $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @param mixed $id
     */
    public function setAmoID($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getAmoID()
    {
        return $this->id;
    }

    /**
     * @param mixed $requestID
     */
    public function setAmoRequestID($requestID)
    {
        $this->requestID = $requestID;
    }

    /**
     * @param mixed $dateCreate
     */
    public function setAmoDateCreate($dateCreate)
    {
        $this->dateCreate = $dateCreate;
    }

    /**
     * @param mixed $lastModified
     */
    public function setAmoLastModified($lastModified)
    {
        $this->lastModified = $lastModified;
    }

    /**
     * @param mixed $responsibleUserID
     */
    public function setAmoResponsibleUserID($responsibleUserID)
    {
        $this->responsibleUserID = $responsibleUserID;
    }

    /**
     * @param mixed $linkedLeadsID
     */
    public function setAmoLinkedLeadsID($linkedLeadsID)
    {
        $this->linkedLeadsID = $linkedLeadsID;
    }

    /**
     * @param mixed $companyName
     */
    public function setAmoCompanyName($companyName)
    {
        $this->companyName = $companyName;
    }

    /**
     * @param CustomField[] $customFields
     * @return $this
     */
    public function setAmoCustomFields($customFields)
    {
        if (!is_array($customFields)) {
            $customFields = [$customFields];
        }

        $this->customFields = $customFields;

        return $this;
    }

    /**
     * @param mixed $tags
     */
    public function setAmoTags($tags)
    {
        $this->tags = $tags;
    }

    /**
     * @return array
     */
    public function toAmoArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'custom_fields' => array_map(function ($customField) {
                /* @var CustomField $customField */
                return $customField->toAmoArray();

            }, $this->customFields)
        ];
    }


}