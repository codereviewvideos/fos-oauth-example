<?php

namespace CodeReview\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\OAuthServerBundle\Model\ClientInterface;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToMany(targetEntity="CodeReview\OAuthServerBundle\Entity\Client")
     * @ORM\JoinTable(name="fos_user__to__oauth_clients",
     *     joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="client_id", referencedColumnName="id")}
     * )
     * @var ArrayCollection
     */
    protected $allowedClients;

    public function __construct()
    {
        parent::__construct();

        $this->allowedClients = new ArrayCollection();
    }

    public function isAuthorizedClient(ClientInterface $client)
    {
        return $this->getAllowedClients()->contains($client);
    }

    public function addClient(ClientInterface $client)
    {
        if ( ! $this->allowedClients->contains($client)) {
            $this->allowedClients->add($client);
        }
    }

    public function getAllowedClients()
    {
        return $this->allowedClients;
    }
}