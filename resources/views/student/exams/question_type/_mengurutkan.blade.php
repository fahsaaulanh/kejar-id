<div class="question-group" data-number="{{ $key + 1 }}" data-repeatance="0" data-id="{{ $question['id'] }}" data-type="mengurutkan" data-repeat="false">
    <div class="_mengurutkan_direction">Urutkan dengan memberikan nomor pada kotak yang tersedia!</div>

    <div class="_mengurutkan_question editor-display">
        {!! $question['question'] !!}
    </div>

    <div class="_mengurutkan_answer">
        @php
            $cho = [];
            foreach($question['choices'] as $key => $choice) {
                $cho[] = [
                   'key' => $key,
                   'answer' => $choice['answer'],
                   'question' => $choice['question'],
                ];
            }
            shuffle($cho);
        @endphp
        @foreach($cho as $key => $choice)
        <div class="d-flex justify-content-start align-items-center">
            <input type="number" inputmode="tel" class="form-control" placeholder="..." data-key="{{$choice['key']}}">
            <div class="_mengurutkan_question_text editor-display">
                {!! $choice['question'] !!}
            </div>
        </div>
        @endforeach
    </div>


    <button class="_question_button _check_button" disabled>CEK JAWABAN <i class="kejar kejar-next"></i></button>

    <div class="_mengurutkan_session">
        <div class="_mengurutkan_right_answers">
            <label>Jawaban Benar:</label>
        </div>
        <div class="_mengurutkan_explanation">
            <label>Pembahasan:</label>
            <div></div>
        </div>
    </div>

</div>
