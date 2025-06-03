@props([
    'id' => '',
    'name',
    'required' => false,
    'options' => ['asasd'],
])

<div class="input-group">
    <label for="{{$id}}">{{$slot}}</label>
    <select
    class="form-input"
    id="{{$id}}"
    name="{{$name}}"
    {{$required ? 'required' : '' }}
    >
        @foreach ($options as $option )
            <option value="{{$option}}">{{$option}}</option>
        @endforeach
    </select>

    @error($name)
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>
