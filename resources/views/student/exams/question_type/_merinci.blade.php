<div class="question-group" data-number="{{ $key + 1 }}" data-repeatance="0" data-id="{{ $question['id'] }}" data-type="merinci" data-repeat="false">
    <p class="_soal_cerita_direction">Sebutkan jawaban satu per satu pada kotak yang disediakan!</p>

    <p class="_merinci_direction">{!! $question['question'] !!}</p>
    <div class="_merinci_input_group">
        @for ($i = 0; $i < count($question['choices']); $i++)
            <input type="text" class="_merinci_input" placeholder="...">
        @endfor
    </div>    
    
    <button class="_question_button _check_button" disabled>CEK JAWABAN <i class="kejar kejar-next"></i></button>

    <div class="_merinci_session">
        <div class="_merinci_right_answers">
            <label>Jawaban Benar:</label>
        </div>
        <div class="_merinci_explanation">
            <label>Pembahasan:</label>
            <div></div>
        </div>
    </div>

</div>
