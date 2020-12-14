@extends('layout.index')

@section('title', $game['title'] . ' - ' . $unit['title'])

@section('content')

<div class="container">

    <!-- Link Back -->
    <div class="px-3 row align-items-center justify-content-between">
        <a class ="btn-back" href="{{ url('/admin/' . $game['uri'] . '/packages/' . $package['id'] . '/units') }}">
            <i class="kejar-back"></i>Kembali
        </a>
        @if ($unit['status'] === 'PUBLISHED')
        <button type="button" class="btn-revise" data-toggle="modal" data-target="#update-revised">
            Revisi
        </button>
        @else
        <button type="button" class="btn-publish" data-toggle="modal" data-target="#update-published">
            Terbitkan
        </button>
        @endif
    </div>

    <!-- Breadcrumb -->
    <nav class="breadcrumb">
        <a class="breadcrumb-item" href="{{ url('/admin/games') }}">Beranda</a>
        <a class="breadcrumb-item" href="{{ url('/admin/' . $game['uri'] . '/packages') }}">{{ $game['short'] }}</a>
        <a class="breadcrumb-item" href="{{ url('/admin/'. $game['uri'] . '/packages/' . $package['id'] . '/units') }}">Paket {{ $package['order'] }}</a>
        <span class="breadcrumb-item active">Unit {{ $unit['order'] }}</span>
    </nav>

    <!-- Title -->
    <div class="page-title">
        <h2 class="mb-08rem edit-title">{{ $unit['title'] }}</h2>
    </div>

    <!-- Description -->
    <div class="page-description">
        <div class="page-description-item description">
            <h5>Deskripsi Unit</h5>
            <pre class="edit-description">{{$unit['description']}}</pre>
        </div>

        <div class="page-description-item material">
            <h5>Wacana</h5>
            <pre class="{{ $unit['material'] == 'NULL' ? 'material-default' : '' }} edit-wacana editor-display">{!! $unit['material'] == 'NULL' ? 'Buat Wacana' :  $unit['material'] !!}</pre>
        </div>

        <div class="page-description-item direction">
            <h5>Petunjuk Soal</h5>
            <p class="edit-petunjuk-soal">Petunjuk soal diberikan oleh sistem berdasarkan tipe soal.</p>
        </div>
    </div>

    <div>
        <button class="btn-upload" data-toggle="modal" data-target="#question-type">
            <i class="kejar-add"></i>Input Soal
        </button>
    </div>

    <!-- Table of questions -->
    <div class="table-questions border-top-none">
        @foreach($questions as $key => $question)
            @php
                $pageNum = request()->page ?? 1;
                $questionNum = (($pageNum * 20) - 20) + $key + 1;
            @endphp

            @if ($question['type'] === 'MCQSA')
                <div class="card type-pilihan-ganda">
                    <div class="card-header">
                        <div>
                            <h5>SOAL {{ $questionNum }}</h5> <i class="kejar-dot"></i> <i class="kejar-pilihan-ganda"></i> <h5>Pilihan Ganda</h5>
                        </div>
                        <div>
                            <button class="edit-btn" data-toggle="modal" data-target="#update-pilihan-ganda" data-url="{{ url('/admin/' . $game['uri'] .'/packages/' . $package['id'] . '/units/' . $unit['id'] . '/questions/' . $question['id']) }}">
                                <i class="kejar-edit"></i> Edit
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="editor-display">
                            {!! $question['question'] !!}
                        </div>
                        <div class="question-answer-group">
                            <table class="question-answer-table">
                                @foreach($question['choices'] as $key => $choice)
                                <tr>
                                    <td>
                                        @if($key == $question['answer'])
                                        <i class="kejar-radio-button"></i>
                                        @else
                                        <i class="kejar-belum-dikerjakan"></i>
                                        @endif
                                    </td>
                                    <td class="editor-display">{!! $choice !!}</td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                        <div class="explanation-group">
                            <strong>Pembahasan</strong>
                            <div class="editor-display">
                                {!! $question['explanation'] !!}
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if ($question['type'] === 'CQ')
                <div class="card type-menceklis-daftar">
                    <div class="card-header">
                        <div>
                            <h5>SOAL {{ $questionNum }}</h5> <i class="kejar-dot"></i> <i class="kejar-pilih-centang"></i> <h5>Menceklis Daftar</h5>
                        </div>
                        <div>
                            <button class="edit-btn" data-toggle="modal" data-target="#update-menceklis-daftar" data-url="{{ url('/admin/' . $game['uri'] .'/packages/' . $package['id'] . '/units/' . $unit['id'] . '/questions/' . $question['id']) }}">
                                <i class="kejar-edit"></i> Edit
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="editor-display">
                            {!! $question['question'] !!}
                        </div>
                        <div class="answer-text">
                            <table class="question-answer-table">
                                @foreach($question['choices'] as $key => $choice)
                                <tr>
                                    <td>
                                        @if(in_array($key, $question['answer'], true))
                                        <i class="kejar-checked-box"></i>
                                        @else
                                        <i class="kejar-check-box"></i>
                                        @endif
                                    </td>
                                    <td class="editor-display">{!! $choice !!}</td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                        <div class="explanation-group">
                            <strong>Pembahasan</strong>
                            <div class="editor-display">
                                {!! $question['explanation'] !!}
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if ($question['type'] === 'TFQMA')
                <div class="card type-benar-salah">
                    <div class="card-header">
                        <div>
                            <h5>SOAL {{ $questionNum }}</h5> <i class="kejar-dot"></i> <i class="kejar-benar-salah"></i> <h5>Benar Salah</h5>
                        </div>
                        <div>
                            <button data-toggle="modal" data-target="#update-benar-salah" class="btn-edit" data-url="{{ url('/admin/' . $game['uri'] .'/packages/' . $package['id'] . '/units/' . $unit['id'] . '/questions/' . $question['id']) }}">
                                <i class="kejar-edit"></i> Edit
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="direction-text">
                            <p class="">
                                {!! $question['question'] !!}
                            </p>
                        </div>
                        <div class="question-answer-group">
                            <table class="question-answer-table">
                                @foreach($question['choices'] as $choice)
                                <tr>
                                    <td>{!! $choice['question'] !!}</td>
                                    <td>{{ $choice['answer'] === true ? 'Benar' : 'Salah' }}</td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                        <div class="explanation-group">
                            <strong>Pembahasan</strong>

                            <div class="explanation-text">
                                {!! $question['explanation'] !!}
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if ($question['type'] === 'YNQMA')
                <div class="card type-ya-tidak">
                    <div class="card-header">
                        <div>
                            <h5>SOAL {{$questionNum}}</h5> <i class="kejar-dot"></i> <i class="kejar-ya-tidak"></i> <h5>Ya Tidak</h5>
                        </div>
                        <div>
                            <button data-toggle="modal" data-target="#update-ya-tidak" data-url="{{ url('/admin/' . $game['uri'] .'/packages/' . $package['id'] . '/units/' . $unit['id'] . '/questions/' . $question['id']) }}">
                                <i class="kejar-edit"></i> Edit
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="direction-text">
                            <p class="">
                                {!! $question['question'] !!}
                            </p>
                        </div>
                        <div class="question-answer-group">
                            <table class="question-answer-table">
                                @foreach ($question['choices'] as $choice)
                                <tr>
                                    <td>{!! $choice['question'] !!}</td>
                                    <td class="text-capitalize">{!! $choice['answer'] === 'yes' ? 'Ya' : 'Tidak' !!}</td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                        <div class="explanation-group">
                            <strong>Pembahasan</strong>

                            <div class="explanation-text">
                                {!! $question['explanation'] !!}
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if ($question['type'] === 'SSQ')
                <div class="card type-mengurutkan">
                    <div class="card-header">
                        <div>
                            <h5>SOAL {{ $key + 1 }}</h5> <i class="kejar-dot"></i> <i class="kejar-mengurutkan-vertikal"></i> <h5>Mengurutkan</h5>
                        </div>
                        <div>
                            <button data-toggle="modal" data-target="#update-mengurutkan" data-url="{{ url('/admin/' . $game['uri'] .'/packages/' . $package['id'] . '/units/' . $unit['id'] . '/questions/' . $question['id']) }}">
                                <i class="kejar-edit"></i> Edit
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="direction-text">
                            <p class="editor-display">
                                {!! $question['question'] !!}
                            </p>
                        </div>
                        <div class="question-answer-group">
                            <table class="question-answer-table">
                                @foreach($question['choices'] as $choice)
                                <tr>
                                    <td>{{ $choice['answer'] }}.</td>
                                    <td class="editor-display">{!! $choice['question'] !!}</td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                        <div class="explanation-group">
                            <strong>Pembahasan</strong>

                            <div class="explanation-text">
                                {!! $question['explanation'] !!}
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if ($question['type'] === 'MQ')
                <div class="card type-memasangkan">
                    <div class="card-header">
                        <div>
                            <h5>SOAL {{ $questionNum }}</h5> <i class="kejar-dot"></i> <i class="kejar-mencocokkan"></i> <h5>Memasangkan</h5>
                        </div>
                        <div>
                            <button class="edit-btn" data-toggle="modal" data-target="#update-memasangkan" data-url="{{ url('/admin/' . $game['uri'] .'/packages/' . $package['id'] . '/units/' . $unit['id'] . '/questions/' . $question['id']) }}">
                                <i class="kejar-edit"></i> Edit
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="editor-display">
                            {!! $question['question'] !!}
                        </div>
                        <div class="question-answer-group">
                            <table class="question-answer-table">
                                @foreach($question['choices'][0] as $key => $choice)
                                <tr>
                                    <td class="editor-display">{!! $choice !!}</td>
                                    <td><i class="kejar-arrow-right"></i></td>
                                    <td class="editor-display">{!! $question['choices'][1][$question['answer'][$key]] !!}</td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                        <div class="explanation-group">
                            <strong>Pembahasan</strong>
                            <div class="editor-display">
                                {!! $question['explanation'] !!}
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if ($question['type'] === 'MQIA')
                <div class="card type-isian-matematika">
                    <div class="card-header">
                        <div>
                            <h5>SOAL {{ $questionNum }}</h5> <i class="kejar-dot"></i> <i class="kejar-isian-matematika"></i> <h5>Isian Matematika</h5>
                        </div>
                        <div>
                            <button data-toggle="modal" data-target="#update-isian-matematika" data-url="{{ url('/admin/' . $game['uri'] .'/packages/' . $package['id'] . '/units/' . $unit['id'] . '/questions/' . $question['id']) }}">
                                <i class="kejar-edit"></i> Edit
                            </button>
                        </div>
                    </div>
                    <div class="card-body editor-display">
                        <div class="direction-text">
                            {!! $question['question'] !!}
                        </div>
                        <div class="answer-group">
                            @for ($x = 0; $x < count($question['choices']['first']); $x++)
                                @if ($question['choices']['first'][$x] !== null)
                                    <div class="_awalan">{!! $question['choices']['first'][$x] !!}</div>
                                @endif

                                @isset($question['answer'][$x])
                                    <div class="input-styled">{!! $question['answer'][$x] !!}</div>
                                @endisset

                                @if ($question['choices']['last'][$x] !== null)
                                    <div class="_akhiran">{!! $question['choices']['last'][$x] !!}</span></div>
                                @endif
                            @endfor
                        </div>
                        <div class="explanation-group">
                            <strong>Pembahasan</strong>

                            <div class="explanation-text">
                                {!! $question['explanation'] !!}
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if ($question['type'] === 'IQ')
                <div class="card type-teks-rumpang">
                <div class="card-header">
                    <div>
                        <h5>SOAL {{ $questionNum }}</h5> <i class="kejar-dot"></i> <i class="kejar-checked-box"></i> <h5>Teks Rumpang PG</h5>
                    </div>
                    <div>
                        <button class="edit-btn" data-toggle="modal" data-target="#update-teks-rumpang-pg" data-url="{{ url('/admin/' . $game['uri'] .'/packages/' . $package['id'] . '/units/' . $unit['id'] . '/questions/' . $question['id']) }}">
                            <i class="kejar-edit"></i> Edit
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="question-answer-group">
                        <div class="editor-display">
                            @foreach($question['choices'] as $key1 => $choice)
                                @if(!is_null($choice['question']))
                                    {!! $choice['question'] !!}
                                @endif
                                @if(!is_null($choice['choices']))
                                    @foreach($choice['choices'] as $key2 => $answer)
                                        @if($key2 == $question['answer'][$key1])
                                        <div class="answer-box disable-editor active">{!! $answer !!}</div>
                                        @else
                                        <div class="answer-box disable-editor">{!! $answer !!}</div>
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="explanation-group">
                        <strong>Pembahasan</strong>
                        <div class="editor-display">
                            {!! $question['explanation'] !!}
                        </div>
                    </div>
                </div>
                </div>
            @endif

            @if ($question['type'] === 'CTQ')
                <div class="card type-melengkapi-tabel">
                    <div class="card-header">
                        <div>
                            <h5>SOAL {{ $questionNum }}</h5> <i class="kejar-dot"></i> <i class="kejar-table"></i> <h5>Melengkapi Tabel</h5>
                        </div>
                        <div>
                        <button data-toggle="modal" data-target="#update-melengkapi-tabel" data-url="{{ url('/admin/' . $game['uri'] .'/packages/' . $package['id'] . '/units/' . $unit['id'] . '/questions/' . $question['id']) }}">
                                <i class="kejar-edit"></i> Edit
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="direction-text">
                            <p class="">
                                {!! $question['question'] !!}
                            </p>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <thead>
                                    @foreach ($question['choices']['header'] as $header)
                                        <th>{{ $header }}</th>
                                    @endforeach
                                </thead>
                                <tbody>
                                    @foreach ($question['choices']['body'] as $body)
                                    <tr>
                                        @foreach ($body as $column)
                                            @if ($column['type'] === 'question')
                                                <td class="melengkapi-table-filled">
                                                    {!! $column['value'] !!}
                                                </td>
                                            @else
                                                <td class="melengkapi-table-unfilled">
                                                    {{ $column['value'] }}
                                                </td>
                                            @endif
                                        @endforeach
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="explanation-group">
                            <strong>Pembahasan</strong>

                            <div class="explanation-text">
                                {!! $question['explanation'] !!}
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if ($question['type'] === 'QSAT')
                <div class="card type-isian-bahasa">
                    <div class="card-header">
                        <div>
                            <h5>SOAL {{ $questionNum }}</h5> <i class="kejar-dot"></i> <i class="kejar-isian-bahasa"></i> <h5>Isian Bahasa</h5>
                        </div>
                        <div>
                            <button class="edit-btn" data-toggle="modal" data-target="#update-isian-bahasa" data-url="{{ url('/admin/' . $game['uri'] .'/packages/' . $package['id'] . '/units/' . $unit['id'] . '/questions/' . $question['id']) }}">
                                <i class="kejar-edit"></i> Edit
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="editor-display">
                            {!! $question['question'] !!}
                        </div>
                        <div class="question-answer-group">
                            <table class="question-answer-table">
                                @foreach($question['answer'] as $answer)
                                <tr>
                                    <td><i class="kejar-soal-benar"></i></td>
                                    <td class="disable-editor">{!! $answer !!}</td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                        <div class="explanation-group">
                            <strong>Pembahasan</strong>
                            <div class="editor-display">
                                {!! $question['explanation'] !!}
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if ($question['type'] === 'BDCQMA')
                <div class="card type-merinci">
                    <div class="card-header">
                        <div>
                            <h5>SOAL {{ $questionNum }}</h5> <i class="kejar-dot"></i> <i class="kejar-teks-merinci"></i> <h5>Merinci</h5>
                        </div>
                        <div>
                        <button class="edit-btn" data-toggle="modal" data-target="#update-merinci" data-url="{{ url('/admin/' . $game['uri'] .'/packages/' . $package['id'] . '/units/' . $unit['id'] . '/questions/' . $question['id']) }}">
                                <i class="kejar-edit"></i> Edit
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="editor-display">
                            {!! $question['question'] !!}
                        </div>
                        <div class="question-answer-group">
                            <table class="question-answer-table">
                                @foreach($question['answer'] as $answer)
                                <tr>
                                    <td class="disable-editor black">{!! $answer !!}</td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                        <div class="explanation-group">
                            <strong>Pembahasan</strong>
                            <div class="editor-display">
                                {!! $question['explanation'] !!}
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if ($question['type'] === 'EQ')
                <div class="card type-essai">
                    <div class="card-header">
                        <div>
                            <h5>SOAL {{ $questionNum }}</h5> <i class="kejar-dot"></i> <i class="kejar-esai"></i> <h5>Esai</h5>
                        </div>
                        <div>
                            <button class="edit-btn" data-toggle="modal" data-target="#update-esai" data-url="{{ url('/admin/' . $game['uri'] .'/packages/' . $package['id'] . '/units/' . $unit['id'] . '/questions/' . $question['id']) }}">
                                <i class="kejar-edit"></i> Edit
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="editor-display">
                            {!! $question['question'] !!}
                        </div>
                        <div class="answer-group">
                            <div class="editor-display">
                                {!! $question['answer'] !!}
                            </div>
                        </div>
                        <div class="explanation-group">
                            <strong>Pembahasan</strong>
                            <div class="editor-display">
                                {!! $question['explanation'] !!}
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        @endforeach
    </div>

    <!-- Pagination -->
    <nav class="navigation">
        <div>
            <span class="pagination-detail">{{ $pagination['to'] ?? 0 }} dari {{ $pagination['total'] }} soal</span>
        </div>
        <ul class="pagination">
            <li class="page-item {{ (request()->page ?? 1) - 1 <= 0 ? 'disabled' : '' }}">
                <a class="page-link" href="?page={{ (request()->page ?? 1) - 1 }}" tabindex="-1">&lt;</a>
            </li>
            @php
                $x = $pagination['current_page'] < 3 ? 1 : $pagination['current_page'] - 2;
                $y = $pagination['current_page'] + 2 < $pagination['last_page'] ? $pagination['current_page'] + 2 : $pagination['last_page'];
            @endphp
            @for($i= $x; $i <= $y; $i++)
            <li class="page-item {{ (request()->page ?? 1) == $i ? 'active disabled' : '' }}">
                <a class="page-link" href="?page={{ $i }}">{{ $i }}</a>
            </li>
            @endfor
            <li class="page-item {{ ((request()->page ?? 1) + 1) > $pagination['last_page'] ? 'disabled' : '' }}">
                <a class="page-link" href="?page={{ (request()->page ?? 1) + 1 }}">&gt;</a>
            </li>
        </ul>
    </nav>
