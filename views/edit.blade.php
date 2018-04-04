{!! '@'.'extends("layouts.app")' !!}
{!! '@'.'section("content")' !!}
<div class="card">
    <div class="card-header"> Edit {{ $modelName }}</div>
    <div class="card-body">
        <form action="{!! '{'.'{'."route('$resourceName.update', $variableName"."->id)".'}'.'}' !!}" method="post">
            {!! '{'.'{'."method_field('PUT')".'}'.'}' !!}
            {!! '{'.'{'."csrf_field()".'}'.'}' !!}
            {!! '@'.'include("'.$tableName.'.form", ["model" => '.$variableName.'])' !!}
            <button class="btn btn-success">Save</button>
            <a href="{!! '{'.'{'."route('$resourceName.edit', $variableName"."->id)".'}'.'}' !!}" class="btn btn-danger">Cancel</a>
        </form>
    </div>
</div>
{!! '@'.'endsection' !!}