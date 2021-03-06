<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;
use App\Helpers\StringHelper;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use Form;

/**
 * @author achmadmunandar
 */
class CrudController extends Controller
{

    use FormBuilderTrait;
    private $title;
    private $subtitle;
    private $className;
    private $class;
    private $entityName;

    public function __construct($entityName)
    {
        $this->entityName = $entityName;
        $className = "\\App\\Http\\Forms\\" . str_replace("-", "", ucwords($entityName, '-')) . "Form";
        $this->className = $className;
        if (!class_exists($this->className)) {
            abort(404);
        }
        $this->class = new $className();
        $this->title = $this->class->getTitle();
        $this->subtitle = $this->class->getSubtitle();
    }

    public function addForm($request, $formBuilder)
    {
        $entityName = $this->entityName;
        $title = $this->title != null ? $this->title : StringHelper::humanize(str_replace("-", " ", $entityName));
        $subtitle = $this->subtitle != null ? $this->subtitle : "Create";
        $form = $this->buildAddForm($request, $formBuilder);
        return view('dashboard.form', compact("title","subtitle", "form", "entityName"));
    }

    protected function buildAddForm(Request $request, FormBuilder $formBuilder)
    {
        $form = $formBuilder->create($this->className,
            [
                'method' => 'POST',
                'url' => $request->path(),
                'files' => true,
            ]);
        return $form;
    }

    public function editForm($request, $formBuilder, $id)
    {
        $entityName = $this->entityName;
        $title = $this->title != null ? $this->title : StringHelper::humanize(str_replace("-", " ", $entityName));
        $subtitle = $this->subtitle != null ? $this->subtitle : "Edit";
        $form = $this->buildEditForm($request, $formBuilder, $id);
        return view('dashboard.form', compact("title", "subtitle", "form", "entityName"));
    }

    protected function buildEditForm(Request $request, FormBuilder $formBuilder,
                                     $id)
    {
        $form = $formBuilder->create($this->className,
            [
            ]);
        $table = $form->entityTableName($this->entityName);
        $model = $this->className::get_data($table, $id);
        $form = $formBuilder->create($this->className,
            [
                'method' => 'POST',
                'url' => $request->path(),
                'files' => true,
                'model' => $model
            ]);
        $form = $form->modifyEditForm($form);
        return $form;
    }

    public function submitAdd(Request $request)
    {
        $form = $this->form($this->className);

        $request->validate($form->getRules());

        $form->insertData($this->entityName, $form->getFields(), $request);
        $request->session()->flash('gritter', 'Create ' . StringHelper::humanize(str_replace("-", " ", $this->entityName)) . ' was Successful!');
        return redirect(str_replace("form", 'list', str_replace("/create", "", $request->path())));
    }

    public function submitEdit(Request $request, $id)
    {
        $form = $this->form($this->className);
        $form = $form->modifyEditForm($form);

        $request->validate($form->getRules());

        $form->updateData($this->entityName, $form->getFields(), $request, $id);
        $request->session()->flash('gritter', 'Edit ' . StringHelper::humanize(str_replace("-", " ", $this->entityName)) . ' was Successful!');
        return redirect($request->path());
    }

    public function submitDelete(Request $request)
    {
        $id = $request->id;
        $form = $this->form($this->className);
        $form->deleteData($this->entityName, $id);
        $request->session()->flash('gritter', 'Delete ' . StringHelper::humanize(str_replace("-", " ", $this->entityName)) . ' was Successful!');
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }
}