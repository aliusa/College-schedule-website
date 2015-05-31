<?php

namespace Schedule\CMSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ScheduleCMSBundle:Default:index.html.twig');
    }
}
