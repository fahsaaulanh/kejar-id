<?php

namespace App\Services;

class Game
{
    public function parse($game)
    {
        $gameVar = strtoupper($game);
        $parseResult = [];

        if ($gameVar === 'OBR') {
            $parseResult = [
                'short' => 'OBR',
                'title' => 'Operasi Bilangan Rill',
                'uri' => 'obr',
            ];
        } elseif ($gameVar === 'VOCABULARY') {
            $parseResult = [
                'short' => 'Vocabulary',
                'title' => 'Vocabulary',
                'uri' => 'vocabulary',
            ];
        } elseif ($gameVar === 'KATABAKU') {
            $parseResult = [
                'short' => 'Kata Baku',
                'title' => 'Kata Baku',
                'uri' => 'katabaku',
            ];
        } elseif ($gameVar === 'TOEICWORDS') {
            $parseResult = [
                'short' => 'Toeic Words',
                'title' => 'TOEIC Words',
                'uri' => 'toeicwords',
            ];
        } elseif ($gameVar === 'MENULISEFEKTIF') {
            $parseResult = [
                'short' => 'Menulis Efektif',
                'title' => 'Menulis Efektif',
                'uri' => 'menulisefektif',
            ];
        } else {
            abort(404);
        }

        return $parseResult;
    }
}
