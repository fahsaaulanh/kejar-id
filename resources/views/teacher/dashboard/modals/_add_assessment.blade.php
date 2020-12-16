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
                <form method="POST" id="form-addAssessment" class="mt-4">
                    <div class="modal-body border-0">
                            @csrf
                            <!-- Input -->
                            <label for="title" class="font-weight-bold">Judul penilaian</label>
                            <input id="title-addAssessment" type="text" placeholder="Ketik judul penilaian" name="title" class="form-control">
                            <!-- Button  -->
                    </div>
                    <div class="modal-footer border-0 p-0">
                        <div class="d-flex justify-content-end w-100" >
                            <button type="button" class="btn btn-cancel mr-4" data-dismiss="modal">
                                Batal
                            </button>
                            <button type="submit" id="simpan-addAssessment" class="btn btn-primary">
                                Simpan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
  </div>
</div>
