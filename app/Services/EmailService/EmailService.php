<?php

namespace App\Services\EmailService;

use App\Models\Emails\Email;
use App\Repositories\EmailRepository;
use App\Services\EmailService\Output\OutputInterface;

/**
 * Class EmailService
 * @package App\Services\EmailService
 */
class EmailService
{

    /** @var EmailRepository $repository */
    public $repository;

    /**
     * EmailService constructor.
     * @param EmailRepository $repository
     */
    public function __construct(EmailRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param string $sort
     * @param string $sortType
     * @param int $offset
     * @param int $limit
     * @param OutputInterface $output
     * @return mixed
     */
    public function getAllEmails(string $sort, string $sortType, int $offset, int $limit, OutputInterface $output)
    {
        return $output->render($this->repository->getAllEmails($sort, $sortType, $offset, $limit));
    }

    /**
     * @param string $data
     * @return mixed
     */
    public function create(string $data): Email
    {
        return $this->repository->create($data);
    }

    /**
     * @param int $id
     * @return Email
     * @throws \Exception
     */
    public function getById(int $id): Email
    {
        return $this->repository->getById($id);
    }

    /**
     * @param int $id
     * @param string $title
     * @return Email
     */
    public function updateById(int $id, string $title): Email
    {
        return $this->repository->updateById($id, $title);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function deleteById(int $id): bool
    {
        return $this->repository->deleteById($id);
    }

}
