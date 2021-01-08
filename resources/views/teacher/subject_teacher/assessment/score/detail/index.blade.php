@extends('layout.index')

@section('title', 'Detail Nilai')

@section('content')
<div class="container-lg">

    <!-- Link Back -->
    <a class="btn-back" href="{{ url('/teacher/'.$teacherType.'/'.$assessmentGroupId.'/subject/'.$subject['id'].'/'.$grade.'/assessment/student-group/'.$studentGroup['id'].'/score') }}">
        <i class="kejar-back"></i>Kembali
    </a>

    <div class="row">
        <div class="col-10">
            <nav class="breadcrumb">
                <a class="breadcrumb-item" href="{{ url('/teacher/games') }}">Beranda</a>
                <a class="breadcrumb-item" href="{{ url('/teacher/'.$teacherType.'/'.$assessmentGroupId.'/subject') }}">{{$assessmentGroup}}</a>
                <span class="breadcrumb-item active">{{$subject['name']}}</span>
            </nav>
            <div class="page-title">
                <h2 class="mb-08rem">{{$studentDetail['name']}}</h2>
                <h5-reg class="text-grey-6">{{$studentDetail['nis']}} | {{$studentGroup['name']}}</h5-reg>
            </div>
        </div>
        <div class="col-2 justify-content-end">
            <div class="card-score">
                <div class="header-score bg-grey-15">
                    <h6-reg>Nilai Akhir</h6-reg>
                </div>
                <div class="body-score">
                    @if($task['final_score'])
                    <h2 data-toggle="modal" style="cursor: pointer;" data-target="#updateScore" class="finalScore text-grey-6">{{$task['final_score']}}</h2>
                    @else
                    <h2 data-toggle="modal" style="cursor: pointer;" data-target="#updateScore" class="finalScore text-grey-6">Input</h2>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="pb-6">
        <div>
            <h5>Nilai Rekomendasi</h5>
        </div>
        <div>
            <h5-reg>{{$task['score']}}</h5-reg>
        </div>
    </div>

    <div class="pb-6">
        <div>
            <h5>Hasil Penilaian</h5>
        </div>
        <div>
            <h5-reg>Benar = {{$task['answer_status']['correct']}} soal | Salah = {{$task['answer_status']['wrong']}} soal | Kosong = {{$task['answer_status']['empty']}} soal</h5-reg>
        </div>
    </div>

    <div class="pb-6">
        <div>
            <h5>Waktu Mulai dan Selesai</h5>
        </div>
        <div>
            <h5-reg>{{$time}}, {{$firstTime}} s.d. {{$secondTime}}</h5-reg>
        </div>
        <div>
            <h5-reg>{{$duration}} menit</h5-reg>
        </div>
    </div>

    <div class="pb-6">
        <div>
            <h5>Catatan Siswa</h5>
        </div>
        @if(isset($task['schedule']['notes']['student']) && $task['schedule']['notes']['student'] !== null)
        <div>
            <h5-reg>{{$task['schedule']['notes']['student']}}</h5-reg>
        </div>
        @else
        <div>
            <h5-reg class="text-grey-6">Tidak ada catatan.</h5-reg>
        </div>
        @endif
    </div>

    <div class="pb-6">
        <div>
            <h5>Catatan Pengawas</h5>
        </div>
        @if(isset($task['schedule']['notes']['teacher']) && $task['schedule']['notes']['teacher'] !== null)
        <div>
            <h5-reg>{{$task['schedule']['notes']['teacher']}}</h5-reg>
        </div>
        @else
        <div>
            <h5-reg class="text-grey-6">Tidak ada catatan.</h5-reg>
        </div>
        @endif
    </div>

    <div class="pb-6">
        <div class="pb-4">
            <h3 class="title-question" style="display: none;">Jawaban Siswa</h3>
        </div>
        <div id="question-list">
            <button onclick="viewQuestion()" class="btn-upload d-flex justify-content-center font-15">
                Tampilkan Soal dan Jawaban
            </button>
        </div>
    </div>

</div>

@include('teacher.subject_teacher.assessment.score.detail._update_score')
@endsection

@push('script')
<script type="text/javascript">
    function editScore(id) {
        if ($("#finalScore").val() === "") {
            alert('Terjadi kesalahan, Nilai tidak boleh kosong!');
            return false
        }

        $('#AddFinalScore').prop('disabled', true);
        $('#AddFinalScore').html('Tunggu...');

        // run save
        const url = "{!! URL::to('/teacher/subject-teacher/assessment/update-score') !!}";
        let data = new Object();

        data = {
            id: "{{$task['id']}}",
            score: $("#finalScore").val(),
        };

        var form = new URLSearchParams(data);
        var request = new Request(url, {
            method: 'POST',
            body: form,
            headers: new Headers({
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            })
        });

        fetch(request)
            .then(response => response.json())
            .then(function(data) {
                var score = $("#finalScore").val();
                $('#updateScore').modal('hide');
                $('#AddFinalScore').prop('disabled', false);
                $('#AddFinalScore').html('Simpan');
                $('#updateScore').modal('hide');
                $('#AddFinalScore').html('Simpan');
                $('.finalScore').html(score);

            })
            .catch(function(error) {
                console.error(error);
                $('#AddFinalScore').prop('disabled', false);
                $('#AddFinalScore').html('Simpan');
            });
    }

    function handleChange(input) {
        if (input.value < 0) input.value = 0;
        if (input.value > 100) input.value = 100;
    }

    function closeModal() {
        var score = "{{$task['final_score']}}";
        $('#updateScore').modal('hide');
        $("#finalScore").val(score);
        $('.finalScore').html(score);
    }

    function viewQuestion() {

        var id = "{{$task['id']}}"

        const url = "{!! URL::to('/teacher/subject-teacher/services/tasks/assessments') !!}" + "/" + id + "/questions";

        $("#question-list").html(`
            <div class="row justify-content-center">
                <div class="mr-2 spinner-grow spinner-grow-sm" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <div class="mr-2 spinner-grow spinner-grow-sm" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <div class="mr-2 spinner-grow spinner-grow-sm" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <div class="mt-2 row justify-content-center">
                <h5>Loading</h5>
            </div>
        `);

        var request = new Request(url, {
            method: 'GET',
            headers: new Headers({
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            })
        });

        fetch(request)
            .then(response => response.json())
            .then(function(data) {
                $('.title-question').show();
                $('#question-list').html(data.data);

                console.log({
                    data
                });

            })
            .catch(function(error) {
                console.error(error);
            });
    }

    function viewNaskah(pdf) {
        if (typeof window !== undefined) {
            window.open(pdf, '_blank');
        }
    }
</script>
@endpush