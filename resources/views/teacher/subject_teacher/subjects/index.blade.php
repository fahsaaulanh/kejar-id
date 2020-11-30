@extends('layout.index')

@section('title', $assessmentGroup)

@section('content')
    <div class="container">

        <!-- Link Back -->
        <a class ="btn-back" href="{{ url('/subject-teacher/games') }}">
            <i class="kejar-back"></i>Kembali
        </a>

        <!-- Breadcrumb -->
        <nav class="breadcrumb">
            <a class="breadcrumb-item" href="{{ url('/subject-teacher/games') }}">Beranda</a>
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

        <form onsubmit="event.preventDefault(); searchName();">
            <div class="row mb-5">
                <div class="col-10">
                    <div class="input-group">
                        <span class="input-group-append">
                            <h2 class="border-right-0 border pt-1 pl-1">
                                <i class="kejar-search text-muted"></i>
                            </h2>
                        </span>
                        <input class="form-control py-2 border-left-0 border" placeholder="Cari mapel..." id="subject_name" type="search" value="{{(request()->name ?? '')}}">
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
        <nav class="navigation mt-5">
            <div>
                <span class="pagination-detail">{{ $subjectMeta['to'] ?? 0 }} dari {{ $subjectMeta['total'] }} mapel</span>
            </div>
            @if($subjectMeta && ($subjectMeta['total'] > 20))
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
            @endif()
        </nav>

        <!-- List of Stages (Teacher)-->
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
                                <a href="{{ URL('teacher/subject-teacher/'.$assessmentGroupId.'/subject/'.$v['id'].'/1'.$i.'/assessment') }}" class="col-12">
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

        <!-- Pagination -->
        <nav class="navigation mt-5">
            <div>
                <span class="pagination-detail">{{ $subjectMeta['to'] ?? 0 }} dari {{ $subjectMeta['total'] }} mapel</span>
            </div>
            @if($subjectMeta && ($subjectMeta['total'] > 20))
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
            @endif()
        </nav>

    </div>
@endsection


@push('script')
<script>
    function searchName(){
        var loc = window.location.href
        var web = window.location.href.split('?');
        var search = $('#subject_name').val();
        if(loc.includes('name') == true){
            web = web.map(item => {
                if(item.includes('name') == true){
                    item ="name=" + search;
                }
                return item
            })
            web = web.join("?");
        }else{
            web.push("name=" + search)
        }
        console.log(web)
        location.replace(web);
    }
</script>
@endpush
