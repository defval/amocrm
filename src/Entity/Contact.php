<?php

namespace mb24dev\AmoCRM\Entity;

/**
 * Class Contact
 *
 * @package mb24dev\AmoCRM\Entity
 */
class Contact implements AmoEntityInterface, AmoIdentityInterface
{
    /**
     * @var string|int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string|int
     */
    private $requestID;

    /**
     * @var \DateTime
     */
    private $dateCreate;

    /**
     * @var \DateTime
     */
    private $lastModified;

    /**
     * @var string|int
     */
    private $responsibleUserID;

    /**
     * @var array
     */
    private $linkedLeadsID;

    /**
     * @var string
     */
    private $companyName;

    /**
     * @var AmoEntityInterface[]
     */
    private $customFields = [];

    /**
     * @var string
     */
    private $tags;

    /**
     * Contact constructor.
     *
     * @param $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @param mixed $id
     * @return $this
     */
    public function setAmoID($id)
    {
        $this->id = $id;

        return $this;
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
     * @return $this
     */
    public function setAmoRequestID($requestID)
    {
        $this->requestID = $requestID;

        return $this;
    }

    /**
     * @param \DateTime $dateCreate
     * @return $this
     */
    public function setAmoDateCreate(\DateTime $dateCreate)
    {
        $this->dateCreate = $dateCreate;

        return $this;
    }

    /**
     * @param \DateTime $lastModified
     * @return $this
     */
    public function setAmoLastModified(\DateTime $lastModified)
    {
        $this->lastModified = $lastModified;

        return $this;
    }

    /**
     * @param mixed $responsibleUserID
     * @return $this
     */
    public function setAmoResponsibleUserID($responsibleUserID)
    {
        $this->responsibleUserID = $responsibleUserID;

        return $this;
    }

    /**
     * @param array $linkedLeadsID
     * @return $this
     */
    public function setAmoLinkedLeadsID(array $linkedLeadsID)
    {
        $this->linkedLeadsID = $linkedLeadsID;

        return $this;
    }

    /**
     * @param mixed $companyName
     * @return $this
     */
    public function setAmoCompanyName($companyName)
    {
        $this->companyName = $companyName;

        return $this;
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
     * @param string $tags
     * @return $this
     */
    public function setAmoTags($tags)
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * @return array
     */
    public function toAmoArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'date_create' => $this->dateCreate ? $this->dateCreate->getTimestamp() : null,
            'last_modified' => $this->dateCreate ? $this->dateCreate->getTimestamp() : null,
            'responsible_user_id' => $this->responsibleUserID,
            'linked_leads_id' => $this->linkedLeadsID,
            'company_name' => $this->companyName,
            'custom_fields' => array_map(
                function (AmoEntityInterface $customField) {
                    return $customField->toAmoArray();
                },
                $this->customFields
            ),
            'tags' => $this->tags,
        ];
    }

}
