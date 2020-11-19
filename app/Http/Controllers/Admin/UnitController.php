<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Game;
use App\Services\Round;
use App\Services\Stage;
use Illuminate\Http\Request;
use Throwable;

class UnitController extends Controller
{
    public function index($game, $packageId)
    {
        $gameApi = new Game;
        $packageApi = new Stage;
        $unitApi = new Round;

        
        try {
            $game = $gameApi->parse($game);
            
            $package = $packageApi->getDetail(strtoupper($game['uri']), $packageId)['data'] ?? [];

            $filter = [
                'filter[stage_id]' => $packageId,
                'per_page' => 99,
            ];
            
            $units = $unitApi->index($filter)['data'] ?? [];

            // Next And Prev
            $packages = $packageApi->getAll(strtoupper($game['uri']), [])['data'] ?? [];

            $nextPrev = $this->checkNextPrev($packages, $package['id']);

            $prevPackage = $packages[$nextPrev - 1]['id'] ?? null;
            $nextPackage = $packages[$nextPrev + 1]['id'] ?? null;

            usort($units, fn ($a, $b) => $a['order'] <=> $b['order']);
        } catch (Throwable $th) {
            return redirect()->back()->with('message', 'Tidak ditemukan!');
        }

        return view('admin.units.index', compact('game', 'package', 'units', 'nextPackage', 'prevPackage'));
    }

    public function checkNextPrev($array, $id)
    {
        foreach ($array as $key => $value) {
            if ($value['id'] === $id) {
                return $key;
            }
        }

        return false;
    }

    public function store(Request $request, $game, $packageId)
    {
        $game;

        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);
        
        $unitApi = new Round;

        try {
            $filter = [
                'filter[stage_id]' => $packageId,
                'per_page' => 99,
            ];

            $order = count($unitApi->index($filter)['data'] ?? []) + 1;
    
            $data = [
                'stage_id' => $packageId,
                'title' => $request->title,
                'description' => $request->description ?? 'Tambahkan deskripsi', // database tidak nullable
                'direction' => 'NULL', // database tidak nullable
                'material' => 'NULL', // database tidak nullable
                'total_question' => 99,
                'question_timespan' => 99,
                'order' => $order,
                'status' => 'NOT_PUBLISHED', // status unknown
            ];
    
            $unitApi->store($data);
            
            $message = 'Berhasil menambahkan unit!';
        } catch (Throwable $th) {
            $message = 'Gagal menambahkan unit!';
        }
        
        return redirect()->back()->with('message', $message);
    }

    public function order($game, $packageId, Request $request)
    {
        $game;
        $packageId;
        $unitApi = new Round;

        $payload = [
            'order' => $request->order,
        ];

        $unit = $unitApi->update($payload, $request->id)['data'] ?? [];

        return response()->json($unit);
    }

    public function update($game, $packageId, $unitId, Request $request)
    {
        $game;
        $packageId;
        $unitApi = new Round;

        $unit = $unitApi->getDetail($unitId)['data'] ?? [];

        $payload = [
            'title' => $request->title ?? $unit['title'],
            'description' => $request->description ?? $unit['description'],
            'material' => $request->wacana ?? $unit['material'],
            'status' => $request->status ?? $unit['status'],
        ];

        $unitApi->update($payload, $unitId);

        return redirect()->back()->with('message', 'Pengubahan berhasil dilakukan!');
    }
}
