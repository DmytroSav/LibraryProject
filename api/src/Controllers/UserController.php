<?php
namespace App\Controllers;

use App\Models\User;


class UserController
{

    private $db;
    private $method;

    private $user;

    public function __construct($db, $method)
    {
        $this->db = $db;
        $this->method = $method;

        $this->user = new User($db);
    }

    public function processRequest()
    {
        switch ($this->method) {
            case 'POST':
                $response = $this->getUser();
                break;
            default:
                $response = $this->notFound();
                break;
        }
        header($response['status_code_header']);
        if ($response['body']) {
            echo $response['body'];
        }
    }

    private function getUser()
    {
        $request = (array) json_decode(file_get_contents('php://input'), TRUE);

        $result = $this->user->checkUserByToken($request);
        if (! $result) {
            return $this->notFound();
        }
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function notFound()
    {
        $response['body'] = json_encode([
            'status' => '404',
            'error' => 'Not Found'
        ]);
        return $response;
    }
}