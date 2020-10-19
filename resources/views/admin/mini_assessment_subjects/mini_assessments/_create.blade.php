<div class="modal fade" id="add-ma">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Paket Soal</h5>
                <button class="close modal-close" data-dismiss="modal">
                    <i class="kejar kejar-close"></i>
                </button>
            </div>
            <form action="{{ URL('admin/mini-assessment/'.$miniAssessmentGroupValue.'/subject/'.$subjectId.'/'.$grade) }}" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="title" class="font-weight-bold">Judul Paket</label>
                                <input type="text" class="form-control" name="title" placeholder="Ketik judul paket" required="" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <label for="title" class="font-weight-bold">Dimulai Pada</label>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <input type="date" class="form-control" name="start_date" placeholder="Ketik judul paket" required="" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <input type="time" class="form-control" name="start_time" placeholder="Ketik judul paket" required="" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <label for="title" class="font-weight-bold">Selesai Pada</label>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <input type="date" class="form-control" name="expiry_date" placeholder="Ketik judul paket" required="" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <input type="time" class="form-control" name="expiry_time" placeholder="Ketik judul paket" required="" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="title" class="font-weight-bold">Durasi</label>
                                <input type="number" class="form-control" name="duration" placeholder="Ketik durasi" required="" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <label for="title" class="font-weight-bold">Naskah Soal</label>
                            <div class="row custom-upload">
                                <div class="col-8">
                                    <input type="text" name="pdf_name" id="upload_pdf_name" class="input-file" value="Pilih file" disabled>
                                    <input type="file" name="pdf_file" id="upload_pdf_file" accept=".pdf" required>
                                </div>
                                <div class="col-4">
                                    <label for="upload_pdf_file" class="btn btn-label">Pilih File</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="text-right col-md-12">
                        <button class="btn btn-cancel" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" onclick="showLoadingCreate()">Simpan</button>
                    </div>
                    <div class="col-12 text-center mt-3" id="LoadingCreate" style="display:none">
                        <div class="row justify-content-center">
                            <div class="mr-2 spinner-grow spinner-grow-sm" role="status">
                                <span class="sr-only">Sedang Menyimpan...</span>
                            </div>
                            <div class="mr-2 spinner-grow spinner-grow-sm" role="status">
                                <span class="sr-only">Sedang Menyimpan...</span>
                            </div>
                            <div class="mr-2 spinner-grow spinner-grow-sm" role="status">
                                <span class="sr-only">Sedang Menyimpan...</span>
                            </div>
                        </div>
                        <div class="mt-2 row justify-content-center">
                            <h5>Sedang Menyimpan</h5>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
