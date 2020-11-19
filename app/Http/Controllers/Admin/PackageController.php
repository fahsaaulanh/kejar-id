<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Game;
use App\Services\Stage;
use Illuminate\Http\Request;
use Throwable;

class PackageController extends Controller
{
    public function index($game)
    {
        $gameApi = new Game;
        $game = $gameApi->parse($game);

        $packageApi = new Stage;
        
        $filter = [
            'per_page' => 99,
        ];
        
        $packages = $packageApi->getAll(strtoupper($game['uri']), $filter)['data'] ?? [];

        return view('admin.packages.index', compact('game', 'packages'));
    }

    public function store(Request $request, $game)
    {

        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        $packageApi = new Stage;
        $packages = $packageApi->getAll(strtoupper($game))['data'] ?? [];
        $packageOrder = $packages[count($packages) - 1]['order'] ?? 0;

        $payload = [
            'title' => $request->title,
            'description' => $request->description,
            'game' => strtoupper($game),
            'order' => $packageOrder += 1,
        ];

        $package = $packageApi->store(strtoupper($game), $payload);

        $message = 'Berhasil menambahkan paket!';

        if ($package['error']) {
            $message = 'Gagal menambahkan paket!';
        }

        return redirect()->back()->with(['message' => $message]);
    }

    public function order(Request $request, $game, $packageId)
    {
        $packageApi = new Stage;

        $package = $packageApi->getDetail(strtoupper($game), $packageId)['data'] ?? [];

        if (count($package) > 0) {
            $payload = [
                'title' => $package['title'],
                'game' => $package['game'],
                'description' => $package['description'],
                'order' => $request->order,
            ];
    
            $package = $packageApi->reorder(strtoupper($game), $packageId, $payload);
        }

        return response()->json($package);
    }

    public function update(Request $request, $game, $packageId)
    {
        $packageApi = new Stage;

        try {
            $package = $packageApi->getDetail(strtoupper($game), $packageId)['data'] ?? [];

            $payload = [
                'title' => $request->title ?? $package['title'],
                'game' => $package['game'],
                'description' => $request->description ?? $package['description'],
                'order' => $package['order'],
            ];

            $packageApi->reorder(strtoupper($game), $packageId, $payload);

            $message = 'Berhasil mengubah!';
        } catch (Throwable $th) {
            $message = 'Gagal mengubah!';
        }

        return redirect()->back()->with('message', $message);
    }
}
