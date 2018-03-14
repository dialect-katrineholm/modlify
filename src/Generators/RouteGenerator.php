<?php

namespace Dialect\Modlify\Generators;
use File;
class RouteGenerator extends Generator {

	function __construct($model,$modelName,$databaseName, $tableName, $columns, $variableName, $collectionName, $resourceName) {
		parent::__construct($model, $modelName,$databaseName, $tableName, $columns,$variableName, $collectionName, $resourceName);
	}

	public function generate($force = false){
		$route = 'Route::resource("'.$this->resourceName.'", "'.$this->modelName.'Controller")';
		$routePath = base_path("routes");

		$routeFilePath = $routePath."/web.php";

		if(!is_dir($routePath))
		{
			File::makeDirectory($routePath);
		}

		if(!File::exists($routeFilePath)){
			File::put($routeFilePath, '');
		}

		if(strpos(File::get($routeFilePath), $route) !== false){
			return false;
		}

		File::append($routeFilePath, $route.";\n");
		return true;
	}

}