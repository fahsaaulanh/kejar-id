<div class="modal fade assignStudentsModalSection" id="createSchedule">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tugaskan Siswa<br>
                    <small class="nameStudent">Agung Prasetyo</small>
                </h5>
                <button class="close modal-close" data-dismiss="modal">
                    <i class="kejar kejar-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    @if($type == 'MINI_ASSESSMENT')
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="title" class="font-weight-bold">Token/Password PDF</label>
                                @if($assessments[0]['pdf_password'])
                                <input type="text" class="form-control" name="title" value="{{$assessments[0]['pdf_password']}}" readonly disabled>
                                @else
                                <p class="text-grey">Tidak ada token/password.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="row">
                        <div class="col-12">
                            <div class="check-group row">
                                <input type="checkbox" onchange="modalAssignShowChoicePanel(0)" id="choice-0" value="1" class="col-1 mt-2">
                                <label for="choice-0" class="col pl-0">
                                    Penilaian hanya dapat dibuka dengan <b>token</b> yang diberikan secara manual oleh guru/pengawas.
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="display:none;" id="choice-0-panel">
                        <div class="col-1"></div>
                        <div class="col pl-0">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label for="title" class="font-weight-bold">Token</label><br>
                                    <small class="text-muted">
                                        Ketik token/password yang digunakan pada penilaian (jika ada).
                                        <span class="text-primary" onclick="viewToken()" style="cursor:pointer">Pelajari</span>
                                    </small>
                                    <input type="text" class="form-control" name="title" value="" placeholder="Ketik token, 6 karakter a-z dan/atau 0-9" id="token">
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif()
                    <div class="row">
                        <div class="col-12">
                            <div class="check-group row">
                                <input type="checkbox" onchange="modalAssignShowChoicePanel(1)" id="choice-1" value="1" class="col-1 mt-2">
                                <label for="choice-1" class="col pl-0">
                                    Penilaian hanya dapat dikerjakan <b>mulai dari</b> waktu tertentu.
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="display:none;" id="choice-1-panel">
                        <div class="col-1"></div>
                        <div class="col pl-0">
                            <div class="row">
                                <div class="col-12">
                                    <label for="title" class="font-weight-bold">Dimulai Pada</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control datepicker text-dark" placeholder="DD/MM/YYYY" id="start_date" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control clockpicker text-dark" placeholder="HH:MM" id="start_time" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="check-group row">
                                <input type="checkbox" onchange="modalAssignShowChoicePanel(2)" id="choice-2" value="1" class="col-1 mt-2">
                                <label for="choice-2" class="col pl-0">
                                    Penilaian hanya dapat dikerjakan <b>sampai dengan</b> tanggal dan waktu tertentu.
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="choice-2-panel" style="display:none;">
                        <div class="col-1"></div>
                        <div class="col pl-0">
                            <div class="row">
                                <div class="col-12">
                                    <label for="title" class="font-weight-bold">Selesai Pada</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control datepicker text-dark" placeholder="DD/MM/YYYY" id="expiry_date" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control clockpicker text-dark" placeholder="HH:MM" id="expiry_time" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div id="footerModal">
                <div class="modal-footer justify-content-end">
                    <div>
                        <button class="btn btn-danger" data-dismiss="modal">Hapus</button>
                    </div>
                    <div>
                        <button class="btn btn-link" data-dismiss="modal">Batal</button>
                        <button class="btn btn-primary" id="createAssgin" onclick="createNewAssign()">Tugaskan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>