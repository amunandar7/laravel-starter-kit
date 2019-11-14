<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\StringHelper;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class DatatablesController extends Controller
{
    private $title;
    private $subtitle;
    private $class;
    private $entityName;
    private $tableName;
    private $tableColumns;
    private $attrTableColumns;
    private $tableJoins;
    private $tableWhere;
    private $tableDbColumns;
    private $hiddenColumns;
    private $defaultOrder;
    private $defaultOrderBy;
    private $dtRawColumns;
    private $softDeletes;
    private $filters;
    private $enableAdd;
    private $enableDelete;

    public function __construct($entityName)
    {
        $this->entityName = $entityName;
        $className = "\\App\\Http\\Datatables\\" . str_replace("-", "",
                ucwords($entityName, '-')) . "Datatables";
        if (!class_exists($className)) {
            abort(404);
        }
        $this->class = new $className();
        $this->title = $this->class->getTitle();
        $this->tableName = $this->class->getTableName();
        $this->tableColumns = $this->class->getTableColumns();
        $this->attrTableColumns = $this->class->getAttrTableColumns();
        $this->tableJoins = $this->class->getTableJoins();
        $this->tableWhere = $this->class->getTableWhere();
        $this->tableDbColumns = $this->class->getTableDbColumns();
        $this->hiddenColumns = $this->class->getHiddenColumns();
        $this->defaultOrder = $this->class->getDefaultOrder();
        $this->defaultOrderBy = $this->class->getDefaultOrderBy();
        $this->softDeletes = $this->class->getSoftDeletes();
        $this->filters = $this->class->getFilters();
        $this->enableAdd = $this->class->getEnableAdd();
        $this->enableDelete = $this->class->getEnableDelete();
    }

    public function index()
    {
        $title = $this->title != null ? $this->title : StringHelper::humanize(str_replace("-", " ", str_plural($this->entityName)));
        $subtitle = $this->subtitle != null ? $this->subtitle : "List of " . $title;
        $columns = $this->tableColumns;
        $hidden_columns = $this->hiddenColumns;
        $attr_columns = $this->attrTableColumns;
        $default_order = $this->defaultOrder;
        $default_order_by = $this->defaultOrderBy;
        $filters = $this->filters;
        $enable_add = $this->enableAdd;
        $table_db_columns = (sizeof($this->tableDbColumns) > 0) ? $this->tableDbColumns : $columns;

        return view('dashboard.datatables', compact("title", "subtitle", 'columns', 'hidden_columns', 'attr_columns', 'default_order', 'default_order_by', 'table_db_columns', 'filters', 'enable_add'));
    }

    public function ajax(Request $request)
    {
        $table = $this->tableName;
        $db_columns = [];
        if (sizeof($this->tableDbColumns) > 0) {
            foreach ($this->tableDbColumns AS $idx => $col) {
                $db_columns[$idx] = DB::raw($col . " AS `" . $this->tableColumns[$idx] . "`");
            }
        } else {
            $db_columns = $this->tableColumns;
        }
        $db_columns[] = $table . '.id';
        $datas = DB::table($table)->select($db_columns);
        if ($this->softDeletes) {
            $datas->where($table . '.deleted_at', null);
        }
        if (sizeof($this->tableJoins) > 0) {
            foreach ($this->tableJoins AS $join) {
                $datas->leftJoin($join[0], $join[1], $join[2], $join[3]);
            }
        }
        if (sizeof($this->tableWhere) > 0) {
            foreach ($this->tableWhere AS $where) {
                $datas->where($where[0], $where[1], $where[2]);
            }
        }

        if ($request->dropdown_filter && is_array($request->dropdown_filter)) {
            foreach ($this->filters AS $idx => $data) {
                if ($request->dropdown_filter[$idx] != null) {
                    $datas->where(DB::raw($data[1]), $data[2], $request->dropdown_filter[$idx]);
                }
            }
        }

        $datatables = DataTables::of($datas);
        $datatables = $this->class->modifyDatatables($datatables, $request);
        return $datatables->make(true);
    }

    public function modal($id)
    {
        if (method_exists($this->class, "modal")) {
            return $this->class->modalData($id);
        }
        $excepts = ['deleted_at'];
        if (method_exists($this->class, 'modalData')) {
            $datas = $this->class->modalData($id);
        } else {
            $datas = DB::table($this->tableName)->where($this->tableName . '.deleted_at', null)->where('id', $id)->first();
        }
        $body = '<table class="table table-striped table-responsive">';
        foreach ($datas AS $name => $val) {
            if (!in_array($name, $excepts)) {
                if ($name != "longitude") {
                    $body .= '<tr>';
                    if ($name == "latitude") {
                        $body .= '<td style="vertical-align: top;">Location</td>';
                    } else {
                        $body .= '<td style="vertical-align: top;">' . StringHelper::humanize($name) . "</td>";
                    }
                    $body .= '<td style="vertical-align: top;"> : </td>';
                    if (in_array($name, $this->class->getImageColumnTypes())) {
                        if ($val != null) {
                            $body .= '<td style="vertical-align: top;"><img src="' . url($val) . '" class="img-fluid" /></td>';
                        } else {
                            $body .= '<td style="vertical-align: top;">-</td>';
                        }
                    } else if (in_array($name, ['sex', 'gender'])) {
                        if ($val == 'M') {
                            $body .= '<td style="vertical-align: top;">Pria</td>';
                        } else if ($val == 'F') {
                            $body .= '<td style="vertical-align: top;">Wanita</td>';
                        } else {
                            $body .= '<td style="vertical-align: top;">' . $val . '</td>';
                        }
                    } else if (in_array($name, ['created_at', 'updated_at'])) {
                        if ($val != null) {
                            $body .= '<td style="vertical-align: top;">' . date('d M Y H:i',
                                    strtotime($val)) . '</td>';
                        } else {
                            $body .= '<td style="vertical-align: top;">-</td>';
                        }
                    } else if ($name == "latitude" && $datas->latitude != null && $datas->longitude
                        != null) {
                        $body .= '<td style="vertical-align: top;">'
                            . '<iframe
                            width="100%"
                            frameborder="0"
                            scrolling="no"
                            marginheight="0"
                            marginwidth="0"
                            src="https://maps.google.com/maps?q=' . $datas->latitude . ',' . $datas->longitude . '&hl=es;z=14&amp;output=embed">
                           </iframe>'
                            . '</td>';
                    } else {
                        $body .= '<td style="vertical-align: top;">' . ($val != null ? $val : '-') . "</td>";
                    }
                    $body .= '</tr>';
                }
            }
        }
        $body .= '</table>';
        return [
            'title' => StringHelper::humanize(str_replace("-", " ", $this->entityName)),
            'body' => $body
        ];
    }
}