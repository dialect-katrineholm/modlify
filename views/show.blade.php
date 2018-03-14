{!! '@'.'extends("layouts.app")' !!}
{!! '@'.'section("content")' !!}
<p>
    <form action="{!! '{'.'{'."route('$resourceName.destroy', $variableName"."->id)".'}'.'}' !!}" method="post">
        {!! '{'.'{'."method_field('DELETE')".'}'.'}' !!}
        {!! '{'.'{'."csrf_field()".'}'.'}' !!}
        <a href="{!! '{'.'{'."route('$resourceName.edit', $variableName"."->id)".'}'.'}' !!}" class="btn btn-warning">Edit</a>
        <button class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
    </form>
</p>
<div class="card card-default">
    <div class="card-header"> {{$tableName}} {!! '{'.'{'.$variableName.'->id}'.'}' !!}</div>
    <div class="card-body">
        <table class="table table-striped">
@foreach($columns as $column)
            <tr>
                <td><strong>{{$column->name}}</strong></td>
                <td>{{ '{'.'{' }}{{$variableName}}->{{$column->name}}{{ '}'.'}' }}</td>
            </tr>
@endforeach
        </table>
    </div>
</div>

{!! '@'.'endsection' !!}
