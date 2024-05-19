<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css"
        integrity="sha384-dpuaG1suU0eT09tx5plTaGMLBsfDLzUCCUXOY2j/LSvXYuG6Bqs43ALlhIqAJVRb" crossorigin="anonymous">

    <!-- Icons import -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <title>Create New Post</title>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    {{-- trix editor --}}
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>

    <!-- link CSS SweetAlert2 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.3.0/sweetalert2.min.css">

    <!-- link JavaScript SweetAlert2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.3.0/sweetalert2.all.min.js"></script>

    {{-- jquery --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        trix-toolbar [data-trix-button-group="file-tools"] {
            display: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="mt-5 mb-4">Add Post File</h1>
        <hr>
        <form id="uploadForm" method="post" action="/createpostfile" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <small class="text-danger">*required field</small>
            </div>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @elseif (session('edited'))
                <div class="alert alert-warning">{{ session('edited') }}</div>
            @elseif (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            {{-- ini dikirim dari function show --}}
            <input type="hidden" name="postid" value="{{ $postid }}">
            <p>{{ $postid }} (Nanti hapus)</p>

            <div class="mb-3">
                <label for="filename" class="form-label">File Title*</label>
                <input type="text" name="filename" class="form-control @error('filename') is-invalid @enderror"
                    id="filename" placeholder="Masukkan filename" required value="{{ old('filename') }}">
                @error('filename')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div id="fileUploads" class="mb-3">
                <label for="selectFile" class="form-label">Upload File</label>
                <select class="form-select" name="selectFile" id="selectFile" onchange="enableFileUpload(this)">
                    <option value="0">Select File Type</option>
                    <option value="1">Link</option>
                    <option value="2">Image (jpg, jpeg, png)</option>
                    <option value="3">Album (jpg, jpeg, png)</option>
                    <option value="4">Video (mp4)</option>
                    <option value="5">Audio (mp3, wav)</option>
                    <option value="6">Document (pdf) </option>
                    <option value="7">3D Object (glb) </option>
                </select>
            </div>

            <div class="mb-3 d-none" id="fileLinkUpload">
                <label class="form-label">Insert Link</label>
                <input class="form-control" type="text" id="link" name="link"
                    @error('link') is-invalid @enderror>
                @error('link')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-3 d-none" id="fileImageUpload">
                <img class="image-preview img-fluid mb-3 col-sm-3">
                <input class="form-control" type="file" id="image" name="image" onchange="previewImage()"
                    accept="image/*" @error('image') is-invalid @enderror>
                <small class="form-text text-muted">Allowed image format: jpg, jpeg, png</small>
                @error('image')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-3 d-none" id="fileAlbumUpload">
                <img class="album-preview">
                <input class="form-control" type="file" id="album" name="album[]" onchange="previewAlbum()"
                    multiple accept="image/*" @error('album') is-invalid @enderror>
                <small class="form-text text-muted">Allowed album format: jpg, jpeg, png</small>
                @error('album')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-3 d-none" id="fileVideoUpload">
                <video class="video-preview mb-3 col-sm-3" controls style="display: none;"></video>
                <input class="form-control mt-3" type="file" id="video" name="video" onchange="previewVideo()"
                    accept="video/*" @error('video') is-invalid @enderror>
                <small class="form-text text-muted">Allowed video format: mp4</small>
                @error('video')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-3 d-none" id="fileAudioUpload">
                <audio class="audio-preview mb-3 col-sm-3" controls style="display: none;"></audio>
                <input class="form-control mt-3" type="file" id="audio" name="audio"
                    onchange="previewAudio()" accept="audio/*" @error('audio') is-invalid @enderror>
                <small class="form-text text-muted">Allowed audio format: mp3, wav</small>
                @error('audio')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-3 d-none" id="fileDocumentUpload">
                <img class="document-preview mb-3 col-sm-3">
                <input class="form-control" type="file" id="document" name="document" accept=".pdf"
                    onchange="previewDocument()" @error('document') is-invalid @enderror>
                <small class="form-text text-muted">Allowed document format: pdf</small>
                @error('document')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-3 d-none" id="fileObjectUpload">
                <img class="object-preview mb-3 col-sm-3">
                <input class="form-control" type="file" id="object" name="object" accept=".glb"
                    onchange="previewObject()" @error('image') is-invalid @enderror>
                <small class="form-text text-muted">Allowed object
                    format: glb</small>
                @error('image')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            {{-- <div class="progress my-3">
                <p>Progress Bar</p>
                <div class="progress-bar" role="progressbar" style="width: 0%;" id="progressBar">0%</div>
            </div> --}}

            <div class="mb-3 d-grid">
                <button type="submit" class="btn btn-primary">Add File</button>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col" style="width: 60%;">File Title</th>
                        <th scope="col" style="width: 20%;">File Type</th>
                        <th scope="col">View File</th>
                        <th scope="col">Delete File</th>
                    </tr>
                </thead>
                @if ($postfile->isEmpty())
                    <tbody class="table-group-divider">
                        <tr>
                            <td class="table-danger" colspan="5">No File Added</td>
                        </tr>
                    </tbody>
                @else
                    @foreach ($postfile as $file)
                        <tbody class="table-group-divider">
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $file->filename }}</td>
                                <td>{{ $file->filetype }}</td>
                                <td><a href="/viewpostfile/{{ $file->id }}" class="btn btn-primary">View</a>
                                </td>
                                <td>
                                    <form action="/createpostfile/{{ $file->id }}" method="post"
                                        id="deleteForm">
                                        @method('delete')
                                        @csrf
                                        <button class="btn btn-danger" onclick="confirmDelete(event)"
                                            title="">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        </tbody>
                    @endforeach
                @endif
            </table>
        </div>

        <div class="mb-3 d-grid">
            <a href="/createpostcontributor" class="btn btn-primary">Next (Add Post Contributor)</a>
        </div>
    </div>


    <script>
        function confirmDelete(event) {
            e.preventDefault();

            Swal.fire({
                title: 'Are you sure?',
                text: "You want to delete this file?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Delete',
                cancelButtonText: 'Cancel',
                allowOutsideClick: false,
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteForm').submit();
                }
            });
        };

        // document.getElementById('uploadForm').addEventListener('submit', function(e) {
        //     e.preventDefault(); // Prevent default form submission

        //     const formData = new FormData(this);
        //     const xhr = new XMLHttpRequest();
        //     const progressBar = document.getElementById('progressBar');

        //     xhr.upload.addEventListener('progress', function(e) {
        //         if (e.lengthComputable) {
        //             const percentComplete = (e.loaded / e.total) * 100;
        //             progressBar.style.width = percentComplete + '%';
        //             progressBar.textContent = Math.round(percentComplete) + '%';
        //         }
        //     });

        //     xhr.addEventListener('load', function() {
        //         if (xhr.status === 200) {
        //             Swal.fire('Success', 'File uploaded successfully!', 'success').then(() => {
        //                 location.reload();
        //             });
        //         } else {
        //             Swal.fire('Error', 'There was an error uploading the file.', 'error');
        //         }
        //     });

        //     xhr.open('POST', '/createpostfile', true);
        //     xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute(
        //         'content'));
        //     xhr.send(formData);
        // });

        // document.getElementById('uploadForm').addEventListener('submit', function (e) {
        //     e.preventDefault();
        //     const progressBar = document.getElementById('progressBar');

        //     $('form').ajaxForm({
        //         beforeSend: function () {
        //             var percentVal = '0%';
        //             progressBar.css('width', percentVal);
        //             progressBar.text(percentVal);
        //         },
        //         uploadProgress: function (event, position, total, percentComplete) {
        //             var percentVal = percentComplete + '%';
        //             progressBar.css('width', percentVal);
        //             progressBar.text(percentVal);
        //         },
        //         complete: function () {
        //             alert("Upload Sukses");
        //         }
        //     });
        // });

        function previewImage() {
            const image = document.querySelector('#image');
            const imgPreview = document.querySelector('.image-preview');

            imgPreview.style.display = 'block';

            const fileURL = URL.createObjectURL(image.files[0]);
            imgPreview.src = fileURL;

            //cara lain (web unpas)
            // const oFReader = new FileReader();
            // oFReader.readAsDataURL(image.files[0]);

            // oFReader.onload = function(oFREvent) {
            //     imgPreview.src = oFREvent.target.result;
            // }

        }

        function previewVideo() {
            const video = document.querySelector('#video');
            const videoPreview = document.querySelector('.video-preview');

            videoPreview.style.display = 'block';

            const fileURL = URL.createObjectURL(video.files[0]);
            videoPreview.src = fileURL;
        }

        function previewAudio() {
            const audio = document.querySelector('#audio');
            const audioPreview = document.querySelector('.audio-preview');

            audioPreview.style.display = 'block';

            const fileURL = URL.createObjectURL(audio.files[0]);
            audioPreview.src = fileURL;
        }

        function previewAlbum() {}

        function toggleFileUpload() {
            var fileUploads = document.getElementById('fileUploads');
            var addFileButton = document.getElementById('addFileButton');

            if (fileUploads.classList.contains('d-none')) {
                fileUploads.classList.remove('d-none');
                addFileButton.textContent = 'Hide File Uploads';
            } else {
                fileUploads.classList.add('d-none');
                addFileButton.textContent = 'Add File';
            }
        }

        function enableFileUpload(selected) {
            if (selected.value == 0) {
                document.getElementById('fileLinkUpload').classList.add('d-none');
                document.getElementById('fileImageUpload').classList.add('d-none');
                document.getElementById('fileAlbumUpload').classList.add('d-none');
                document.getElementById('fileVideoUpload').classList.add('d-none');
                document.getElementById('fileAudioUpload').classList.add('d-none');
                document.getElementById('fileDocumentUpload').classList.add('d-none');
                document.getElementById('fileObjectUpload').classList.add('d-none');
            } else if (selected.value == 1) {
                document.getElementById('fileLinkUpload').classList.remove('d-none');
                document.getElementById('fileImageUpload').classList.add('d-none');
                document.getElementById('fileAlbumUpload').classList.add('d-none');
                document.getElementById('fileVideoUpload').classList.add('d-none');
                document.getElementById('fileAudioUpload').classList.add('d-none');
                document.getElementById('fileDocumentUpload').classList.add('d-none');
                document.getElementById('fileObjectUpload').classList.add('d-none');
            } else if (selected.value == 2) {
                document.getElementById('fileLinkUpload').classList.add('d-none');
                document.getElementById('fileImageUpload').classList.remove('d-none');
                document.getElementById('fileAlbumUpload').classList.add('d-none');
                document.getElementById('fileVideoUpload').classList.add('d-none');
                document.getElementById('fileAudioUpload').classList.add('d-none');
                document.getElementById('fileDocumentUpload').classList.add('d-none');
                document.getElementById('fileObjectUpload').classList.add('d-none');
            } else if (selected.value == 3) {
                document.getElementById('fileLinkUpload').classList.add('d-none');
                document.getElementById('fileImageUpload').classList.add('d-none');
                document.getElementById('fileAlbumUpload').classList.remove('d-none');
                document.getElementById('fileVideoUpload').classList.add('d-none');
                document.getElementById('fileAudioUpload').classList.add('d-none');
                document.getElementById('fileDocumentUpload').classList.add('d-none');
                document.getElementById('fileObjectUpload').classList.add('d-none');
            } else if (selected.value == 4) {
                document.getElementById('fileLinkUpload').classList.add('d-none');
                document.getElementById('fileImageUpload').classList.add('d-none');
                document.getElementById('fileAlbumUpload').classList.add('d-none');
                document.getElementById('fileVideoUpload').classList.remove('d-none');
                document.getElementById('fileAudioUpload').classList.add('d-none');
                document.getElementById('fileDocumentUpload').classList.add('d-none');
                document.getElementById('fileObjectUpload').classList.add('d-none');
            } else if (selected.value == 5) {
                document.getElementById('fileLinkUpload').classList.add('d-none');
                document.getElementById('fileImageUpload').classList.add('d-none');
                document.getElementById('fileAlbumUpload').classList.add('d-none');
                document.getElementById('fileVideoUpload').classList.add('d-none');
                document.getElementById('fileAudioUpload').classList.remove('d-none');
                document.getElementById('fileDocumentUpload').classList.add('d-none');
                document.getElementById('fileObjectUpload').classList.add('d-none');
            } else if (selected.value == 6) {
                document.getElementById('fileLinkUpload').classList.add('d-none');
                document.getElementById('fileImageUpload').classList.add('d-none');
                document.getElementById('fileAlbumUpload').classList.add('d-none');
                document.getElementById('fileVideoUpload').classList.add('d-none');
                document.getElementById('fileAudioUpload').classList.add('d-none');
                document.getElementById('fileDocumentUpload').classList.remove('d-none');
                document.getElementById('fileObjectUpload').classList.add('d-none');
            } else if (selected.value == 7) {
                document.getElementById('fileLinkUpload').classList.add('d-none');
                document.getElementById('fileImageUpload').classList.add('d-none');
                document.getElementById('fileAlbumUpload').classList.add('d-none');
                document.getElementById('fileVideoUpload').classList.add('d-none');
                document.getElementById('fileAudioUpload').classList.add('d-none');
                document.getElementById('fileDocumentUpload').classList.add('d-none');
                document.getElementById('fileObjectUpload').classList.remove('d-none');
            }
        }
    </script>
</body>

</html>
