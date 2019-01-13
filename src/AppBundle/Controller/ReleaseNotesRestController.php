<?php

namespace AppBundle\Controller;

use AppBundle\Service\ReleaseNotesService;
use Doctrine\ORM\EntityManager;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ReleaseNotesRestController
 * @package AppBundle\Controller
 *
 */
class ReleaseNotesRestController extends AbstractFOSRestController
{
    /** @var  ReleaseNotesService */
    private $_releaseNotesService;

    public function __construct(ReleaseNotesService $releaseNotesService)
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

    /**
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
            $releaseNoteData = $request->request->all();
            $releaseNoteData['file'] = $request->files->get('file');

            $releaseNoteData = $this->_releaseNotesService->createOrUpdateReleaseNote($releaseNoteData);

            return $this->view(
                [
                    'code' => Response::HTTP_CREATED,
                    'status' => 'SUCCESS',
                    'releaseNote' => $releaseNoteData
                ]);
        });
    }
}
