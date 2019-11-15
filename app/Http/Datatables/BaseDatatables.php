<?php

namespace App\Http\Datatables;

use Illuminate\Support\Facades\DB;

/**
 * @author achmadmunandar
 */
class BaseDatatables
{
    protected $title;
    protected $subtitle;
    protected $tableName;
    protected $tableColumns = []; // snake case
    protected $attrTableColumns = []; // atribute of td column
    protected $tableJoins = []; // every array contain parameters join function in laravel
    protected $tableWhere = []; // every array contain parameters [column, operator, value]
    protected $tableDbColumns = []; // column name with table prefix
    protected $hiddenColumns = []; // hidden columnns index
    protected $filters = []; // filter dropdown [placeholder, db column, operator, data]
    protected $defaultOrder = 'asc'; // datatables default order: asc/desc
    protected $defaultOrderBy = 0; // datatables default order by column index
    protected $dtRawColumns = ['action'];
    protected $softDeletes = true;
    protected $enableAdd = true;
    protected $enableDelete = true;
    protected $imageColumnTypes = ['picture', 'image', 'logo', 'photo'];

    public function getTitle()
    {
        return $this->title;
    }

    public function getSubTitle()
    {
        return $this->subtitle;
    }

    public function getTableName()
    {
        return $this->tableName;
    }

    public function getTableColumns()
    {
        return $this->tableColumns;
    }

    public function getAttrTableColumns()
    {
        return $this->attrTableColumns;
    }

    public function getTableJoins()
    {
        return $this->tableJoins;
    }

    public function getTableWhere()
    {
        return $this->tableWhere;
    }

    public function getTableDbColumns()
    {
        return $this->tableDbColumns;
    }

    public function getHiddenColumns()
    {
        return $this->hiddenColumns;
    }

    public function getDefaultOrder()
    {
        return $this->defaultOrder;
    }

    public function getDefaultOrderBy()
    {
        return $this->defaultOrderBy;
    }

    public function getDtRawColumns()
    {
        return $this->dtRawColumns;
    }

    public function getSoftDeletes()
    {
        return $this->softDeletes;
    }

    public function getFilters()
    {
        return $this->filters;
    }

    public function getEnableAdd()
    {
        return $this->enableAdd;
    }

    public function getEnableDelete()
    {
        return $this->enableDelete;
    }

    public function getImageColumnTypes()
    {
        return $this->imageColumnTypes;
    }


    public function modifyDatatables($datatables, $request)
    {
        $datatables->addColumn('action',
            function ($data) use ($request) {
                return ''
                    . '<a href="' . url(str_replace("list", "form",
                        str_replace("datatables", "edit/" . $data->id,
                            $request->path()))) . '" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i> Edit</a>'
                    . '&nbsp;'
                    . '<a data-id="' . $data->id . '" href="javascript:;" data-click="delete" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> Delete</a>';
            });
        foreach ($this->imageColumnTypes AS $col) {
            if (in_array($col, $this->tableColumns)) {
                $datatables->editColumn($col,
                    function ($data) use ($request, $col) {
                        $src = $data->$col;
                        if(substr( $src, 0, 4 ) != "http")
                            $src = url('image/'.$src);
                        return $this->clickableImg($src, '100px');
                    });
                $this->dtRawColumns[] = $col;
            }
        }
        $datatables->rawColumns($this->dtRawColumns);
        return $datatables;
    }

    public function modalData($id)
    {
        $datas = DB::table($this->tableName)
            ->select($this->tableColumns)
            ->first();
        return $datas;
    }

    public function clickableImg($src, $maxWidth)
    {
        return '<img onClick="showImage(\'' . $src . '\')" src="' . $src . '" style="max-width:' . $maxWidth . ';cursor:pointer" />';
    }

    protected function modalAjaxLink($url, $text)
    {
        return '<a href="javascript:;" onClick="modalAjax(\'' . $url . '\')" class="text-primary">' . $text . '</a>';
    }
}