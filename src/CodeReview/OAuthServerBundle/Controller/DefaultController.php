<?php

namespace CodeReview\OAuthServerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('CodeReviewOAuthServerBundle:Default:index.html.twig', array('name' => $name));
    }
}
