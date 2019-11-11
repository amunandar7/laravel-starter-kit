<?php
namespace App\Http\Forms\Fields;

use \Kris\LaravelFormBuilder\Fields\FormField;

/**
 * @author Achmad Munandar
 */
class NumberType extends FormField
{
    protected function getTemplate()
    {
        return 'fields.text';
    }
    public function render(array $options = [], $showLabel = true, $showField = true, $showError = true)
    {
        $options['type'] = 'number';
        return parent::render($options, $showLabel, $showField, $showError);
    }
}