@extends('layout.index')

@section('title', 'On Boarding')

@section('content')
    <div class="container">
        <!-- Link Back -->
        <a class ="btn-back" href="{{ url('student/mini_assessment') }}">
            <i class="kejar-back"></i>Kembali
        </a>
        <!-- Breadcrumb -->
        <nav class="breadcrumb">
            <a class="breadcrumb-item" href="{{ url('student/games') }}">Beranda</a>
            <a class="breadcrumb-item" id="breadcrumb-1" href="{{ url('student/mini_assessment') }}"></a>
        </nav>
        <!-- Title -->
        <div class="page-title">
            <h2 id="title" class="mb-08rem"></h2>
        </div>

        <!-- Content -->
        <div class="mt-8">
            <h5>Waktu Pelaksanaan</h5>
            <!-- Dynamic Data -->
            <h5 id="date" class="text-reguler">{{ $task['mini_assessment']['start_date'] }}</h5>
            <h5 id="time" class="text-reguler">{{ $task['mini_assessment']['start_time'] }} - {{ $task['mini_assessment']['expiry_time'] }}</h5>
        </div>

        <div class="mt-8">
            <h5>Durasi</h5>
            <!-- Dynamic Data -->
            <h5 id="duration" class="text-reguler">{{ $task['mini_assessment']['duration'] }} menit</h5>
        </div>

        <div class="mt-8">
            <h5>Banyaknya Soal</h5>
            <!-- Dynamic Data -->
            <h5 id="total-question" class="text-reguler">{{ count($task['answers']) }} soal</h5>
        </div>

        <div class="mt-8 onboarding-page-pts">
            <p class="text-bold">Petunjuk Pengerjaan</p>
            <div class="row">
                <div class="pts-number">1.</div>
                <div class="col mt-1">
                    <p>Penilaian hanya dapat dikerjakan pada tanggal dan waktu yang telah ditetapkan.</p>
                </div>
            </div>
            <div class="row">
                <div class="pts-number">2.</div>
                <div class="col mt-1">
                    <p>Naskah soal terkunci dengan password/token. Password/token tersebut dibagikan oleh guru pada saat ujian berlangsung.</p>
                </div>
            </div>
            <div class="row">
                <div class="pts-number">3.</div>
                <div class="col mt-1">
                    <p>Penilaian terdiri dari tipe soal pilihan ganda (hanya ada satu jawaban benar) dan menceklis daftar (dapat ada lebih dari satu jawaban benar). Ikuti petunjuk pada setiap bagian.</p>
                </div>
            </div>
            <div class="row">
                <div class="pts-number">4.</div>
                <div class="col mt-1">
                    <p>Sebelum mengeklik tombol selesai, pastikan bahwa salinan lembar jawaban telah diunduh. Simpan salinan lembar jawaban tersebut baik-baik.</p>
                </div>
            </div>
            <div class="row">
                <div class="pts-number">5.</div>
                <div class="col mt-1">
                    <p>Kerjakan penilaian dengan jujur, cermat, dan saksama. Segala bentuk ketidakjujuran akan dikenakan sanksi.</p>
                </div>
            </div>
        </div>

        <!-- Button -->
        <!-- <div class="stage-order-buttons"> -->
        <div class="row justify-content-end px-4 mt-9">
            <div id="play" class="pts-btn-next" role="button">
                <h3>Mulai</h3>
                <i class="kejar-play"></i>
            </div>
        </div>
        <!-- </div> -->
    </div>
@endsection

@push('script')
<script>
    $('#breadcrumb-1').html(localStorage.getItem('pts_title') || '');
    $('#title').html(localStorage.getItem('detail_title') || '');
    $('title').html('On Boarding - ' + localStorage.getItem('pts_title') || '');

    $('#play').on('click', function() {
        if (typeof window !== 'undefined') {
            window.location.href = "/student/mini_assessment/{{ $task['subject_id'] }}?save=true"
        }
    });
</script>
@endpush
