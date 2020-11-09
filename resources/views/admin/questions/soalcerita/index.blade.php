@extends('layout.index')

@section('title', 'Soal Cerita')

@section('content')

<div class="container">

    <!-- Link Back -->
    <div class="px-3 row align-items-center justify-content-between">
        <a class ="btn-back" href="{{ url('/admin/' . $game['uri'] . '/stages/' . $stage['id'] . '/rounds') }}">
            <i class="kejar-back"></i>Kembali
        </a>
        <button class="{{ $round['status'] == 'PUBLISHED' ? 'btn-revise' : 'btn-publish'}}" onclick="document.getElementById('update-status-form').submit();">
            {{ $round['status'] == 'PUBLISHED' ? 'Revisi' : 'Terbitkan'}}
        </button>
        <form action="{{ url('/admin/' . $game['uri'] .'/stages/' . $stage['id'] . '/rounds/' . $round['id']) }}" method="post" id="update-status-form" class="d-none">
            @csrf
            @method('PATCH')
            <input type="hidden" name="status" value="{{ $round['status'] == 'PUBLISHED' ? 'NOT_PUBLISHED' : 'PUBLISHED' }}">
        </form>
    </div>

    <!-- Breadcrumb -->
    <nav class="breadcrumb">
        <a class="breadcrumb-item" href="{{ url('/admin/games') }}">Beranda</a>
        <a class="breadcrumb-item" href="{{ url('/admin/' . $game['uri'] . '/stages') }}">{{ $game['short'] }}</a>
        <a class="breadcrumb-item" href="{{ url('/admin/'. $game['uri'] . '/stages/' . $stage['id'] . '/rounds') }}">Babak {{ $stage['order'] }}</a>
        <span class="breadcrumb-item active">Ronde {{ $round['order'] }}</span>
    </nav>

    <!-- Title -->
    <div class="page-title">
        <h2 class="mb-08rem">{{ $round['title'] }}</h2>
        <span class="copy-id" data-id="{{ $round['id'] }}" data-toggle="popover" data-placement="top" data-content="ID disalin!">Salin ID Ronde</span>
    </div>

    <!-- Description -->
    <div class="page-description">
        <div class="page-description-item setting">
            <h5>Pengaturan Ronde</h5>
            <p>{{$round['total_question']}} soal ditampilkan &bullet; {{$round['question_timespan']}} detik/soal</p>
        </div>

        <div class="page-description-item description">
            <h5>Deskripsi Ronde</h5>
            <p>{{$round['description']}}</p>
        </div>

        <div class="page-description-item material">
            <h5>Materi</h5>
            <pre class="{{ $round['material'] == 'Buat Materi' ? 'material-default' : '' }}">{{$round['material']}}</pre>
        </div>

        <div class="page-description-item direction">
            <h5>Petunjuk Soal</h5>
            <p>{{$round['direction']}}</p>
        </div>
    </div>

    <div>
        <button class="btn-upload" data-toggle="modal" data-target="#create-soal-cerita-question-modal">
            <i class="kejar-add"></i>Input Soal
        </button>
    </div>

    <!-- Table of questions -->
    <div class="table-questions border-top-none">
        @foreach($roundQuestionsData as $key => $question)
        @php
        $pageNum = request()->page ?? 1;
        $questionNum = (($pageNum * 20) - 20) + $key + 1;
        @endphp

        @if ($question['question']['type'] === 'MCQSA')
        <div class="card type-pilihan-ganda">
            <div class="card-header">
                <div>
                    <h5>SOAL {{ $questionNum }}</h5> <i class="kejar-dot"></i> <i class="kejar-pilihan-ganda"></i> <h5>Pilihan Ganda</h5>
                </div>
                <div>
                    <button class="edit-btn" data-target="#edit-pilihan-ganda" data-url="{{ url('/admin/' . $game['uri'] .'/stages/' . $stage['id'] . '/rounds/' . $round['id'] . '/questions/' . $question['question_id']) }}">
                        <i class="kejar-edit"></i> Edit
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="editor-display">
                    {!! $question['question']['question'] !!}
                </div>
                <div class="question-answer-group">
                    <table class="question-answer-table">
                        @foreach($question['question']['choices'] as $key => $choice)
                        <tr>
                            <td>
                                @if($key == $question['question']['answer'])
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
                        {!! $question['question']['explanation'] !!}
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if ($question['question']['type'] === 'CQ')
        <div class="card type-menceklis-daftar">
            <div class="card-header">
                <div>
                    <h5>SOAL {{ $questionNum }}</h5> <i class="kejar-dot"></i> <i class="kejar-pilih-centang"></i> <h5>Menceklis Daftar</h5>
                </div>
                <div>
                    <button class="edit-btn" data-target="#edit-menceklis-daftar" data-url="{{ url('/admin/' . $game['uri'] .'/stages/' . $stage['id'] . '/rounds/' . $round['id'] . '/questions/' . $question['question_id']) }}">
                        <i class="kejar-edit"></i> Edit
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="editor-display">
                    {!! $question['question']['question'] !!}
                </div>
                <div class="answer-text">
                    <table class="question-answer-table">
                        @foreach($question['question']['choices'] as $key => $choice)
                        <tr>
                            <td>
                                @if(in_array($key, $question['question']['answer'], true))
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
                        {!! $question['question']['explanation'] !!}
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if ($question['question']['type'] === 'TFQMA')
        <div class="card type-benar-salah">
            <div class="card-header">
                <div>
                    <h5>SOAL {{ $questionNum }}</h5> <i class="kejar-dot"></i> <i class="kejar-benar-salah"></i> <h5>Benar Salah</h5>
                </div>
                <div>
                    <button data-toggle="modal" data-target="#edit-benar-salah" class="btn-edit" data-url="{{ url('/admin/' . $game['uri'] .'/stages/' . $stage['id'] . '/rounds/' . $round['id'] . '/questions/' . $question['question_id']) }}">
                        <i class="kejar-edit"></i> Edit
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="direction-text">
                    <p class="">
                        {!! $question['question']['question'] !!}
                    </p>
                </div>
                <div class="question-answer-group">
                    <table class="question-answer-table">
                        @foreach($question['question']['choices'] as $choice)
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
                        {!! $question['question']['explanation'] !!}
                    </div>
                </div>
            </div>
        </div>
        @endif
        <!--
        <div class="card type-ya-tidak">
            <div class="card-header">
                <div>
                    <h5>SOAL 4</h5> <i class="kejar-dot"></i> <i class="kejar-ya-tidak"></i> <h5>Ya Tidak</h5>
                </div>
                <div>
                    <button>
                        <i class="kejar-edit"></i> Edit
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="direction-text">
                    <p class="">
                        Bacalah wacana yang diberikan dengan seksama. Pilihlah benar atau salah untuk setiap pernyataan berikut sesuai dengan wacana. Petunjuk juga bisa menjadi sangat panjang sehingga ukuran formnya menjadi lebih besar dari yang semula disediakan seperti ini.
                    </p>
                </div>
                <div class="question-answer-group">
                    <table class="question-answer-table">
                        <tr>
                            <td>Ibu dan ayah pergi ke Taman Safari.</td>
                            <td>Ya</td>
                        </tr>
                        <tr>
                            <td>Taman Safari Indonesia terletak di Prigen, Pasuruan.</td>
                            <td>Ya</td>
                        </tr>
                        <tr>
                            <td>Taman Safari adalah tempat penangkaran Gajah Lampung.</td>
                            <td>Tidak</td>
                        </tr>
                        <tr>
                            <td>Ada berbagai pertunjukkan badut yang dapat disaksikan di Taman Safari. Ada berbagai pertunjukkan badut yang dapat disaksikan di Taman Safari. Ada berbagai pertunjukkan badut yang dapat disaksikan di Taman Safari.</td>
                            <td>Ya</td>
                        </tr>
                    </table>
                </div>
                <div class="explanation-group">
                    <strong>Pembahasan</strong>
                    <div class="explanation-text">
                        <p>
                            <ul class="list-unstyled">
                                <li>Huruf kapital digunakan pada awal kalimat.</li>
                                <li>Huruf kapital digunakan pada huruf pertama nama.</li>
                                <li>Kedua kalimat digabungkan dengan kata penghubung dan.</li>
                            </ul>
                        </p>
                    </div>
                </div>
            </div>
        </div> -->

        @if ($question['question']['type'] === 'SSQ')
        <div class="card type-mengurutkan">
            <div class="card-header">
                <div>
                    <h5>SOAL {{ $key + 1 }}</h5> <i class="kejar-dot"></i> <i class="kejar-mengurutkan-vertikal"></i> <h5>Mengurutkan</h5>
                </div>
                <div>
                    <button data-toggle="modal" data-target="#update-mengurutkan" data-url="{{ url('/admin/' . $game['uri'] .'/stages/' . $stage['id'] . '/rounds/' . $round['id'] . '/questions/' . $question['question_id']) }}">
                        <i class="kejar-edit"></i> Edit
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="direction-text">
                    <p class="editor-display">
                        {!! $question['question']['question'] !!}
                    </p>
                </div>
                <div class="question-answer-group">
                    <table class="question-answer-table">
                        @foreach($question['question']['choices'] as $choice)
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
                        {!! $question['question']['explanation'] !!}
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if ($question['question']['type'] === 'MQ')
        <div class="card type-memasangkan">
            <div class="card-header">
                <div>
                    <h5>SOAL {{ $questionNum }}</h5> <i class="kejar-dot"></i> <i class="kejar-mencocokkan"></i> <h5>Memasangkan</h5>
                </div>
                <div>
                    <button class="edit-btn" data-target="#edit-memasangkan" data-url="{{ url('/admin/' . $game['uri'] .'/stages/' . $stage['id'] . '/rounds/' . $round['id'] . '/questions/' . $question['question_id']) }}">
                        <i class="kejar-edit"></i> Edit
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="editor-display">
                    {!! $question['question']['question'] !!}
                </div>
                <div class="question-answer-group">
                    <table class="question-answer-table">
                        @foreach($question['question']['choices'][0] as $key => $choice)
                        <tr>
                            <td class="editor-display">{!! $choice !!}</td>
                            <td><i class="kejar-arrow-right"></i></td>
                            <td class="editor-display">{!! $question['question']['choices'][1][$question['question']['answer'][$key]] !!}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                <div class="explanation-group">
                    <strong>Pembahasan</strong>
                    <div class="editor-display">
                        {!! $question['question']['explanation'] !!}
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!--
        <div class="card type-merinci">
            <div class="card-header">
                <div>
                    <h5>SOAL 7</h5> <i class="kejar-dot"></i> <i class="kejar-teks-merinci"></i> <h5>Merinci</h5>
                </div>
                <div>
                    <button>
                        <i class="kejar-edit"></i> Edit
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="direction-text">
                    <p class="">
                        Berikut adalah soal yang akan ditampilkan. Bagaimana jika soalnya sangat panjang? Ukuran form akan mengikuti konten soal dengan sendirinya. Apa saja yang diperlukan untuk membuat sebuah resep kue bolu?
                    </p>
                </div>
                <div class="question-answer-group">
                    <table class="question-answer-table">
                        <tr>
                            <td>tepun terigu</td>
                        </tr>
                        <tr>
                            <td>gula pasir</td>
                        </tr>
                        <tr>
                            <td>telur</td>
                        </tr>
                    </table>
                </div>
                <div class="explanation-group">
                    <strong>Pembahasan</strong>
                    <div class="explanation-text">
                        <p>
                            <ul class="list-unstyled">
                                <li>Huruf kapital digunakan pada awal kalimat.</li>
                                <li>Huruf kapital digunakan pada huruf pertama nama.</li>
                                <li>Kedua kalimat digabungkan dengan kata penghubung dan.</li>
                            </ul>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card type-essai">
            <div class="card-header">
                <div>
                    <h5>SOAL 8</h5> <i class="kejar-dot"></i> <i class="kejar-esai"></i> <h5>Esai</h5>
                </div>
                <div>
                    <button>
                        <i class="kejar-edit"></i> Edit
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="question-text">
                    <p class="">
                        Berikut adalah soal yang akan ditampilkan. Bagaimana jika soalnya sangat panjang? Ukuran form akan mengikuti konten soal dengan sendirinya. Bisa jadi ukurannya menjadi lebih besar dari form yang semula disediakan.
                    </p>
                </div>
                <div class="answer-group">
                    <p>Sedang mengetik kunci jawaban. Demikian adalah tampilannya.</p>
                </div>
                <div class="explanation-group">
                    <strong>Pembahasan</strong>
                    <div class="explanation-text">
                        <p>
                            <ul class="list-unstyled">
                                <li>Huruf kapital digunakan pada awal kalimat.</li>
                                <li>Huruf kapital digunakan pada huruf pertama nama.</li>
                                <li>Kedua kalimat digabungkan dengan kata penghubung dan.</li>
                            </ul>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card type-isian-bahasa">
            <div class="card-header">
                <div>
                    <h5>SOAL 9</h5> <i class="kejar-dot"></i> <i class="kejar-isian-bahasa"></i> <h5>Isian Bahasa</h5>
                </div>
                <div>
                    <button>
                        <i class="kejar-edit"></i> Edit
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="direction-text">
                    <p class="">
                        Berikut adalah soal yang akan ditampilkan. Bagaimana jika soalnya sangat panjang? Ukuran form akan mengikuti konten soal dengan sendirinya. Bisa jadi ukurannya menjadi lebih besar dari form yang semula disediakan.
                    </p>
                </div>
                <div class="question-answer-group">
                    <table class="question-answer-table">
                        <tr>
                            <td><i class="kejar-soal-benar"></i></td>
                            <td>Ini adalah pernyataan yang sudah diisi. Ketika agak panjang, ukuran form akan mengikuti.</td>
                        </tr>
                        <tr>
                            <td><i class="kejar-soal-benar"></i></td>
                            <td>Pernyataan ini sedang diisi.</td>
                        </tr>
                        <tr>
                            <td><i class="kejar-soal-benar"></i></td>
                            <td>Pernytaaan ini sudah diisi juga.</td>
                        </tr>
                    </table>
                </div>
                <div class="explanation-group">
                    <strong>Pembahasan</strong>
                    <div class="explanation-text">
                        <p>
                            <ul class="list-unstyled">
                                <li>Huruf kapital digunakan pada awal kalimat.</li>
                                <li>Huruf kapital digunakan pada huruf pertama nama.</li>
                                <li>Kedua kalimat digabungkan dengan kata penghubung dan.</li>
                            </ul>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card type-isian-matematika">
            <div class="card-header">
                <div>
                    <h5>SOAL 10</h5> <i class="kejar-dot"></i> <i class="kejar-isian-matematika"></i> <h5>Isian Matematika</h5>
                </div>
                <div>
                    <button>
                        <i class="kejar-edit"></i> Edit
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="direction-text">
                    <p class="">
                        Berikut adalah soal yang akan ditampilkan. Bagaimana jika soalnya sangat panjang? Ukuran form akan mengikuti konten soal dengan sendirinya. Bisa jadi ukurannya menjadi lebih besar dari form yang semula disediakan.
                    </p>
                </div>
                <div class="answer-group">
                    <span class="input-styled">15</span>
                     apel + <span class="input-styled">3</span> jeruk
                </div>
                <div class="explanation-group">
                    <strong>Pembahasan</strong>
                    <div class="explanation-text">
                        <p>
                            <ul class="list-unstyled">
                                <li>Huruf kapital digunakan pada awal kalimat.</li>
                                <li>Huruf kapital digunakan pada huruf pertama nama.</li>
                                <li>Kedua kalimat digabungkan dengan kata penghubung dan.</li>
                            </ul>
                        </p>
                    </div>
                </div>
            </div>
        </div> -->

        @if ($question['question']['type'] === 'IQ')
        <div class="card type-teks-rumpang">
            <div class="card-header">
                <div>
                    <h5>SOAL {{ $questionNum }}</h5> <i class="kejar-dot"></i> <i class="kejar-checked-box"></i> <h5>Teks Rumpang PG</h5>
                </div>
                <div>
                    <button class="edit-btn" data-target="#edit-teks-rumpang-pg" data-url="{{ url('/admin/' . $game['uri'] .'/stages/' . $stage['id'] . '/rounds/' . $round['id'] . '/questions/' . $question['question_id']) }}">
                        <i class="kejar-edit"></i> Edit
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="question-answer-group">
                    <div class="editor-display">
                        @foreach($question['question']['choices'] as $key1 => $choice)
                            @if(!is_null($choice['question']))
                                {!! $choice['question'] !!}
                            @endif
                            @if(!is_null($choice['choices']))
                                @foreach($choice['choices'] as $key2 => $answer)
                                    @if($key2 == $question['question']['answer'][$key1])
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
                        {!! $question['question']['explanation'] !!}
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
            <span class="pagination-detail">{{ $roundQuestionsMeta['to'] ?? 0 }} dari {{ $roundQuestionsMeta['total'] }} soal</span>
        </div>
        <ul class="pagination">
            <li class="page-item {{ (request()->page ?? 1) - 1 <= 0 ? 'disabled' : '' }}">
                <a class="page-link" href="?page={{ (request()->page ?? 1) - 1 }}" tabindex="-1">&lt;</a>
            </li>
            @for($i=1; $i <= $roundQuestionsMeta['last_page']; $i++)
            <li class="page-item {{ (request()->page ?? 1) == $i ? 'active disabled' : '' }}">
                <a class="page-link" href="?page={{ $i }}">{{ $i }}</a>
            </li>
            @endfor
            <li class="page-item {{ ((request()->page ?? 1) + 1) > $roundQuestionsMeta['last_page'] ? 'disabled' : '' }}">
                <a class="page-link" href="?page={{ (request()->page ?? 1) + 1 }}">&gt;</a>
            </li>
        </ul>
    </nav>


