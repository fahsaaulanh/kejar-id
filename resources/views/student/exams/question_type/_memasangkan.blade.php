<div class="question-group" data-number="{{ $key + 1 }}" data-repeatance="0" data-id="{{ $question['id'] }}" data-type="memasangkan" data-repeat="false">

    <p class="_memasangkan_direction">Pasangkan dengan menuliskan nomor pernyataan pasangan pada kotak yang tersedia!</p>

    <div class="_memasangkan_question editor-display">
        {!! $question['question'] !!}
        <p class="mb-0"><b>Pernyataan</b></p>
        @foreach ($question['choices'][0] as $key => $choice)
        <div class="d-flex justify-content-start align-items-start _memasangkan_pertanyaan">
            <div class="_memasangkan_pertanyaan_key" data-key="{{ $key }}">{{ $key }}</div>
            <div>
                {!! $choice !!}
            </div>
        </div>
        @endforeach
    </div>

    <!-- Answer Input -->
    <div class="_memasangkan_answer">
        <p><b>Pasangan</b></p>
        @foreach ($question['choices'][1] as $key => $choice)
        <div class="d-flex justify-content-start align-items-start _memasangkan_jawaban">
            <input type="text" class="form-control _memasangkan_jawaban_key" data-key="{{ $key }}" placeholder="...">
            <div>
                {!! $choice !!}
            </div>
        </div>
        @endforeach
    </div>

    <button class="_question_button _check_button" disabled>CEK JAWABAN <i class="kejar kejar-next"></i></button>

    <div class="_memasangkan_session">
        <div class="_memasangkan_right_answers">
            <label>Jawaban Benar:</label>
        </div>
        <div class="_memasangkan_explanation">
            <label>Pembahasan:</label>
            <div></div>
        </div>
    </div>

</div>
