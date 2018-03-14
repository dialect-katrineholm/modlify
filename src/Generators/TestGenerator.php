<?php

namespace Dialect\Modlify\Generators;

class TestGenerator extends Generator {

	function __construct($model,$modelName,$databaseName, $tableName, $columns, $variableName, $collectionName, $resourceName) {
		parent::__construct($model, $modelName,$databaseName, $tableName, $columns,$variableName, $collectionName, $resourceName);
	}

	public function generate($force = false){
		$path = base_path("tests/Feature");

		$viewData = [
			'model' => $this->model,
			'modelName' => $this->modelName,
			'databaseName' => $this->databaseName,
			'tableName' => $this->tableName,
			'variableName' => $this->variableName,
			'collectionName' => $this->collectionName,
			'resourceName' => $this->resourceName,
			'columns' => $this->columns,
			'checkColumn' => $this->getFirstNonKeyColumnName(),
			'hasPassword' => $this->hasPassword(),
			];

		$factory = "<?php\n".view('modlify::tests', $viewData);
		$this->save($path, $this->modelName."Test.php", $factory, $force);

		return true;
	}

	public function getFirstNonKeyColumnName(){
		foreach($this->columns as $column){
			if(!$column->key){
				return $column->name;
			}
		}

		return $this->columns[0]->name;
	}

	public function hasPassword(){
		foreach($this->columns as $column){
			if(strpos($column->name,'password') !== false){
				return true;
			}
		}

		return false;
	}


}