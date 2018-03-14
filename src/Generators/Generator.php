<?php
namespace Dialect\Modlify\Generators;
use File;
abstract class Generator{
	protected $model, $modelName, $databaseName, $tableName, $columns,$variableName, $collectionName, $resourceName;
	function __construct($model, $modelName,$databaseName, $tableName, $columns,$variableName, $collectionName, $resourceName) {
		$this->model = $model;
		$this->modelName = $modelName;
		$this->databaseName = $databaseName;
		$this->tableName = $tableName;
		$this->columns = $columns;
		$this->variableName = $variableName;
		$this->collectionName = $collectionName;
		$this->resourceName = $resourceName;
	}

	protected function save($path, $filename, $data, $force = false){
		$fullPath = $path.'/'.$filename;
		if(!is_dir($path))
		{
			File::makeDirectory($path);
		}
		if(File::exists($fullPath) && !$force){
			return false;
		}


		return File::put($fullPath, $data);
	}

	public abstract function generate($force = false);

}