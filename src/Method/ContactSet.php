<?php

namespace mb24dev\AmoCRM\Method;

use GuzzleHttp\Psr7\Request;
use mb24dev\AmoCRM\Entity\Contact;
use Psr\Http\Message\RequestInterface;

/**
 * Class ContactSet
 * @package mb24dev\AmoCRM\Method
 */
class ContactSet extends BaseMethod
{
    /**
     * @var Contact[]
     */
    private $addContacts;

    /**
     * @var Contact[]
     */
    private $updateContacts;

    /**
     * @return RequestInterface
     */
    public function buildRequest()
    {
        $addContacts = [];

        foreach ($this->addContacts as $addContact) {
            $addContacts[] = $addContact->toAmoArray();
        }

        $body = json_encode(
            [
                'request' => [
                    'contacts' => [
                        'add' => $addContacts
                    ]
                ]
            ]
        );


        $request = new Request('POST', $this->getUser()->getAmoCRMDomain() . 'private/api/v2/json/contacts/set', [], $body);

        return $request;
    }

    /**
     * @return \mb24dev\AmoCRM\Entity\Contact[]
     */
    public function getContacts()
    {
        return array_merge($this->addContacts, $this->updateContacts);
    }

    /**
     * @param \mb24dev\AmoCRM\Entity\Contact[] $contacts
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