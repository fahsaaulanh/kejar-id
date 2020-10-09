@extends('layout.index')

@section('title', $miniAssessmentGroup)

@section('content')
    <div class="container">

        <!-- Link Back -->
        <a class ="btn-back" href="{{ url('/admin/games') }}">
            <i class="kejar-back"></i>Kembali
        </a>

        <!-- Breadcrumb -->
        <nav class="breadcrumb">
            <a class="breadcrumb-item" href="{{ url('/admin/games') }}">Beranda</a>
            <span class="breadcrumb-item active">{{$miniAssessmentGroup}}</span>
        </nav>

        <!-- Title -->
        <div class="page-title">
            <h2 class="mb-08rem">{{$miniAssessmentGroup}}</h2>
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

        <!-- List of Stages (Admin)-->
        <div class="list-group" data-url="#" data-token="{{ csrf_token() }}">
            @forelse($subjects as $key => $v)
                <div class="list-group-item" data-toggle="collapse" data-target="#collapse-{{ $v['id']}}" aria-expanded="false" aria-controls="collapse-{{ $v['id']}}">
                    <a href="javascript:void(0)" class="col-12">
                        <i class="kejar-mapel" data-toggle="collapse" data-target="#collapse-{{ $v['id']}}" aria-expanded="false" aria-controls="collapse-{{ $v['id']}}"></i>
                        {{$v['name']}}
                    </a>
                </div>
                <div class="collapse" id="collapse-{{ $v['id']}}" style="margin-top: -16px;">
                    @for($i=0; $i < 3; $i++)
                        <div class="list-group" data-url="#" data-token="{{ csrf_token() }}">
                            <div class="list-group-item-dropdown">
                                <a href="{{ URL('admin/mini-assessment/'.$miniAssessmentGroupValue.'/subject/'.$v['id'].'/1'.$i) }}" class="col-12">
                                    <span class="ml-5">Kelas 1{{$i}}</span>
                                    <i class="kejar-right float-right"></i>
                                </a>
                            </div>
                        </div>
                    @endfor()
                </div>
            @empty
                <h5 class="text-center">Tidak ada data</h5>
            @endforelse
        </div>

        @if($subjectMeta && ($subjectMeta['total'] > 20))
            <!-- Pagination -->
            <nav class="navigation mt-5">
                <div>
                    <span class="pagination-detail">{{ $subjectMeta['to'] ?? 0 }} dari {{ $subjectMeta['total'] }} soal</span>
                </div>
                <ul class="pagination">
                    <li class="page-item {{ (request()->page ?? 1) - 1 <= 0 ? 'disabled' : '' }}">
                        <a class="page-link" href="?page={{ (request()->page ?? 1) - 1 }}" tabindex="-1">&lt;</a>
                    </li>
                    @for($i=1; $i <= $subjectMeta['last_page']; $i++)
                    <li class="page-item {{ (request()->page ?? 1) == $i ? 'active disabled' : '' }}">
                        <a class="page-link" href="?page={{ $i }}">{{ $i }}</a>
                    </li>
                    @endfor
                    <li class="page-item {{ ((request()->page ?? 1) + 1) > $subjectMeta['last_page'] ? 'disabled' : '' }}">
                        <a class="page-link" href="?page={{ (request()->page ?? 1) + 1 }}">&gt;</a>
                    </li>
                </ul>
            </nav>
        @endif()

    </div>
@endsection


@push('script')
<script src="{{ mix('/js/admin/stage/script.js') }}"></script>
@endpush
