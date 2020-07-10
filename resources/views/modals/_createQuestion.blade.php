<form action="{{ url('admin/' . $game['uri'] .'/stages/' . $stage['id'] .'/rounds/'. $round['id'] . '/questions')}}" method="post">
    @csrf
    <div class="modal fade" id="createQuestionModal" tabindex="-1" role="dialog" aria-labelledby="createQuestionModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content rounded-0">
                <div class="modal-header border-0">
                <h5 class="modal-title font-modal-title mt-2" id="exampleModalLongTitle">Input Soal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="stage-item">
                        <div class="stage-text w-100">
                            <label class="row">
                                <span class="col stage-number font-label-modal mt-2">Soal </span>
                                <span class="col stage-number font-label-modal mt-2">Jawaban </span>
                            </label>
                        </div>
                    </div>
                    <hr class="border-0">
                    <div id="TextBoxContainer">
                        <div class="row">
                            <div class="col">
                            <input type="text" name="question[0][question]" class="form-control rounded-0 " border-0 placeholder="Ketik Soal">
                            </div>
                            <div class="col">
                            <input type="text" name="question[0][answer]" class="form-control rounded-0" placeholder="Ketik Jawaban">
                            </div>
                        </div>
                    </div>
                    <hr class="border-0">
                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn btn-add-question font-add-question" id="btnAdd" type="button" onclick="AddTextBox()">
                                <i class="kejar-add">  </i> Tambah Soal
                                <asp:Button ID="btnPost" Text="Submit" CssClass="btn btn-success" runat="server" OnClick="Post" />
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-cancel font-button" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-modal-save font-button">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
    function GetDynamicTextBox(value) {
        var quest_ind=document.getElementsByClassName("question");
        // var ans_ind=document.getElementsByClassName("answer");
        quest_ind=quest_ind.length+1;
        // ans_ind=ans_ind.length+1;

           return   '<hr class="border-0" style="line-height: 2px">' +
                        '<div class="row">' +
                            '<div class="col">' +
                                '<input name="question['+ quest_ind+'][question]" type="text" class="question form-control rounded-0 " border-0 placeholder="Ketik Soal">' +
                            '</div>' +
                            '<div class="col">' +
                                '<input name="question['+ quest_ind+'][answer]" type="text" class="answer form-control rounded-0" placeholder="Ketik Jawaban">' +
                            '</div>' +
                        '</div>'
       }
       function AddTextBox() {
           var div = document.createElement('DIV');
           div.innerHTML = GetDynamicTextBox("");
           document.getElementById("TextBoxContainer").appendChild(div);
       }
</script>