</div>
<!-- Units -->
@include('admin.questions.update._rename_round')
@include('admin.questions.update._update_description')
@include('admin.questions.update._update_wacana')
@include('admin.questions.update._confirm_published')
@include('admin.questions.update._confirm_revised')
<!-- Questions -->
@include('admin.questions.create._question_type')
@include('admin.questions.create._pilihan_ganda')
@include('admin.questions.update.akm._pilihan_ganda')
@include('admin.questions.create._menceklis_daftar')
@include('admin.questions.update.akm._menceklis_daftar')
@include('admin.questions.create._benar_salah')
@include('admin.questions.update.akm._benar_salah')
@include('admin.questions.create._ya_tidak')
@include('admin.questions.update.akm._ya_tidak')
@include('admin.questions.create._mengurutkan')
@include('admin.questions.update.akm._mengurutkan')
@include('admin.questions.create._memasangkan')
@include('admin.questions.update.akm._memasangkan')
@include('admin.questions.create._merinci')
@include('admin.questions.update.akm._merinci')
@include('admin.questions.create._esai')
@include('admin.questions.update.akm._esai')
@include('admin.questions.create._isian_bahasa_literasi')
@include('admin.questions.update.akm._isian_bahasa_literasi')
@include('admin.questions.create._isian_matematika')
@include('admin.questions.update.akm._isian_matematika')
@include('admin.questions.create._melengkapi_table')
@include('admin.questions.update.akm._melengkapi_table')
@include('admin.questions.create._teks_rumpang_PG')
@include('admin.questions.update.akm._teks_rumpang_PG')
@endsection


@push('script')
<script src="{{ asset('ckeditor/build/ckeditor.js') }}"></script>
<script src="{{ mix('/js/admin/question/literasi.js') }}"></script>
@endpush
