{{-- Modal Add Assessment --}}
<div class="modal fade" id="modal-addAssessment" tabindex="-1" role="dialog" aria-labelledby="modal-addAssessment-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content kotak justify-content-center">
            <div class="content">
                <div class="modal-header pt-2 border-0">
                    <h3 class="text-title">Tambah Kelompok Penilaian</h3>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true"><i class="kejar-close"></i></span>
                    </button>
                </div>
                <div class="modal-body border-0">
                    <!-- Input -->
                    <form method="post" id="form-addAssessment" class="mt-4">
                        @csrf
                        <label for="title" class="font-weight-bold">Judul penilaian</label>
                        <input id="title-addAssessment" type="text" placeholder="Ketik judul penilaian" name="title" class="form-control">
                    </form>
                    <!-- Button  -->
                    <div class="d-flex justify-content-end btn-start-group" >
                        <button class="btn btn-lg btn-link mr-2" data-dismiss="modal">
                            Batal
                        </button>
                        <button id="simpan-addAssessment" class="btn btn-primary btn-lg">
                            Simpan
                        </button>
                    </div>
                </div>
            </div>
        </div>
  </div>
</div>
