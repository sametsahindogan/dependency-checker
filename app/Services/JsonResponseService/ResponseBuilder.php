<?php


namespace App\Services\JsonResponseService;

/**
 * Class ResponseBuilder
 * @package App\Services\JsonResponseService
 */
class ResponseBuilder implements ResponseBuilderInterface
{
    /** @var array $fields */
    protected $fields = [];

    /** @var string $message */
    protected $message = '';

    /** @var bool $result */
    protected $result = true;

    /**
     * @param bool $result
     * @return $this
     */
    public function result(bool $result): self
    {
        $this->result = $result;

        return $this;
    }

    /**
     * @param String $message
     * @return $this
     */
    public function message(String $message): self
    {
        $this->message = trim($message);

        return $this;
    }

    /**
     * @param array $fields
     * @return $this
     */
    public function fields(array $fields): self
    {
        $this->fields = $fields;

        return $this;
    }

    /**
     * @return array
     */
    public function build(): array
    {
        return [
            'result' => $this->result,
            'fields' => $this->fields,
            'message' => $this->message
        ];
    }

}
