<?php
namespace App\Controllers;

use App\Models\Library;


class LibraryController {

    private $db;
    private $method;
    private $id;

    private $library;

    public function __construct($db, $method, $id)
    {
        $this->db = $db;
        $this->method = $method;
        $this->id = $id;

        $this->library = new Library($db);
    }

    public function processRequest()
    {
        switch ($this->method) {
            case 'GET':
                    $response = $this->getBooks($this->id);
                break;
            case 'POST':
                $response = $this->addNewBook();
                break;
            case 'PUT':
                $response = $this->updateBookById($this->id);
                break;
            case 'DELETE':
                $response = $this->deleteBook($this->id);
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

    private function getBooks($id)
    {
        $result = $this->library->getBooks($id);
        if (! $result) {
            return $this->notFound();
        }
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function addNewBook()
    {
        $request = (array) json_decode(file_get_contents('php://input'), TRUE);
        if (! $this->validate($request)) {
            return $this->validationFailed();
        }
        $this->library->add($request);
        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = null;
        return $response;
    }

    private function updateBookById($id)
    {
        $result = $this->library->get($id);
        if (! $result) {
            return $this->notFound();
        }
        $request = (array) json_decode(file_get_contents('php://input'), TRUE);
        if (! $this->validate($request)) {
            return $this->validationFailed();
        }
        $this->library->update($request);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = null;
        return $response;
    }

    private function deleteBook($id)
    {
        $result = $this->library->get($id);
        if (! $result) {
            return $this->notFound();
        }
        $this->library->delete($id);
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = null;
        return $response;
    }

    private function validate($input)
    {
        if (! isset($input['id'])) {
            return false;
        }
        if (! isset($input['content'])) {
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