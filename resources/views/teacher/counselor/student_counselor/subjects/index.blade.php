@extends('layout.index')

@section('title', $studentCounselor['name'])

@section('content')
    <div class="container">

        <!-- Link Back -->
        <a class ="btn-back" href="{{ url('/teacher/games') }}">
            <i class="kejar-back"></i>Kembali
        </a>

        <!-- Breadcrumb -->
        <nav class="breadcrumb">
            <a class="breadcrumb-item" href="{{ url('/teacher/games') }}">Beranda</a>
            <a class="breadcrumb-item" href="{{ url('/teacher/student-counselor/'.$assessmentGroupId.'/counseling-groups/') }}">{{$assessmentGroup}}</a>
            <span class="breadcrumb-item active">{{$studentCounselor['name']}}</span>
        </nav>

        <!-- Title -->
        <div class="page-title">
            <h2 class="mb-08rem">{{$studentCounselor['name']}}</h2>
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

        <form method="get" action="{{ URL('teacher/'.$teacherType.'/'.$assessmentGroupId.'/subject') }}">
            <div class="row mb-5">
                <div class="col-10">
                    <div class="input-group">
                        <span class="input-group-append">
                            <h2 class="border-right-0 border pt-1 pl-1">
                                <i class="kejar-search text-muted"></i>
                            </h2>
                        </span>
                        <input name="name" value="{{(request()->name ?? '')}}" class="form-control py-2 border-left-0 border" placeholder="Cari mapel..." id="subject_name" type="search">
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
        @if($subjectMeta && ($subjectMeta['total'] > 20))
            <nav class="navigation mt-5">
                <div>
                    <span class="pagination-detail">{{ $subjectMeta['to'] ?? 0 }} dari {{ $subjectMeta['total'] }} mapel</span>
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

        <!-- List of Stages (Teacher)-->
        <div class="list-group" data-url="#" data-token="{{ csrf_token() }}">
            @forelse($subjects as $key => $v)
                <div class="list-group-item" aria-expanded="false" aria-controls="collapse-{{ $v['id']}}">
                    <a href="{{ URL('teacher/student-counselor/'.$assessmentGroupId.'/counseling-groups/'.$studentCounselor['id'].'/subject/'.$v['id']) }}" class="col-12">
                        <i class="kejar-mapel" aria-expanded="false" aria-controls="collapse-{{ $v['id']}}"></i>
                        {{$v['name']}}
                    </a>
                </div>
            @empty
                <h5 class="text-center">Tidak ada data</h5>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($subjectMeta && ($subjectMeta['total'] > 20))
            <nav class="navigation mt-5">
                <div>
                    <span class="pagination-detail">{{ $subjectMeta['to'] ?? 0 }} dari {{ $subjectMeta['total'] }} mapel</span>
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
@endpush
