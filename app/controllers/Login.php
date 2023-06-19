<?php

class Login extends Controller {
	public function index()
	{
		// var_dump(base_api);
		$data['title'] = 'Halaman Login';

		$this->view('login/login2', $data);
	}

	public function prosesLogin() {
		// var_dump(base_api);
		$row = $this->model('LoginModel')->checkLogin($_POST);
		
		if($row['message'] == 'Login Success'){
			$_SESSION['token'] = $row['session']['token'];
			$_SESSION['created_at'] = $row['session']['created_at']; //1 admin 2 user
			$_SESSION['expired_at'] = $row['session']['expired_at'];
			$_SESSION['session_login'] = 'sudah_login';
			$_SESSION['name'] = $row['name'];
			$_SESSION['versi'] = $row['session']['apps_ver'];
			header('location: '. base_url . '/home');
		} else {
			Flasher::setMessage($row['message'],'','danger');
			header('location: '. base_url . '/login');
			exit;	
		}
	}
}