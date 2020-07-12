<div class="row">
    <div class="col-12">
        <div class="modal modal-custom fade" id="settingEditModal" tabindex="-1" role="dialog" aria-labelledby="settingEditModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" name="updatesettingForm" action="{{ url('admin/' . $game['uri'] . '/stages/' . $stage['id'] . '/rounds/modal/round/update/'. $round['id']) }}">
                  @csrf
                  <div class="modal-header">
                    <h5 class="modal-title" id="settingEditModalLabel">Edit Pengaturan Ronde</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <i class="kejar-close"></i>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                      <input type="hidden" name="field" value="setting">
                      <div class="col-sm-6">
                        <div class="form-group">
                            <label class="form-title" for="totalQuestionInput">Soal Ditampilkan</label>
                            <input type="text" class="form-control input-custom number-input input-not-zero" id="totalQuestionInput" name="total_question" required="" value="{{ $round['total_question'] }}">
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-group">
                            <label class="form-title" for="questionTimeSpanInput">Waktu per Soal (detik)</label>
                            <input type="text" class="form-control input-custom number-input input-not-zero" id="questionTimeSpanInput" name="question_timespan" required="" value="{{ $round['question_timespan'] }}">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn-cancel" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-save">Simpan</button>
                  </div>
              </form>
            </div>
          </div>
        </div>
    </div>
</div>
<script src="{{ asset('assets/js/jquery.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.js') }}"></script>
<script type="text/javascript">
    (function($) {
      $.fn.inputFilter = function(inputFilter) {
        return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
          if (inputFilter(this.value)) {
            this.oldValue = this.value;
            this.oldSelectionStart = this.selectionStart;
            this.oldSelectionEnd = this.selectionEnd;
          } else if (this.hasOwnProperty("oldValue")) {
            this.value = this.oldValue;
            this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
          } else {
            this.value = "";
          }
        });
      };
    }(jQuery));

    $(".number-input").inputFilter(function(value) {
      return /^-?\d*$/.test(value); 
    });

    $(document).on('input propertychange paste', '.input-not-zero', function(e){
      var val = $(this).val()
      var reg = /^0/gi;
      if (val.match(reg)) {
          $(this).val(val.replace(reg, ''));
      }
    });

    $(document).on('dblclick', '.round-detail:nth-child(1) h5', function () {
      $('#settingEditModal').modal('show');
    });

    $(document).on('dblclick', '.round-detail:nth-child(1) p', function () {
      $('#settingEditModal').modal('show');
    });
</script>