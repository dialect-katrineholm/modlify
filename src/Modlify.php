<?php

namespace Dialect\Modlify;


use Dialect\Modlify\Generators\ControllerGenerator;
use Dialect\Modlify\Generators\FactoryGenerator;
use Dialect\Modlify\Generators\PolicyGenerator;
use Dialect\Modlify\Generators\RouteGenerator;
use Dialect\Modlify\Generators\TestGenerator;
use Dialect\Modlify\Generators\ViewGenerator;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class Modlify {

	public $model;
	public $databaseName;
	public $tableName;
	public $columns;
	public $variableName;
	public $collectionName;
	public $modelName;
	public $resourceName;
	protected $skipColumns = [
		'id',
		'created_at',
		'updated_at',
		'deleted_at',
		'remember_token'
	];
	function __construct($model) {

		$this->model = $model;
		$this->modelName = class_basename($model);
		$this->databaseName = $this->getDatabaseName();
		$this->tableName = $model->getTable();
		$this->variableName = '$'.lcfirst($this->modelName);
		$this->collectionName = '$'.str_replace('_', null, lcfirst(ucwords($this->tableName, '_')));
		$this->resourceName = str_replace('_', '-', $this->tableName);
		$this->columns = $this->getColumns();



	}


	protected function getColumns(){

		$columns =  DB::table('information_schema.columns')
		        ->where('table_schema', $this->databaseName)
		        ->where('table_name', $this->tableName)
		        ->get();

		return $this->parseColumns($columns);
	}

	protected function parseColumns($columns){
		$parsedColumns = collect();
		foreach($columns as $column){
			if(in_array($column->COLUMN_NAME, $this->skipColumns)){
				continue;
			}
			$data = new \stdClass();
			$data->name = $column->COLUMN_NAME;
			$data->nullable = $column->IS_NULLABLE == "YES";
			$data->type = $column->DATA_TYPE;
			$data->key = $column->COLUMN_KEY;
			$parsedColumns->push($data);
		}

		return $parsedColumns;
	}

	protected function getDatabaseName(){
		$connection = $this->model->getConnectionName() ? $this->model->getConnectionName() : config('database.default');
		$database = Config::get('database.connections.'.$connection.'.database');

		return $database;
	}

	public function generateController($force = false){
		return $this->generate(ControllerGenerator::class, $force);
	}

	public function generateViews($force = false){
		return $this->generate(ViewGenerator::class, $force);
	}

	public function generateFactory($force = false){
		return $this->generate(FactoryGenerator::class, $force);
	}

	public function generateTests($force = false){
		return $this->generate(TestGenerator::class, $force);
	}

	public function generatePolicy($force = false){
		return $this->generate(PolicyGenerator::class, $force);
	}

	public function generateRoute($force = false){
		return $this->generate(RouteGenerator::class, $force);
	}


	protected function generate($generatorClass, $force){
		$generator = new $generatorClass(
			$this->model,
			$this->modelName,
			$this->databaseName,
			$this->tableName,
			$this->columns,
			$this->variableName,
			$this->collectionName,
			$this->resourceName
			);

		return $generator->generate($force);
	}

	public static function getModels(){
		$dir = app_path();
		$files = scandir($dir);

		$models = array();
		$namespace = 'App\\';
		foreach($files as $file) {
			//skip current and parent folder entries and non-php files
			if ($file == '.' || $file == '..' || !preg_match('/\.php/', $file)) continue;
			$model = $namespace . preg_replace('/\.php$/', '', $file);
			$classCheck = new \ReflectionClass($model);
			if($classCheck->getConstructor()->class == "Illuminate\Database\Eloquent\Model"){
				$models[] = $model;
			}
		}

		return $models;
	}




}
