<?php

namespace CodeReview\OAuthServerBundle\EventListener;

use Doctrine\Common\Persistence\ObjectManager;
use FOS\OAuthServerBundle\Event\OAuthEvent;

class OAuthEventListener
{
    private $em;

    public function __construct(ObjectManager $em)
    {
        $this->em = $em;
    }

    public function onPreAuthorizationProcess(OAuthEvent $event)
    {
        if ($user = $this->getUser($event)) { /** @var $user \CodeReview\UserBundle\Entity\User */
            $event->setAuthorizedClient(
                $user->isAuthorizedClient($event->getClient())
            );
        }
    }

    public function onPostAuthorizationProcess(OAuthEvent $event)
    {
        if ($event->isAuthorizedClient()) {
            if (null !== $client = $event->getClient()) {
                $user = $this->getUser($event); /** @var $user \CodeReview\UserBundle\Entity\User */
                $user->addClient($client);
                $this->em->persist($user);
                $this->em->flush();
            }
        }
    }

    protected function getUser(OAuthEvent $event)
    {
        return $this->em
            ->getRepository('CodeReviewUserBundle:User')
            ->findOneByUsername($event->getUser()->getUsername())
        ;
    }
}