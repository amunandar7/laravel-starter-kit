<?php


namespace App\Http\Datatables;


class ExampleCategoryDatatables extends BaseDatatables
{
    protected $tableName    = 'example_categories';
    protected $tableColumns = ['name', 'description'];

}