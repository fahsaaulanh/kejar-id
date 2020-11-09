<div class="question-group" data-number="{{ $key + 1 }}" data-repeatance="0" data-id="{{ $question['id'] }}" data-type="ya_tidak" data-repeat="false">
    <p class="_soal_cerita_direction">Pilihlah "Ya" atau "Tidak" untuk setiap pernyataan yang diberikan!</p>

    <p class="_ya_tidak_direction">{!! $question['question'] !!}</p>

    @foreach($question['choices'] as $x => $questionItem)
    <div class="d-flex flex-wrap flex-md-nowrap justify-content-between _ya_tidak">
        <div class="_ya_tidak_question">
            {!! $questionItem['question'] !!}
        </div>
        <div class="_ya_tidak_options">
            <div>
                <input type="radio" class="_ya_tidak_radio _answer_ya_option" name="answer[{{$x}}]" id="answer_ya_{{$key}}[{{ $x }}]" value="ya"> <label for="answer_ya_{{$key}}[{{ $x }}]"><i></i> Ya</label>
            </div>
            <div>
                <input type="radio" class="_ya_tidak_radio _answer_tidak_option" name="answer[{{$x}}]" id="answer_tidak_{{$key}}[{{ $x }}]" value="tidak"> <label for="answer_tidak_{{$key}}[{{ $x }}]"><i></i> Tidak</label>
            </div>
        </div>
    </div>
    @endforeach

    <button class="_question_button _check_button disabled">CEK JAWABAN <i class="kejar kejar-next"></i></button>


    <div class="_ya_tidak_session">
        <div class="_ya_tidak_right_answers">
            <label>Jawaban Benar</label>
        </div>
        <div class="_ya_tidak_explanation">
            <label>Pembahasan</label>
            <div></div>
        </div>
    </div>
</div>
