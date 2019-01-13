<?php


namespace AppBundle\Traits;


use AppBundle\Validators\AccumulatingValidator;

trait EntityUpdating
{
    /** @var AccumulatingValidator $entityValidator */
    protected $entityValidator;

    /**
     * @param $entity
     * @param $data
     * @return mixed
     */
    protected function updateEntityData($entity, $data)
    {
        foreach($data as $field => $value) {
            if(!is_array($value)) {
                $this->setFieldValue($entity, $field, $value);
            }
        }
        $this->entityValidator->validate($entity);
        return $entity;
    }

    /**
     * @param $entity
     * @param $field
     * @param $value
     * @return void
     */
    protected function setFieldValue($entity, $field, $value)
    {
        if (method_exists($entity, 'set'.ucwords($field))) {
            $entity->{'set'.ucwords($field)}($value);
        }
    }
}
