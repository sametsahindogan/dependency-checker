<?php


namespace App\Services\GitService\Output;

use Illuminate\Http\JsonResponse;

/**
 * Class JsonOutput
 * @package App\Services\GitService\Output
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
                "provider" =>'<img src="' . asset('start-ui/img/' . $data->gitProvider->title . '.png') . '" width="75">',
                "status" => getStatus($data->status),
                "slug" => '<a href="' . route('dependencies', ['repo_slug' => $data->repo_slug, 'project_slug' => $data->project_slug]) . '"><b>' . $data->repo_slug . '/' . $data->project_slug . '</b></a>',
                "checked_at" => $data->checked_at ? $data->checked_at->isoFormat('DD MMMM Y HH:mm') : '-',
                "created_at" => $data->created_at->isoFormat('DD MMMM Y HH:mm'),
            ];
        }

        $output = [
            "total" => $datas['total'],
            "rows" => $rows
        ];

        return response()->json($output);
    }
}
