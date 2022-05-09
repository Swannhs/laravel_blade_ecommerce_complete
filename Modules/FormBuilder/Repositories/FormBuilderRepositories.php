<?php


namespace Modules\FormBuilder\Repositories;


use Modules\FormBuilder\Entities\CustomForm;

class FormBuilderRepositories
{
    public function all()
    {
        return CustomForm::all();
    }

    public function find($id)
    {
        return CustomForm::findOrFail($id);
    }


}
