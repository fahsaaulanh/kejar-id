<div class="modal fade" id="create-question">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Input Soal</h5>
                <button class="close modal-close" data-dismiss="modal">
                    <i class="kejar kejar-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ url('/admin/'. $game['uri'] . '/stages/' . $stage['id'] . '/rounds/' . $round['id'] . '/questions') }}" method="post" id="question-create-form">
                    @csrf
                    <div class="table-responsive-md">
                        <table class="table table-borderless table-form table-toeic">
                            <thead>
                                <th class="a">Meaning</th>
                                <th class="b">Word</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <input type="text" placeholder="Ketik meaning" name="question[0][question]" class="form-control">
                                    </td>
                                    <td>
                                        <input type="text" placeholder="Ketik word" name="question[0][answer]" class="form-control">
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot class="table-form-footer">
                                <th colspan="2">
                                    <button class="btn-add" type="button" data-type="toeic">
                                        <i class="kejar-add"></i> Tambah Soal
                                    </button>
                                </th>
                            </tfoot>
                        </table>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <a href="#" class="" data-toggle="modal" data-target="#upload-questions">
                    <i class="kejar kejar-upload"></i> Upload Soal
                </a>
                <div>
                    <button class="btn btn-cancel" data-dismiss="modal">Batal</button>
                    <button class="btn btn-primary" onclick="document.getElementById('question-create-form').submit();">Unggah</button>
                </div>
            </div>
        </div>
    </div>
</div>
