<?php

namespace Dialect\Modlify\Generators;
use File;
class PolicyGenerator extends Generator {

	function __construct($model,$modelName,$databaseName, $tableName, $columns, $variableName, $collectionName, $resourceName) {
		parent::__construct($model, $modelName,$databaseName, $tableName, $columns,$variableName, $collectionName, $resourceName);
	}

	public function generate($force = false){
		$path = app_path("Policies");

		$viewData = [
			'model' => $this->model,
			'modelName' => $this->modelName,
			'databaseName' => $this->databaseName,
			'tableName' => $this->tableName,
			'variableName' => $this->variableName,
			'collectionName' => $this->collectionName,
			'resourceName' => $this->resourceName,
			'columns' => $this->columns,
			'argumentName' => $this->getArgumentName(),
			];

		$factory = "<?php\n".view('modlify::policy', $viewData);
		$this->save($path, $this->modelName."Policy.php", $factory, $force);
		$this->addToAuthServiceProvider();
		return true;
	}

	protected function getArgumentName(){
		if($this->variableName == '$user'){
			return '$user2';
		}

		return $this->variableName;
	}

	protected function addToAuthServiceProvider(){
		$array = ' protected $policies = [';
		$new = $this->modelName.'::class => '.$this->modelName.'Policy::class,';
		$provider = base_path("app/Providers/AuthServiceProvider.php");

		$data = File::get($provider);
		//only add if it doesnt exist.
		if(strpos($data, $new) == false){
			File::put($provider, str_replace($array, $array."\n         ".$new, $data));
		}

		$use = "use Illuminate\Support\Facades\Gate;";
		$modelUse = "use App\\".$this->modelName.";";
		$policyUse = "use App\\Policies\\".$this->modelName.'Policy;';

		$data = File::get($provider);
		if(strpos($data, $modelUse) == false){
			File::put($provider, str_replace($use, $use."\n".$modelUse, $data));
		}

		$data = File::get($provider);
		if(strpos($data, $policyUse) == false){
			File::put($provider, str_replace($use, $use."\n".$policyUse, $data));
		}

	}


}