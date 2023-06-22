<?php

class Getaranling extends Controller {
	public function __construct()
	{	
        date_default_timezone_set('Asia/Jakarta');

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
            
            $date = DATE('H:i:s');
            if($date > '01:00:00' && $date < '10:00:00'){
                $status = 'Selamat Pagi';
            } else if ($date > '10:00:01' && $date < '15:00:00'){
                $status = 'Selamat Siang';
            } else if ($date > '15:00:01' && $date < '18:00:00'){
                $status = 'Selamat Sore';
            } else {
                $status = 'Selamat Malam';
            }
		$data['title'] = 'APPS INTILAB';
		$data['nama'] = $_SESSION['name'];
		$data['salam'] = $status;
		$data['koneksi'] = $this->connection();
		$data['total_data'] = $this->model('GetaranLingModel')->getJsonData();
		$this->view('templates/header', $data);
		$this->view('templates/sidebar', $data);
		$this->view('getaranling/index', $data);
		$this->view('templates/footer');
		}else {
			session_start();
			session_destroy();
			header('location: '. base_url . '/login');
		}
		
	}

	public function data(){
		$data['title'] = 'APPS INTILAB';
		$data['token'] = $_SESSION['token'];
		$data['koneksi'] = $this->connection();
		$data['data'] = $this->model('GetaranLingModel')->GetListData();
		$data['akses'] = $this->model('GetaranLingModel')->Permission();
		$this->view('templates/header', $data);
		$this->view('templates/sidebar', $data);
		$this->view('getaranling/data', $data);
		$this->view('templates/footer');
	}

	public function approvedat(){
		$val = $this->model('GetaranLingModel')->ApproveDat($_POST['id']);
		echo $val;
	}
	public function hapusdat(){
		$val = $this->model('GetaranLingModel')->HapusDat($_POST['id']);
		echo $val;
	}


	public function add_data(){
		$data['title'] = 'APPS INTILAB';
		$data['token'] = $_SESSION['token'];
		$this->view('templates/header', $data);
		$this->view('templates/sidebar', $data);
		$this->view('getaranling/input', $data);
		$this->view('templates/footer');
	}

	public function templat($data) {
		if($data->frek != null) {
			$frek = $data->frek.' Hz';
		}else {
			$frek = '- Hz';
		}
		$template = '<div class="card-body"><div class="row"><div class="col-sm-4" id="bang4"><div class="card-body"><table><tr><th></th><th></th><th></th></tr><tr class="detail"><td class="data">Nama Sampler</td><td>:</td><td><span>'.$data->sampler.'</span></td></tr><tr class="detail"><td class="data">No Sample</td><td>:</td><td><span>'.$data->no_sample.'</span></td></tr><tr class="detail"><td class="data">No Order</td><td>:</td><td><span>'.$data->no_order.'</span></td></tr><tr class="detail"><td class="data">Nama Perusahaan</td><td>:</td><td><span>'.$data->corp.'</span></td></tr><tr class="detail"><td class="data">Kategori</td><td>:</td><td><span>'.$data->categori.'</span></td></tr><tr class="detail"><td class="data">Penamaan Titik</td><td>:</td><td><span>'.$data->keterangan.'</span></td></tr><tr class="detail"><td class="data">Penamaan Tambahan</td><td>:</td><td><span>'.$data->keterangan_2.'</span></td></tr><tr class="detail"><td class="data">Sumber Getaran</td><td>:</td><td><span>'.$data->sumber_get.'</span></td></tr><tr class="detail"><td class="data">jarak Getaran</td><td>:</td><td><span>'.$data->jarak_get.' m</span></td></tr><tr class="detail"><td class="data">Kondisi</td><td>:</td><td><span>'.$data->kondisi.'</span></td></tr><tr class="detail"><td class="data">Intensitas</td><td>:</td><td><span>'.$data->intensitas.'</span></td></tr><tr class="detail"><td class="data">Satuan Kecepatan</td><td>:</td><td><span>'.$data->sat_kec.'</span></td></tr><tr class="detail"><td class="data">Satuan Percepatan</td><td>:</td><td><span>'.$data->sat_per.'</span></td></tr><tr class="detail"><td class="data">Frekuensi</td><td>:</td><td><span>'.$frek.'</span></td></tr><tr class="detail"><td class="data">Jam Pengambilan</td><td>:</td><td><span>'.$data->waktu.'</span></td></tr></table></div></div><div class="col-sm-8" id="bang2"><div class="card-body"><div class="row"><div class="row mb-2"><div class="col-12"><h6 class="data font-weight-bold">Hasil Pengukuran</h6></div><div class="col-12"><div id="getaran" style="overflow-y:scroll;overflow-x:scroll;width:320px"></div></div></div></div></div></div><div class="col-sm-6"><div class="card-body"><div class="text-center"><a href="'.base_foto.$data->foto_lok.'" data-lightbox="image-1" data-title="'.$data->no_sample.'"><img style="width:150px" src="'.base_foto.$data->foto_lok.'" class="img-fluid"></a></div><div class="card-body"><div><h5 class="card-title" style="float:left">Foto Lokasi Sample</h5><a href="javascript:;" value="'.base_foto.$data->foto_lok.'" onclick="fotoD(this)" style="float:right;border-radius:5px" id="foto-d" type="button" class="btns btn-success" download="'.$data->foto_lok.'">Download</a></div></div></div></div><div class="col-sm-6"><div class="card-body"><div class="text-center"><a href="'.base_foto.$data->foto_lain.'" data-lightbox="image-1" data-title="'.$data->no_sample.'"><img style="width:150px" src="'.base_foto.$data->foto_lain.'" class="img-fluid"></a></div><div class="card-body"><div><h5 class="card-title" style="float:left">Foto Lain lain</h5><a href="'.base_foto.$data->foto_lain.'" style="float:right;border-radius:5px" id="foto-d" type="button" class="btns btn-success" download="'.$data->foto_lain.'">Download</a></div></div></div></div></div></div>';
			return $template;
	}

	public function showData($id){
		$val = $this->model('GetaranLingModel')->showDetail($id);
		$template = Self::templat($val);
		$data['title'] = 'APPS INTILAB';
		$data['token'] = $_SESSION['token'];
		$data['template'] = $template;
		$data['id_kat'] = $val->id_kat;
		$data['pengukuran'] = $val->pengukuran;
		$this->view('templates/header', $data);
		$this->view('templates/sidebar', $data);
		$this->view('getaranling/detail', $data);
		$this->view('templates/footer');
	}
	public function getSampel(){
		$no_sample = $_POST['no_sample'];
		$val = $this->model('GetaranLingModel')->GetData($no_sample);
		echo $val;
	}

	public function saveData(){
		$kon = $this->connection();
		$save = $this->model('GetaranLingModel')->saveData($kon, $_POST);
		echo json_encode($save['status']);
		// header('location: '. base_url . '/air');
	}

	public function upload_data_to_server(){
		$data = $this->model('GetaranLingModel')->syncronize();
		echo $data;
	}

}