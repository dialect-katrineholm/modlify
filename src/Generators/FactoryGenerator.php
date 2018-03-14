<?php

namespace Dialect\Modlify\Generators;

class FactoryGenerator extends Generator {

	function __construct($model,$modelName,$databaseName, $tableName, $columns, $variableName, $collectionName, $resourceName) {
		parent::__construct($model, $modelName,$databaseName, $tableName, $columns,$variableName, $collectionName, $resourceName);
	}

	public function generate($force = false){
		$path = database_path('factories');

		$viewData = [
			'model' => $this->model,
			'modelName' => $this->modelName,
			'databaseName' => $this->databaseName,
			'tableName' => $this->tableName,
			'variableName' => $this->variableName,
			'collectionName' => $this->collectionName,
			'resourceName' => $this->resourceName,
			'columns' => $this->columns,
			'fakers' => $this->getFakersFromColumns(),
			];

		$factory = "<?php\n".view('modlify::factory', $viewData);
		$this->save($path, $this->modelName."Factory.php", $factory, $force);



		return true;
	}

	public function getFakersFromColumns(){
		$result = collect();
		foreach($this->columns as $column){
			$faker = $this->getFakerByName($column->name);
			if($faker){
				$result->put($column->name, $faker);
				continue;
			}

			$faker = $this->getFakerByType($column->type);
			if($faker){
				$result->put($column->name, $faker);
				continue;
			}

			$faker = $this->getFromFormatter($column->name);
			if($faker){
				$result->put($column->name, $faker);
				continue;
			}

			$result->put($column->name, '$faker->paragraph(3)');

		}
		return $result;
	}

	public function getFakerByName($columnName){
		if(strpos($columnName, 'email') !== false){
			return '$faker->email';
		}
		elseif(strpos($columnName, 'date') !== false){
			return '$faker->date';
		}
		elseif(strpos($columnName, 'url') !== false){
			return '$faker->url';
		}
		elseif(strpos($columnName, 'password') !== false){
			return 'bcrypt("password")';
		}
		elseif(strpos($columnName, 'address') !== false){
			return '$faker->streetAddress';
		}
		elseif(strpos($columnName, 'city') !== false){
			return '$faker->city';
		}
		elseif(strpos($columnName, 'postcode') !== false){
			return '$faker->postcode';
		}
		elseif(strpos($columnName, 'country') !== false){
			return '$faker->country';
		}
		elseif(strpos($columnName, 'phone') !== false || strpos($columnName, 'mobile') !== false){
			return '$faker->phoneNumber';
		}
		elseif(strpos($columnName, 'name') !== false){
			return 'str_replace("\'", null,$faker->name)';
		}

		return null;
	}

	public function getFakerByType($columnType){
		switch($columnType){
			case 'int': return '$faker->randomNumber()';
			case 'float': return '$faker->randomFloat()';
			case 'double': return '$faker->randomFloat()';
			case 'tinyint': return '$faker->numberBetween(0, 1)';
			case 'datetime': return '$faker->datetime()';
			case 'date': return '$faker->date()';
			default: return null;
		}
	}


	protected function getFromFormatter($formatter){
		$faker =  \Faker\Factory::create();
		try{
			$faker->getFormatter($formatter);
			return '$faker->'.$formatter;
		}catch(\Exception $e){
			return null;
		}
	}

}
