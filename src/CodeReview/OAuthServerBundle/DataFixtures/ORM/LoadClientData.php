<?php

namespace CodeReview\OAuthServerBundle\DataFixtures\ORM;

use CodeReview\OAuthServerBundle\Entity\Client;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadClientData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $c = new Client();

        $c->setRedirectUris(array('http://fake.local'));
        $c->setAllowedGrantTypes(array(
            'authorization_code',
            'password',
            'refresh_token',
            'token',
            'client_credentials',
        ));

        $manager->persist($c);

        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1000; // the order in which fixtures will be loaded
    }
}