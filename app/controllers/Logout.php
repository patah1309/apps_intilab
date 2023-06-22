<?php

class Logout {
	public function index(){
		session_destroy();
		header('location: '. base_url . '/login');
	}
}