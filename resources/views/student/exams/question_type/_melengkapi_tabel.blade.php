<div class="question-group" data-number="{{ $key + 1 }}" data-repeatance="0" data-id="{{ $question['id'] }}" data-type="melengkapi_tabel" data-repeat="false">

    <p class="_soal_cerita_direction">Lengkapi tabel berikut dengan jawaban yang benar!</p>

    <p class="_melengkapi_tabel_direction">{!! $question['question'] !!}</p>

    <div class="table-responsive _melengkapi_tabel_question">
        <table class="_melengkapi_tabel_tabel">
            <thead>
                @foreach ($question['choices']['header'] as $header)
                <th>{{ $header }}</th>
                @endforeach
            </thead>
            <tbody>
                @foreach ($question['choices']['body'] as $row)
                <tr>
                    @foreach ($row as $column)
                        @if ($column['type'] === 'question')
                        <td>{!! $column['value'] !!}</td>
                        @else
                        <td>
                            <input type="text" class="_melengkapi_tabel_input" placeholder="..." autocomplete="off">
                        </td>
                        @endif
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    
    <button class="_question_button _check_button" disabled>CEK JAWABAN <i class="kejar kejar-next"></i></button>


    <div class="_melengkapi_tabel_session">
        <div class="_melengkapi_tabel_right_answers">
            <label>Jawaban Benar:</label>
        </div>
        <div class="_melengkapi_tabel_explanation">
            <label>Pembahasan:</label>
            <div></div>
        </div>
    </div>
</div>
