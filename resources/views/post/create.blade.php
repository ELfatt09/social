@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card bg-light border border-dark p-5 rounded-lg shadow-md">
                    <div class="card-header bg-dark text-light p-3 rounded-lg">Buat Post Baru</div>
                    <div class="card-body">
                        <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="title" class="text-dark">Judul:</label>
                                <input type="text" name="title" id="title" class="form-control bg-light border border-dark p-3 rounded-lg text-dark" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="body" class="text-dark">Isi:</label>
                                <textarea name="body" id="body" class="form-control bg-light border border-dark p-3 rounded-lg text-dark" rows="5"></textarea>
                            </div>
                            <div class="form-group mb-3">
                                <label for="media" class="text-dark">Unggah Media:</label>
                                <input type="file" name="media[]" id="media" accept="image/*,video/*" multiple class="form-control bg-light border border-dark p-3 rounded-lg text-dark">
                            </div>
                            <div class="preview-container">
                                <div class="preview" id="media-preview"></div>
                            </div>
                            <button type="submit" class="btn btn-primary bg-dark text-light p-3 rounded-lg border-0">Buat Post</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const mediaInput = document.getElementById('media');
        const mediaPreview = document.getElementById('media-preview');

        mediaInput.addEventListener('change', (e) => {
            const files = Array.from(mediaInput.files);
            mediaPreview.innerHTML = '';

            files.forEach((file) => {
                const reader = new FileReader();

                reader.onload = (e) => {
                    const fileType = file.type;
                    const fileUrl = e.target.result;

                    if (fileType.startsWith('image/')) {
                        const img = document.createElement('img');
                        img.src = fileUrl;
                        img.alt = file.name;
                        img.classList.add('img-thumbnail', 'img-fluid', 'media-preview-item', 'rounded-lg', 'shadow-md', 'hover:scale-110');
                        mediaPreview.appendChild(img);
                    } else if (fileType.startsWith('video/')) {
                        const video = document.createElement('video');
                        video.src = fileUrl;
                        video.alt = file.name;
                        video.classList.add('media-preview-item', 'rounded-lg', 'shadow-md', 'hover:scale-110');
                        video.controls = true;
                        mediaPreview.appendChild(video);
                    }
                };

                reader.readAsDataURL(file);
            });
        });
    </script>

    <style>
        .preview-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .preview {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            grid-gap: 10px;
        }

        .media-preview-item {
            width: auto;
            height: 150px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease-in-out;
        }

        .media-preview-item:hover {
            transform: scale(1.1);
        }
    </style>
@endsection

