{!! '@'.'extends("layouts.app")' !!}
{!! '@'.'section("content")' !!}
<p>
    <a href="{!! '{'.'{'."route('$resourceName.create')".'}'.'}' !!}" class="btn btn-primary ">New</a>
</p>
<div class="card">
    <div class="card-header"> {{$tableName}}</div>
    <div class="card-body">
        {!! '@'."if($collectionName"."->count())" !!}
            <table class="table table-striped">
                <thead>
                    <tr>
@foreach($columns as $column)
                        <th>{{$column->name}}</th>
@endforeach
                        <th class="text-right"></th>
                    </tr>
                </thead>
                <tbody>
                    {!! '@'."foreach($collectionName as $variableName)" !!}
                        <tr>
@foreach($columns as $column)
                            <td>{{ '{'.'{' }}{{$variableName}}->{{$column->name}}{{ '}'.'}' }}</td>
@endforeach
                            <td><a href="{!! '{'.'{'."route('$resourceName.show', $variableName"."->id)".'}'.'}' !!}" class="btn btn-primary ">Show</a></td>
                        </tr>
                    {!! '@'."endforeach" !!}
                </tbody>
            </table>
        {!! '@'."else" !!}
            The table is empty.
        {!! '@'."endif" !!}
    </div>
</div>

{!! '@'.'endsection' !!}
