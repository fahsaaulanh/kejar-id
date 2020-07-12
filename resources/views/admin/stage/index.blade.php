@extends('layout.main')

@section('css')
<link rel="stylesheet" href="{{ url('/assets/css/stage.css') }}">
@endsection

@section('content')

<div class="container-fluid">
    <div class="row justify-content-center my-4">
        <div class="col-md-10 col-lg-6">
            <!-- Link Back -->
            <div class="d-flex align-items-center">
                <a href="{{ url('/dashboard') }}" class="text-link link-back d-flex align-items center">
                    <i class="kejar kejar-arrow-left"></i> <span class="ml-2">Kembali</span>
                </a>
            </div>
            <!-- Breadcrumb -->
            <nav class="breadcrumb bg-transparent p-0">
                <a class="breadcrumb-item" href="{{ url('/dashboard') }}">Beranda</a>
                <span class="breadcrumb-item active">{{ $game['short'] }}</span>
            </nav>
            <!-- Title -->
            <h1 class="text-title">{{ $game['title'] }}</h1>
            <!-- Modal Buttons -->
            <div class="row mt-4">
                <div class="col-md-6">
                    <button class="btn btn-md btn-modal btn-block" data-toggle="modal" data-target="#upload-stages">
                        <i class="kejar kejar-upload"></i> Unggah Babak
                    </button>
                    @if($errors->has('stage_file'))
                        <div class="error text-danger">{{ $errors->first('stage_file') }}</div>
                    @endif
                </div>
                <div class="col-md-6">
                    <button class="btn btn-md btn-modal btn-block" data-toggle="modal" data-target="#uploadRoundModal">
                        <i class="kejar kejar-upload"></i> Unggah Ronde
                    </button>
                </div>
            </div>
            <!-- Stages Group -->
            <div class="stages-group mt-3">
                <!-- Stage Item -->
                @forelse($stages as $stage)
                <div class="stage-item">
                    <div class="stage-copy-id">
                        <i class="kejar kejar-ink"></i>
                        <input type="text" class="stage-id" value="{{ $stage['id'] }}">
                    </div>
                    <div class="stage-text w-100">
                        <a href="{{ url('admin/' . $game['uri'] . '/stages/' . $stage['id']) }}/rounds" class="text-link">
                            <span class="stage-number">Babak </span> : {{ $stage['title'] }}
                        </a>
                    </div>
                    <div class="stage-order-buttons">
                        <button class="btn btn-sm btn-up">
                            <i class="kejar kejar-arrow-left"></i>
                        </button>
                        <button class="btn btn-sm btn-down">
                            <i class="kejar kejar-arrow-left"></i>
                        </button>
                    </div>
                </div>
                @empty
                    <h5 class="text-center">Tidak ada data</h5>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@include('modals/_upload_stages')

@push('script')
<script>

    // Ceking Element
    checkElements();
    function checkElements(){
        var elements = $('.stages-group .stage-item');
        $.each(elements, function(key, value) {
            if (key == 0){
                $(value).find('.btn-up').css('display', 'none');
                $(value).find('.btn-down').css('display', 'flex');
            } else if(key == (elements.length - 1)){
                $(value).find('.btn-up').css('display', 'flex');
                $(value).find('.btn-down').css('display', 'none');
            } else{
                $(value).find('.stage-order-buttons button').css('display', 'flex');
            }
            $(value).find('.stage-number').text('Babak ' + (key + 1));
        });
    }

    // Ordering Stage Buttons
    $('.btn-up').click(function(){
        var el = $(this).parents('.stage-item');
        var elPrev = el.prev();
        el.insertBefore(elPrev);
        checkElements();
        ordering(el, elPrev);
    });

    $('.btn-down').click(function(){
        var el  = $(this).parents('.stage-item');
        var elNext = el.next();
        el.insertAfter(elNext);
        checkElements();
        ordering(el, elNext);
    });

    // Copying the id of stage
    $('body .stage-copy-id').click(function(){
        var dataId = $(this).find('input')[0];
        dataId.select();
        document.execCommand('copy');
    });

    // Upload File Fix
    $(document).on('change', 'input[name=stage_file]', function(){
        var filename = $(this).val().replace(/C:\\fakepath\\/i, '');

        filename = filename == '' ? 'Pilih file' : filename;
        $('input[name=stage_name]').val(filename);
    });


    // Function for Checking AJAX Orderin

    function ordering(mainEl, minorEl){
        var elements = $('.stages-group .stage-item');
        var mainElId = $(mainEl).find('input').val();
        var minorElId = $(minorEl).find('input').val();

        $.each(elements, function (key, value) {
             if ($(value).find('input').val() == mainElId){
                orderUpdate(mainElId, (key + 1));
             } else if ($(value).find('input').val() == minorElId){
                orderUpdate(minorElId, (key + 1));
             }
        });
    }

    // AJAX Ordering
    function orderUpdate(id, order){
        $.ajax({
            type: "POST",
            url: "{{ url('admin/'. $game['uri'] . '/') }}/stages" + id + "/order",
            data: {
                "_method": "PATCH",
                "_token": "{{ csrf_token() }}",
                "order": order
            },
            dataType: "JSON",
            success: function (response) {
                console.log(response);
            }
        });
    }
</script>
@endpush
