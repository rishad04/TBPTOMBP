{{-- Extends layout --}}
@extends('admin.layouts.master')

@section('title')
{{ $page_title }}
@endsection

{{-- Content --}}
@section('container')
<div class="row">
    <div class="col-lg-12">
        <div class="myy-card">
            <div class="myy-card__wrapper">
                {{-- Card Header Start --}}
                <div class=" myy-table__header d-flex justify-content-between">
                    <div class="myy-table__title">
                        <h5>{{ $info->title }}</h5>
                    </div>
                    <div class="float-right">
                        <a href="{{ route($info->first_button_route) }}" class="btn btn-primary">

                            <i class="flaticon2-add"></i>

                            {{ $info->first_button_title }}
                        </a>
                    </div>
                </div>
                {{-- Card Header End --}}

                {{-- Card Body Start --}}
                <div class="myy-card__body">
                    <form class="form" action="{{ route($info->form_route) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf


                        <div class="row g-4">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="unique_id">Unique ID <span>&#x002A;</span> </label>
                                    <input type="number" value="{{ old('unique_id') }}"
                                        class="form-control @error('unique_id') is-invalid @enderror" id="unique_id"
                                        name="unique_id" placeholder="Enter Title">
                                    @error('unique_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Name <span>*</span></label>
                                    <input type="text" name="name" value="{{ old('name') }}" required>
                                    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Photo <span>*</span></label>
                                <div class="upload-box" id="uploadBox">
                                    <input type="file" accept="image/*" name="photo" id="photoInput" hidden>
                                    <input type="hidden" name="photo_temp" id="photoTemp" value="{{ old('photo_temp') }}">
                                    <div id="dropArea" class="drop-area">
                                        <span id="uploadText">Click or Drag Image</span>
                                    </div>
                                    <div id="previewContainer" class="preview-container" style="display: {{ old('photo_temp') ? 'block' : 'none' }}">
                                        @if(old('photo_temp'))
                                            <img src="{{ asset('temp-uploads/' . old('photo_temp')) }}" alt="Preview" class="preview-image">
                                            <button type="button" class="remove-btn" onclick="removeImage()">×</button>
                                        @endif
                                    </div>
                                </div>
                                @error('photo') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                           {{-- <x-image-uploader
                                id="mainPhotoUploader"
                                label="Main Photo"
                                name="main_photo"
                            />

                            <x-image-uploader
                                id="bannersUploader"
                                label="Banners"
                                name="banners[]"
                                :multiple="true"
                            /> --}}



                        </div>
                        <div class="row">
                            <div class="col-lg-10">
                                <button type="submit"
                                    class="btn btn-primary mt-4">{{ __('button.create') }}</button>
                                <button type="reset" class="btn btn-danger mt-4">{{ __('button.reset') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
                {{-- Card Body End --}}
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
@parent

<style>
.upload-box {
    border: 2px dashed #ccc;
    padding: 30px;
    text-align: center;
    border-radius: 10px;
    cursor: pointer;
    position: relative;
}

.drop-area {
    color: #666;
}

.preview-container {
    position: relative;
    margin-top: 10px;
}

.preview-image {
    max-width: 100%;
    height: auto;
    border-radius: 6px;
}

.remove-btn {
    position: absolute;
    top: -10px;
    right: -10px;
    background: red;
    color: white;
    border: none;
    font-size: 16px;
    border-radius: 50%;
    width: 25px;
    height: 25px;
    cursor: pointer;
}
</style>
@endsection

@section('js')
@parent


  <script>
document.getElementById('uploadBox').addEventListener('click', function () {
    document.getElementById('photoInput').click();
});

document.getElementById('photoInput').addEventListener('change', function (e) {
    uploadImage(e.target.files[0]);
});

document.getElementById('uploadBox').addEventListener('dragover', function (e) {
    e.preventDefault();
    this.classList.add('dragover');
});

document.getElementById('uploadBox').addEventListener('drop', function (e) {
    e.preventDefault();
    this.classList.remove('dragover');
    const file = e.dataTransfer.files[0];
    uploadImage(file);
});

function uploadImage(file) {
    if (!file || !file.type.startsWith('image/')) return;

    const formData = new FormData();
    formData.append('photo', file);

    fetch('{{ route('form.upload-temp') }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        // show preview
        const previewContainer = document.getElementById('previewContainer');
        previewContainer.innerHTML = `
            <img src="/temp-uploads/${data.filename}" alt="Preview" class="preview-image">
            <button type="button" class="remove-btn" onclick="removeImage()">×</button>
        `;
        previewContainer.style.display = 'block';
        document.getElementById('photoTemp').value = data.filename;
    })
    .catch(err => {
        alert("Image upload failed");
    });
}

function removeImage() {
    document.getElementById('previewContainer').innerHTML = '';
    document.getElementById('previewContainer').style.display = 'none';
    document.getElementById('photoTemp').value = '';
}
</script>




@endsection