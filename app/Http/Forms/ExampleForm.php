<?php


namespace App\Http\Forms;


use App\Enums\ExampleStatus;
use App\Http\Forms\Fields\Types;
use App\Http\Select2\Select2Config;

class ExampleForm extends BaseForm
{

    public function buildForm()
    {
        $this
            ->add('name', Types::TEXT,
                [
                    'label' => "Name",
                    'rules' => "required",
                ])
            ->add('example_category_id', Types::SELECT2,
                [
                    'label' => "Category",
                    'ajax' => Select2Config::EXAMPLE_CATEGORIES,
                ])
            ->add('email', Types::EMAIL,
                [
                    'label' => "Email",
                ])
            ->add('image', Types::IMAGE,
                [
                    'label' => "Image",
                    'help_block' => ["text" => "Recommended Size: 300x300 px"],
                    'extentions' => ["jpg", "jpeg", "png", "gif"],
                    'path' => "examples",
                    'rules' => "required",
                ])
            ->add('password', Types::PASSWORD,
                [
                    'label' => "Password",
                    'rules' => "required",
                ])
            ->add('password_confirmation', Types::PASSWORD,
                [
                    'label' => "Password Confirmation",
                    'rules' => "required|same:password",
                ])
            ->add('example_date', Types::DATEPICKER,
                [
                    'label' => "Example Date",
                    'rules' => "required",
                    'viewMode' => "years",
                    'maxDate' => date('Y-m-d'),
                ])
            ->add('description', Types::CKEDITOR,
                [
                    'label' => "Description",
                    'rules' => "required",
                ])
            ->add('status', Types::SELECT,
                [
                    'label' => "Status",
                    'rules' => "required",
                    'empty_value' => "=== Choose Status ===",
                    'choices' => ExampleStatus::get_labels()
                ])
        ;
    }
}