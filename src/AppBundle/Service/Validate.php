<?php

namespace AppBundle\Service;

use Symfony\Component\Validator\Validator\ValidatorInterface;

class Validate
{
    private $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function validateRequest($data)
    {
        $errors = $this->validator->validate($data);
        $reponse = [];
        $errorResponse = [];

        if (count($errors) > 0)
        {
            foreach ($errors as $error) {
                $errorResponse = [
                    'field' => $error->getPropertyPath(),
                    'message' => $error->getMessage()
                ];
            }
            return $reponse = [
                'code' => 1,
                'message' => 'validation error',
                'errors' => $errorResponse,
                'result' => null
            ];
        } else {
            return $reponse = [];
        }
    }
}