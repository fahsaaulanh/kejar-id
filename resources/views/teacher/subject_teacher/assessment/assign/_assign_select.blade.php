<div class="modal fade bd-example-modal-md assignStudentsModalSection" id="assignStudentsModal-2">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tugaskan Siswa<br>
                    <small>2/2 Pilih Rombel atau Siswa</small>
                </h5>
                <button class="close modal-close" onclick="modalAssignShow(1)">
                    <i class="kejar kejar-close"></i>
                </button>
            </div>
            <div class="modal-body pb-0">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="title" class="font-weight-bold mb-3">Pilih Rombel atau Siswa</label>
                            <div class="form-check row ml-1">
                                <input class="form-check-input col-1" name="choice-Assign" type="radio" id="choice-Assign1" value="1" checked>
                                <label class="form-check-label col" for="choice-Assign1">
                                    Pilih Rombel
                                </label>
                            </div>
                            <div class="form-check row mt-3 ml-1">
                                <input class="form-check-input col-1" name="choice-Assign" type="radio" id="choice-Assign2" value="1">
                                <label class="form-check-label col" for="choice-Assign2">
                                    Pilih Siswa
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer text-right">
                <div class="text-right col-md-12">
                    <button class="btn btn-primary pull-right" onclick="modalAssignShow(3)">Pilih</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg assignStudentsModalSection" id="assignStudentsModal-3-studentGroup">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tugaskan Siswa<br>
                    <small>2/2 Pilih Rombel</small>
                </h5>
                <button class="close modal-close" onclick="modalAssignShow(2)">
                    <i class="kejar kejar-close"></i>
                </button>
            </div>
            <div class="modal-body ml-4 mr-4" style="max-height: 500px; overflow-x:hidden">
                <div class="row">
                    <div class="col-12">
                        <p>Klik nama rombel untuk menceklis atau menghapus siswa.</p>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-12">
                        <div class="check-group row">
                            <input type="checkbox" id="schedule-check-all" onchange="scheduleCheckAll()" value="1" class="col-1 mt-2 ml-2">
                            <label for="schedule-check-all" class="col pl-0">
                                <b>Pilih Semua Rombel</b>
                            </label>
                        </div>
                    </div>
                </div>
                <div id="studentGroupCheck"></div>
            </div>
            <div class="modal-footer text-right">

                <div class="col-12 text-center mt-3 mb-2" id="LoadingGetStudent">
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

                <div class="col-12 text-center mt-3 mb-2 LoadingCreateSceduleStudents" style="display:none">
                    <div class="row justify-content-center">
                        <div class="mr-2 spinner-grow spinner-grow-sm" role="status">
                            <span class="sr-only">Sedang Menyimpan Data...</span>
                        </div>
                        <div class="mr-2 spinner-grow spinner-grow-sm" role="status">
                            <span class="sr-only">Sedang Menyimpan Data...</span>
                        </div>
                        <div class="mr-2 spinner-grow spinner-grow-sm" role="status">
                            <span class="sr-only">Sedang Menyimpan Data...</span>
                        </div>
                    </div>
                    <div class="mt-2 row justify-content-center">
                        <h5>Sedang Menyimpan Data</h5>
                    </div>
                </div>
                <button class="btn btn-primary btn-block pull-right" id="submitBtn" onclick="submit()" disabled>
                    <div class="row">
                        <div class="col text-left">
                            <span class="total-students total-students-selected">0</span> siswa
                        </div>
                        <div class="col text-right">
                            Tugaskan <i class="kejar-forward text-white"></i>
                        </div>
                    </div>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg assignStudentsModalSection" id="assignStudentsModal-3-students">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tugaskan Siswa<br>
                    <small>2/2 Pilih Siswa</small>
                </h5>
                <button class="close modal-close" onclick="modalAssignShow(2)">
                    <i class="kejar kejar-close"></i>
                </button>
            </div>
            <div class="modal-body ml-4 mr-4" style="max-height: 500px; overflow-x:hidden">
                <div class="row">
                    <div class="col-12">
                        <h5>Pilih Siswa</h5>
                        <p>Siswa yang dipilih akan mendapatkan rekomendasi/tugas untuk mengerjakan penilaian.</p>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-12">
                        <textarea class="form-control" id="NISTextarea" placeholder="Ketik nama atau NIS siswa" rows="5"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <small class="text-muted">Copy paste NIS siswa, pisahkan dengan koma.</small>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="col-12 text-center mt-3 mb-2 LoadingCreateSceduleStudents" style="display:none">
                    <div class="row justify-content-center">
                        <div class="mr-2 spinner-grow spinner-grow-sm" role="status">
                            <span class="sr-only">Sedang Menyimpan Data...</span>
                        </div>
                        <div class="mr-2 spinner-grow spinner-grow-sm" role="status">
                            <span class="sr-only">Sedang Menyimpan Data...</span>
                        </div>
                        <div class="mr-2 spinner-grow spinner-grow-sm" role="status">
                            <span class="sr-only">Sedang Menyimpan Data...</span>
                        </div>
                    </div>
                    <div class="mt-2 row justify-content-center">
                        <h5>Sedang Menyimpan Data</h5>
                    </div>
                </div>
                <div class="text-right col-md-12">
                    <button class="btn btn-primary pull-right" id="submitBtnStudent" onclick="submitStudent()">
                        Tugaskan
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
