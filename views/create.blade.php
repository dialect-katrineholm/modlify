{!! '@'.'extends("layouts.app")' !!}
{!! '@'.'section("content")' !!}
<div class="card card-default">
    <div class="card-header"> Create {{$modelName}}</div>
    <div class="card-body">
        <form action="{!! '{'.'{'."route('$resourceName.store')".'}'.'}' !!}" method="post">
            {!! '{'.'{'."csrf_field()".'}'.'}' !!}
            {!! '@'.'include("'.$tableName.'.form")' !!}
            <button class="btn btn-success">Save</button>
            <a href="{!! '{'.'{'."route('$resourceName.index')".'}'.'}' !!}" class="btn btn-danger">Cancel</a>
        </form>
    </div>
</div>
{!! '@'.'endsection' !!}