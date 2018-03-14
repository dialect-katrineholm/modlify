<?php

namespace Dialect\Modlify\Generators;

class ControllerGenerator extends Generator {

	function __construct($model,$modelName,$databaseName, $tableName, $columns, $variableName, $collectionName, $resourceName) {
		parent::__construct($model, $modelName,$databaseName, $tableName, $columns,$variableName, $collectionName, $resourceName);
	}

	public function generate($force = false){
		$path = app_path('Http/Controllers');
		$filename = $this->modelName."Controller.php";
		$data = "<?php\n".view('modlify::controller', [
				'model' => $this->model,
				'modelName' => $this->modelName,
				'databaseName' => $this->databaseName,
				'tableName' => $this->tableName,
				'variableName' => $this->variableName,
				'collectionName' => $this->collectionName,
				'resourceName' => $this->resourceName,
				'columns' => $this->columns,
				'validations' => $this->getValidation(),
				'hasPassword' => $this->hasPassword(),
			]);

		return $this->save($path, $filename, $data, $force);
	}

	protected function getValidation(){
		$validations = collect();

		foreach($this->columns as $column){
			$requirements = $this->getValidationRequirements($column);

			if($requirements){
				$validations->put($column->name, $requirements);
			}

		}
		return $validations;
	}

	protected function getValidationRequirements($column){
		$requirements = ['store' => '', 'update' => ''];
		if(!$column->nullable){
			$requirements['store'] .= "required";
			$requirements['update'] .= $column->name != "password" ? "required" : "";
		}

		$validationFromType = $this->getValidationFromType($column->type);
		if($validationFromType['store']){
			$requirements['store'] .= $requirements['store'] ? "|".$validationFromType['store'] : $validationFromType['store'];
		}
		if($validationFromType['update']){
			$requirements['update'] .= $requirements['update'] ? "|".$validationFromType['update'] : $validationFromType['update'];
		}

		$validationFromName = $this->getValidationFromName($column->name);
		if($validationFromName['store']){
			$requirements['store'] .= $requirements['store'] ? "|".$validationFromName['store'] : $validationFromName['store'];
		}
		if($validationFromName['update']){
			$requirements['update'] .= $requirements['update'] ? "|".$validationFromName['update'] : $validationFromName['update'];
		}

		$validationFroKey = $this->getValidationFromKey($column->key);
		if($validationFroKey['store']){
			$requirements['store'] .= $requirements['store'] ? "|".$validationFroKey['store'] : $validationFroKey['store'];
		}
		if($validationFroKey['update']){
			$requirements['update'] .= $requirements['update'] ? "|".$validationFroKey['update'] : $validationFroKey['update'];
		}


		return $requirements;
	}

	private function getValidationFromType($columnType){

		switch($columnType){
			case 'int': $requirement = 'numeric'; break;
			case 'float': $requirement = 'numeric'; break;
			case 'double': $requirement = 'numeric'; break;
			case 'tinyint': $requirement = 'boolean'; break;
			default: $requirement = '';
		}

		$data['update'] = $requirement;
		$data['store'] = $requirement;

		return $data;

	}

	private function getValidationFromName($columnName){
		$data = [];
		$requirement = '';
		if(strpos($columnName, 'email') !== false){
			$requirement = 'email';
		}
		elseif(strpos($columnName, 'date') !== false){
			$requirement = 'date';
		}
		elseif(strpos($columnName, 'url') !== false){
			$requirement = 'url';
		}
		elseif(strpos($columnName, 'password') !== false){
			$requirement = 'confirmed';
		}

		$data['update'] = $requirement;
		$data['store'] = $requirement;

		return $data;
	}

	private function getValidationFromKey($columnKey){
		$requirements = ['store' => '', 'update' => ''];

		if($columnKey == "UNI"){
			$requirements['store'] .= 'unique:'.$this->tableName;
			$requirements['update'] .= 'unique:'.$this->tableName.',id,'.$this->variableName.'->id';

		}

		return $requirements;
	}

	protected function hasPassword(){
		foreach($this->columns as $column){
			if($column->name == 'password') return true;
		}

		return false;
	}

}