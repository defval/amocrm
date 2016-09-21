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
    private $last_modified;

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
     */
    public function setAmoId($id)
    {
        $this->id = $id;
    }
    /**
     * @param mixed $name
     */
    public function setAmoName($name)
    {
        $this->name = $name;
    }
    /**
     * @param \DateTime $dateCreate
     */
    public function setAmoDateCreate(\DateTime $dateCreate)
    {
        $this->dateCreate = $dateCreate;
    }
    /**
     * @param \DateTime $last_modified
     */
    public function setAmoLastModified(\DateTime $last_modified)
    {
        $this->last_modified = $last_modified;
    }
    /**
     * @param mixed $statusID
     */
    public function setAmoStatusID($statusID)
    {
        $this->statusID = $statusID;
    }
    /**
     * @param mixed $pipelineID
     */
    public function setAmoPipelineID($pipelineID)
    {
        $this->pipelineID = $pipelineID;
    }
    /**
     * @param mixed $price
     */
    public function setAmoPrice($price)
    {
        $this->price = $price;
    }
    /**
     * @param mixed $responsibleUserID
     */
    public function setAmoResponsibleUserID($responsibleUserID)
    {
        $this->responsibleUserID = $responsibleUserID;
    }
    /**
     * @param mixed $requestID
     */
    public function setAmoRequestID($requestID)
    {
        $this->requestID = $requestID;
    }
    /**
     * @param mixed $customFields
     */
    public function setAmoCustomFields($customFields)
    {
        $this->customFields = $customFields;
    }
    /**
     * @param mixed $tags
     */
    public function setAmoTags($tags)
    {
        $this->tags = $tags;
    }
    /**
     * @param mixed $visitorUID
     */
    public function setAmoVisitorUID($visitorUID)
    {
        $this->visitorUID = $visitorUID;
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
