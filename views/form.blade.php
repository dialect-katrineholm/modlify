{!! '<?'.'php if(!isset($model)) $model = null; ?>' !!}
@foreach($inputs as $name => $type)
<div class="form-group">
@if($name == "password")
    <label for="password">Password</label>
    <input type="password" name="password" class="form-control" /><br>
    <label for="password_confirmation">Confirm password</label>
    <input type="password" name="password_confirmation" class="form-control" />
@elseif($type['type'] == 'checkbox')
    <input type="hidden" name="{{$name}}" value="0" />
    <label><input type="checkbox" name="{{$name}}" value="1" {{$type['required'] ? 'required' : null}} {!! '{'.'{'.'old("'.$name.'", optional($model)->'.$name.') ? "checked" : null'.'}'.'}' !!}> {{$name}}</label>
@else
    <label for="{{$name}}">{{$name}}</label>
@if($type['type'] == "textarea")
    <textarea name="{{$name}}" {{$type['required'] ? 'required' : null}} class="form-control">{!! '{'.'{'.'old("'.$name.'", optional($model)->'.$name.')'.'}'.'}' !!}</textarea>
@else
    <input type="{{$type['type']}}" {!! $type['type'] == "number" ? 'steps="any" ' : null !!}name="{{$name}}" value="{!! '{'.'{'.'old("'.$name.'", optional($model)->'.$name.')'.'}'.'}' !!}" class="form-control" {{$type['required'] ? 'required' : null}} />
@endif
@endif
</div>

@endforeach