<?php


namespace App\Http\Forms;


use App\Http\Forms\Fields\Types;

class ExampleCategoryForm extends BaseForm
{

    public function buildForm()
    {
        $this
            ->add('name', Types::TEXT,
                [
                    'label' => "Name",
                    'rules' => "required",
                ])
            ->add('description', Types::TEXTAREA,
                [
                    'label' => "Description",
                    'rules' => "required",
                ])
        ;
    }
}