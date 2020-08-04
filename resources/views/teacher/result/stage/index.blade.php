@extends('./layout/index')
@php
    $titleResult = 'Daftar Babak - ' . $game['title']
@endphp
@section('title', $titleResult)

@section('content')
    <div class="container-fluid">
        <div class="cont-mv">
            <!-- Link Back -->
            <a class="btn-back" href="{{ url('/teacher/games/'. $game['uri'] .'/class') }}">
                <i class="kejar-back"></i>Kembali
            </a>
            <!-- Breadcrumb -->
            <nav class="breadcrumb">
                <a class="breadcrumb-item" href="{{ url('/teacher/games/') }}">Beranda</a>
                <a class="breadcrumb-item" href="{{ url('/teacher/games/'. $game['uri'] .'/class') }}">Daftar Rombel</a>
                <span class="breadcrumb-item active">Daftar Babak</span>
            </nav>
            <!-- Title -->
            <div class="page-title">
                    <div class="class-dropdown">
                        <div class="row" style="padding-left: 1.5rem">
                            <h1 class="mb-08rem">Ringkasan {{$game['short']}} - Kelas 10 -&nbsp;</h1>
                            <button class="dropdown-toggle" type="button" id="classDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <h1 class="mb-08rem">  RPL X-1 <i class="kejar-show"></i></h1>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="classDropdown">
                                @foreach ($dataStudentGroups['data'] as $item)
                                    <a class="dropdown-item" href="{{ url( '/teacher/games/'.$game['uri'].'/class/'.$item['batch_id'].'/'.$item['id'].'/stages' )}}"> {{$item['name']}}</a>
                                @endforeach
                            </div>
                        </div>
                    </div>
            </div>
            <div class="content-body">
                <!-- ICON-STATUS -->
                <div class="icon-description">
                    <div class="align-items-center"><i class="kejar-sudah-dikerjakan"></i> Semua ronde selesai</div>
                    <div class="align-items-center"><i class="kejar-latihan-to-bold"></i> Ada ronde belum dikerjakan</div>
                    <div class="align-items-center"><i class="kejar-belum-mengerjakan-2"></i> Belum ada ronde dikerjakan</div> <br>
                </div>
                <!-- Alert -->
                <div class="alert information-alert">
                    <div class="full-text">
                        <i class="kejar-info">i</i>Klik nomor babak untuk melihat capaian per ronde.
                    </div>
                    <div class="add-text">
                        <i>i</i>Klik nama siswa untuk melihat rincian.<br>
                            <div class="add-text-2">
                                <p>Gunakan tampilan desktop untuk melihat laporan lengkap.</p>    
                            </div>
                    </div>
                </div>
                <table class="table table-responsive table-bordered" id="table-kejar">
                    <thead>
                        <tr class="kejar-done">
                            <th class="th-name" rowspan="2">Nama Siswa</th>
                            <th colspan="{{ count($cn) }}" class="text-center">Babak</th>
                        </tr>
                        <tr class="numbr">
                            @forelse ($cn as $i => $data)
                                <th class="kejar-done">
                                    <a
                                        class="text-reset text-decoration-none"
                                        href="{{ url()->current() .'/'. $responses->first()['progress'][$i]['stage_id'] .'/rounds' }}"
                                    >
                                        {{ $data['stage_order'] }}
                                    </a>
                                </th>
                            @empty
                                <th>
                                    Tidak ada data
                                </th>
                            @endforelse
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($responses as $item)
                        <tr class="result-icon remove-inherit">
                            <td class="td-name" data-url="{{ url('/teacher/games/'.$game['uri'].'/class/'.$batchId.'/'.$studentGroupId.'/stages/'.$item['id'].'/detail') }}" data-game="{{ $game['uri'] }}">
                                {{$item['name']}} <br>
                                @php
                                    $jum = 0;
                                @endphp
                                @foreach ($item['progress'] as $pro)
                                    @if ($pro['undone'] = 0 && $pro['done'] > 0 )
                                        $jum++;
                                    @endif
                                @endforeach
                                <strong>{{$jum}}</strong> {{$game['result']}}
                            </td>
                            @foreach ($item['progress'] as $prog)
                            <td class="kejar-done">
                                <div>
                                        @if ($prog['undone'] == 0 && $prog['done'] > 0 )
                                            <i class="kejar-sudah-dikerjakan"></i>
                                        @elseif($prog['undone'] > 0 && $prog['undone'] < $prog['total_rounds'] )
                                            <i class="kejar-latihan-to-bold"></i>
                                        @elseif($prog['undone'] == $prog['total_rounds']  )
                                            <i class="kejar-belum-mengerjakan-2"></i>
                                        @elseif($prog['undone'] == 0 && $prog['done'] == 0 )
                                            <i class="kejar-belum-mengerjakan-2"></i>
                                        @endif
                                </div>
                            </td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{count($responses->items())}} dari {{$responses->total()}} siswa
                    <div class="paginate">
                        {{ $responses->render() }}
                    </div>
            </div>
        </div>    
    </div>
@include('teacher.result.stage._detail_student')
@endsection

@push('script')
<script>
    $(document).ready(function(){
        if(window.matchMedia("(max-width: 767px)").matches){
            $('.kejar-done').hide();
            $('#table-kejar').attr('cellpadding','0').attr('cellspacing','0').css('border-color','solid white').removeClass('table-responsive').removeClass('table-bordered');
        } else{
            // The viewport is at least 768 pixels wide
        }
    });

    $(document).on('click', '.td-name', function() {
        if(window.matchMedia("(max-width: 767px)").matches){
            var urlDetail = $(this).attr('data-url');
            var game = $(this).attr('data-game');
            $.ajax({
            method: "GET",
            url: urlDetail,
            success:function(response) {
                $('.modal-title-group h4').html(response.student.name);
                var listGroup = '';
                var stages = response.student.progress.length;
                if (stages != 0) {
                    for (var num = 0; num < stages; num++) {
                        var finishedRound = response.student.progress[num].done;
                        var totalRound = response.student.progress[num].total_rounds;
                        var totalAnswer = response.student.progress[num].total_anwers;
                        var information = [];

                        if (finishedRound === totalRound && finishedRound !== 0) { information[0] = 'kejar-sudah-dikerjakan'; }
                        else if (finishedRound !== 0) { information[0] = 'kejar-latihan-to-bold'; }
                        else { information[0] = 'kejar-belum-mengerjakan-2'; }

                        if (game === 'obr') { information[1] = '<span>' + finishedRound + '/' + totalRound + '</span> ronde'; }
                        else if (game === 'katabaku') { information[1] = '<span>'+ totalAnswer +'</span> kata sudah dipelajari'; }
                        else { information[1] = '<span>'+ totalAnswer +'</span> words have been learned'; }
                        listGroup += '<li class="list-group-item"><i class="'+ information[0] +'"></i><div class="list-item-text"><h6>Babak '+ response.student.progress[num].stage_order +': '+ response.student.progress[num].stage_title +'</h6><p>'+ information[1] +'</p></div></li>';
                    }
                } else {
                    listGroup += '<li class="list-group-item"><h5>Tidak ada data</h5></li>';
                }

                $('.list-group').html(listGroup);
                $('#detailResultModal').modal('show');
            }
            });
        }
    });
</script>
@endpush
