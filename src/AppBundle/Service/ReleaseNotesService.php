<?php

namespace AppBundle\Service;


use AppBundle\Repository\ReleaseNotesRepository;
use Doctrine\ORM\EntityNotFoundException;
use Gaufrette\Filesystem;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;

class ReleaseNotesService
{

    /** @var  ReleaseNotesRepository */
    private $_releaseNotesRepository;

    /** @var  ContainerInterface */
    private $_container;

    public function __construct(ReleaseNotesRepository $releaseNotesRepository, ContainerInterface $container)
    {
        $this->_releaseNotesRepository = $releaseNotesRepository;
        $this->_container = $container;
    }

    public function findAll()
    {
        return $this->_releaseNotesRepository->findAll();
    }

    public function createOrUpdateReleaseNote($releaseNoteData)
    {
        return $this->_releaseNotesRepository->createOrUpdateReleaseNotes($releaseNoteData);
    }

    /**
     * @param $id
     * @return Response
     * @throws EntityNotFoundException
     */
    public function downloadReleaseNoteFile($id)
    {
        $releaseNote = $this->_releaseNotesRepository->find($id);
        if ($releaseNote !== null) {
            return $this->downloadFile('release_notes_filesystem', $releaseNote->getDocument());
        }
        throw new EntityNotFoundException("No Record has been found !");
    }

    /**
     * @param $configSystem
     * @param $fileName
     * @return Response
     */
    private function downloadFile($configSystem, $fileName)
    {
        /**
         * @var Filesystem $fileSystem
         */
        $fileSystem = $this->_container->get('knp_gaufrette.filesystem_map')->get($configSystem);

        $response = new Response();
        $response->headers->set('Content-Disposition', 'attachment;filename="'.$fileName.'"');
        $response->headers->set('Content-Type','application/force-download');
        $content = $fileSystem->read($fileName);
        $response->setContent($content);
        return $response;
    }

}