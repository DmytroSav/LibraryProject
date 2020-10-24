<?php
namespace App\Models;

class User
{

    private $db = null;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function save($input){
        $statement = "
            INSERT INTO users 
                (name, email, password)
            VALUES
                (:user_name, :user_email, :user_password);
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array(
                'user_name' => $input['name'],
                'user_email'  => $input['email'],
                'user_password'  => password_hash($input['password'], PASSWORD_DEFAULT),
            ));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function getLastRecordID()
    {
        $statement = "
           SELECT id
           FROM users
            ORDER BY  id 
            DESC LIMIT 1;
        ";

        try {
            $statement = $this->db->query($statement);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function getPasswordHash($email){
            $statement = "
            SELECT 
                id, password
            FROM
                users
            WHERE
                email = ?;
        ";

            try {
                $statement = $this->db->prepare($statement);
                $statement->execute(array($email));
                $p =  $statement->fetchAll(\PDO::FETCH_ASSOC);
                return $p;
            } catch (\PDOException $e) {
                exit($e->getMessage());
            }
    }

    public function storeToken($id, $token){
        $statement = "
            UPDATE users
            SET 
                token = :token
            WHERE 
                id = :id;
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array(
                'id' => $id,
                'token'  => $token
            ));
            return $statement->rowCount();;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function checkUserByToken($inputs){
        $statement = "
            SELECT 
                id, name
            FROM
                users
            WHERE
                token = ?;
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array($inputs['token']));
            $user = $statement->fetchAll(\PDO::FETCH_ASSOC);
            return $user;
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }
}