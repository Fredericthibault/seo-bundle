<?php

namespace Viweb\SeoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ViwebSeoBundle:Default:index.html.twig');
    }
}
