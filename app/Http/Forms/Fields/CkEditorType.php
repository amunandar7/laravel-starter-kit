<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Forms\Fields;
use \Kris\LaravelFormBuilder\Fields\FormField;

/**
 * Description of CkEditorType
 *
 * @author achmadmunandar
 */
class CkEditorType extends FormField
{
    protected function getTemplate()
    {
        return 'fields.textarea';
    }
    public function render(array $options = [], $showLabel = true, $showField = true, $showError = true)
    {
        return parent::render($options, $showLabel, $showField, $showError);
    }
}