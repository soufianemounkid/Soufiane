<?php

namespace MSIM\TacheBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('MSIMTacheBundle:Default:index.html.twig', array('name' => $name));
    }
}
