<div class="question-group" data-number="{{ $key + 1 }}" data-repeatance="0" data-id="{{ $question['id'] }}" data-type="menceklis" data-repeat="false">
    <div class="_meceklis_direction">Berilah tanda centang pada jawaban yang benar!</div>

    <div class="_menceklis_question editor_display">
        {!! $question['question'] !!}
    </div>

    <div class="md-answer">
        @foreach ($question['choices'] as $key => $choice)
        <label class="md-checkbox-answer">{!! $choice !!}
            <input type="checkbox" name="answer[]" value="{{ $key }}">
            <i class="kejar kejar-check-box"></i>
        </label>
        @endforeach
    </div>

    <button class="_question_button _check_button" disabled>CEK JAWABAN <i class="kejar kejar-next"></i></button>

    <div class="_menceklis_session">
        <div class="_menceklis_right_answers">
            <label>Jawaban Benar:</label>
        </div>
        <div class="_menceklis_explanation">
            <label>Pembahasan:</label>
            <div></div>
        </div>
    </div>

</div>