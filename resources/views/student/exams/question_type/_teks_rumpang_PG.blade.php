<div class="question-group" data-number="{{ $key + 1 }}" data-repeatance="0" data-id="{{ $question['id'] }}" data-type="rumpang" data-repeat="false">

    <div class="_rumpang_direction">Lengkapi kalimat rumpang berikut dengan jawaban yang tepat!</div>

    <div class="_rumpang_question">
        <div class="rmpg-question-answer clearfix">
            @foreach ($question['choices'] as $choice)
                {!! $choice['question'] !!}

                @if (isset($choice['choices']) && count($choice['choices']) > 0)
                <div class="dropdown">
                    <input type="hidden" name="answer" class="answer-field">
                    <button class="btn-select dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="d-flex justify-content-between align-items-center">
                            <span>...</span>
                            <i class="kejar kejar-dropdown"></i>
                        </div>
                    </button>
                    <div class="dropdown-menu shadow" aria-labelledby="dropdownMenuButton">
                        @foreach ($choice['choices'] as $key => $op)
                            <a class="dropdown-item" data-type="answer" data-value="{{ $key }}" href="#">{{ $op }}</a>
                        @endforeach
                    </div>
                </div>
                @endif
                
            @endforeach
        </div>
    </div>

    <button class="_question_button _check_button" disabled>CEK JAWABAN <i class="kejar kejar-next"></i></button>

    <div class="_rumpang_session">
        <div class="_rumpang_right_answers">
            <label>Jawaban Benar:</label>
        </div>
        <div class="_rumpang_explanation">
            <label>Pembahasan:</label>
            <div></div>
        </div>
    </div>

</div>