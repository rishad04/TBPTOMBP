@props([
'id',
'label' => 'Upload Image',
'multiple' => false,
'name',
'existing' => [], // For old images (edit form)
])
@php
$errorKey = Str::endsWith($name, '[]') ? Str::replaceLast('[]', '', $name) . '.*' : $name;
@endphp
<div id="{{ $id }}" class=" {{ $errors->has($errorKey) ?  'image-uploader-error' : 'image-uploader'}}" data-multiple="{{ $multiple ? 'true' : 'false' }}" data-name="{{ $name }}">
    <div class="upload-box">
        <p>{{ $label }} - Drag & Drop or <span class="clickable">Browse</span></p>


        <input
            type="file"
            name="{{ $name }}"
            {{ $multiple ? 'multiple' : '' }}
            accept="image/*"
            class="file-input {{ $errors->has($errorKey) ? 'is-invalid' : '' }}">

        @if ($errors->has($errorKey))
        <div class="invalid-feedback">
            {{ $errors->first($errorKey) }}
        </div>
        @endif
    </div>

    <div class="preview-box">
        @foreach ($existing as $image)
        <div class="preview">
            <img src="{{ asset('storage/' . $image) }}" alt="Uploaded">
            <span class="remove-btn">&times;</span>
            <input type="hidden" name="existing_{{ $name }}[]" value="{{ $image }}">
        </div>
        @endforeach
    </div>
</div>