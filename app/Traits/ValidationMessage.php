<?php
namespace App\Traits;

trait ValidationMessage{

    public function messages()
    {
        return validationMessage($this->rules());
    }
}
