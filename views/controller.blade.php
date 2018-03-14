namespace App\Http\Controllers;

use Illuminate\Http\Request;
use {{get_class($model)}};
class {{$modelName}}Controller extends Controller
{
    public function index()
    {
        {{$collectionName}} = {{$modelName}}::paginate(20);

        return view('{{$tableName}}.index', [
            '{{str_replace('$', null, $collectionName)}}' => {{$collectionName}},
        ]);
    }

    public function show({{$modelName}} {{$variableName}})
    {
        return view('{{$tableName}}.show', [
            '{{str_replace('$', null, $variableName)}}' => {{$variableName}},
        ]);
    }

    public function create()
    {
        return view('{{$tableName}}.create');
    }

    public function edit({{$modelName}} {{$variableName}})
    {
        return view('{{$tableName}}.edit', [
            '{{str_replace('$', null, $variableName)}}' => {{$variableName}},
        ]);
    }

    public function store()
    {
        $this->validate(request(), [
@foreach($validations as $key => $rules)
@if($rules['store'])
            '{{$key}}' => '{{$rules['store']}}',
@endif
@endforeach
        ]);

@if($hasPassword)
        {{$variableName}} = {{$modelName}}::create(['password' => bcrypt(request('password'))] + request()->except('password_confirmation'));
@else
        {{$variableName}} = {{$modelName}}::create(request()->all());
@endif

        return redirect()->route('{{$tableName}}.show', {{$variableName}}->id);
    }


    public function update({{$modelName}} {{$variableName}})
    {
        $this->validate(request(), [
@foreach($validations as $key => $rules)
@if($rules['update'])
            '{{$key}}' => '{!! $rules['update'] !!}',
@endif
@endforeach
        ]);

@if($hasPassword)
        {{$variableName}}->update(['password' => request('password') ? bcrypt(request('password')) : {{$variableName}}->password] + request()->except('password_confirmation'));
@else
        {{$variableName}}->update(request()->all());
@endif

        return redirect()->route('{{$tableName}}.show', {{$variableName}}->id);
    }

    public function destroy({{$modelName}} {{$variableName}})
    {
        {{$variableName}}->delete();

        return redirect()->route('{{$tableName}}.index');
    }
}
