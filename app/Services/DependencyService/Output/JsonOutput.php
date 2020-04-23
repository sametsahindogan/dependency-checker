<?php


namespace App\Services\DependencyService\Output;

use Illuminate\Http\JsonResponse;

/**
 * Class JsonOutput
 * @package App\Services\DependencyService\Output
 */
class JsonOutput implements OutputInterface
{

    /**
     * @param $data
     * @return JsonResponse
     */
    public function render($data): JsonResponse
    {
        $rows = [];
        foreach ($data->dependencies as $key => $data) {

            $rows[] = [
                "id" => $data->id,
                "type" => '<img src="' . asset('start-ui/img/' . $data->type->title . '.png') . '">',
                "title" => '<b>' . $data->title . '</b>',
                "current_version" => $data->current_version,
                "latest_version" => $data->latest_version,
                "status" => getStatus($data->status)
            ];
        }

        $output = [
            "rows" => $rows
        ];

        return response()->json($output);
    }
}
