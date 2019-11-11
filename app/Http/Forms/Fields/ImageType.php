<?php
namespace App\Http\Forms\Fields;

use \Kris\LaravelFormBuilder\Fields\FormField;

/**
 * @author Achmad Munandar
 */
class ImageType extends FormField
{
    protected function getTemplate()
    {
        return 'fields.image';
    }
    public function render(array $options = [], $showLabel = true, $showField = true, $showError = true)
    {
        return parent::render($options, $showLabel, $showField, $showError);
    }
}