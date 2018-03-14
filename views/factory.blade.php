use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\{{$modelName}}::class, function (Faker $faker) {
	return [
@foreach($fakers as $name => $function)
		'{{$name}}' => {!! $function !!},
@endforeach
	];
});