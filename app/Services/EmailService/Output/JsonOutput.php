<?php


namespace App\Services\EmailService\Output;

use Illuminate\Http\JsonResponse;

/**
 * Class JsonOutput
 * @package App\Services\EmailService\Output
 */
class JsonOutput implements OutputInterface
{
    /**
     * @param $datas
     * @return JsonResponse
     */
    public function render($datas): JsonResponse
    {
        $rows = [];
        foreach ($datas['datas'] as $key => $data) {
            $rows[] = [
                "id" => $data->id,
                "order" => $datas['offset'] + $key + 1,
                "title" => $data->title,
                "created_at" => $data->created_at->isoFormat('dddd, DD MMMM Y HH:mm'),
                "options" => '<div class="tabledit-toolbar btn-toolbar d-block">
                                <div class="btn-group btn-group-sm">
                                    <a href="' . route('emails.updatePage', ['id' => $data->id]) . '" data-toggle="modal" data-target="#modalsm" class="tabledit-edit-button btn btn-sm btn-warning"><span class="glyphicon glyphicon-pencil"></span></a>
                                    <a href="' . route('emails.deletePage', ['id' => $data->id]) . '" data-toggle="modal" data-target="#modalsm" class="tabledit-delete-button btn btn-sm btn-danger"><span class="glyphicon glyphicon-trash"></span></a>
                                </div>
                              </div>'
            ];
        }

        $output = [
            "total" => $datas['total'],
            "rows" => $rows
        ];

        return response()->json($output);
    }
}
