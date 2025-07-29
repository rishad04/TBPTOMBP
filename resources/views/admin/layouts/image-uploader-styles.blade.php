
{{-- @push('css') --}}
    <style>
        .image-uploader { border: 2px dashed #ccc; padding: 20px; margin-bottom: 20px; }
        .upload-box { text-align: center; cursor: pointer; }
        .upload-box input { display: none; }
        .preview-box { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 10px; }
        .preview { position: relative; width: 100px; height: 100px; }
        .preview img { width: 100%; height: 100%; object-fit: cover; }
        .remove-btn {
            position: absolute;
            top: 0; right: 0;
            background: rgba(0,0,0,0.6);
            color: white;
            border: none;
            cursor: pointer;
            padding: 2px 6px;
        }
    </style>
{{-- @endpush --}}


{{-- @once
    @push('js')
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                document.querySelectorAll(".image-uploader").forEach(function (uploader) {
                    const input = uploader.querySelector("input[type=file]");
                    const previewBox = uploader.querySelector(".preview-box");
                    const isMultiple = uploader.dataset.multiple === "true";
                    const name = uploader.dataset.name;

                    uploader.querySelector(".upload-box").addEventListener("click", () => input.click());

                    input.addEventListener("change", function () {
                        [...this.files].forEach(file => {
                            const reader = new FileReader();
                            reader.onload = function (e) {
                                const preview = document.createElement("div");
                                preview.className = "preview";
                                preview.innerHTML = `
                                    <img src="${e.target.result}" />
                                    <span class="remove-btn">&times;</span>
                                `;
                                const hiddenInput = document.createElement("input");
                                hiddenInput.type = "hidden";
                                hiddenInput.name = name;
                                hiddenInput.files = file;
                                preview.appendChild(hiddenInput);

                                preview.querySelector(".remove-btn").addEventListener("click", () => preview.remove());
                                previewBox.appendChild(preview);
                            };
                            reader.readAsDataURL(file);
                        });
                    });

                    previewBox.querySelectorAll(".remove-btn").forEach(btn => {
                        btn.addEventListener("click", () => btn.closest('.preview').remove());
                    });
                });
            });
        </script>
    @endpush
@endonce --}}

