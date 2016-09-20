<?php

namespace mb24dev\AmoCRM\Method;

use GuzzleHttp\Psr7\Request;
use mb24dev\AmoCRM\Entity\AmoEntityInterface;
use mb24dev\AmoCRM\Entity\AmoIdentityInterface;
use Psr\Http\Message\RequestInterface;

/**
 * Class ContactSet
 *
 * @package mb24dev\AmoCRM\Method
 */
class ContactSet extends BaseMethod
{
    /**
     * @var AmoEntityInterface[]
     */
    private $addContacts = [];

    /**
     * @var AmoEntityInterface[]
     */
    private $updateContacts = [];

    /**
     * @return RequestInterface
     */
    public function buildRequest()
    {
        $addContacts = [];
        $updateContacts = [];

        foreach ($this->addContacts as $addContact) {
            $addContacts[] = $addContact->toAmoArray();
        }

        foreach ($this->updateContacts as $updateContact) {
            $updateContacts[] = $updateContact->toAmoArray();
        }

        $body = json_encode(
            [
                'request' => [
                    'contacts' => [
                        'add' => $addContacts,
                        'update' => $updateContacts,
                    ],
                ],
            ]
        );

        $request = new Request(
            'POST', $this->getUser()->getAmoCRMDomain() . 'private/api/v2/json/contacts/set', [], $body
        );

        return $request;
    }

    /**
     * @return AmoEntityInterface[]
     */
    public function getContacts()
    {
        return array_merge($this->addContacts, $this->updateContacts);
    }

    /**
     * @param AmoIdentityInterface[] $contacts
     * @return $this
     */
    public function setContacts($contacts)
    {
        if (!is_array($contacts)) {
            $contacts = [$contacts];
        }

        foreach ($contacts as $contact) {
            if ($contact->getAmoID()) {
                $this->updateContacts[] = $contact;
            } else {
                $this->addContacts[] = $contact;
            }
        }

        return $this;
    }

}
