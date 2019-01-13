<?php

namespace AppBundle\Service;


use AppBundle\Repository\ReleaseNotesRepository;

class ReleaseNotesService
{

    /** @var  ReleaseNotesRepository */
    private $_releaseNotesRepository;


    public function __construct(ReleaseNotesRepository $releaseNotesRepository)
    {
        $this->_releaseNotesRepository = $releaseNotesRepository;
    }

    public function findAll()
    {
        return $this->_releaseNotesRepository->findAll();
    }

    public function createOrUpdateReleaseNote($releaseNoteData)
    {
        return $this->_releaseNotesRepository->createOrUpdateReleaseNotes($releaseNoteData);
    }
}