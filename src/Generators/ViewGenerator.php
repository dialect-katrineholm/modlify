<?php

namespace Dialect\Modlify\Generators;

class ViewGenerator extends Generator {

	function __construct($model,$modelName,$databaseName, $tableName, $columns, $variableName, $collectionName, $resourceName) {
		parent::__construct($model, $modelName,$databaseName, $tableName, $columns,$variableName, $collectionName, $resourceName);
	}

	public function generate($force = false){
		$path = resource_path('views/'.$this->resourceName);

		$viewData = [
			'model' => $this->model,
			'modelName' => $this->modelName,
			'databaseName' => $this->databaseName,
			'tableName' => $this->tableName,
			'variableName' => $this->variableName,
			'collectionName' => $this->collectionName,
			'resourceName' => $this->resourceName,
			'columns' => $this->columns,
			];

		$index = view('modlify::index', $viewData);
		$this->save($path, "index.blade.php", $index, $force);

		$create = view('modlify::create', $viewData);
		$this->save($path, "create.blade.php", $create, $force);

		$show = view('modlify::show', $viewData);
		$this->save($path, "show.blade.php", $show, $force);

		$edit = view('modlify::edit', $viewData);
		$this->save($path, "edit.blade.php", $edit, $force);

		$form = view('modlify::form', ['inputs' => $this-> getColumnFormInputs()] + $viewData);
		$this->save($path, "form.blade.php", $form, $force);



		return true;
	}

	protected function getColumnFormInputs(){
		$inputs = [];

		foreach($this->columns as $column){
			$inputs[$column->name] = [
				'type' => $this->getcolumnInputType($column),
				'required' => $column->nullable,
			];
		}

		return $inputs;
	}



	protected function getcolumnInputType($column){
		if($column->type == "int" || $column->type == "float" || $column->type == "double"){
			return "number";
		}

		if($column->type == "tinyint"){
			return "checkbox";
		}

		if($column->type == "text"){
			return "textarea";
		}

		if(strpos($column->name, 'email') !== false){
			return "email";
		}

		return "text";
	}

}