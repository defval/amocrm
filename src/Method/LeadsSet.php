<?php

namespace mb24dev\AmoCRM\Method;

use GuzzleHttp\Psr7\Request;
use mb24dev\AmoCRM\Entity\AmoEntityInterface;
use mb24dev\AmoCRM\Entity\AmoIdentityInterface;
use Psr\Http\Message\RequestInterface;

/**
 * Class LeadsSet
 *
 * @package mb24dev\AmoCRM\Method
 */
class LeadsSet extends BaseMethod
{
    /**
     * @var AmoEntityInterface[]
     */
    private $addEntities = [];

    /**
     * @var AmoEntityInterface[]
     */
    private $updateEntities = [];

    /**
     * @return RequestInterface
     */
    public function buildRequest()
    {
        $addEntities = [];
        $updateEntities = [];

        foreach ($this->addEntities as $entity) {
            $addEntities[] = $entity->toAmoArray();
        }

        foreach ($this->updateEntities as $entity) {
            $updateEntities[] = $entity->toAmoArray();
        }

        $body = json_encode(
            [
                'request' => [
                    'leads' => [
                        'add' => $addEntities,
                        'update' => $updateEntities,
                    ],
                ],
            ]
        );

        $request = new Request(
            'POST', $this->getUser()->getAmoCRMDomain() . 'private/api/v2/json/leads/set', [], $body
        );

        return $request;
    }

    /**
     * @param AmoIdentityInterface[] $entities
     * @return $this
     */
    public function setLeads($entities)
    {
        if (!is_array($entities)) {
            $entities = [$entities];
        }

        foreach ($entities as $entity) {
            if ($entity->getAmoID()) {
                $this->updateEntities[] = $entity;
            } else {
                $this->addEntities[] = $entity;
            }
        }

        return $this;
    }

}
