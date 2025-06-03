@props([
    'id' => '',
    'type',
    'name',
    'required' => false,
])

<div class="input-group ">
    <label class="{{$required ? 'input-is-required' : ''}}" for="{{$id}}">{{$slot}}</label>
    <input
        id="{{$id}}"
        type="{{$type}}"
        name="{{$name}}"
        class="form-input"
        value="{{ old($name) }}"
        {{ $required ? 'required' : ''}}
    >
    @error($name)
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>

