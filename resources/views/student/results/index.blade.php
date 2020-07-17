@extends('layout.main')

@section('title', 'Student Result')

@section('css')
<link href="{{ url('/assets/css/result.css') }}" rel="stylesheet">
<link href="{{ url('/assets/font/kejar-matrikulasi.svg') }}">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card rounded-0 mt-5 size-card">
                <div class="card-body">
                    <a href="{{ url('students/games') }}">
                        <span class="pull-right clickable close-icon" data-effect="fadeOut"><i class="kejar-close close-position"></i></span>
                    </a>
                    <hr class="border-0">
                    @if ($task['score'] >= 90)
                        @include('student.results._cardMantaaap')
                    @elseif ($task['score'] >= 80)
                        @include('student.results._cardLumayan')
                    @elseif ($task['score'] >= 75)
                        @include('student.results._cardBintangSatu')
                    @elseif ($task['score'] < 75)
                        @include('student.results._cardBintangDua')
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
@endsection