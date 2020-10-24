<?php
namespace App\Models;

class Library {

    private $db = null;

    public function __construct($db){
        $this->db = $db;
    }
    public function getBooks($user_id)
    {
        $statement = "
            SELECT 
                id, content
            FROM
                library
            WHERE
                user_id = ?;
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array($user_id));
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function get($id)
    {
        $statement = "
            SELECT 
                id, content
            FROM
                library
            WHERE
                id = ?;
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array($id));
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function add(Array $input)
    {
        $statement = "
            INSERT INTO library 
                (user_id, content)
            VALUES
                (:user_id, :content);
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array(
                'user_id' => $input['id'],
                'content'  => $input['content'],
            ));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function update(Array $input)
    {
        $statement = "
            UPDATE library
            SET 
                book_name = :book_name
            WHERE 
                id = :book_id;
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array(
                'book_id'  => $input['id'],
                'content' => $input['content']
            ));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function delete($id)
    {
        $statement = "
            DELETE FROM library
            WHERE id = :id;
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array('id' => $id));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }


}