@extends('layout.index')

@section('title', $assessmentGroup)

@section('content')
    <div class="container">

        <!-- Link Back -->
        <a class ="btn-back" href="{{ url('/teacher/games') }}">
            <i class="kejar-back"></i>Kembali
        </a>

        <!-- Breadcrumb -->
        <nav class="breadcrumb">
            <a class="breadcrumb-item" href="{{ url('/teacher/games') }}">Beranda</a>
            <span class="breadcrumb-item active">{{$assessmentGroup}}</span>
        </nav>

        <!-- Title -->
        <div class="page-title">
            <h2 class="mb-08rem">{{$assessmentGroup}}</h2>
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

        <form method="get" action="{{ URL('teacher/'.$type.'/'.$assessmentGroupId.'/student-groups') }}">
            <div class="row mb-5">
                <div class="col-10">
                    <div class="input-group">
                        <span class="input-group-append">
                            <h2 class="border-right-0 border pt-1 pl-1">
                                <i class="kejar-search text-muted"></i>
                            </h2>
                        </span>
                        <input name="name" class="form-control py-2 border-left-0 border" placeholder="Cari kelas..." id="class_name" type="search" value="{{(request()->name ?? '')}}">
                    </div>
                </div>
                <div class="col-2">
                    <button class="btn btn-revise btn-block bg-white" type="submit">
                        <span>Cari</span>
                    </button>
                </div>
            </div>
        </form>

        <!-- Pagination -->
        @if($studentGroupMeta && ($studentGroupMeta['total'] > 20))
            <nav class="navigation mt-5">
                <div>
                    <span class="pagination-detail">{{ $studentGroupMeta['to'] ?? 0 }} dari {{ $studentGroupMeta['total'] }} mapel</span>
                </div>
                <ul class="pagination">
                    <li class="page-item {{ (request()->page ?? 1) - 1 <= 0 ? 'disabled' : '' }}">
                        <a class="page-link" href="?page={{ (request()->page ?? 1) - 1 }}" tabindex="-1">&lt;</a>
                    </li>
                    @for($i=1; $i <= $studentGroupMeta['last_page']; $i++)
                    <li class="page-item {{ (request()->page ?? 1) == $i ? 'active disabled' : '' }}">
                        <a class="page-link" href="?page={{ $i }}">{{ $i }}</a>
                    </li>
                    @endfor
                    <li class="page-item {{ ((request()->page ?? 1) + 1) > $studentGroupMeta['last_page'] ? 'disabled' : '' }}">
                        <a class="page-link" href="?page={{ (request()->page ?? 1) + 1 }}">&gt;</a>
                    </li>
                </ul>
            </nav>
        @endif

        <!-- List of Stages (Teacher)-->
        <div class="list-group">
            @forelse($studentGroups as $key => $v)
                <div class="list-group-item">
                    <a class="col-12" href="{{ URL('teacher/'.$type.'/'.$assessmentGroupId.'/student-groups/'.$v['id'].'/subjects')}}">
                        <i class="kejar-rombel"></i>
                        {{$v['name']}}
                    </a>
                </div>
            @empty
                <h5 class="text-center">Tidak ada data</h5>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($studentGroupMeta && ($studentGroupMeta['total'] > 20))
            <nav class="navigation mt-5">
                <div>
                    <span class="pagination-detail">{{ $studentGroupMeta['to'] ?? 0 }} dari {{ $studentGroupMeta['total'] }} kelas</span>
                </div>
                <ul class="pagination">
                    <li class="page-item {{ (request()->page ?? 1) - 1 <= 0 ? 'disabled' : '' }}">
                        <a class="page-link" href="?page={{ (request()->page ?? 1) - 1 }}" tabindex="-1">&lt;</a>
                    </li>
                    @for($i=1; $i <= $studentGroupMeta['last_page']; $i++)
                    <li class="page-item {{ (request()->page ?? 1) == $i ? 'active disabled' : '' }}">
                        <a class="page-link" href="?page={{ $i }}">{{ $i }}</a>
                    </li>
                    @endfor
                    <li class="page-item {{ ((request()->page ?? 1) + 1) > $studentGroupMeta['last_page'] ? 'disabled' : '' }}">
                        <a class="page-link" href="?page={{ (request()->page ?? 1) + 1 }}">&gt;</a>
                    </li>
                </ul>
            </nav>
        @endif

    </div>
@endsection


@push('script')
@endpush
