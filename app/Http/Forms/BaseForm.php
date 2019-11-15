<?php

namespace App\Http\Forms;

use Illuminate\Support\Str;
use Kris\LaravelFormBuilder\Form;
use Illuminate\Support\Facades\DB;

class BaseForm extends Form
{
    protected $title;
    protected $subtitle;
    protected $imageTypes = ['image', 'logo', 'avatar', 'icon', 'picture'];

    public function insertData($entityName, $fields, $request)
    {
        $table        = $this->entityTableName($entityName);
        $inputs       = $this->getInputs($fields, $request, null);
        if (array_key_exists("password", $inputs)) {
            $inputs["password"] = bcrypt($inputs["password"]);
        }
        $inputs['created_at'] = date("Y-m-d H:i:s");
        return DB::table($table)->insert($inputs);
    }

    public function updateData($entityName, $fields, $request, $id)
    {

        $table  = $this->entityTableName($entityName);
        $inputs = $this->getInputs($fields, $request);
        if (array_key_exists("password", $inputs)) {
            $inputs["password"] = bcrypt($inputs["password"]);
        }
        $inputs['updated_at'] = date("Y-m-d H:i:s");
        return DB::table($table)->where('id', $id)->update($inputs);
    }

    public static function get_data($table, $id)
    {
        return DB::table($table)->where('id', $id)->where('deleted_at',null)->first();
    }

    public function modifyEditForm($form)
    {
        foreach ($form->getFields() AS $name => $field) {
            if (in_array($field->getType(), $this->imageTypes)) {
                $form->modify($name, 'image',
                    [
                    'rules' => []
                ]);
            } else if ($name === "password") {
                $form->modify('password', 'password',
                    [
                    'attr' => ['placeholder' => "Kosongkan jika tidak ingin mengganti password"],
                    'rules' => ''
                ]);
            } else if ($name === "password_confirmation") {
                $form->modify('password_confirmation', 'password',
                    [
                    'attr' => ['placeholder' => "Kosongkan jika tidak ingin mengganti password"],
                    'rules' => 'same:password'
                ]);
            }
        }
        return $form;
    }

    protected function getInputs($fields, $request)
    {
        $inputs = [];
        foreach ($fields AS $name => $field) {
            if ($field->getType() == 'image') {
                if ($request->file($name)) {
                    $path     = $field->getOptions()['path'];
                    $ext      = $request->$name->extension();
                    $filename = Str::random(6).time();
                    $destinationPath = storage_path().'/images/'.Str::plural($path);
                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath);
                    }
                    $request->file($name)->move($destinationPath,
                        $filename.'.'.$ext);
                    $inputs[$name] = $filename.'.'.$ext;
                }
            } else {
                $inputs[$name] = $request->$name;
            }
        }
        return $inputs;
    }

    public function deleteData($entityName, $id)
    {
        $table = $this->entityTableName($entityName);
        DB::table($table)->where('id', $id)->update(['deleted_at' => date('Y-m-d H:i:s')]);
    }

    public function entityTableName($entityName)
    {
        return Str::plural(str_replace("-", "_", $entityName));
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getSubtitle()
    {
        return $this->subtitle;
    }
}