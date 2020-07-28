@extends('layout.index')

@section('title', 'Modal detail')

@section('content')
<div class="container-fluid">
  <button type="button" data-id="90d58896-6e4c-36c3-8533-356158e7eb26">Example Stages Button</button>
</div>
@endsection

@include('teacher.rounds._detail_round')

@push('script')
<script>
  $(document).on('click', 'button', function () {
    var studentId = $(this).attr('data-id');
    var game = "{{ $game['uri'] }}";
    var studentGroupId = "{{ $studentGroupId }}";

    $.ajax({
      method: "GET",
      url: "{{ url('/teacher/games') }}/" + game + "/class/" + studentGroupId + "/stages/" + studentId + "/detail",
      success:function(response) {
        $('.modal-title-group h4').html(response.student.name);
        var listGroup = '';
        var stages = response.student.progress.length;

        if (stages !== 0) {
          for (var num = 0; num < stages; num++) {
            var finishedRound = response.student.progress[num].finished_round;
            var totalRound = response.student.progress[num].total_round;
            var information = [];

            if (finishedRound === totalRound && finishedRound !== 0) { information[0] = 'kejar-sudah-dikerjakan'; }
            else if (finishedRound !== 0) { information[0] = 'kejar-latihan-to-bold'; }
            else { information[0] = 'kejar-belum-mengerjakan-2'; }

            if (game === 'obr') { information[1] = '<span>' + finishedRound + '/' + totalRound + '</span> ronde'; }
            else if (game === 'katabaku') { information[1] = '<span></span> kata sudah dipelajari'; }
            else { information[1] = '<span></span> words have been learned'; }

            listGroup += '<li class="list-group-item"><i class="'+ information[0] +'"></i><div class="list-item-text"><h6>Babak '+ response.student.progress[num].stage_order +': '+ response.student.progress[num].stage_title +'</h6><p>'+ information[1] +'</p></div></li>';
          }
        } else {
          listGroup += '<li class="list-group-item"><h5>Tidak ada data</h5></li>';
        }

        $('.list-group').html(listGroup);
        $('#detailResultModal').modal('show');
      }
    });
  });
</script>
@endpush
