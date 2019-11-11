<?php
namespace App\Http\Forms\Field;

use \Kris\LaravelFormBuilder\Fields\FormField;

/**
 * @author Achmad Munandar
 */
class CheckboxType extends FormField
{
    protected function getTemplate()
    {
        return 'fields.checkbox';
    }
    public function render(array $options = [], $showLabel = true, $showField = true, $showError = true)
    {
        return parent::render($options, $showLabel, $showField, $showError);
    }
}