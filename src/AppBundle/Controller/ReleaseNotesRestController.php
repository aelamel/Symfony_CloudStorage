<?php

namespace AppBundle\Controller;

use AppBundle\Service\ReleaseNotesService;
use Doctrine\ORM\EntityManager;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ReleaseNotesRestController
 * @package AppBundle\Controller
 *
 */
class ReleaseNotesRestController extends FOSRestController
{
    /** @var  ReleaseNotesService */
    private $_releaseNotesService;

    function __construct(ReleaseNotesService $releaseNotesService)
    {
        $this->_releaseNotesService = $releaseNotesService;
    }

    /**
     * @Rest\Get("/release-notes")
     * @Rest\View()
     */
    public function getReleaseNotesAction()
    {
        $releaseNotes = $this->_releaseNotesService->findAll();

        return [
            'status' => Response::HTTP_OK,
            'releaseNotes' => $releaseNotes
        ];
    }

    /***
     * @Rest\Post("/release-notes")
     * @Rest\View(statusCode="201")
     *
     * @param Request $request
     * @return bool|mixed
     */
    public function postReleaseNotesCreateAction(Request $request) {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        return $em->transactional(function() use ($request) {
            $releaseNote = $request->request->all();
            $releaseNote['file'] = $request->files->get('file');

            $releaseNote = $this->_releaseNotesService->createOrUpdateReleaseNote($releaseNote);

            return $this->view(
                [
                    'code' => Response::HTTP_CREATED,
                    'status' => 'SUCCESS',
                    'releaseNote' => $releaseNote
                ]);
        });
    }
}
