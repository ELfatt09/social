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
                                <textarea name="body" id="body" class="form-control bg-light border border-dark p-3 rounded-lg text-dark"></textarea>
                            </div>
                            <div class="form-group mb-3">
                                <label for="media" class="text-dark">Unggah Media:</label>
                                <input type="file" name="media[]" id="media" accept="image/*,video/*" multiple class="form-control bg-light border border-dark p-3 rounded-lg text-dark">
                                <div id="media-preview" class="mt-3 grid grid-cols-2 gap-2"></div>
                            </div>
                            <button type="submit" class="btn btn-primary bg-dark text-light p-3 rounded-lg border-0">Buat Post</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
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
                img.classList.add('img-thumbnail', 'img-fluid', 'media-preview-item');
                mediaPreview.appendChild(img);
            } else if (fileType.startsWith('video/')) {
                const video = document.createElement('video');
                video.src = fileUrl;
                video.alt = file.name;
                video.classList.add('media-preview-item');
                video.controls = true;
                mediaPreview.appendChild(video);
            }
        };

        reader.readAsDataURL(file);
    });
});
    </script>

    <style>
        .media-preview {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            grid-gap: 10px;
        }

        .media-preview-item {
            border: 1px solid #ddd;
            padding: 3px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            height: 60px;
            width: auto;
        }

        .media-preview-item:hover {
            transform: scale(1.1);
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            height: 70px;
            width: auto;
        }
    </style>
@endsection