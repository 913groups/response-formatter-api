<?php

namespace Groups913\ResponseFormatterApi;

use Psr\Http\Message\ResponseInterface as Response;

class ResponseFormatterAPI
{
    public static function JSON($success, $message, $status, $data, Response $response): Response
    {
        $payload = json_encode([
            'success' => $success,
            'message' => $message,
            'data' => $data == null ? null : $data,
        ]);

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json')->withStatus($status);
    }

    public static function XML($success, $message, $status, $data, Response $response): Response
    {
        $payload = '<?xml version="1.0" encoding="UTF-8"?>' .
            '<response>' .
            '<success>' . ($success ? 'true' : 'false') . '</success>' .
            '<message>' . htmlspecialchars($message) . '</message>' .
            '<data>' . htmlspecialchars(json_encode($data)) . '</data>' .
            '</response>';

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/xml')->withStatus($status);
    }
}
