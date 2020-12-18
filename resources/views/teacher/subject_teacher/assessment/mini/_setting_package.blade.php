<div class="modal fade" id="setting_pack">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div>
                        <h5 class="modal-title">Ubah Pengaturan</h5>
                        <input type="hidden" name="title" value="Paket {{count($assessments) + 1}}" />
                    </div>
                    <button class="close modal-close" data-dismiss="modal">
                        <i class="kejar kejar-close"></i>
                    </button>
                </div>
                <form action="{{ URL('teacher/subject-teacher/'.$assessmentGroupId.'/subject/'.$subject['id'].'/'.$grade.'/assessment/'.$assessments[0]['id']) }}" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        @method('PATCH')
                        @csrf
                        <div class="form-group">
                            <label for="token" class="font-weight-bold">Token/Password PDF</label>
                            <h6 class="mb-2">Ketik token/password yang digunakan pada naskah PDF (jika ada). <a class="btn-link bg-white" data-toggle="modal" data-target="#info_token">Pelajari</a></h6>
                            <input type="text" class="form-control" value="{{($assessments[0]['pdf_password'] ?? '')}}" name="pdf_password" placeholder="Ketik token/password" autocomplete="off">
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div>
                                    <label for="duration" class="font-weight-bold">Durasi(menit)</label>
                                    <input type="number" class="form-control" value={{($assessments[0]['duration'] ?? 0)}} name="duration" placeholder="Ketik durasi" required="" autocomplete="off">
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
