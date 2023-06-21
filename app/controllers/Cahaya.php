<?php

class Cahaya extends Controller {
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
		$data['total_data'] = $this->model('CahayaModel')->getJsonData();
		$this->view('templates/header', $data);
		$this->view('templates/sidebar', $data);
		$this->view('cahaya/index', $data);
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
		$data['data'] = $this->model('CahayaModel')->GetListData();
		$data['akses'] = $this->model('CahayaModel')->Permission();
		$this->view('templates/header', $data);
		$this->view('templates/sidebar', $data);
		$this->view('cahaya/data', $data);
		$this->view('templates/footer');
	}

	public function approvedat(){
		$val = $this->model('CahayaModel')->ApproveDat($_POST['id']);
		echo $val;
	}
	public function hapusdat(){
		$val = $this->model('CahayaModel')->HapusDat($_POST['id']);
		echo $val;
	}


	public function add_data(){
		$data['title'] = 'APPS INTILAB';
		$data['token'] = $_SESSION['token'];
		$this->view('templates/header', $data);
		$this->view('templates/sidebar', $data);
		$this->view('cahaya/input', $data);
		$this->view('templates/footer');
	}

	public function penumum($data) {
		$template = '<div class="card-body"><div class="row"><div class="col-sm-4"><div class="card-body"><table><tr><th></th><th></th><th></th></tr><tr class="detail"><td class="data">Nama Sampler</td><td>:</td><td><span>'.$data->sampler.'</span></td></tr><tr class="detail"><td class="data">No Sample</td><td>:</td><td><span>'.$data->no_sample.'</span></td></tr><tr class="detail"><td class="data">No Order</td><td>:</td><td><span>'.$data->no_order.'</span></td></tr><tr class="detail"><td class="data">Nama Perusahaan</td><td>:</td><td><span>'.$data->corp.'</span></td></tr><tr class="detail"><td class="data">Penamaan Titik</td><td>:</td><td><span>'.$data->keterangan.'</span></td></tr><tr class="detail"><td class="data">Penamaan Tambahan</td><td>:</td><td><span>'.$data->info_tambahan.'</span></td></tr><tr class="detail"><td class="data">Kategori</td><td>:</td><td><span>'.$data->categori.'</span></td></tr><tr class="detail"><td class="data">Panjang Area</td><td>:</td><td><span>'.$data->panjang.'</span></td></tr><tr class="detail"><td class="data">Lebar Area</td><td>:</td><td><span>'.$data->lebar.'</span></td></tr><tr class="detail"><td class="data">Luas Area</td><td>:</td><td><span>'.$data->luas.'</span></td></tr><tr class="detail"><td class="data">Jumlah Pekerja</td><td>:</td><td><span>'.$data->jml_kerja.'</span></td></tr><tr class="detail"><td class="data">Jam Mulai</td><td>:</td><td><span>'.$data->mulai.'</span></td></tr><tr class="detail"><td class="data">Jam Selesai</td><td>:</td><td><span>'.$data->selesai.'</span></td></tr><tr class="detail"><td class="data">Jenis Lampu</td><td>:</td><td><span>'.$data->jenis_lampu.'</span></td></tr><tr class="detail"><td class="data">Jumlah Titik</td><td>:</td><td><span>'.$data->jml_titik_p.' titik</span></td></tr></table></div></div><div class="col-sm-6"><div class="card-body"><div class="row mb-2"><div class="col-12"><h6 class="data font-weight-bold">Aktifitas Setiap Area</h6></div><div class="col-12"><div style="overflow-y:scroll;overflow-x:scroll;width:320px">'.$data->aktifitas.'</div></div></div><div class="row mb-2"><div class="col-12"><h6 class="data font-weight-bold">Hasil Pengukuran Titik</h6></div><div class="col-12"><div id="cahaya" style="overflow-y:scroll;overflow-x:scroll;width:320px"></div></div></div></div></div><div class="col-sm-6"><div class="card-body"><div class="text-center"><a href="'.base_foto.$data->foto_lok.'" data-lightbox="image-1" data-title="'.$data->no_sample.'"><img style="width:150px" src="'.base_foto.$data->foto_lok.'" class="img-fluid"></a></div><div class="card-body"><div><h5 class="card-title" style="float:left">Foto Lokasi Sample</h5><a href="'.base_foto.$data->foto_lok.'" style="float:right;border-radius:5px" id="foto-d" type="button" class="btns btn-success">Download</a></div></div></div></div><div class="col-sm-6"><div class="card-body"><div class="text-center"><a href="'.base_foto.$data->foto_lain.'" data-lightbox="image-1" data-title="'.$data->no_sample.'"><img style="width:150px" src="'.base_foto.$data->foto_lain.'" class="img-fluid"></a></div><div class="card-body"><div><h5 class="card-title" style="float:left">Foto Roadmap Pengujian</h5><a href="'.base_foto.$data->foto_lain.'" style="float:right;border-radius:5px" id="foto-d" type="button" class="btns btn-success">Download</a></div></div></div></div></div></div>';
			return $template;
	}
	public function penses($data) {
		$template = '<div class="card-body"><div class="row"><div class="col-sm-4"><div class="card-body"><table><tr><th></th><th></th><th></th></tr><tr class="detail"><td class="data">Nama Sampler</td><td>:</td><td><span>'.$data->sampler.'</span></td></tr><tr class="detail"><td class="data">No Sample</td><td>:</td><td><span>'.$data->no_sample.'</span></td></tr><tr class="detail"><td class="data">No Order</td><td>:</td><td><span>'.$data->no_order.'</span></td></tr><tr class="detail"><td class="data">Nama Perusahaan</td><td>:</td><td><span>'.$data->corp.'</span></td></tr><tr class="detail"><td class="data">Penamaan Titik</td><td>:</td><td><span>'.$data->keterangan.'</span></td></tr><tr class="detail"><td class="data">Penamaan Tambahan</td><td>:</td><td><span>'.$data->info_tambahan.'</span></td></tr><tr class="detail"><td class="data">Kategori</td><td>:</td><td><span>'.$data->categori.'</span></td></tr><tr class="detail"><td class="data">Area Sampling</td><td>:</td><td><span>'.$data->jenis_tem.'</span></td></tr><tr class="detail"><td class="data">Jam Pengambilan</td><td>:</td><td><span>'.$data->waktu.'</span></td></tr><tr class="detail"><td class="data">Jenis Lampu</td><td>:</td><td><span>'.$data->jenis_lampu.'</span></td></tr><tr class="detail"><td class="data">Jumlah Titik</td><td>:</td><td><span>'.$data->jml_titik_p.' titik</span></td></tr></table></div></div><div class="col-sm-6"><div class="card-body"><div class="row mb-2"><div class="col-12"><h6 class="data font-weight-bold">Hasil Pengukuran Titik</h6></div><div class="col-12"><div id="cahaya" style="overflow-y:scroll;overflow-x:scroll;width:320px"></div></div></div></div></div><div class="col-sm-6"><div class="card-body"><div class="text-center"><a href="'.base_foto.$data->foto_lok.'" data-lightbox="image-1" data-title="'.$data->no_sample.'"><img style="width:150px" src="'.base_foto.$data->foto_lok.'" class="img-fluid"></a></div><div class="card-body"><div><h5 class="card-title" style="float:left">Foto Lokasi Sample</h5><a href="'.base_foto.$data->foto_lok.'" style="float:right;border-radius:5px" id="foto-d" type="button" class="btns btn-success">Download</a></div></div></div></div><div class="col-sm-6"><div class="card-body"><div class="text-center"><a href="'.base_foto.$data->foto_lain.'" data-lightbox="image-1" data-title="'.$data->no_sample.'"><img style="width:150px" src="'.base_foto.$data->foto_lain.'" class="img-fluid"></a></div><div class="card-body"><div><h5 class="card-title" style="float:left">Foto Roadmap Pengujian</h5><a href="'.base_foto.$data->foto_lain.'" style="float:right;border-radius:5px" id="foto-d" type="button" class="btns btn-success">Download</a></div></div></div></div></div></div>';
			return $template;
	}

	public function showData($id){
		$val = $this->model('CahayaModel')->showDetail($id);
		if($val->categori == 'Pencahayaan Umum') {
			$template = Self::penumum($val);
		}else if($val->categori == 'Pencahayaan Setempat') {
			$template = Self::penses($val);
		}
		$data['title'] = 'APPS INTILAB';
		$data['token'] = $_SESSION['token'];
		$data['template'] = $template;
		$data['nilai_peng'] = $val->nilai_peng;
		$this->view('templates/header', $data);
		$this->view('templates/sidebar', $data);
		$this->view('cahaya/detail', $data);
		$this->view('templates/footer');
	}
	public function getSampel(){
		$no_sample = $_POST['no_sample'];
		$val = $this->model('CahayaModel')->GetData($no_sample);
		echo $val;
	}

	public function saveData(){
		$kon = $this->connection();
		$save = $this->model('CahayaModel')->saveData($kon, $_POST);
		echo json_encode($save['status']);
	}

	public function upload_data_to_server(){
		$data = $this->model('CahayaModel')->syncronize();
		echo $data;
	}

}