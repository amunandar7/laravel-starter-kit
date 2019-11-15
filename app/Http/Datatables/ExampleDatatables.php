<?php


namespace App\Http\Datatables;


use App\Enums\ExampleStatus;
use App\Http\Select2\Select2Config;
use Illuminate\Support\Facades\DB;


class ExampleDatatables extends BaseDatatables
{
    protected $tableName = 'examples';
    protected $tableColumns = ['example_category_id', 'name', 'image', 'category', 'email', 'example_date', 'status'];
    protected $tableDbColumns = ['example_category_id', 'examples.name', 'image', 'example_categories.name', 'email', 'example_date', 'status'];
    protected $hiddenColumns = [0];
    protected $tableJoins = [
        ['example_categories', 'examples.example_category_id', '=', 'example_categories.id'],
    ];


    public function getFilters()
    {
        return [
            ['All Status', 'status', '=', ExampleStatus::get_labels()],
            ['All Categories', 'example_categories.id', '=', Select2Config::EXAMPLE_CATEGORIES]
        ];
    }


    public function modifyDatatables($datatables, $request)
    {
        $datatables = parent::modifyDatatables($datatables, $request);
        $datatables->editColumn('name',
            function ($data) use ($request) {
                return $this->modalAjaxLink(url('modal/example/' . $data->id),
                    $data->name);
            });
        $datatables->editColumn('category',
            function ($data) use ($request) {
                return $this->modalAjaxLink(url('modal/example-category/' . $data->example_category_id),
                    $data->category);
            });
        $datatables->editColumn('status',
            function ($data) use ($request) {
                return ExampleStatus::get_bootstrap_labels($data->status);
            });
        $datatables->rawColumns(['name', 'image', 'category', 'status', 'action']);
        return $datatables;
    }

    public function modalData($id)
    {
        $datas = DB::table('examples')
            ->select(['examples.name', 'image', 'example_categories.name AS category', 'email', 'example_date', 'status'])
            ->where('examples.id', $id)
            ->leftJoin('example_categories', 'examples.example_category_id', '=',
                'example_categories.id')
            ->first();
        if ($datas->status != null) {
            $datas->status = ExampleStatus::get_bootstrap_labels($datas->status);
        }
//        dd($datas);
        return $datas;
    }
}