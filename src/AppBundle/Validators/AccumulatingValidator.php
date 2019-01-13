<?php


namespace AppBundle\Validators;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AccumulatingValidator implements EntityValidator
{
    /** @var ValidatorInterface */
    private $validator;

    private $errors;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function validate($entity)
    {
        $validationErrors = $this->validator->validate($entity);
        foreach($validationErrors->getIterator() as $error) {
            $classEntity = new \ReflectionClass(get_class($error->getRoot()));
            $this->errors[$classEntity->getShortName()][$error->getPropertyPath()] = $error->getMessage();
        }
    }

    public function throwIfInvalid()
    {
        if (!$this->isValid()) {
            throw new HttpException(Response::HTTP_BAD_REQUEST, sprintf(json_encode($this->getErrors())));
        }
    }

    /**
     * @return string
     */
    private function getErrors()
    {
        return $this->errors;
    }

    private function isValid()
    {
        return (empty($this->errors));
    }
}
