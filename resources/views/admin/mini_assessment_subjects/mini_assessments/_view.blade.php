<div class="modal fade bd-example-modal-lg" id="view-ma">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="headTitle"></h5>
                <button class="close modal-close" data-dismiss="modal">
                    <i class="kejar kejar-close"></i>
                </button>
            </div>
            <div id="loading">
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
            <form action="{{ URL('admin/mini-assessment/edit-answers') }}" method="post">
                @csrf
                <div id="ma-content" style="display:none">
                    <div class="modal-body">
                        <input type="hidden" name="mini_assessment_id" id="mini_assessment_id">
                        <!-- Title -->
                        <h4 class="headGroup"></h4>
                        <!-- Breadcrumb -->
                        <nav class="breadcrumb">
                            <span class="breadcrumb-item headGroup"></span>
                            <span class="breadcrumb-item active" id="headSubject"></span>
                        </nav>
                        <div class="row mt-5">
                            <div class="col-12">
                                <div class="alert alert-primary" role="alert" id="link-package"></div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-6">
                                <label for="title" class="font-weight-bold">Pelaksanaan</label>
                                <p id="headTime"></p>
                            </div>
                            <div class="col-6">
                                <label for="title" class="font-weight-bold">Kode Paket</label>
                                <p id="headId"></p>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-12">
                                <label for="title" class="font-weight-bold">Pilihan Ganda</label>
                            </div>
                            <div class="col-12">
                                <div id="choices"></div>
                            </div>
                                <?php
                                    $no = 1;
                                ?>
                        </div>
                        <div class="row mt-4">
                            <div class="col-12">
                                <label for="title" class="font-weight-bold">Menceklis Daftar</label>
                            </div>
                            <div class="col-12">
                                <div id="multipleChoices"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer text-right">
                        <div class="text-right col-md-12">
                            <button class="btn btn-cancel pull-right" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary pull-right" onclick="$('#loading-edit-answer').show()">Perbarui</button>
                        </div>
                    </div>

                    <div class="col-12 text-center mt-3" id="loading-edit-answer" style="display:none">
                        <div class="row justify-content-center">
                            <div class="mr-2 spinner-grow spinner-grow-sm" role="status">
                                <span class="sr-only">Sedang Memproses Data...</span>
                            </div>
                            <div class="mr-2 spinner-grow spinner-grow-sm" role="status">
                                <span class="sr-only">Sedang Memproses Data...</span>
                            </div>
                            <div class="mr-2 spinner-grow spinner-grow-sm" role="status">
                                <span class="sr-only">Sedang Memproses Data...</span>
                            </div>
                        </div>
                        <div class="mt-2 row justify-content-center">
                            <h5>Sedang Memproses Data</h5>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
