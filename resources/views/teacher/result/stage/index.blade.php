@extends('./layout/index')

@section('title', 'Result Stages')

@section('content')
    <div class="container-fluid">
            <!-- Link Back -->
            <a class="btn-back" href="{{ url('/teachers/games/') }}">
                <i class="kejar-back"></i>Kembali
            </a>
            <!-- Breadcrumb -->
            <nav class="breadcrumb">
                <a class="breadcrumb-item" href="{{ url('/teachers/games/') }}">Beranda</a>
                <a class="breadcrumb-item" href="{{ url('/teachers/games/'. $game['uri'] .'/class') }}">Daftar Rombel</a>
                <span class="breadcrumb-item active">Daftar Babak</span>
            </nav>
            <!-- Title -->
            <div class="page-title">
                    <div class="class-dropdown">
                        <div class="row" style="padding-left: 1.5rem">
                            <h1 class="mb-08rem">Ringkasan {{$game['uri']}} - Kelas 10 -&nbsp;</h1>
                            <button class="dropdown-toggle" type="button" id="classDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <h1 class="mb-08rem">  RPL X-1 <i class="kejar-show"></i></h1>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="classDropdown">
                                @foreach ($dataStudentGroups['data'] as $item)
                                    <a class="dropdown-item" href="{{ url( '/teachers/games/'.$game['uri'].'/class/'.$item['batch_id'].'/'.$item['id'].'/stages' )}}"> {{$item['name']}}</a>                                    
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
                <div class="alert alert-info">
                    <i class="kejar-info"></i><p class="full-text">Klik nomor ronde untuk melihat deskripsi ronde.</p>
                    <p class="add-text">Gunakan tampilan desktop untuk melihat laporan lengkap. </p>                    
                </div>
                <table class="table table-responsive table-bordered" id="table-kejar">
                    <thead>
                        <tr class="kejar-done">
                            <th class="th-name" rowspan="2">Nama Siswa</th>
                            <th colspan="12" class="text-center">Babak</th>
                            <th colspan="99"></th>
                        </tr>
                        <tr class="numbr">
                            @php
                                for ($i=1; $i <=$cn ; $i++) { 
                                    echo '<th class="kejar-done">'.$i.'</th>';
                                }
                            @endphp
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
                20 dari {{$cn}} siswa
                    <div class="paginate">
                        {{ $responses->render() }}
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
