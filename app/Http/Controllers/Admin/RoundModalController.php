<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ModalService as modalServiceApi;
use Illuminate\Http\Request;

class RoundModalController extends Controller
{
    // Update Round Modal
    public function updateRoundModal(Request $req, $game, $stageId, $id)
    {
        $game;
        $stageId;
        $modalServiceApi = new modalServiceApi;
        $editData = $modalServiceApi->edit($id);
        if ($req->field === 'material') {
            $updateData = [
                'id' => $editData['data']['id'],
                'stage_id' => $editData['data']['stage_id'],
                'title' => $editData['data']['title'],
                'description' => $editData['data']['description'],
                'direction' => $editData['data']['direction'],
                'material' => $req->material,
                'total_question' => $editData['data']['total_question'],
                'question_timespan' => $editData['data']['question_timespan'],
                'order' => $editData['data']['order'],
                'status' => $editData['data']['status'],
            ];
        } elseif ($req->field === 'description') {
            $updateData = [
                'id' => $editData['data']['id'],
                'stage_id' => $editData['data']['stage_id'],
                'title' => $editData['data']['title'],
                'description' => $req->description,
                'direction' => $editData['data']['direction'],
                'material' => $editData['data']['material'],
                'total_question' => $editData['data']['total_question'],
                'question_timespan' => $editData['data']['question_timespan'],
                'order' => $editData['data']['order'],
                'status' => $editData['data']['status'],
            ];
        } elseif ($req->field === 'title') {
            $updateData = [
                'id' => $editData['data']['id'],
                'stage_id' => $editData['data']['stage_id'],
                'title' => $req->title,
                'description' => $editData['data']['description'],
                'direction' => $editData['data']['direction'],
                'material' => $editData['data']['material'],
                'total_question' => $editData['data']['total_question'],
                'question_timespan' => $editData['data']['question_timespan'],
                'order' => $editData['data']['order'],
                'status' => $editData['data']['status'],
            ];
        } else {
            $updateData = [
                'id' => $editData['data']['id'],
                'stage_id' => $editData['data']['stage_id'],
                'title' => $editData['data']['title'],
                'description' => $editData['data']['description'],
                'direction' => $editData['data']['direction'],
                'material' => $editData['data']['material'],
                'total_question' => $req->total_question,
                'question_timespan' => $req->question_timespan,
                'order' => $editData['data']['order'],
                'status' => $editData['data']['status'],
            ];
        }

        $modalServiceApi->update($updateData, $id);

        return back();
    }
}
