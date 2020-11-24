<div class="question-group" data-number="{{ $key + 1 }}" data-repeatance="0" data-id="{{ $question['id'] }}" data-type="esai" data-repeat="false">

    <p class="_esai_direction">Uraikan jawaban dari pertanyaan berikut!</p>

    <div class="_esai_question editor-display">
        <p>{!! $question['question']  !!}</p>
    </div>

    <!-- Answer Input -->
    <div class="esai_answer">
        <div class="ckeditor-list ck-height-9">
            <textarea name="esai_answer[]" cols="30" rows="4" class="w-100" placeholder="Ketik jawaban di sini..."></textarea>
            <div class="ckeditor-btn-group ckeditor-btn-1 d-none">
                <button type="button" class="bold-btn" title="Bold (Ctrl + B)" tabindex="-1">
                    <i class="kejar-bold"></i>
                </button>
                <button type="button" class="italic-btn" title="Italic (Ctrl + I)" tabindex="-1">
                    <i class="kejar-italic"></i>
                </button>
                <button type="button" class="underline-btn" title="Underline (Ctrl + U)" tabindex="-1">
                    <i class="kejar-underlined"></i>
                </button>
                <button type="button" class="bullet-list-btn" title="Bulleted list" tabindex="-1">
                    <i class="kejar-bullet"></i>
                </button>
                <button type="button" class="number-list-btn" title="Number list" tabindex="-1">
                    <i class="kejar-number"></i>
                </button>
            </div>
        </div>
    </div>

    <button class="_question_button _check_button" disabled>CEK JAWABAN <i class="kejar kejar-next"></i></button>

    <div class="_esai_session">
        <div class="_esai_explanation">
            <label>Pembahasan:</label>
            <div></div>
        </div>
    </div>
</div>
