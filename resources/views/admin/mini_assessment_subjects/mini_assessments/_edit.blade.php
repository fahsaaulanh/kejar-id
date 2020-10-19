<div class="modal fade" id="edit-ma">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Paket Soal</h5>
                <button class="close modal-close" data-dismiss="modal">
                    <i class="kejar kejar-close"></i>
                </button>
            </div>
            <form id="ma-edit-content" action="{{ URL('admin/mini-assessment/'.$miniAssessmentGroupValue.'/subject/'.$subjectId.'/'.$grade) }}" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    @method('PATCH')
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="title" class="font-weight-bold">Judul Paket</label>
                                <input type="hidden" name="id" id="edit-id">
                                <input type="text" class="form-control" id="edit-title" name="title" placeholder="Ketik judul paket" required="" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <label for="title" class="font-weight-bold">Dimulai Pada</label>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <input type="date" class="form-control" id="edit-start-date" name="start_date" placeholder="Ketik judul paket" required="" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <input type="time" class="form-control" id="edit-start-time" name="start_time" placeholder="Ketik judul paket" required="" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <label for="title" class="font-weight-bold">Selesai Pada</label>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <input type="date" class="form-control" id="edit-expiry-date" name="expiry_date" placeholder="Ketik judul paket" required="" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <input type="time" class="form-control" id="edit-expiry-time" name="expiry_time" placeholder="Ketik judul paket" required="" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="title" class="font-weight-bold">Durasi</label>
                                <input type="number" class="form-control" id="edit-duration" name="duration" placeholder="Ketik durasi" required="" autocomplete="off">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="text-right col-md-12">
                        <button class="btn btn-cancel" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </form>
            <div class="col-12 text-center mt-3" id="loading-edit" style="display:none">
                <div class="row justify-content-center">
                    <div class="mr-2 spinner-grow spinner-grow-sm" role="status">
                        <span class="sr-only">Sedang Mengambil Data...</span>
                    </div>
                    <div class="mr-2 spinner-grow spinner-grow-sm" role="status">
                        <span class="sr-only">Sedang Mengambil Data...</span>
                    </div>
                    <div class="mr-2 spinner-grow spinner-grow-sm" role="status">
                        <span class="sr-only">Sedang Mengambil Data...</span>
                    </div>
                </div>
                <div class="mt-2 row justify-content-center">
                    <h5>Sedang Mengambil Data</h5>
                </div>
            </div>
        </div>
    </div>
</div>
