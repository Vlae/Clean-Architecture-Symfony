<?php

namespace App\Requests;

use Symfony\Component\Validator\Constraints\NotBlank;

class PostHashRequest extends AbstractRequest
{
    #[NotBlank]
    protected $data;

    public function getData()
    {
        return $this->data;
    }
}