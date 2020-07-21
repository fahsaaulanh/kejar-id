@extends('layout.index')

@section('title', 'Permainan - ' . $task['score'])

@section('header')
@endsection

<!-- <link href="{{ url('/assets/css/result.css') }}" rel="stylesheet"> -->

@section('content')
<div class="bg-lego">
    <div class="container-center">
        <div class="card card-result">
            <div class="card-header justify-content-right">
                <a href="{{ url('students/games/' . $game . '/stages/' . $stageId . '/rounds') }}">
                    <span class="pull-right clickable close-icon" data-effect="fadeOut"><i class="kejar-close close-position"></i></span>
                </a>
            </div>
            <div class="card-body">
                <hr class="border-0">
                @if ($task['score'] == 100)
                    @include('student.results._cardMantaaap')
                @elseif ($task['score'] >= 75)
                    @include('student.results._cardLumayan')
                @elseif ($task['score'] >= 50)
                    @include('student.results._cardBintangSatu')
                @elseif ($task['score'] < 50)
                    @include('student.results._cardBintangDua')
                @endif
            </div>
        </div>
    </div>
</div>
<div class="bg-lego-mobile"></div>
@endsection

@push('script')

@endpush