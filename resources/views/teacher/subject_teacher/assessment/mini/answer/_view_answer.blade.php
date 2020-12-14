<div class="modal fade" id="viewAnswer" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div id="loading-view">
                <div class="row justify-content-center">
                    <div class="mr-2 spinner-grow spinner-grow-sm" role="status">
                        <span class="sr-only">Sedang mengambil data...</span>
                    </div>
                    <div class="mr-2 spinner-grow spinner-grow-sm" role="status">
                        <span class="sr-only">Sedang mengambil data...</span>
                    </div>
                    <div class="mr-2 spinner-grow spinner-grow-sm" role="status">
                        <span class="sr-only">Sedang mengambil data...</span>
                    </div>
                </div>
                <div class="mt-2 row justify-content-center">
                    <h5>Sedang mengambil data...</h5>
                </div>
            </div>
            <div id="ma-content-view" style="display:none">
                <div class="modal-body">
                    <div>
                        <div class="pl-4 pr-4 header-view">
                            <div class="row justify-content-between">
                                <nav class="breadcrumb">
                                    <span class="breadcrumb-item active headGroup"></span>
                                    <span class="breadcrumb-item active headSubject-view"></span>
                                </nav>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <i class="kejar-close"></i>
                                </button>
                            </div>
                        </div>
                        <div class="edit-header-view" style="display:none">
                            <div class="pl-4 pr-4">
                                <div class="row justify-content-between">
                                    <h3>EDIT KUNCI JAWABAN</h3>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <i class="kejar-close"></i>
                                    </button>
                                </div>
                            </div>
                            <nav class="breadcrumb">
                                <span class="breadcrumb-item active headGroup"></span>
                                <span class="breadcrumb-item active headSubject-view"></span>
                            </nav>
                        </div>
                        <div class="pb-7">
                            <h3 id="title" class="title-view"></h3>
                        </div>
                        <div class="row pb-7">
                            <div class="col-6">
                                <h5 class="pb-2">Token/Password PDF</h5>
                                <p class="font-15" id="token"></p>
                            </div>
                            <div class="col-6">
                                <h5 class="pb-2">Durasi</h5>
                                <p class="font-15 duration-view"></p>
                            </div>
                        </div>
                        <div>
                            <div class="pl-4 pr-4 pb-7">
                                <div id="view-naskah" class="row">
                                    <div class="pts-btn-pdf" role="button">
                                        <i class="kejar-pdf"></i>
                                        <h4 class="text-reguler ml-4">Lihat Naskah Soal</h4>
                                    </div>
                                </div>
                            </div>
                            <h5 class="pb-2">Kunci Jawaban</h5>
                            <div class="pb-6">
                                <div class="answer-note">
                                    <p>Klik jawaban yang benar.
                                        Pastikan loading penyimpanan selesai
                                        sampai muncul icon ceklis di samping jawaban.
                                    </p>
                                    <p>Jika loading terus-menerus,
                                        refresh halaman ini dan klik ulang jawaban yang dipilih.
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 tab-1-view">
                                </div>
                                <div class="col-md-6 tab-2-view">
                                </div>
                            </div>
                        </div>
                        <div class="pl-4 pr-4 pt-9 footer-view">
                            <div class="row edit-answer justify-content-between align-items-end">
                                <div>
                                    <p class="font-15 text-grey-6 ">Diinput oleh Sande Listiana.</p>
                                    <p class="font-15 text-grey-6 ">Telah divalidasi oleh Mutia Prawitasari.</p>
                                </div>
                                <div>
                                    <button type="button" class="btn btn-lg btn-primary" id="lanjut-missing-answer">EDIT</button>
                                </div>
                            </div>
                            <div class="row validated-answer justify-content-between align-items-end">
                                <div>
                                    <p class="font-15 text-grey-6 ">Diinput oleh Sande Listiana.</p>
                                </div>
                                <div>
                                    <button type="button" class="btn btn-lg btn-primary" id="lanjut-missing-answer">VALIDASI</button>
                                </div>
                            </div>
                            <div class="row create-answer justify-content-end align-items-end">
                                <div>
                                    <button type="button" class="btn-save btn btn-lg btn-primary" data-dismiss="modal">SIMPAN</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>