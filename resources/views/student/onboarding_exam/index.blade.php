@extends('layout.index')

@section('title', 'On Boarding')

@section('content')
<div class="container">
    <!-- Link Back -->
    <a class="btn-back" href="{{ url('student/'.$assessmentGroupId.'/subjects') }}">
        <i class="kejar-back"></i>Kembali
    </a>
    <!-- Breadcrumb -->
    <nav class="breadcrumb">
        <a class="breadcrumb-item" href="{{ url('student/dashboard') }}">Beranda</a>
        <a class="breadcrumb-item" id="breadcrumb-1" href="{{ url('student/'.$assessmentGroupId.'/subjects') }}"></a>
    </nav>
    <!-- Title -->
    <div class="page-title">
        <h2 id="title" class="mb-08rem">{{ $assessment['subject']['name'] }}</h2>
    </div>

    <!-- Content -->

    <div class="mt-8">
        <h5>Durasi</h5>
        <!-- Dynamic Data -->
        <h5 id="duration" class="text-reguler">{{ $assessment['duration'] ?? 0 }} menit</h5>
    </div>

    <div class="mt-8">
        <h5>Banyaknya Soal</h5>
        <!-- Dynamic Data -->
        <h5 id="total-question" class="text-reguler">{{ $assessment['total_questions'] ?? 0 }} butir soal</h5>
    </div>

    @if($assessment['type'] === "ASSESSMENT")
    <div class="mt-8">
        <h5>Token</h5>
        <p>Masukkan token yang telah dibagikan oleh guru.</p>
        <!-- Dynamic Data -->
        <input type="text" placeholder="Ketik Token" id="assessmentToken" />
    </div>

    <div class="mt-8 onboarding-page-pts">
        @include('student.onboarding_exam._rule_assessment')
    </div>
    @else
    <div class="mt-8 onboarding-page-pts">
        @include('student.onboarding_exam._rule_mini_assessment')
    </div>
    @endif



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
    $('#play').on('click', function() {
        const trueToken = "{{ $assessment['schedule']['token'] }}"
        const token = $.trim($("#assessmentToken").val());
        const type = "{{ $assessment['type'] }}";
        const assessmentGroupId = "{{ $assessment['assessment_group_id'] }}";
        const assessmentId = "{{ $assessment['id'] }}";
        const scheduleId = "{{ $assessment['schedule']['id'] }}";

        if (type === "ASSESSMENT") {
            if (trueToken === token) {
                if (typeof window !== 'undefined') {
                    window.location.href = `/student/${assessmentGroupId}/subjects/${assessmentId}/proceed/${scheduleId}`
                }
            } else {
                alert("Token/Password tidak sesuai, silakan cek kembali!");
            }
        } else {
            if (typeof window !== 'undefined') {
                window.location.href = `/student/${assessmentGroupId}/subjects/${assessmentId}/proceed/${scheduleId}`
            }
        }
    });
</script>
@endpush
