<?php
// namespace todolist\models;
// use todolist\config\Database;
// use PDO;
include_once('./config/Database.php');

class Todolist extends Database {


    private $table = 'list';

    public $id;
    public $body;
    public $created_at;
    public $updated_at;

    public function read()
    {
        $sql_query = 'SELECT
                l.id,
                l.body,
                l.created_at,
                l.updated_at
            FROM
                '.$this->table.' l 
            ORDER BY
                l.updated_at DESC';

        $stmt = $this->conn->prepare($sql_query);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);;
    }

    public function read_single()
    {
        $sql_query = 'SELECT
                l.id,
                l.body,
                l.created_at,
                l.updated_at
            FROM
                '.$this->table.' l
            WHERE l.id = :id
            LIMIT 0, 1';

        // Prepare Statement 
        $stmt = $this->conn->prepare($sql_query);

        // Bind ID
        $stmt->bindValue(":id", $this->id, PDO::PARAM_INT);

        // execute query
        $stmt->execute();

        //if Post Exist
        if($stmt->rowCount() > 0){

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // set properties
            // $this->body = $row['body'];
            // $this->created_at = $row['created_at'];
            // $this->updated_at = $row['updated_at'];

            return $row;
        }
        else{
            return false;
        }
       
    }


    public function create()
    {
        $sql_query ='INSERT INTO '.
            $this->table.'
            SET
                body = :body';

        // prepare query
        $stmt = $this->conn->prepare($sql_query);

        // clean/ sanitize input       
        $this->body = htmlspecialchars(strip_tags($this->body));

        // Bind Parameters
        $stmt->bindParam(":body", $this->body, PDO::PARAM_STR);

        // execute query
        if ($stmt->execute()) {
            
         return true;   
        }
        else{
            // print error if exist
            print_r("Error: %s \n". $stmt->error);
            return false;
        }
    }


    public function update()
    {
        $sql_query ='UPDATE '.
            $this->table.'
            SET
                body = :body
            WHERE
                id = :id';

        // prepare query
        $stmt = $this->conn->prepare($sql_query);

        // clean/ sanitize input
        $this->body = htmlspecialchars(strip_tags($this->body));

        // Bind Parameters
        $stmt->bindParam(":body", $this->body, PDO::PARAM_STR);
        $stmt->bindParam(":id", $this->id, PDO::PARAM_INT);

        // execute query
        if ($stmt->execute()) {
            
         return true;   
        }
        else{
            // print error if exist
            print_r("Error: %s \n". $stmt->error);
            return false;
        }
    }

    public function delete()
    {
        // clean id
        $this->id = htmlspecialchars(strip_tags($this->id));

        // sql query
        $sql_query = 'DELETE 
                FROM '.$this->table.'
                WHERE
                    id = :id';

        // prepare statement 
        $stmt = $this->conn->prepare($sql_query);

        // Bind value
        $stmt->bindValue(":id", $this->id);

        // execute statement
        if($stmt->execute()){
            return true;
        }
        else{
            printf("Error: %s ", $stmt->error);
            return false;
        }
    }

}


?>