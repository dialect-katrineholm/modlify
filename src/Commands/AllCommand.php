<?php

namespace Dialect\Modlify\Commands;

use Dialect\Modlify\Modlify;
use Illuminate\Console\Command;

class AllCommand extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'modlify:all 
							{model? : Model to generate from }
							{--force : Overwrite existing files }
							{--all : Generate from all models in the app directory}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Generate all components from models';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
		$force = $this->option('force');
		$all = $this->option('all');
		$model = $this->argument('model');

		if($all && $model){
			$this->error('Cannot use a specified model and --all at the same time.');
			return null;
		}
		if($all){
			foreach(Modlify::getModels() as $modelClass){
				$this->generateFromModel($modelClass, $force);
			}
		}
		else{
			$modelClass = 'App\\'.$model;
			$this->generateFromModel($modelClass, $force);
		}

		return null;
	}

	protected function generateFromModel($modelClass, $force){

		$model = new $modelClass;
		$modlify = new Modlify($model);

		$this->info('Generating controller for '.get_class($model));
		$modlify->generateController($force);

		$this->info('Generating factory for '.get_class($model));
		$modlify->generateFactory($force);

		$this->info('Generating policy for '.get_class($model));
		$modlify->generatePolicy($force);

		$this->info('Generating route for '.get_class($model));
		$modlify->generateRoute($force);

		$this->info('Generating tests for '.get_class($model));
		$modlify->generateTests($force);

		$this->info('Generating views for '.get_class($model));
		$modlify->generateViews($force);
	}





}
