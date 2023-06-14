<?php

class Controller{
	public function view($view, $data = [])
	{
		require_once '../app/views/' . $view . '.php';
	}

	public function model($model)
	{
		require_once '../app/models/' . $model . '.php';
		return new $model;
	}
	public function connection(){
		$connected = @fsockopen("www.google.com", 80); 
                                        //website, port  (try 80 or 443)
		if ($connected){
			$is_conn = true; //action when connected
			fclose($connected);
		}else{
			$is_conn = false; //action in connection failure
		}
		return $is_conn;
	}
	public function versi(){
		return '3.0.0';
	}
}