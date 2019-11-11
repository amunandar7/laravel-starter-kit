<?php
namespace App\Http\Forms\Fields;

/**
 * @author Achmad Munandar
 */
class Select2Type extends \Kris\LaravelFormBuilder\Fields\SelectType
{
    protected function getTemplate()
    {
        return 'fields.select';
    }
    public function render(array $options = [], $showLabel = true, $showField = true, $showError = true)
    {
        if(!array_key_exists("choices", $options)) {
            $options["choices"] = [];
        }
        return parent::render($options, $showLabel, $showField, $showError);
    }
}