</div>
@include('admin.questions.soalcerita._create_soal_cerita_question_modal')

<!-- update -->
@include('admin.questions.soalcerita.update._rename_round')
@include('admin.questions.soalcerita.update._update_setting')
@include('admin.questions.soalcerita.update._update_description')
@include('admin.questions.soalcerita.update._update_material')
@include('admin.questions.soalcerita.update._update_direction')
@include('admin.questions.soalcerita.create._pilihan_ganda')
@include('admin.questions.soalcerita.update._pilihan_ganda')
@include('admin.questions.soalcerita.create._benar_salah')
@include('admin.questions.soalcerita.update._benar_salah')
@include('admin.questions.soalcerita.create._mengurutkan')
@include('admin.questions.soalcerita.update._mengurutkan')
@include('admin.questions.soalcerita.create._menceklis_daftar')
@include('admin.questions.soalcerita.update._menceklis_daftar')
@include('admin.questions.soalcerita.create._memasangkan')
@include('admin.questions.soalcerita.update._memasangkan')
@include('admin.questions.soalcerita.create._teks_rumpang_PG')
@include('admin.questions.soalcerita.update._teks_rumpang_PG')
@endsection


@push('script')
<script src="{{ asset('ckeditor/build/ckeditor.js') }}"></script>
<script src="{{ mix('/js/admin/question/soal-cerita.js') }}"></script>
@endpush
