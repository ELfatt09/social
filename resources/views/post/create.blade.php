@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Buat Post Baru</div>
                    <div class="card-body">
                        <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="title">Judul:</label>
                                <input type="text" name="title" id="title" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="body">Isi:</label>
                                <textarea name="body" id="body" class="form-control" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="media">Unggah Media:</label>
                                <input type="file" name="media[]" id="media" accept="image/*" multiple>
                                <div id="media-preview" class="mt-3 d-grid gap-2 grid-cols-2 grid-rows-2"></div>
                            </div>
                            <button type="submit" class="btn btn-primary">Buat Post</button>
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
                        img.style = 'max-width: 400px; height: auto;';
                        img.className = 'img-thumbnail img-fluid media-preview-item';
                        mediaPreview.appendChild(img);

                        const fileInfo = document.createElement('div');
                        fileInfo.textContent = `${file.name} (${file.size} bytes)`;
                        fileInfo.className = 'media-preview-info';
                        mediaPreview.appendChild(fileInfo);
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
            padding: 10px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .media-preview-info {
            font-size: 12px;
            color: #666;
            margin-top: 10px;
        }

        .media-preview-item:hover {
            transform: scale(1.1);
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        }
    </style>
@endsection