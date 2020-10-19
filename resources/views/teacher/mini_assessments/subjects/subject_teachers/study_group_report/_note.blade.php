<div class="modal fade bd-example-modal-md" id="view-note">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Catatan Pengawas</h5>
                <button class="close modal-close" data-dismiss="modal">
                    <i class="kejar kejar-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div id="noteContent" style="display:none">
                    <div class="row">
                        <div class="col-12">
                            <h5 id="note-name"></h5>
                            <input type="hidden" id="note-id">
                            <input type="hidden" id="note-name-val">
                            <input type="hidden" id="note-nis-val">
                            <input type="hidden" id="student_note-val">
                            <input type="hidden" id="teacher_note-val">
                            <p class="mt-3"><span id="note-nis"></span>, {{ $StudentGroupDetail['name'] }}</p>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-12">
                            <h5>Catatan Siswa</h5>
                            <p class="mt-3" id="note-student"></p>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-12">
                            <h5>Catatan Pengawas</h5>
                            <div id="note-teacher">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer text-right">
                <div class="text-right col-md-12 p-0" id="btn-update" style="display:none">
                    <button class="btn btn-cancel pull-right" data-dismiss="modal">Batal</button>
                    <button class="btn btn-primary pull-right" onclick="updateNote()">Simpan</button>
                </div>
                <div class="text-right col-md-12 p-0" id="btn-edit" style="display:none">
                    <button class="btn btn-primary pull-right" onclick="editNote()">Edit</button>
                </div>
                <div id="noteLoading" class="col-12 text-center mt-4" style="display:none">
                    <div class="row justify-content-center">
                        <div class="mr-2 spinner-grow spinner-grow-sm" role="status">
                            <span class="sr-only">Memperbarui data...</span>
                        </div>
                        <div class="mr-2 spinner-grow spinner-grow-sm" role="status">
                            <span class="sr-only">Memperbarui data...</span>
                        </div>
                        <div class="mr-2 spinner-grow spinner-grow-sm" role="status">
                            <span class="sr-only">Memperbarui data...</span>
                        </div>
                    </div>
                    <div class="mt-2 row justify-content-center">
                        <h5>Memperbarui data...</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
