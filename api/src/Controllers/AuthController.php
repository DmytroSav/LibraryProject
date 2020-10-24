<?php
namespace App\Controllers;

use App\Models\User;


class AuthController
{

    private $db;
    private $method;
    private $id;

    private $user;

    public function __construct($db, $method, $id)
    {
        $this->db = $db;
        $this->method = $method;
        $this->id = $id;

        $this->user = new User($db);
    }

    /**
     * set PUT for login, because token will be modified
     *
     */
    public function processRequest()
    {
        switch ($this->method) {
            case 'PUT':
                $response = $this->login($this->id);
                break;
            case 'POST':
                $response = $this->saveUser();
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

    private function saveUser()
    {
        $request = (array) json_decode(file_get_contents('php://input'), TRUE);
        if (! $this->validateStoring($request)) {
            return $this->validationFailed();
        }
        $this->user->save($request);
        $userID = $this->user->getLastRecordID();
        $token = md5(uniqid(rand(), true));

        $this->user->storeToken($userID[0]['id'], $token);

        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = $token;
        return $response;
    }

    private function login()
    {
        $request = (array) json_decode(file_get_contents('php://input'), TRUE);
        if (! $this->validateLogin($request)) {
            return $this->validationFailed();
        }

        $passwordRequest = $this->user->getPasswordHash($request['email']);

        $eqal = password_verify ($request['password'], $passwordRequest[0]['password']);

        if($eqal){
            $token = md5(uniqid(rand(), true));

            $this->user->storeToken($passwordRequest[0]['id'], $token);

            $response['status_code_header'] = 'HTTP/1.1 200 OK';
            $response['body'] = $token;
        }
        else {
            $response['body'] = json_encode([
                'status' => '404',
                'error' => 'User Not Found'
            ]);
        }
        return $response;
    }


    private function validateStoring($input)
    {
        if (! isset($input['name'])) {
            return false;
        }
        if (! isset($input['email'])) {
            return false;
        }
        if (! isset($input['password'])) {
            return false;
        }
        return true;
    }

    private function validateLogin($input)
    {
        if (! isset($input['email'])) {
            return false;
        }
        if (! isset($input['password'])) {
            return false;
        }
        return true;
    }

    private function validationFailed()
    {
        $response['status_code_header'] = 'HTTP/1.1 422 Unprocessable Entity';
        $response['body'] = json_encode([
            'error' => 'Invalid input value'
        ]);
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