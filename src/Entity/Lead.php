<?php

namespace mb24dev\AmoCRM\Entity;

/**
 * Class Lead
 *
 * @package mb24dev\AmoCRM\Entity
 */
class Lead implements AmoEntityInterface, AmoIdentityInterface
{
    private $id;
    private $name;
    private $statusID;
    private $pipelineID;
    private $price;
    private $responsibleUserID;
    private $requestID;
    private $customFields;
    private $tags;
    private $visitorUID;

    /**
     * @var \DateTime
     */
    private $dateCreate;

    /**
     * @var \DateTime
     */
    private $lastModified;

    /**
     * Lead constructor.
     *
     * @param $name
     * @param $statusID
     */
    public function __construct($name, $statusID)
    {
        $this->name = $name;
        $this->statusID = $statusID;
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
     * @param mixed $statusID
     * @return $this
     */
    public function setAmoStatusID($statusID)
    {
        $this->statusID = $statusID;

        return $this;
    }

    /**
     * @param mixed $pipelineID
     * @return $this
     */
    public function setAmoPipelineID($pipelineID)
    {
        $this->pipelineID = $pipelineID;

        return $this;
    }

    /**
     * @param mixed $price
     * @return $this
     */
    public function setAmoPrice($price)
    {
        $this->price = $price;

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
     * @param mixed $requestID
     * @return $this
     */
    public function setAmoRequestID($requestID)
    {
        $this->requestID = $requestID;

        return $this;
    }

    /**
     * @param mixed $customFields
     * @return $this
     */
    public function setAmoCustomFields($customFields)
    {
        $this->customFields = $customFields;

        return $this;
    }

    /**
     * @param mixed $tags
     * @return $this
     */
    public function setAmoTags($tags)
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * @param mixed $visitorUID
     * @return $this
     */
    public function setAmoVisitorUID($visitorUID)
    {
        $this->visitorUID = $visitorUID;

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
            'status_id' => $this->statusID,
            'pipeline_id' => $this->pipelineID,
            'price' => $this->price,
            'responsible_user_id' => $this->responsibleUserID,
            'request_id' => $this->requestID,
            'custom_fields' => array_map(
                function (AmoEntityInterface $customField) {
                    return $customField->toAmoArray();
                },
                $this->customFields
            ),
            'tags' => $this->tags,
            'visitor_uid' => $this->visitorUID,
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
