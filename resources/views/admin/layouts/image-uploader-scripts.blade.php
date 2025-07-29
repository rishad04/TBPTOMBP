{{-- @push('js') --}}
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
{{-- @endpush --}}
