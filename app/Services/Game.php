<?php

namespace App\Services;

class Game
{
    private $games = [
        'OBR' => [
            'short' => 'OBR',
            'title' => 'Operasi Bilangan Rill',
            'uri' => 'obr',
            'result' => 'ronde',
        ],
        'VOCABULARY' => [
            'short' => 'Vocabulary',
            'title' => 'Vocabulary',
            'uri' => 'vocabulary',
            'result' => 'words',
        ],
        'KATABAKU' => [
            'short' => 'Kata Baku',
            'title' => 'Kata Baku',
            'uri' => 'katabaku',
            'result' => 'kata',
        ],
        'TOEICWORDS' => [
            'short' => 'Toeic Words',
            'title' => 'TOEIC Words',
            'uri' => 'toeicwords',
            'result' => 'words',
        ],
        'MENULISEFEKTIF' => [
            'short' => 'Menulis Efektif',
            'title' => 'Menulis Efektif',
            'uri' => 'menulisefektif',
            'result' => 'ronde',
        ],
    ];

    public function parse($game)
    {
        $gameVar = strtoupper($game);

        if (!array_key_exists($gameVar, $this->games)) {
            abort(404);
        }

        return $this->games[$gameVar];
    }
}
