<?php

namespace mb24dev\AmoCRM\Entity;

/**
 * Class Company
 *
 * @package mb24dev\AmoCRM\Entity
 */
class Company implements AmoEntityInterface, AmoIdentityInterface
{
    private $id;
    private $name;
    private $requestID;
    private $responsibleUserID;
    private $linkedLeadsID = [];
    private $tags = [];

    /**
     * @var \DateTime
     */
    private $dateCreate;

    /**
     * @var \DateTime
     */
    private $lastModified;

    /**
     * @var AmoEntityInterface[]
     */
    private $customFields = [];

    /**
     * Company constructor.
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
    public function setAmoId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @param mixed $name
     * @return $this
     */
    public function setAmoName($name)
    {
        $this->name = $name;

        return $this;
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
    public function setAmoLinkedLeadsID($linkedLeadsID)
    {
        $this->linkedLeadsID = $linkedLeadsID;

        return $this;
    }

    /**
     * @param array $tags
     * @return $this
     */
    public function setAmoTags($tags)
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * @param \DateTime $dateCreate
     * @return $this
     */
    public function setAmoDateCreate($dateCreate)
    {
        $this->dateCreate = $dateCreate;

        return $this;
    }

    /**
     * @param \DateTime $lastModified
     * @return $this
     */
    public function setAmoLastModified($lastModified)
    {
        $this->lastModified = $lastModified;

        return $this;
    }

    /**
     * @param AmoEntityInterface[] $customFields
     * @return $this
     */
    public function setAmoCustomFields($customFields)
    {
        $this->customFields = $customFields;

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
            'last_modified' => $this->lastModified ? $this->lastModified->getTimestamp() : null,
            'request_id' => $this->requestID,
            'responsible_user_id' => $this->responsibleUserID,
            'linked_leads_id' => $this->linkedLeadsID,
            'custom_fields' => array_map(
                function (AmoEntityInterface $customField) {
                    return $customField->toAmoArray();
                },
                $this->customFields
            ),
            'tags' => $this->tags,
        ];
    }

    /**
     * @return mixed
     */
    public function getAmoID()
    {
        return $this->id;
    }

}
