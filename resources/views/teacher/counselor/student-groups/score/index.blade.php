@extends('layout.index')

@section('title', $assessmentGroup)

@section('content')
    <div class="container mw-1040r">

        <!-- Link Back -->
        <a class ="btn-back" href="{{ url('/teacher/'.$assessmentGroupId.'/student-groups'.$studentGroup['id'].'/subjects') }}">
            <i class="kejar-back"></i>Kembali
        </a>

        <!-- Breadcrumb -->
        <nav class="breadcrumb">
            <a class="breadcrumb-item" href="{{ url('/teacher/games') }}">Beranda</a>
            <a class="breadcrumb-item" href="{{ url('/teacher/'.$assessmentGroupId.'/student-groups') }}">{{$assessmentGroup}}</a>
            <a class="breadcrumb-item" href="{{ url('/teacher/'.$assessmentGroupId.'/student-groups/'.$studentGroup['id'].'/subjects') }}">{{$studentGroup['name']}}</a>
            <span class="breadcrumb-item active">{{$subject['name']}}</span>
        </nav>

        <!-- Student Group -->
        <div class="page-title">
            <h2 class="mb-08rem">{{$subject['name']}}</h2>
        </div>

        <!-- Upload Buttons -->
        @if($errors->has('round_file'))
            <script>
                alert("{{ $errors->first('round_file') }}");
            </script>
        @endif
        @if($errors->has('stage_file'))
            <script>
                alert("{{ $errors->first('stage_file') }}");
            </script>
        @endif
        @if (\Session::has('success'))
            <script>
                alert("{{ \Session::get('success') }}");
            </script>
        @endif

        <!-- Table of Score-->
        <div class="table-responsive table-result-stage">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width: 5.8rem!important">No.</th>
                        <th style="width: 27.8rem; text-align: left!important">Nama</th>
                        <th style="width: 15.8rem ">NIS</th>
                        <th style="width: 13.8rem">Durasi(menit)</th>
                        <th style="width: 15.8rem">Nilai Rekomendasi</th>
                        <th style="width: 15.8rem">Nilai Akhir</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($scores as $key => $v)
                        <tr>
                            <td>{{$key + 1 + (((request()->page ?? 1) - 1) * 50)}}</td>
                            <td>{{$v['name']}}</td>
                            <td>{{$v['nis']}}</td>
                            @if($v['duration'] == null)
                                <td colspan="3">Belum mengerjakan</td>
                            @else
                                <td>{{$v['duration']}}</td>
                                <td>{{$v['recommendation_score']}}</td>
                                <td>{{($v['final_score'] ?? '-')}}</td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">Tidak ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>


        <!-- Pagination -->
        <nav class="navigation mt-5">
            <div>
                <span class="pagination-detail">{{ $scoreMeta['to'] ?? 0 }} dari {{ $scoreMeta['total'] }} siswa</span>
            </div>
            @if($scoreMeta && ($scoreMeta['total'] > 20))
                <ul class="pagination">
                    <li class="page-item {{ (request()->page ?? 1) - 1 <= 0 ? 'disabled' : '' }}">
                        <a class="page-link" href="?page={{ (request()->page ?? 1) - 1 }}" tabindex="-1">&lt;</a>
                    </li>
                    @for($i=1; $i <= $scoreMeta['last_page']; $i++)
                    <li class="page-item {{ (request()->page ?? 1) == $i ? 'active disabled' : '' }}">
                        <a class="page-link" href="?page={{ $i }}">{{ $i }}</a>
                    </li>
                    @endfor
                    <li class="page-item {{ ((request()->page ?? 1) + 1) > $scoreMeta['last_page'] ? 'disabled' : '' }}">
                        <a class="page-link" href="?page={{ (request()->page ?? 1) + 1 }}">&gt;</a>
                    </li>
                </ul>
            @endif
        </nav>

    </div>
@endsection


@push('script')
@endpush
