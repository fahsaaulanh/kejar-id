@extends('layout.index')

@section('title', 'Games ')

@section('content')
    <div class="container">

        <!-- Link Back -->
        <a class ="btn-back" href="{{ url('/admin/games') }}">
            <i class="kejar-back"></i>Kembali
        </a>

        <!-- Breadcrumb -->
        <nav class="breadcrumb">
            <a class="breadcrumb-item" href="{{ url('/admin/games') }}">Beranda</a>
            <span class="breadcrumb-item active">{{ $game['short'] }}</span>
        </nav>

        <!-- Title -->
        <div class="page-title">
            <h2 class="mb-08rem">{{ $game['title'] }}</h2>
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
        <div class="upload-buttons">
            <button class="btn-upload" data-toggle="modal" data-target="#upload-stages">
                <i class="kejar-upload"></i>Unggah Babak
            </button>
            <button class="btn-upload" data-toggle="modal" data-target="#upload-rounds">
                <i class="kejar-upload"></i>Unggah Ronde
            </button>
        </div>

        <!-- List of Stages (Admin)-->
        <div class="list-group">       
            @forelse ($stages as $stage)
            <div class="list-group-item" data-id="{{ $stage['id'] }}">
                <a href="{{ url('admin/' . $game['uri'] . '/stages/' . $stage['id']) }}/rounds">
                    <i class="kejar-ink" onclick="textToClipboard('<?= $stage['id'] ?>')" data-toggle="popover" data-placement="top" data-content="ID disalin!"></i>
                    <span class="stage-number">Babak </span> : {{ $stage['title'] }}
                </a>
                <!-- <div class="hover-only"> -->
                    <div class="stage-order-buttons">
                        <button class="btn-icon">
                            <i class="kejar-top"></i>
                        </button>
                        <button class="btn-icon">
                            <i class="kejar-bottom"></i>
                        </button>
                    </div>
                <!-- </div> -->
            </div>
            @empty
                <h5 class="text-center">Tidak ada data</h5>
            @endforelse
        </div>

    </div>
@include('admin.stages._upload_stages')
@include('admin.stages._create_stage')
@include('admin.stages._upload_rounds')
@endsection


@push('script')
<script>
    $('#createStageModal').on('show.bs.modal', event => {
        $('#upload-stages').modal('hide');
    });

    $('#createStageModal').on('hide.bs.modal', event => {
        $('#upload-stages').modal('show');
    });

    // Ceking Element
    checkElements();
    function checkElements(){
        var elements = $('.list-group .list-group-item');
        $.each(elements, function(key, value) {
            if (key == 0 && elements.length > 1) {
                $(value).find('.btn-icon:first').css('display', 'none');
                $(value).find('.btn-icon:last').css('display', 'grid');
            } else if (key == (elements.length - 1) && elements.length) {
                $(value).find('.btn-icon:first').css('display', 'grid');
                $(value).find('.btn-icon:last').css('display', 'none');
            } else if (elements.length > 1) {
                $(value).find('.stage-order-buttons button').css('display', 'grid');
            } else{
                $(value).find('.stage-order-buttons button').css('display', 'none');
            }
            $(value).find('.stage-number').text('Babak ' + (key + 1));
        });
    }

    // Ordering Stage Buttons
    $('.list-group-item').on('click', '.btn-icon:first', function(){
        var el = $(this).parents('.list-group-item');
        var elPrev = el.prev();
        el.insertBefore(elPrev);
        checkElements();
        ordering(el, elPrev);
    });

    $('.list-group-item').on('click', '.btn-icon:last', function(){
        var el  = $(this).parents('.list-group-item');
        var elNext = el.next();
        el.insertAfter(elNext);
        checkElements();
        ordering(el, elNext);
    });

    // Copying the id of stage
    function textToClipboard (text) {
        event.preventDefault();
        $('[data-toggle="popover"]').popover();
        setTimeout(() => {
            $('[data-toggle="popover"]').popover('hide');
        }, 1000);
        var dummy = document.createElement("textarea");
        document.body.appendChild(dummy);
        dummy.value = text;
        dummy.select();
        document.execCommand("copy");
        document.body.removeChild(dummy);
    }

    // Upload File Fix

    $(document).on('change', 'input[type=file]', function(){
        var filename = $(this).val().replace(/C:\\fakepath\\/i, '');

        filename = filename == '' ? 'Pilih file' : filename;
        $(this).parents('.custom-upload').find('input[type=text]').val(filename);
    });


    // Function for Checking AJAX Orderin

    function ordering(mainEl, minorEl){
        var elements = $('.list-group .list-group-item');
        var mainElId = $(mainEl).data('id');
        var minorElId = $(minorEl).data('id');

        $.each(elements, function (key, value) {
             if ($(value).data('id') == mainElId){
                orderUpdate(mainElId, (key + 1));
             } else if ($(value).data('id') == minorElId){
                orderUpdate(minorElId, (key + 1));
             }
        });
    }

    // AJAX Ordering
    function orderUpdate(id, order){
        $.ajax({
            type: "POST",
            url: "{{ url('admin/'. $game['uri'] . '/') }}/stages/" + id + "/order",
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
