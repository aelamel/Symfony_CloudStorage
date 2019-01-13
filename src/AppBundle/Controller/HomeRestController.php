<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;

class HomeRestController extends FOSRestController
{
    /**
     * @Rest\Get("/")
     */
    public function getHomeAction()
    {
        return $this->view([
            'code' => Response::HTTP_OK
        ]);
    }
}
