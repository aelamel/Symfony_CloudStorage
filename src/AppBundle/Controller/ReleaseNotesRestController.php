<?php

namespace AppBundle\Controller;

use AppBundle\Service\ReleaseNotesService;
use Doctrine\ORM\EntityManager;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

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
                    'status' => 'SUCCESS',
                    'releaseNote' => $releaseNoteData
                ],
                Response::HTTP_CREATED
            );
        });
    }

    /**
     * @Rest\Get("/release-notes/{id}/download")
     * @param $id
     * @return \FOS\RestBundle\View\View|Response
     */
    public function getReleaseNotesDownloadAction($id) {

        try {
            return $this->_releaseNotesService->downloadReleaseNoteFile($id);
        } catch (HttpException $e) {
            return $this->reportError($e, $e->getStatusCode());
        } catch (\Exception $e) {
            return $this->reportError($e, 500);
        }
    }

    private function reportError(\Exception $e, $code)
    {
        return $this->view([
                'code' => $code,
                'status' => 'ERROR',
                'message' => $e->getMessage()
            ], $code
        );
    }
}
