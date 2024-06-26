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
    @if (session()->has('isAdmin'))
        <title>Create New Post as {{ $permissionName }}</title>
    @else
        <title>Create New Post</title>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    {{-- trix editor --}}
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>

    <style>
        trix-toolbar [data-trix-button-group="file-tools"] {
            display: none;
        }
    </style>
</head>

<body>
    <div class="container">
        @if (session()->has('isAdmin'))
            <h1 class="mt-5 mb-4">Create New Post as {{ $permissionName }}</h1>
        @else
            <h1 class="mt-5 mb-4">Create New Post</h1>
        @endif
        <hr>
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <form method="post" action="/createpost" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <small class="text-danger">*required field</small>
            </div>
            <div class="mb-3">
                <label for="slug" class="form-label">Slug*</label>
                <div id="slugHelp" class="form-text" style="font-size:12px;">Slug is the <span style="color: red;">last
                        path of the url</span> used to access and display your post details.</div>
                <div id="slugHelp" class="form-text" style="font-size:12px;">ex:
                    https://portofolioweb.site/viewpost/<code>your-slug</code></div>
                <div id="slugHelp" class="form-text" style="font-size:12px;">Avoid using spaces or can use
                    hyphen '-' to separate words.</div>
                <div id="slugHelp" class="form-text mb-3" style="font-size:12px; color: #FFA500;">*Can't edit slug after post created</div>
                <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror"
                    id="slug" placeholder="Input slug" required value="{{ old('slug') }}">
                @error('slug')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description*</label>
                @error('description')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
                <input id="description" type="hidden" name="description" value={{ old('description') }}>
                <trix-editor id="trix-editor" input="description"></trix-editor>
            </div>

            {{-- <div class="user-box d-inline-flex justify-content-center border p-2 rounded-3 mb-3">
                <div class="text-center fw-bold">Kategori Test</div>
            </div> --}}

            <div class="mb">
                <label for="department" class="form-label" required>Department*</label>
                <div class="mb-3">
                    <select class="form-select" name="department">
                        <option value="empty" {{ old('deparment') == '' ? 'selected' : '' }}>Select Department</option>
                        <option value="Badan Eksekutif Mahasiswa"
                            {{ old('department') == 'Badan Eksekutif Mahasiswa' ? 'selected' : '' }}>Badan Eksekutif
                            Mahasiswa</option>
                        <option value="Branding and Digital Marketing"
                            {{ old('department') == 'Branding and Digital Marketing' ? 'selected' : '' }}>Branding and
                            Digital Marketing</option>
                        <option value="Broadcast And Journalism"
                            {{ old('department') == 'Broadcast And Journalism' ? 'selected' : '' }}>Broadcast And
                            Journalism</option>
                        <option value="Departemen Matakuliah Umum"
                            {{ old('department') == 'Departemen Matakuliah Umum' ? 'selected' : '' }}>Departemen
                            Matakuliah Umum</option>
                        <option value="Doktor Ilmu Manajemen"
                            {{ old('department') == 'Doktor Ilmu Manajemen' ? 'selected' : '' }}>Doktor Ilmu Manajemen
                        </option>
                        <option value="Fakultas Ekonomi"
                            {{ old('department') == 'Fakultas Ekonomi' ? 'selected' : '' }}>Fakultas Ekonomi</option>
                        <option value="Fakultas Humaniora dan Industri Kreatif"
                            {{ old('department') == 'Fakultas Humaniora dan Industri Kreatif' ? 'selected' : '' }}>
                            Fakultas Humaniora dan Industri Kreatif</option>
                        <option value="Fakultas Ilmu Komunikasi"
                            {{ old('department') == 'Fakultas Ilmu Komunikasi' ? 'selected' : '' }}>Fakultas Ilmu
                            Komunikasi</option>
                        <option value="Fakultas Keguruan dan Ilmu Pendidikan"
                            {{ old('department') == 'Fakultas Keguruan dan Ilmu Pendidikan' ? 'selected' : '' }}>
                            Fakultas Keguruan dan Ilmu Pendidikan</option>
                        <option value="Fakultas Sastra" {{ old('department') == 'Fakultas Sastra' ? 'selected' : '' }}>
                            Fakultas Sastra</option>
                        <option value="Fakultas Seni dan Desain"
                            {{ old('department') == 'Fakultas Seni dan Desain' ? 'selected' : '' }}>Fakultas Seni dan
                            Desain</option>
                        <option value="Fakultas Teknik Sipil Perencanaan"
                            {{ old('department') == 'Fakultas Teknik Sipil Perencanaan' ? 'selected' : '' }}>Fakultas
                            Teknik Sipil Perencanaan</option>
                        <option value="Fakultas Teknologi Industri"
                            {{ old('department') == 'Fakultas Teknologi Industri' ? 'selected' : '' }}>Fakultas
                            Teknologi Industri</option>
                        <option value="International Business Accounting"
                            {{ old('department') == 'International Business Accounting' ? 'selected' : '' }}>
                            International Business Accounting</option>
                        <option value="Laboratorium Fisika"
                            {{ old('department') == 'Laboratorium Fisika' ? 'selected' : '' }}>Laboratorium Fisika
                        </option>
                        <option value="Lembaga Penelitian dan Pengabdian kepada Masyarakat"
                            {{ old('department') == 'Lembaga Penelitian dan Pengabdian kepada Masyarakat' ? 'selected' : '' }}>
                            Lembaga Penelitian dan Pengabdian kepada Masyarakat</option>
                        <option value="Magister Manajemen"
                            {{ old('department') == 'Magister Manajemen' ? 'selected' : '' }}>Magister Manajemen
                        </option>
                        <option value="Pendidikan Guru Sekolah Dasar"
                            {{ old('department') == 'Pendidikan Guru Sekolah Dasar' ? 'selected' : '' }}>Pendidikan
                            Guru Sekolah Dasar</option>
                        <option value="Pendidikan Profesi Insinyur"
                            {{ old('department') == 'Pendidikan Profesi Insinyur' ? 'selected' : '' }}>Pendidikan
                            Profesi Insinyur</option>
                        <option value="Petra Bussiness English"
                            {{ old('department') == 'Petra Bussiness English' ? 'selected' : '' }}>Petra Bussiness
                            English</option>
                        <option value="Program Akuntansi Bisnis"
                            {{ old('department') == 'Program Akuntansi Bisnis' ? 'selected' : '' }}>Program Akuntansi
                            Bisnis</option>
                        <option value="Program Akuntansi Pajak"
                            {{ old('department') == 'Program Akuntansi Pajak' ? 'selected' : '' }}>Program Akuntansi
                            Pajak</option>
                        <option value="Program Apresiasi dan Pengembangan Musik Gereja"
                            {{ old('department') == 'Program Apresiasi dan Pengembangan Musik Gereja' ? 'selected' : '' }}>
                            Program Apresiasi dan Pengembangan Musik Gereja</option>
                        <option value="Program Data Science And Analytics"
                            {{ old('department') == 'Program Data Science And Analytics' ? 'selected' : '' }}>Program
                            Data Science And Analytics</option>
                        <option value="Program Desain Fashion dan Tekstil"
                            {{ old('department') == 'Program Desain Fashion dan Tekstil' ? 'selected' : '' }}>Program
                            Desain Fashion dan Tekstil</option>
                        <option value="Program Digital Media"
                            {{ old('department') == 'Program Digital Media' ? 'selected' : '' }}>Program Digital Media
                        </option>
                        <option value="Program English For Business"
                            {{ old('department') == 'Program English For Business' ? 'selected' : '' }}>Program English
                            For Business</option>
                        <option value="Program English For Creative Industry"
                            {{ old('department') == 'Program English For Creative Industry' ? 'selected' : '' }}>
                            Program English For Creative Industry</option>
                        <option value="Program Interior Design And Styling"
                            {{ old('department') == 'Program Interior Design And Styling' ? 'selected' : '' }}>Program
                            Interior Design And Styling</option>
                        <option value="Program Interior Product Design"
                            {{ old('department') == 'Program Interior Product Design' ? 'selected' : '' }}>Program
                            Interior Product Design</option>
                        <option value="Program International Business Accounting"
                            {{ old('department') == 'Program International Business Accounting' ? 'selected' : '' }}>
                            Program International Business Accounting</option>
                        <option value="Program International Business Engineering"
                            {{ old('department') == 'Program International Business Engineering' ? 'selected' : '' }}>
                            Program International Business Engineering</option>
                        <option value="Program International Business Management"
                            {{ old('department') == 'Program International Business Management' ? 'selected' : '' }}>
                            Program International Business Management</option>
                        <option value="Program Internet Of Things"
                            {{ old('department') == 'Program Internet Of Things' ? 'selected' : '' }}>Program Internet
                            Of Things</option>
                        <option value="Program Manajemen Bisnis"
                            {{ old('department') == 'Program Manajemen Bisnis' ? 'selected' : '' }}>Program Manajemen
                            Bisnis</option>
                        <option value="Program Manajemen Kepariwisataan"
                            {{ old('department') == 'Program Manajemen Kepariwisataan' ? 'selected' : '' }}>Program
                            Manajemen Kepariwisataan</option>
                        <option value="Program Manajemen Keuangan"
                            {{ old('department') == 'Program Manajemen Keuangan' ? 'selected' : '' }}>Program Manajemen
                            Keuangan</option>
                        <option value="Program Manajemen Pemasaran"
                            {{ old('department') == 'Program Manajemen Pemasaran' ? 'selected' : '' }}>Program
                            Manajemen Pemasaran</option>
                        <option value="Program Manajemen Perhotelan"
                            {{ old('department') == 'Program Manajemen Perhotelan' ? 'selected' : '' }}>Program
                            Manajemen Perhotelan</option>
                        <option value="Program Otomotif"
                            {{ old('department') == 'Program Otomotif' ? 'selected' : '' }}>Program Otomotif</option>
                        <option value="Program Pascasarjana Magister Teknik Sipil"
                            {{ old('department') == 'Program Pascasarjana Magister Teknik Sipil' ? 'selected' : '' }}>
                            Program Pascasarjana Magister Teknik Sipil</option>
                        <option value="Program Pendidikan Bahasa"
                            {{ old('department') == 'Program Pendidikan Bahasa' ? 'selected' : '' }}>Program Pendidikan
                            Bahasa</option>
                        <option value="Program Pendidikan Berkelanjutan"
                            {{ old('department') == 'Program Pendidikan Berkelanjutan' ? 'selected' : '' }}>Program
                            Pendidikan Berkelanjutan</option>
                        <option value="Program Pendidikan Profesi Arsitek"
                            {{ old('department') == 'Program Pendidikan Profesi Arsitek' ? 'selected' : '' }}>Program
                            Pendidikan Profesi Arsitek</option>
                        <option value="Program Pendidikan Profesional Berkelanjutan"
                            {{ old('department') == 'Program Pendidikan Profesional Berkelanjutan' ? 'selected' : '' }}>
                            Program Pendidikan Profesional Berkelanjutan</option>
                        <option value="Program Pendidikan Kepariwisataan"
                            {{ old('department') == 'Program Pendidikan Kepariwisataan' ? 'selected' : '' }}>Program
                            Pendidikan Kepariwisataan</option>
                        <option value="Program Sistem Informasi Bisnis"
                            {{ old('department') == 'Program Sistem Informasi Bisnis' ? 'selected' : '' }}>Program
                            Sistem Informasi Bisnis</option>
                        <option value="Program Studi Akuntansi"
                            {{ old('department') == 'Program Studi Akuntansi' ? 'selected' : '' }}>Program Studi
                            Akuntansi</option>
                        <option value="Program Studi Bahasa Mandarin"
                            {{ old('department') == 'Program Studi Bahasa Mandarin' ? 'selected' : '' }}>Program Studi
                            Bahasa Mandarin</option>
                        <option value="Program Studi Desain Interior"
                            {{ old('department') == 'Program Studi Desain Interior' ? 'selected' : '' }}>Program Studi
                            Desain Interior</option>
                        <option value="Program Studi Desain Komunikasi Visual"
                            {{ old('department') == 'Program Studi Desain Komunikasi Visual' ? 'selected' : '' }}>
                            Program Studi Desain Komunikasi Visual</option>
                        <option value="Program Studi Doktor Teknik Sipil"
                            {{ old('department') == 'Program Studi Doktor Teknik Sipil' ? 'selected' : '' }}>Program
                            Studi Doktor Teknik Sipil</option>
                        <option value="Program Studi Ilmu Komunikasi"
                            {{ old('department') == 'Program Studi Ilmu Komunikasi' ? 'selected' : '' }}>Program Studi
                            Ilmu Komunikasi</option>
                        <option value="Program Studi Magister Arsitektur"
                            {{ old('department') == 'Program Studi Magister Arsitektur' ? 'selected' : '' }}>Program
                            Studi Magister Arsitektur</option>
                        <option value="Program Studi Magister Manajemen"
                            {{ old('department') == 'Program Studi Magister Manajemen' ? 'selected' : '' }}>Program
                            Studi Magister Manajemen</option>
                        <option value="Program Studi Magister Sastra"
                            {{ old('department') == 'Program Studi Magister Sastra' ? 'selected' : '' }}>Program Studi
                            Magister Sastra</option>
                        <option value="Program Studi Magister Teknik Industri"
                            {{ old('department') == 'Program Studi Magister Teknik Industri' ? 'selected' : '' }}>
                            Program Studi Magister Teknik Industri</option>
                        <option value="Program Studi Magister Teknik Sipil"
                            {{ old('department') == 'Program Studi Magister Teknik Sipil' ? 'selected' : '' }}>Program
                            Studi Magister Teknik Sipil</option>
                        <option value="Program Studi Manajemen"
                            {{ old('department') == 'Program Studi Manajemen' ? 'selected' : '' }}>Program Studi
                            Manajemen</option>
                        <option value="Program Studi PG-Pendidikan Anak Usia Dini"
                            {{ old('department') == 'Program Studi PG-Pendidikan Anak Usia Dini' ? 'selected' : '' }}>
                            Program Studi PG-Pendidikan Anak Usia Dini</option>
                        <option value="Program Studi Sastra Inggris"
                            {{ old('department') == 'Program Studi Sastra Inggris' ? 'selected' : '' }}>Program Studi
                            Sastra Inggris</option>
                        <option value="Program Studi Sastra Tionghoa"
                            {{ old('department') == 'Program Studi Sastra Tionghoa' ? 'selected' : '' }}>Program Studi
                            Sastra Tionghoa</option>
                        <option value="Program Studi Teknik Arsitektur"
                            {{ old('department') == 'Program Studi Teknik Arsitektur' ? 'selected' : '' }}>Program
                            Studi Teknik Arsitektur</option>
                        <option value="Program Studi Teknik Elektro"
                            {{ old('department') == 'Program Studi Teknik Elektro' ? 'selected' : '' }}>Program Studi
                            Teknik Elektro</option>
                        <option value="Program Studi Teknik Industri"
                            {{ old('department') == 'Program Studi Teknik Industri' ? 'selected' : '' }}>Program Studi
                            Teknik Industri</option>
                        <option value="Program Studi Teknik Informatika"
                            {{ old('department') == 'Program Studi Teknik Informatika' ? 'selected' : '' }}>Program
                            Studi Teknik Informatika</option>
                        <option value="Program Studi Teknik Mesin"
                            {{ old('department') == 'Program Studi Teknik Mesin' ? 'selected' : '' }}>Program Studi
                            Teknik Mesin</option>
                        <option value="Program Studi Teknik Sipil"
                            {{ old('department') == 'Program Studi Teknik Sipil' ? 'selected' : '' }}>Program Studi
                            Teknik Sipil</option>
                        <option value="Program Sustainable Mechanical Engineering Design"
                            {{ old('department') == 'Program Sustainable Mechanical Engineering Design' ? 'selected' : '' }}>
                            Program Sustainable Mechanical Engineering Design</option>
                        <option value="Pusat Penelitian"
                            {{ old('department') == 'Pusat Penelitian' ? 'selected' : '' }}>Pusat Penelitian</option>
                    </select>
                </div>
                @error('department')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb">
                <label for="categories" class="form-label" required>Categories*</label>
                <div class="mb-3">
                    <select class="form-select" name="categories">
                        <option value="empty" {{ old('categories') == '' ? 'selected' : '' }}>Select Categories
                        </option>
                        <option value="Autobiography" {{ old('categories') == 'Autobiography' ? 'selected' : '' }}>
                            Autobiography </option>
                        <option value="Archieve" {{ old('categories') == 'Archieve' ? 'selected' : '' }}>Archieve
                        </option>
                        <option value="Banner" {{ old('categories') == 'Banner' ? 'selected' : '' }}>Banner</option>
                        <option value="Book Cover" {{ old('categories') == 'Book Cover' ? 'selected' : '' }}>Book
                            Cover</option>
                        <option value="Book" {{ old('categories') == 'Book' ? 'selected' : '' }}>Book</option>
                        <option value="Brochure" {{ old('categories') == 'Brochure' ? 'selected' : '' }}>Brochure
                        </option>
                        <option value="Clipping" {{ old('categories') == 'Clipping' ? 'selected' : '' }}>Clipping
                        </option>
                        <option value="Course" {{ old('categories') == 'Course' ? 'selected' : '' }}>Course</option>
                        <option value="D2" {{ old('categories') == 'D2' ? 'selected' : '' }}>D2</option>
                        <option value="D3" {{ old('categories') == 'D3' ? 'selected' : '' }}>D3</option>
                        <option value="Digital Image" {{ old('categories') == 'Digital Image' ? 'selected' : '' }}>
                            Digital Image</option>
                        <option value="E-book" {{ old('categories') == 'E-book' ? 'selected' : '' }}>E-book</option>
                        <option value="Events" {{ old('categories') == 'Events' ? 'selected' : '' }}>Events</option>
                        <option value="Fashion Design" {{ old('categories') == 'Fashion Design' ? 'selected' : '' }}>
                            Fashion Design</option>
                        <option value="Graphic Art" {{ old('categories') == 'Graphic Art' ? 'selected' : '' }}>Graphic
                            Art</option>
                        <option value="Guidebook" {{ old('categories') == 'Guidebook' ? 'selected' : '' }}>Guidebook
                        </option>
                        <option value="History" {{ old('categories') == 'History' ? 'selected' : '' }}>History
                        </option>
                        <option value="Magazine" {{ old('categories') == 'Magazine' ? 'selected' : '' }}>Magazine
                        </option>
                        <option value="Media" {{ old('categories') == 'Media' ? 'selected' : '' }}>Media</option>
                        <option value="Monograph" {{ old('categories') == 'Monograph' ? 'selected' : '' }}>Monograph
                        </option>
                        <option value="Motion Pictures / Visual Work"
                            {{ old('categories') == 'Motion Pictures / Visual Work' ? 'selected' : '' }}>Motion
                            Pictures / Visual Work</option>
                        <option value="Newsletter" {{ old('categories') == 'Newsletter' ? 'selected' : '' }}>
                            Newsletter</option>
                        <option value="Newspaper" {{ old('categories') == 'Newspaper' ? 'selected' : '' }}>Newspaper
                        </option>
                        <option value="Patterns Design Element"
                            {{ old('categories') == 'Patterns Design Element' ? 'selected' : '' }}>Patterns Design
                            Element</option>
                        <option value="Photojournalism"
                            {{ old('categories') == 'Photojournalism' ? 'selected' : '' }}>Photojournalism</option>
                        <option value="Political Cartoon"
                            {{ old('categories') == 'Political Cartoon' ? 'selected' : '' }}>Political Cartoon
                        </option>
                        <option value="Postcard" {{ old('categories') == 'Postcard' ? 'selected' : '' }}>Postcard
                        </option>
                        <option value="Poster" {{ old('categories') == 'Poster' ? 'selected' : '' }}>Poster</option>
                        <option value="Publication" {{ old('categories') == 'Publication' ? 'selected' : '' }}>
                            Publication</option>
                        <option value="Quiz" {{ old('categories') == 'Quiz' ? 'selected' : '' }}>Quiz</option>
                        <option value="Report" {{ old('categories') == 'Report' ? 'selected' : '' }}>Report</option>
                        <option value="Research Document"
                            {{ old('categories') == 'Research Document' ? 'selected' : '' }}>Research Document
                        </option>
                        <option value="S1" {{ old('categories') == 'S1' ? 'selected' : '' }}>S1</option>
                        <option value="S2" {{ old('categories') == 'S2' ? 'selected' : '' }}>S2</option>
                        <option value="S3" {{ old('categories') == 'S3' ? 'selected' : '' }}>S3</option>
                        <option value="Short Story" {{ old('categories') == 'Short Story' ? 'selected' : '' }}>Short
                            Story</option>
                        <option value="Visual Poetry" {{ old('categories') == 'Visual Poetry' ? 'selected' : '' }}>
                            Visual Poetry</option>
                        <option value="Website" {{ old('categories') == 'Website' ? 'selected' : '' }}>Website
                        </option>
                        <option value="Yearbook" {{ old('categories') == 'Yearbook' ? 'selected' : '' }}>Yearbook
                        </option>
                    </select>
                </div>
                @error('categories')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb">
                <label for="subcategories" class="form-label" required>Sub-Categories*</label>
                <div class="mb-3">
                    <select class="form-select" name="subcategories">
                        <option value="empty" {{ old('subcategories') == '' ? 'selected' : '' }}>Select
                            Subcategories</option>
                        <option value="Audio Visual dan Animasi"
                            {{ old('subcategories') == 'Audio Visual dan Animasi' ? 'selected' : '' }}>Audio Visual
                            dan Animasi</option>
                        <option value="Board Game" {{ old('subcategories') == 'Board Game' ? 'selected' : '' }}>Board
                            Game</option>
                        <option value="Buku" {{ old('subcategories') == 'Buku' ? 'selected' : '' }}>Buku</option>
                        <option value="Branding" {{ old('subcategories') == 'Branding' ? 'selected' : '' }}>Branding
                        </option>
                        <option value="Branding dan Promosi"
                            {{ old('subcategories') == 'Branding dan Promosi' ? 'selected' : '' }}>Branding dan
                            Promosi</option>
                        <option value="Branding Design"
                            {{ old('subcategories') == 'Branding Design' ? 'selected' : '' }}>Branding Design</option>
                        <option value="Brand Komunikasi dan Fashion Produk"
                            {{ old('subcategories') == 'Brand Komunikasi dan Fashion Produk' ? 'selected' : '' }}>
                            Brand Komunikasi dan Fashion Produk</option>
                        <option value="Buku Concept Art"
                            {{ old('subcategories') == 'Buku Concept Art' ? 'selected' : '' }}>Buku Concept Art
                        </option>
                        <option value="Buku Fotografi Referensi"
                            {{ old('subcategories') == 'Buku Fotografi Referensi' ? 'selected' : '' }}>Buku Fotografi
                            Referensi</option>
                        <option value="Buku Ilustrasi"
                            {{ old('subcategories') == 'Buku Ilustrasi' ? 'selected' : '' }}>Buku Ilustrasi</option>
                        <option value="Buku Interaktif"
                            {{ old('subcategories') == 'Buku Interaktif' ? 'selected' : '' }}>Buku Interaktif</option>
                        <option value="Business Innovation/Inovasi Bisnis"
                            {{ old('subcategories') == 'Business Innovation/Inovasi Bisnis' ? 'selected' : '' }}>
                            Business Innovation/Inovasi Bisnis</option>
                        <option value="Company Profile"
                            {{ old('subcategories') == 'Company Profile' ? 'selected' : '' }}>Company Profile</option>
                        <option value="Creative Thesis"
                            {{ old('subcategories') == 'Creative Thesis' ? 'selected' : '' }}>Creative Thesis</option>
                        <option value="Critical Thesis"
                            {{ old('subcategories') == 'Critical Thesis' ? 'selected' : '' }}>Critical Thesis</option>
                        <option value="Desain Grafis"
                            {{ old('subcategories') == 'Desain Grafis' ? 'selected' : '' }}>Desain Grafis</option>
                        <option value="Desain Kemasan"
                            {{ old('subcategories') == 'Desain Kemasan' ? 'selected' : '' }}>Desain Kemasan</option>
                        <option value="Desain Motif" {{ old('subcategories') == 'Desain Motif' ? 'selected' : '' }}>
                            Desain Motif</option>
                        <option value="Desain Website"
                            {{ old('subcategories') == 'Desain Website' ? 'selected' : '' }}>Desain Website</option>
                        <option value="Digital Marketing"
                            {{ old('subcategories') == 'Digital Marketing' ? 'selected' : '' }}>Digital Marketing
                        </option>
                        <option value="Disertasi" {{ old('subcategories') == 'Disertasi' ? 'selected' : '' }}>
                            Disertasi</option>
                        <option value="E-book Ilustrasi Berseri"
                            {{ old('subcategories') == 'E-book Ilustrasi Berseri' ? 'selected' : '' }}>E-book
                            Ilustrasi Berseri</option>
                        <option value="Educational Media"
                            {{ old('subcategories') == 'Educational Media' ? 'selected' : '' }}>Educational Media
                        </option>
                        <option value="Fashion Branding"
                            {{ old('subcategories') == 'Fashion Branding' ? 'selected' : '' }}>Fashion Branding
                        </option>
                        <option value="Fashion Design"
                            {{ old('subcategories') == 'Fashion Design' ? 'selected' : '' }}>Fashion Design</option>
                        <option value="Final Project"
                            {{ old('subcategories') == 'Final Project' ? 'selected' : '' }}>Final Project</option>
                        <option value="Fotografi" {{ old('subcategories') == 'Fotografi' ? 'selected' : '' }}>
                            Fotografi</option>
                        <option value="Identitas Perusahaan"
                            {{ old('subcategories') == 'Identitas Perusahaan' ? 'selected' : '' }}>Identitas
                            Perusahaan</option>
                        <option value="Iklan Layanan Masyarakat"
                            {{ old('subcategories') == 'Iklan Layanan Masyarakat' ? 'selected' : '' }}>Iklan Layanan
                            Masyarakat</option>
                        <option value="Inovasi Bisnis"
                            {{ old('subcategories') == 'Inovasi Bisnis' ? 'selected' : '' }}>Inovasi Bisnis</option>
                        <option value="Kampanye Komersial"
                            {{ old('subcategories') == 'Kampanye Komersial' ? 'selected' : '' }}>Kampanye Komersial
                        </option>
                        <option value="Kampanye Komersil dan Sosial"
                            {{ old('subcategories') == 'Kampanye Komersil dan Sosial' ? 'selected' : '' }}>Kampanye
                            Komersil dan Sosial</option>
                        <option value="Kampanye Sosial"
                            {{ old('subcategories') == 'Informatika' ? 'selected' : '' }}>Kampanye Sosial</option>
                        <option value="Ilustrasi" {{ old('subcategories') == 'Ilustrasi' ? 'selected' : '' }}>
                            Ilustrasi</option>
                        <option value="Komik Web" {{ old('subcategories') == 'Komik Web' ? 'selected' : '' }}>Komik
                            Web</option>
                        <option value="Komunikasi Pemasaran"
                            {{ old('subcategories') == 'Komunikasi Pemasaran' ? 'selected' : '' }}>Komunikasi
                            Pemasaran</option>
                        <option value="Laporan Karya"
                            {{ old('subcategories') == 'Laporan Karya' ? 'selected' : '' }}>Laporan Karya</option>
                        <option value="Laporan Perancangan Arsitektur"
                            {{ old('subcategories') == 'Laporan Perancangan Arsitektur' ? 'selected' : '' }}>Laporan
                            Perancangan Arsitektur</option>
                        <option value="Laporan" {{ old('subcategories') == 'Laporan' ? 'selected' : '' }}>Laporan
                        </option>
                        <option value="Magang" {{ old('subcategories') == 'Magang' ? 'selected' : '' }}>Magang
                        </option>
                        <option value="Manajemen Produk"
                            {{ old('subcategories') == 'Manajemen Produk' ? 'selected' : '' }}>Manajemen Produk
                        </option>
                        <option value="Media Cetak" {{ old('subcategories') == 'Media Cetak' ? 'selected' : '' }}>
                            Media Cetak</option>
                        <option value="Media Edukatif"
                            {{ old('subcategories') == 'Media Edukatif' ? 'selected' : '' }}>Media Edukatif</option>
                        <option value="Media Interaktif"
                            {{ old('subcategories') == 'Media Interaktif' ? 'selected' : '' }}>Media Interaktif
                        </option>
                        <option value="Media Promosi Online"
                            {{ old('subcategories') == 'Media Promosi Online' ? 'selected' : '' }}>Media Promosi
                            Online</option>
                        <option value="Motion Graphic"
                            {{ old('subcategories') == 'Motion Graphic' ? 'selected' : '' }}>Motion Graphic</option>
                        <option value="Multimedia Interaktif"
                            {{ old('subcategories') == 'Multimedia Interaktif' ? 'selected' : '' }}>Multimedia
                            Interaktif</option>
                        <option value="Pemberdayaan Masyarakat"
                            {{ old('subcategories') == 'Pemberdayaan Masyarakat' ? 'selected' : '' }}>Pemberdayaan
                            Masyarakat</option>
                        <option value="Pengembangan Merek"
                            {{ old('subcategories') == 'Pengembangan Merek' ? 'selected' : '' }}>Pengembangan Merek
                        </option>
                        <option value="Penjualan dan Distribusi"
                            {{ old('subcategories') == 'Penjualan dan Distribusi' ? 'selected' : '' }}>Penjualan dan
                            Distribusi</option>
                        <option value="Perancangan" {{ old('subcategories') == 'Perancangan' ? 'selected' : '' }}>
                            Perancangan</option>
                        <option value="Perancangan dan Promosi Buku"
                            {{ old('subcategories') == 'Perancangan dan Promosi Buku' ? 'selected' : '' }}>Perancangan
                            dan Promosi Buku</option>
                        <option value="Perancangan Fashion"
                            {{ old('subcategories') == 'Perancangan Fashion' ? 'selected' : '' }}>Perancangan Fashion
                        </option>
                        <option value="Perancangan Grafis"
                            {{ old('subcategories') == 'Perancangan Grafis' ? 'selected' : '' }}>Perancangan Grafis
                        </option>
                        <option value="Perancangan Interior"
                            {{ old('subcategories') == 'Perancangan Interior' ? 'selected' : '' }}>Perancangan
                            Interior</option>
                        <option value="Perancangan Komunikasi Visual"
                            {{ old('subcategories') == 'Perancangan Komunikasi Visual' ? 'selected' : '' }}>
                            Perancangan Komunikasi Visual</option>
                        <option value="Perancangan Majalah Fashion"
                            {{ old('subcategories') == 'Perancangan Majalah Fashion' ? 'selected' : '' }}>Perancangan
                            Majalah Fashion</option>
                        <option value="Perancangan Media Komunikasi Visual"
                            {{ old('subcategories') == 'Perancangan Media Komunikasi Visual' ? 'selected' : '' }}>
                            Perancangan Media Komunikasi Visual</option>
                        <option value="Perancangan Start-Up"
                            {{ old('subcategories') == 'Perancangan Start-Up' ? 'selected' : '' }}>Perancangan
                            Start-Up</option>
                        <option value="Perancangan Webtoon"
                            {{ old('subcategories') == 'Perancangan Webtoon' ? 'selected' : '' }}>Perancangan Webtoon
                        </option>
                        <option value="Perencanaan Keuangan"
                            {{ old('subcategories') == 'Perencanaan Keuangan' ? 'selected' : '' }}>Perencanaan
                            Keuangan</option>
                        <option value="Perencanaan Pemasaran"
                            {{ old('subcategories') == 'Perencanaan Pemasaran' ? 'selected' : '' }}>Perencanaan
                            Pemasaran</option>
                        <option value="Periklanan" {{ old('subcategories') == 'Periklanan' ? 'selected' : '' }}>
                            Periklanan</option>
                        <option value="Picture Book" {{ old('subcategories') == 'Picture Book' ? 'selected' : '' }}>
                            Picture Book</option>
                        <option value="Presentasi" {{ old('subcategories') == 'Presentasi' ? 'selected' : '' }}>
                            Presentasi</option>
                        <option value="Promosi" {{ old('subcategories') == 'Promosi' ? 'selected' : '' }}>Promosi
                        </option>
                        <option value="Promosi Periklanan"
                            {{ old('subcategories') == 'Promosi Periklanan' ? 'selected' : '' }}>Promosi Periklanan
                        </option>
                        <option value="Promosi Produk"
                            {{ old('subcategories') == 'Promosi Produk' ? 'selected' : '' }}>Promosi Produk</option>
                        <option value="Promotion Media"
                            {{ old('subcategories') == 'Promotion Media' ? 'selected' : '' }}>Promotion Media</option>
                        <option value="Rancangan Desain Komunikasi Visual"
                            {{ old('subcategories') == 'Rancangan Desain Komunikasi Visual' ? 'selected' : '' }}>
                            Rancangan Desain Komunikasi Visual</option>
                        <option value="Rancangan Mesin"
                            {{ old('subcategories') == 'Rancangan Mesin' ? 'selected' : '' }}>Rancangan Mesin</option>
                        <option value="Rancangan Pengecoran"
                            {{ old('subcategories') == 'Rancangan Pengecoran' ? 'selected' : '' }}>Rancangan
                            Pengecoran</option>
                        <option value="Rancangan Produk atau Alat"
                            {{ old('subcategories') == 'Rancangan Produk atau Alat' ? 'selected' : '' }}>Rancangan
                            Produk atau Alat</option>
                        <option value="Rancangan Struktur"
                            {{ old('subcategories') == 'Rancangan Struktur' ? 'selected' : '' }}>Rancangan Struktur
                        </option>
                        <option value="Rancangan System"
                            {{ old('subcategories') == 'Rancangan System' ? 'selected' : '' }}>Rancangan System
                        </option>
                        <option value="Rancangan Usaha"
                            {{ old('subcategories') == 'Rancangan Usaha' ? 'selected' : '' }}>Rancangan Usaha</option>
                        <option value="Rangkuman Karya Ilmiah"
                            {{ old('subcategories') == 'Rangkuman Karya Ilmiah' ? 'selected' : '' }}>Rangkuman Karya
                            Ilmiah</option>
                        <option value="Riset Pemasaran"
                            {{ old('subcategories') == 'Riset Pemasaran' ? 'selected' : '' }}>Riset Pemasaran</option>
                        <option value="Skripsi" {{ old('subcategories') == 'Skripsi' ? 'selected' : '' }}>Skripsi
                        </option>
                        <option value="Social Campaign"
                            {{ old('subcategories') == 'Social Campaign' ? 'selected' : '' }}>Social Campaign</option>
                        <option value="Social Care" {{ old('subcategories') == 'Social Care' ? 'selected' : '' }}>
                            Social Care</option>
                        <option value="Sociopreneurship"
                            {{ old('subcategories') == 'Sociopreneurship' ? 'selected' : '' }}>Sociopreneurship
                        </option>
                        <option value="Socio Start-Up"
                            {{ old('subcategories') == 'Socio Start-Up' ? 'selected' : '' }}>Socio Start-Up</option>
                        <option value="Tesis" {{ old('subcategories') == 'Tesis' ? 'selected' : '' }}>Tesis</option>
                        <option value="Tugas Akhir" {{ old('subcategories') == 'Tugas Akhir' ? 'selected' : '' }}>
                            Tugas Akhir</option>
                        <option value="Video Company Profile"
                            {{ old('subcategories') == 'Video Company Profile' ? 'selected' : '' }}>Video Company
                            Profile</option>
                    </select>
                </div>
                @error('subcategories')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Post Thumbnail</label>
                <img class="thumbnail-preview img-fluid mb-3 col-sm-3">
                <input class="form-control" type="file" id="thumbnail" name="thumbnail"
                    onchange="previewThumbnail()" accept="image/*" @error('thumbnail') is-invalid @enderror>
                {{-- <small class="form-text text-muted">Allowed thumbnail format: jpg, jpeg,
                    png</small> --}}
                <div id="thumbnailHelp" class="form-text" style="font-size:12px;">Allowed thumbnail format: jpg,
                    jpeg,
                    png</div>
                {{-- <div id="thumbnailHelp" class="form-text" style="font-size:12px;">Picture must have one of the following ratios: 16:9, 3:4, 4:3</div> --}}
                @error('thumbnail')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-3 d-grid">
                <button type="submit" class="btn btn-primary">Next (Add Post File)</button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('trix-file-accept', function(e) {
            e.preventDefault();
        })

        function previewThumbnail() {
            const image = document.querySelector('#thumbnail');
            const imgPreview = document.querySelector('.thumbnail-preview');

            imgPreview.style.display = 'block';

            const fileURL = URL.createObjectURL(image.files[0]);
            imgPreview.src = fileURL;
        }

        document.addEventListener('trix-initialize', function(event) {
            var trixEditor = event.target;
            var descriptionInput = document.getElementById('description');

            // Set nilai editor dengan nilai dari input tersembunyi
            trixEditor.editor.insertHTML(descriptionInput.value);
        });
    </script>
</body>

</html>
