<?php

namespace AppBundle\Repository;


use AppBundle\Entity\ReleaseNotes;
use AppBundle\Traits\EntityUpdating;
use AppBundle\Validators\AccumulatingValidator;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class ReleaseNotesRepository
 * @package AppBundle\Repository
 */
class ReleaseNotesRepository extends EntityRepository
{
    use EntityUpdating;

    protected $key = ['id'];

    /**
     * @param ValidatorInterface $validator
     */
    public function setEntityValidator(ValidatorInterface $validator)
    {
        $this->entityValidator = new AccumulatingValidator($validator);
    }

    /**
     * @param $releaseNoteData
     * @return ReleaseNotes|null|object
     */
    public function createOrUpdateReleaseNotes($releaseNoteData)
    {
        $releaseNote = $this->findOrCreateOne($releaseNoteData);

        $this->updateEntityData($releaseNote, $releaseNoteData);

        $this->entityValidator->throwIfInvalid();
        $this->getEntityManager()->persist($releaseNote);
        $this->getEntityManager()->flush($releaseNote);

        return $releaseNote;
    }

    /**
     * @param $criteria
     * @return ReleaseNotes|null|object
     */
    public function findOrCreateOne($criteria)
    {
        if(count($this->key) > 0) {
            $search = array_intersect_key($criteria, $this->key);
            if(count($search) > 0) {
                $entity = $this->findOneBy($search);
                if (null !== $entity) {
                    return $entity;
                }
            }
        }
        return new ReleaseNotes();
    }
}