@extends('components.main')

@section('container')
    <div class="container">
        <div class="row mt-5">
            <div class="mb-3 d-grid">
                <a href="/createpostfile" class="btn btn-outline-secondary"><i class="bi bi-arrow-left-square"></i> Back to Post
                    File
                </a>
            </div>

            <div class="mb-3">
                <h5 class="text-center">Preview Post File</h5>
            </div>

            <div class="">
                @if ($files->filetype == 'Link')
                    <div class="row mb-3">
                        <div class="h6 text-center mb-3">{{ $files->filename }}</div>
                        <a href="{{ $files->file }}" class="btn btn-outline-secondary" title="{{ $files->file }}"><i
                                class="bi bi-link-45deg"></i>Link:
                            {{ $files->file }}</a>
                    </div>
                    <hr>
                @elseif ($files->filetype == 'Image')
                    <div class="h6 text-center mb-3">{{ $files->filename }}</div>
                    <div class="row mb-3">
                        <img src="{{ asset('storage/public-images/' . $files->file) }}" class="img-fluid">
                    </div>
                    <hr>
                @elseif ($files->filetype == 'Album')
                    <div class="h6 text-center mb-3">{{ $files->filename }}</div>
                    <div class="row mb-3">
                        <img src="{{ asset('storage/album-images/' . $files->file) }}" class="img-fluid">
                    </div>
                    <hr>
                @elseif($files->filetype == 'Video')
                    <div class="h6 text-center mb-3">{{ $files->filename }}</div>
                    <div class="row mb-3">
                        <video controls>
                            <source src="{{ asset('storage/public-videos/' . $files->file) }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                    <hr>
                @elseif($files->filetype == 'Audio')
                    <div class="h6 text-center mb-3">{{ $files->filename }}</div>
                    <div class="row mb-3">
                        <audio controls>
                            <source src="{{ asset('storage/public-audios/' . $files->file) }}" type="audio/mpeg">
                            Your browser does not support the audio element.
                        </audio>
                    </div>
                    <hr>
                @elseif($files->filetype == 'Object')
                    <div class="h6 text-center mb-3">{{ $files->filename }}</div>
                    <div class="row mb-3">
                        <model-viewer alt="3d" src="{{ asset('storage/public-objects/' . $files->file) }}"
                            style="width: 100vw; height: 33vw; border: 1px solid #ccc; margin: auto; background-color: #f0f0f0;" ar
                            shadow-intensity="1" camera-controls auto-rotate touch-action="pan-y"></model-viewer>
                    </div>
                    {{-- style="width: 60vw; height: 33.75vw; border: 1px solid #ccc; margin: auto;" --}}
                @elseif($files->filetype == 'Document')
                    <div class="h6 text-center mb-3">{{ $files->filename }}</div>
                    <div class="row mb-3">
                        <iframe src="{{ asset('storage/public-documents/' . $files->file) }}" width="800"
                            height="800"></iframe>
                    </div>
                    <hr>
                @endif
            </div>
        </div>
    @endsection
