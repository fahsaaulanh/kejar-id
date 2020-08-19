@extends('layout.index')

@section('title', 'Daftar Ronde - ' . $game['title'])

@section('content')
    <div class="container-fluid">
        <!-- Link Back, Previous and Next -->
        <div class="btn-group-between">
            <a class="btn-back" href="{{ url('/teacher/games/'. $game['uri'] .'/class/'.$batchId.'/'. $thisClass[1]['id'] .'/stages') }}">
                <i class="kejar-back"></i>Kembali
            </a>
            <div class="btn-page-management">
                @if(!is_null($pages[0]))
                <a href="{{ url('/teacher/games/'. $game['uri'] .'/class/'.$batchId.'/'. $thisClass[1]['id'] .'/stages/'. $pages[0]['stage_id']) . '/rounds' }}" class="active">
                @else
                <a href="#">
                @endif
                    <i class="kejar-arrow-left"></i>
                    Sebelumnya
                </a>
                @if(!is_null($pages[2]))
                <a href="{{ url('/teacher/games/'. $game['uri'] .'/class/'.$batchId.'/'. $thisClass[1]['id'] .'/stages/'. $pages[2]['stage_id']) . '/rounds' }}" class="active">
                @else
                <a href="#">
                @endif
                    Selanjutnya
                    <i class="kejar-arrow-right"></i>
                </a>
            </div>
        </div>

        <!-- Breadcrumb -->
        <nav class="breadcrumb">
            <a class="breadcrumb-item" href="{{ url('/teacher/games/') }}">Beranda</a>
            <a class="breadcrumb-item" href="{{ url('/teacher/games/'. $game['uri'] .'/class') }}">Daftar Rombel</a>
            <a class="breadcrumb-item" href="{{ url('/teacher/games/'. $game['uri'] .'/class/'.$batchId.'/'. $thisClass[1]['id'] .'/stages') }}">Daftar Babak</a>
            <span class="breadcrumb-item active">Babak {{ $stage['order'] }}</span>
        </nav>
        <!-- Title -->
        <div class="page-title">
            <div class="class-dropdown" id="rombelDropdown">
                @php
                    if ($thisClass[0] == 'X') {
                        $gradeLatin = 10;
                    } elseif ($thisClass[0] == 'XI') {
                        $gradeLatin = 11;
                    } else {
                        $gradeLatin = 12;
                    }
                @endphp
                <span>Kelas {{ $gradeLatin }} - </span>
                <button class="dropdown-toggle" type="button" id="classDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-flip="false">
                    @if ($thisClass[0] !== '')
                    {{ $thisClass[1]['name'] }}
                    @else
                    Tidak ada kelas
                    @endif
                    <i class="kejar-show"></i>
                </button>
                <div class="dropdown-menu" aria-labelledby="classDropdown">
                    @foreach($classGroup as $class)
                    <a class="dropdown-item" href="{{ url('/teacher/games/'. $game['uri'] .'/class/'.$batchId.'/'. $class['class_id'] .'/stages/'. $pages[1]['stage_id'] . '/rounds') }}">{{ $class['class_name'] }}</a>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Description -->
        <h5 class="mb-08rem">Babak {{ $stage['order'] . ' : ' . $stage['title'] }}</h5>
        <p class="mb-4rem">{{ $stage['description'] }}</p>

        <!-- Information Alert -->
        <div class="alert information-alert" role="alert">
            <i>i</i>Klik nomor ronde untuk melihat deskripsi ronde
        </div>

        <!-- Table -->
        <div class="table-responsive table-result-round">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th rowspan="2">Nama Siswa</th>
                        <th colspan="{{ count($students['data'][0]['progress']) }}">Babak {{ $stage['order'] }}, Ronde ke-</th>
                    </tr>
                    <tr>
                        @forelse($students['data'][0]['progress'] as $round)
                        <th class="round-btn" data-url="{{ url()->current() . '/' .  $round['round_id'] . '/description' }}">{{ $round['round_order'] }}</th>
                        @empty
                        <th colspan="10">Tidak ada data</th>
                        @endforelse
                    </tr>
                </thead>
                <tbody>
                    @forelse($students['data'] as $student)
                    @php
                        $totalTask = count($student['progress']);
                        $taskCompeleted = 0;
                    @endphp
                    @foreach($student['progress'] as $progress)
                        @if($progress['is_done'] === true)
                            @php $taskCompeleted += 1; @endphp
                        @endif
                    @endforeach
                    <tr>
                        <td>
                            <div class="text-elipsis">
                                @if ($totalTask === $taskCompeleted && $taskCompeleted !== 0)
                                <i class="kejar-sudah-dikerjakan"></i>
                                @elseif ($taskCompeleted !== 0)
                                <i class="kejar-latihan-to-bold"></i>
                                @else
                                <i class="kejar-belum-mengerjakan-2"></i>
                                @endif
                                {{ $student['name'] }}
                            </div>
                        </td>
                        @forelse ($student['progress'] as $progress)
                        @if ($progress['is_done'] === true)
                            <td>
                                <div class="icon-group">
                                    <h5 class="text-reguler">{{ number_format($progress['score'], 0) }}</h5>
                                </div>
                            </td>
                        @else
                            <td>
                                <div class="icon-group">
                                    <i class="kejar-belum-mengerjakan1"></i>
                                </div>
                            </td>
                        @endif
                        @empty
                        <td>
                            Tidak ada data
                        </td>
                        @endforelse
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ count($students['data'][0]['progress']) !== 0 ? 1 : 2 }}" class="text-center">Tidak ada data</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="result-pagination">
            <p class="data-result">{{ $students['meta']['to'] }} dari {{ $students['meta']['total'] }} siswa</p>
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item {{ $students['meta']['current_page'] == 1 ? 'disabled' : '' }}">
                        <a class="page-link" href="?page={{ $students['meta']['current_page'] - 1 }}" aria-label="Previous">
                            <i class="kejar-left"></i>
                        </a>
                    </li>
                    @for ($i = 1; $i <= $students['meta']['last_page']; $i++)
                        @if ($students['meta']['total'] > 0)
                            <li class="page-item page-item {{ $students['meta']['current_page'] == $i ? 'active' : '' }}"><a class="page-link" href="?page={{$i}}">{{ $i }}</a></li>
                        @endif
                    @endfor
                    <li class="page-item {{ $students['meta']['current_page'] >= $students['meta']['last_page'] ? 'disabled' : '' }}">
                        <a class="page-link" href="?page={{ $students['meta']['current_page'] + 1 }}" aria-label="Next">
                            <i class="kejar-right"></i>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
    <div class="modal-group"></div>
@endsection

@push('script')
<script>
    $('.dropdown-toggle').dropdown();

    $(window).on('resize', function(){
        thisWidth();
    });

    thisWidth();

    function thisWidth() {
        var backUrl = $('.btn-back').attr('href');
        var windowWidth = $(window).width();
        if (windowWidth < 768) {
            window.open(backUrl, '_self');
        }
    }

    $(document).on('click', '.round-btn', function(){
        var urlDetail = $(this).attr('data-url');
        $.ajax({
            url: urlDetail,
            method: "GET",
            success:function(data){
                $('.modal-group').html(data);
                $('#detailDescriptionModal').modal('show');
            }
        })
    });
</script>
@endpush
