<?php


namespace App\Repositories;

use App\Models\Emails\Email;
use Exception;

/**
 * Class EmailRepository
 * @package App\Repositories
 */
class EmailRepository
{
    /** @var Email $model */
    private $model;

    /**
     * EmailRepository constructor.
     * @param Email $model
     */
    public function __construct(Email $model)
    {
        $this->model = $model;
    }

    /**
     * @param string $sort
     * @param string $sortType
     * @param int $offset
     * @param int $limit
     * @return array
     */
    public function getAllEmails(string $sort = 'id', string $sortType = 'desc', int $offset = 0, int $limit = 0): array
    {
        $queryBuilder = $this->model;

        $total = $queryBuilder->count();

        $datas = $queryBuilder->orderBy($sort, $sortType)
            ->offset($offset)
            ->limit($limit)
            ->get();


        return [
            'total' => $total,
            'datas' => $datas,
            'offset' => $offset
        ];
    }

    /**
     * @param string $data
     * @return Email
     */
    public function create(string $data): Email
    {
        return $this->model::create(['title' => $data]);
    }

    /**
     * @param int $id
     * @return Email
     * @throws Exception
     */
    public function getById(int $id): Email
    {
        $email = $this->model->find($id);

        if (!$email) {
            throw new Exception('Email not found.');
        }

        return $email;
    }

    /**
     * @param int $id
     * @param string $title
     * @return Email
     * @throws Exception
     */
    public function updateById(int $id, string $title): Email
    {
        return $this->getById($id)->updateTitle($title);
    }

    /**
     * @param $id
     * @return bool
     * @throws Exception
     */
    public function deleteById(int $id): bool
    {
        return $this->getById($id)->delete();
    }
}
