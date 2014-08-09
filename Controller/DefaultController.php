<?php

namespace Movent\ProfilerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('MoventProfilerBundle:Default:index.html.twig', array('name' => $name));
    }
}
