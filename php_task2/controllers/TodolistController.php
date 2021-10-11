<?php
// namespace todolist\controllers;

//import Todolist model and their namespace
include_once('./models/Todolist.php');

// use todolist\models\Todolist;

class TodolistController extends Todolist{

    public function index()
    {
        $this->connect();

        $res = $this->read();

        $this->disconnect();

        return $res;

    }

    public function c_create($request)
    {
        $this->connect();
        $res = false;
       
        if (filter_input(INPUT_POST, "body", FILTER_SANITIZE_STRING)) {
            $this->body = $request['body'];
            $res = $this->create();
            
        }

       if($res){
           return "Task Created Successfuly";
       }
       else{
           return "unable to create task! correct your input";
       }

    }

    public function c_show($id)
    {
        $this->connect();

        $this->id = $id;
        $res = $this->read_single();

        $this->disconnect();

        return $res;
    }

    public function c_update($request, $id)
    {
       $this->connect();
        
        $this->id = $id;

        if (filter_input(INPUT_POST, "body", FILTER_SANITIZE_STRING)) {
            $this->body = $request['body'];
            $res = $this->update();
            
        }

        $this->disconnect();

        if($res){
            return "Task Updated Successfuly";
        }
        else{
            return "unable to update task!";
        }
    }
    
    public function c_delete($id)
    {
        $this->connect();

        $this->id = $id;
        $res = $this->delete();

        $this->disconnect();

        if($res){
            return "Task deleted Successfuly";
        }
        else{
            return "unable to delete task!";
        }
    }


}



?>