<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    {{-- import --}}
    <script type="module" src="https://ajax.googleapis.com/ajax/libs/model-viewer/3.4.0/model-viewer.min.js"></script>
    <title>3D Object Preview</title>

    <style>
        /* body {
            margin: 0;
            font-family: "Montserrat", sans-serif;
            background-color: #000;
        } */

        /* header {
            margin-top: 3em;
            text-align: center;
            color: white;
        }

        header h1 {
            font-size: 2em;
            font-weight: 900;
        } */

        /* #container3D canvas {
            width: 100vw !important;
            height: 100vh !important;
            position: absolute;
            top: 0;
            left: 0;
        } */

        .box{
            display: flex;
        }

        model-viewer{
            width: 800px;
            height: 600px;
            margin: 0, auto;
        }
    </style>

    {{-- <script async src="https://unpkg.com/es-module-shims@1.6.3/dist/es-module-shims.js"></script>
    <script type="importmap">
    {
    "imports": {
        "three": "https://unpkg.com/three@v0.153.0/build/three.module.js",
        "three/addons/": "https://unpkg.com/three@v0.153.0/examples/jsm/"
    }
    }
    </script> --}}
</head>

<body>
    {{-- <header>
        <h1>Simple 3D - Autumn House</h1>
    </header> --}}

    {{-- <main>
        <div id="container3D"></div>
    </main> --}}

    {{-- <script type="module" src={{ asset('main.js') }}></script> --}}
    {{-- <script type="module" src='/js/main.js'></script> --}}

    {{-- <main>
        <div class="container3D">
            <model-viewer alt="3d" src="public/storage/models1/scene.gltf" ar shadow-intensity="1"
                camera-controls touch-action="pan-y"></model-viewer>
        </div>
    </main> --}}

    <div class="box">
        <div>Title Object
            <div>
                <model-viewer alt="3d" src="{{ asset('storage/gummigoo/scene.gltf') }}" ar
                    shadow-intensity="1" camera-controls auto-rotate touch-action="pan-y"></model-viewer>
            </div>
        </div>
    </div>
</body>

</html>
