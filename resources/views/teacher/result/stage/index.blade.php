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
                            <th colspan="{{$cn}}" class="text-center">Babak</th>
                        </tr>
                        <tr class="numbr">
                            @for($i=1; $i <=$cn ; $i++)
                                <th class="kejar-done">
                                    <a
                                        class="text-reset text-decoration-none"
                                        href="{{ url()->current() .'/'. $responses->first()['progress'][$i-1]['stage_id'] .'/rounds' }}"
                                    >
                                        {{$i}}
                                    </a>
                                </th>
                            @endfor
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($responses as $item)
                        <tr class="result-icon remove-inherit">
                            <td class="td-name">
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
        </script>
    @endpush
@endsection
