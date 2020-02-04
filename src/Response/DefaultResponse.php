<?php


namespace App\Response;


use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultResponse extends JsonResponse
{
    /**
     * DefaultResponse constructor.
     *
     * @param null $data
     * @param int $status
     * @param array $headers
     * @param bool $json
     * @param $message
     */
    public function __construct($data = null, int $status = 200, array $headers = [], bool $json = true, $message = "OK")
    {
        $response['message'] = $message;
        $response['data'] = $data;
        parent::__construct(json_encode($response), $status, $headers, $json);
    }
}
