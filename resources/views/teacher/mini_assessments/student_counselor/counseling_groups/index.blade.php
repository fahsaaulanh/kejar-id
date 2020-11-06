@extends('layout.index')

@section('title', $miniAssessmentGroup)

@section('content')
<div class="container">

    <!-- Link Back -->
    <a class="btn-back" href="{{ url('/teacher/games') }}">
        <i class="kejar-back"></i>Kembali
    </a>

    <!-- Breadcrumb -->
    <nav class="breadcrumb">
        <a class="breadcrumb-item" href="{{ url('/teacher/games') }}">Beranda</a>
        <span class="breadcrumb-item active">{{$miniAssessmentGroup}}</span>
    </nav>

    <!-- Title -->
    <div class="page-title">
        <h2 class="mb-08rem">{{$miniAssessmentGroup}}</h2>
    </div>

    <!-- List of Stages (Teacher)-->
    <div class="list-group" data-url="#" data-token="{{ csrf_token() }}">
        @forelse($studentCounselors as $key => $v)
        <div class="list-group-item">
            <a href="{{ URL('teacher/'.$type.'/mini-assessment/'.$miniAssessmentGroupValue.'/'.$v['id'].'/detail') }}" class="col-12">
                <i class="kejar-mapel"></i>
                <span class="ml-5">Rayon {{$v['name']}} ({{$v['abbreviation']}})</span>
                <i class="kejar-right float-right"></i>
            </a>
        </div>
        @empty
        <h5 class="text-center">Tidak ada data</h5>
        @endforelse
    </div>

</div>
@endsection


@push('script')
@endpush
