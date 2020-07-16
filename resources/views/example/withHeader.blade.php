@extends('./layout/index')

@section('title', 'Judul Halaman')

@section('content')
    <div class="container">
        <!-- Link Back -->
        <a class ="btn-back" href="">
            <i class="kejar-back"></i>Kembali
        </a>
        <!-- Breadcrumb -->
        <nav class="breadcrumb">
            <a class="breadcrumb-item" href="">Beranda</a>
            <a class="breadcrumb-item" href="">OBR</a>
            <a class="breadcrumb-item" href="">Babak 1</a>
            <span class="breadcrumb-item active">Ronde 1</span>
        </nav>
        <!-- Title -->
        <div class="page-title">
            <h2 class="mb-08rem">Ini Judul Babak atau Ronde</h2>
            <span class="copy-id" onclick="">Salin ID Ronde</span>
        </div>

        <!-- Upload Buttons -->
        <div class="upload-buttons">
            <button class="btn-upload" data-toggle="modal" data-target="">
                <i class="kejar-upload"></i>Unggah Babak
            </button>
            <button class="btn-upload" data-toggle="modal" data-target="">
                <i class="kejar-upload"></i>Unggah Ronde
            </button>
        </div>

        <!-- List of Stages (Admin)-->
        <div class="list-group">       
            <div class="list-group-item">
                <a href="#">
                    <i class="kejar-ink"></i>
                    Ini Judul Babak dalam Permainan
                </a>
                <!-- <div class="hover-only"> -->
                    <div class="stage-order-buttons">
                        <button class="btn-icon">
                            <i class="kejar-top"></i>
                        </button>
                        <button class="btn-icon">
                            <i class="kejar-bottom"></i>
                        </button>
                    </div>
                <!-- </div> -->
            </div>
        </div>


    </div>
@endsection
