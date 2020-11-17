<div class="question-group" data-number="{{ $key + 1 }}" data-repeatance="0" data-id="{{ $question['id'] }}" data-type="isian_bahasa" data-repeat="false">
    <p class="_soal_cerita_direction">Jawablah dengan benar!</p>

    <p class="_isian_bahasa_direction">{!! $question['question'] !!}</p>

    <div class="_isian_bahasa_group">
        <div contenteditable="true" class="_isian_bahasa_textarea editor-display" placeholder="..."></div>
    </div>

    <button class="_question_button _check_button" disabled>CEK JAWABAN <i class="kejar kejar-next"></i></button>

    <div class="_isian_bahasa_session">
        <div class="_isian_bahasa_right_answers">
            <label>Jawaban Benar:</label>
        </div>
        <div class="_isian_bahasa_explanation">
            <label>Pembahasan:</label>
            <div><p>Paragraf tersebut menjelaskan sarana transportasi yang ada di Pantai Mutun sehingga kalimat penjelas yang sumbang dalam paragraf tersebut ditandai dengan nomor (5), karena kalimat nomor (5) berisi tentang pedagang yang berada di Pantai Mutun.</p></div>
        </div>
    </div>

</div>