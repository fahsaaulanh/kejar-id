@extends('layout.index')

@section('title', 'Permainan')

@section('css')
<link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
@endsection

@section('content')
<div class="bg-blue-tp">
    <div class="container-fluid">
        <div class="row dashboard">
            <div class="col-12">
                <div class="content-header mb-8">
                    <h1 class="content-title">Penilaian</h1>
                </div>
                <div class="content-body">
                    @if($user['userable']['role'] === 'CURRICULUM')
                        <h5 class="mb-2">Sekolah</h5>
                        <div class="row">
                            <div class="col col-sm-4">
                                <select id="school_selector">
                                    <option disabled selected>Pilih sekolah</option>
                                    @foreach($schools as $key => $i)
                                        <option value="{{$i['id']}}">{{$i['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col col-sm-2">
                                <a id="go_to_school" class="btn btn-publish mw-fit" role="button">Pilih</a>
                            </div>
                        </div>
                    @else
                        @forelse($miniAssesmentGroup as $key => $v)
                            <div class="card-deck pl-4 pr-4 pb-4">
                                <div class="list-card-menu-item col-12" data-id="#">
                                    <a href="{{ url('/admin/mini-assessment/'.$key) }}">
                                        <h3><i class="kejar-penilaian" ></i> {{$v}}</h3>
                                    </a>
                                </div>
                            </div>
                        @empty
                        @endforelse
                    @endif
                </div>
            </div>
            <div class="col-12">
                <div class="content-header">
                    <h1 class="content-title">Latihan AKM</h1>
                </div>
                <div class="content-body">
                    <div class="card-deck">
                        <a href="{{ url('/admin/soalcerita/stages') }}" class="card">
                            <img src="{{ asset('assets/images/home/soal-cerita.jpg') }}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Soal Cerita</h5>
                                <p class="card-text">Lebih cerdas menyelesaikan permasalahan di kehidupan sehari-hari dengan kemampuan matematika.</p>
                            </div>
                        </a>
                        <a href="{{ url('/admin/akmnumerasi/packages') }}" class="card">
                            <img src="{{ asset('assets/images/home/menulis-efektif.jpg') }}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">AKM Numerasi</h5>
                                <p class="card-text">Menulis kata yang tepat agar menjadi kalimat yang efektif.</p>
                            </div>
                        </a>
                        <a href="{{ url('/admin/akmliterasi/packages') }}" class="card">
                            <img src="{{ asset('assets/images/home/soal-cerita.jpg') }}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">AKM Literasi</h5>
                                <p class="card-text">Lebih cerdas menyelesaikan permasalahan sehari-hari dengan kemampuan matematika.</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="content-header">
                    <h1 class="content-title">Matrikulasi</h1>
                </div>
                <div class="content-body">
                    <div class="card-deck">
                        <a href="{{ url('/admin/obr/stages') }}" class="card">
                            <img src="{{ asset('assets/images/home/obr.jpg') }}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Operasi Bilangan Riil</h5>
                                <p class="card-text">Berhitung lebih cepat dan tepat agar belajar Matematika mudah dan lancar.</p>
                            </div>
                        </a>
                        <a href="{{ url('/admin/katabaku/stages') }}" class="card">
                            <img src="{{ asset('assets/images/home/kata-baku.jpg') }}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Kata Baku</h5>
                                <p class="card-text">Menulis lebih profesional dengan Bahasa Indonesia yang baik dan benar.</p>
                            </div>
                        </a>
                        <a href="{{ url('/admin/vocabulary/stages') }}" class="card">
                            <img src="{{ asset('assets/images/home/vocab.jpg') }}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Vocabulary</h5>
                                <p class="card-text">Lebih percaya diri menulis dan berbicara dalam Bahasa Inggris karena kosakata yang kaya.</p>
                            </div>
                        </a>
                        <a href="{{ url('/admin/toeicwords/stages') }}" class="card">
                            <img src="{{ asset('assets/images/home/toeic-words.jpg') }}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">TOEIC Words</h5>
                                <p class="card-text">Kuasai 4000 kosakata yang sering muncul pada TOEIC.</p>
                            </div>
                        </a>
                        <a href="{{ url('/admin/menulisefektif/stages') }}" class="card">
                            <img src="{{ asset('assets/images/home/menulis-efektif.jpg') }}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Menulis Efektif</h5>
                                <p class="card-text">Menulis kata yang tepat agar menjadi kalimat yang efektif.</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('script')
<script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#school_selector').select2();
    });
    $('#school_selector').on('change', function(e){
        var id = e.target.value;
        $('#go_to_school').attr('href', `{!! URL::to('/admin/curriculum/schools/') !!}/${id}/assessment-groups`);
    })
</script>
@endpush
