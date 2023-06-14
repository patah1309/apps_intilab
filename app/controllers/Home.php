<?php
ob_start();
class Home extends Controller {
	public function __construct()
	{	
		if($_SESSION['session_login'] != 'sudah_login') {
			Flasher::setMessage('Login','Tidak ditemukan.','danger');
			header('location: '. base_url . '/login');
			exit;
		} else {
			if(date('Y-m-d H:i:s') == $_SESSION['expired_at']){
				Flasher::setMessage('Login','Tidak ditemukan.','danger');
				header('location: '. base_url . '/login');
				exit;
			}
		}
	} 
	public function index()
	{
		if($_SESSION['versi'] == $this->versi()){
			$data['title'] = 'GPS INTILAB';
			// $val = $this->model('UserModel')->getUserById();
			$data['nama'] = $_SESSION['name'];
			$data['koneksi'] = $this->connection();
			$this->view('templates/header', $data);
			$this->view('templates/sidebar', $data);
			$this->view('home/index', $data);
			$this->view('templates/footer');
		}else {
			session_start();
			session_destroy();
			header('location: '. base_url . '/login');
		}
		
	}
}