<?php

namespace Dialect\Modlify\Commands;

use Dialect\Modlify\Modlify;
use Illuminate\Console\Command;

class ViewsCommand extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'modlify:views 
							{model? : Model to generate from }
							{--force : Overwrite existing files }
							{--all : Generate from all models in the app directory}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Generate views from models';

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
		$this->info('Generating views for '.get_class($model));

		$modlify = new Modlify($model);
		$modlify->generateViews($force);
	}





}
