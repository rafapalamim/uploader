<?php

namespace Codemim\Uploader;

class Response
{
    private $message;
    private $status;
    private $errcode;

    function __construct()
    {
    }

    public function set()
    {
    }

    public function render(bool $json = false)
    {
    }

    private function toJson(array $response): void
    {
        echo json_encode($response, JSON_PRETTY_PRINT);
    }
}
