<div class="modal fade" id="add-ma">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title">{{(count($assessments) == 0 ? 'Unggah Naskah Soal': 'Tambah Paket Soal')}}</h5>
                    <h6>Paket {{$assessmentsMeta['total'] + 1}}</h6>
                </div>
                <button class="close modal-close" data-dismiss="modal">
                    <i class="kejar kejar-close"></i>
                </button>
            </div>
            <div class="row align-items-center mx-4 my-2 bg-blue-tp-2">
                <div class="col col-sm-1">
                    <i class="kejar-info"></i>
                </div>
                <div class="col">
                    @if(count($assessments) == 0)
                        <h6 class="text-grey-3 py-2">Semua soal pada naskah yang diinput harus berbentuk Pilihan Ganda.</h6>
                    @else
                        <h6 class="text-grey-3 py-2">
                            Jumlah soal, banyaknya pilihan jawaban, dan token/password PDF harus sama dengan paket
                            yang sudah diunggah sebelumnya.
                        </h6>
                    @endif
                </div>
            </div>
            <form id="saveForm" action="{{ URL('teacher/subject-teacher/'.$assessmentGroupId.'/subject/'.$subject['id'].'/'.$grade.'/assessment') }}" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="title" value="Paket {{$assessmentsMeta['total'] + 1}}" />
                    <input type="hidden" id="astype" name="type" value="MINI_ASSESSMENT" />
                    <div class="row mb-6">
                        <div class="col-12">
                            <label for="pdf_name" class="font-weight-bold">Naskah Soal</label>
                            <h6 class="mb-2 text-grey-3 font-weight-normal">File naskah maksimal 1 MB.</h6>
                            <div class="row custom-upload">
                                <div class="col-8">
                                    <input type="text" name="pdf_name" id="upload_pdf_name" class="input-file" value="Pilih file" disabled>
                                    <input type="file" name="pdf_file" id="upload_pdf_file" accept=".pdf" required>
                                </div>
                                <div class="col-4">
                                    <label for="upload_pdf_file" class="btn btn-label">Pilih File</label>
                                </div>
                            </div>
                            <div class="alert row alert-warning alert-dismissible fade-display hide" id="file_alert" role="alert">
                                Ukuran file terlalu besar.
                            </div>
                        </div>
                    </div>

                    @if($assessmentsMeta['total'] === 0)
                    <div class="form-group">
                        <label for="token" class="font-weight-bold">Token/Password PDF</label>
                        <h6 class="mb-2 text-grey-3 font-weight-normal">Ketik token/password yang digunakan pada naskah PDF (jika ada). <a class="btn-link bg-white" data-toggle="modal" data-target="#info_token">Pelajari</a></h6>
                        <input type="text" class="form-control" name="pdf_password" placeholder="Ketik token/password" autocomplete="off">
                    </div>
                    @else
                    <input type="hidden" name="pdf_password" value="{{$assessments[0]['pdf_password']}}" />
                    @endif

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="question" class="font-weight-bold">Banyaknya Soal</label>
                                @if($assessmentsMeta['total'] === 0)
                                <input type="number" class="form-control" name="total_question" placeholder="Ketik jumlah soal" min="1" required="" autocomplete="off">
                                @else
                                <input type="number" class="form-control" name="total_question" placeholder="Ketik jumlah soal" required="" readonly value={{count($questions)}}>
                                @endif
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="answer" class="font-weight-bold">Pilihan Jawaban</label>
                                @if(count($questions) === 0)
                                <select name="total_choices" class="form-control">
                                    <option value=3>3</option>
                                    <option value=4 {{($grade < 10 ? 'selected' : '')}}>4</option>
                                    <option value=5 {{($grade >= 10 ? 'selected' : '')}}>5</option>
                                </select>
                                @else
                                <input type="number" name="total_choices" class="form-control" value={{count($questions[0]['choices'])}} readonly />
                                @endif
                            </div>
                        </div>
                    </div>

                    @if($assessmentsMeta['total'] === 0)
                    <div class="row">
                        <div class="col-6">
                            <div>
                                <label for="duration" class="font-weight-bold">Durasi(menit)</label>
                                <input type="number" class="form-control" name="duration" placeholder="Ketik durasi" required="" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    @else
                    <input type="hidden" name="duration" value={{$assessments[0]['duration']}} />
                    @endif

                </div>
                <div class="modal-footer">
                    <div class="text-right col-md-12">
                        <button class="btn btn-cancel" data-dismiss="modal">Batal</button>
                        <button class="btn btn-primary" id="saveBtn" onclick="showLoadingCreate()">Lanjut</button>
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
