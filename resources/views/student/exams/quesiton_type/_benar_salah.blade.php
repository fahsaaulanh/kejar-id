<div class="question-group" data-number="{{ $key + 1 }}" data-repeatance="0" data-id="{{ $question['id'] }}" data-type="benar_salah" data-repeat="false">
    <p class="_soal_cerita_direction">Pilihlah "benar" atau "salah" untuk setiap pernyataan yang diberikan!</p>

    <p class="_benar_salah_direction">{!! $question['question'] !!}</p>

    @foreach($question['choices'] as $x => $questionItem)
    <div class="d-flex flex-wrap flex-md-nowrap justify-content-between _benar_salah">
        <div class="_benar_salah_question">
            {!! $questionItem['question'] !!}
        </div>
        <div class="_benar_salah_options">
            <div>
                <input type="radio" class="_benar_salah_radio _answer_benar_option" name="answer[{{$x}}]" id="answer_benar_{{$key}}[{{ $x }}]" value="benar"> <label for="answer_benar_{{$key}}[{{ $x }}]"><i></i> Benar</label>
            </div>
            <div>
                <input type="radio" class="_benar_salah_radio _answer_salah_option" name="answer[{{$x}}]" id="answer_salah_{{$key}}[{{ $x }}]" value="salah"> <label for="answer_salah_{{$key}}[{{ $x }}]"><i></i> Salah</label>
            </div>
        </div>
    </div>
    @endforeach

    <button class="_question_button _check_button disabled">CEK JAWABAN <i class="kejar kejar-next"></i></button>


    <div class="_benar_salah_session">
        <div class="_benar_salah_right_answers">
            <label>Jawaban Benar</label>
        </div>
        <div class="_benar_salah_explanation">
            <label>Pembahasan</label>
            <div></div>
        </div>
    </div>
</div>