<?php

class Air extends Controller {
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
		$data['total_data'] = $this->model('AirModel')->getJsonData();
		$this->view('templates/header', $data);
		$this->view('templates/sidebar', $data);
		$this->view('air/index', $data);
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
		$data['data'] = $this->model('AirModel')->GetListData();
		$data['akses'] = $this->model('AirModel')->Permission();
		$this->view('templates/header', $data);
		$this->view('templates/sidebar', $data);
		$this->view('air/data', $data);
		$this->view('templates/footer');
	}

	public function approvedat(){
		$val = $this->model('AirModel')->ApproveDat($_POST['id']);
		echo $val;
	}
	public function hapusdat(){
		$val = $this->model('AirModel')->HapusDat($_POST['id']);
		echo $val;
	}


	public function add_data(){
		$data['title'] = 'APPS INTILAB';
		$data['token'] = $_SESSION['token'];
		$this->view('templates/header', $data);
		$this->view('templates/sidebar', $data);
		$this->view('air/input', $data);
		$this->view('templates/footer');
	}

	public function permukaan($data) {

		if($data->jenis_fungsi_air == null) {
			$j = $data->jenis_fungsi_air;
		}else {
			$j = preg_replace('~[\\\\/:*?"<>|+-]~', '', $data->jenis_fungsi_air);
		}
		if($data->pengawet == null) {
			$j1 = $data->pengawet;
		}else {
			$j1 = preg_replace('~[\\\\/:*?"<>|+-]~', '', $data->pengawet);
		}
		if($data->teknik == null) {
			$sampling = $data->teknik;
		}else {
			$sampling = str_replace("_"," ",$data->teknik);
		}
		if($data->perlakuan_penyaringan == null) {
			$per_peny = $data->perlakuan_penyaringan;
		}else {
			$per_peny = str_replace("_", " ", $data->perlakuan_penyaringan);
		}
		if($data->pengendalian_mutu == null) {
			$mutu = $data->pengendalian_mutu;
		}else {
			$mutu =preg_replace('~[\\\\/:*?"<>|+-]~', '', $data->pengendalian_mutu);
		}
		if($data->warna == null) {
			$warna = $data->warna;
		}else {
			$warna = str_replace("_"," ",$data->warna);
		}
		if($data->bau == null) {
			$bau = $data->bau;
		}else {
			$bau = str_replace("_"," ",$data->bau);
		}
					$template ='<div class="card-body"><div class="row"><div class="col-sm-3"><div class="card-body"><table><tr><th></th><th></th><th></th></tr><tr class="detail"><td class="data">Nama Sampler</td><td>:</td><td><span>'.$data->sampler.'</span></td></tr><tr class="detail"><td class="data">No Sample</td><td>:</td><td><span>'.$data->no_sample.'</span></td></tr><tr class="detail"><td class="data">No Order</td><td>:</td><td><span>'.$data->no_order.'</span></td></tr><tr class="detail"><td class="data">Jenis Sample</td><td>:</td><td><span>'.$data->jenis.'</span></td></tr><tr class="detail"><td class="data">Nama Perusahaan</td><td>:</td><td><span>'.$data->corp.'</span></td></tr><tr class="detail" id="titik_pengambilan"><td class="data">Jumlah Titik Pengambilan</td><td>:</td><td><span>'.$data->jumlah_titik_pengambilan.'</span></td></tr><tr class="detail"><td class="data">Penamaan Titik</td><td>:</td><td><span>'.$data->keterangan.'</span></td></tr><tr class="detail"><td class="data">Penamaan Tambahan</td><td>:</td><td><span>'.$data->info_tambahan.'</span></td></tr><tr class="detail" id="fungsiair"><td class="data">Jenis Fungsi Air</td><td>:</td><td><span>'.$j.'</span></td></tr><tr class="detail"><td class="data">Jenis Pengawet</td><td>:</td><td><span>'.$j1.'</span></td></tr><tr class="detail"><td class="data">Teknik Sampling</td><td>:</td><td><span>'.$sampling.'</span></td></tr><tr class="detail" id="jam_peng"><td class="data">Jam Pengambilan</td><td>:</td><td><span>'.$data->jam.'</span></td></tr><tr class="detail"><td class="data">Perlakuan Penyaringan</td><td>:</td><td><span>'.$per_peny.'</span></td></tr><tr class="detail"><td class="data">pengendalian Mutu</td><td>:</td><td><span>'.$mutu.'</span></td></tr><tr class="detail" id="pengukuran_debit"><td class="data">Teknik Pengukuran Debit</td><td>:</td><td><span>'.$data->teknik_pengukuran_debit.'</span></td></tr><tr class="detail"><td class="data">Volume</td><td>:</td><td><span>'.$data->volume.' ml</span></td></tr><tr class="detail"><td class="data">Warna</td><td>:</td><td><span>'.$warna.'</span></td></tr><tr class="detail"><td class="data">Bau</td><td>:</td><td><span>'.$bau.'</span></td></tr><tr class="detail"><td class="data">Ph</td><td>:</td><td><span>'.$data->ph.'</span></td></tr><tr class="detail" id="dhl_"><td class="data">DHL</td><td>:</td><td><span>'.$data->dhl.'</span></td></tr><tr class="detail"><td class="data">Suhu Air</td><td>:</td><td><span>'.$data->suhu_air.' ℃</span></td></tr><tr class="detail"><td class="data">Suhu Udara</td><td>:</td><td><span>'.$data->suhu_udara.' ℃</span></td></tr><tr class="detail" id="debit_air"><td class="data">Debit</td><td>:</td><td><span>'.$data->debit.'</span></td></tr><tr class="detail" id="klor_bebas"><td class="data">Klor Bebas</td><td>:</td><td><span>'.$data->klor_bebas.'</span></td></tr><tr class="detail"><td class="data">Koordinat</td><td>:</td><td><span>'.$data->coor.'</span></td></tr></table></div></div><div class="col-sm-6"><div class="card-body"><div class="text-center"><a href="'.base_foto.$data->foto_lok.'" data-lightbox="image-1" data-title="'.$data->no_sample.'"><img style="width:150px" src="'.base_api.$data->foto_lok.'" class="img-fluid"></a></div><div class="card-body"><div><h5 class="card-title" style="float:left">Foto Lokasi Sample</h5><a href="'.base_foto.$data->foto_lok.'" style="float:right;border-radius:5px" id="foto-d" type="button" class="btns btn-success">Download</a></div></div></div></div><div class="col-sm-6"><div class="card-body"><div class="text-center"><a href="'.base_foto.$data->foto_kondisi.'" data-lightbox="image-1" data-title="'.$data->no_sample.'"><img style="width:150px" src="'.base_api.$data->foto_kondisi.'" class="img-fluid"></a></div><div class="card-body"><div><h5 class="card-title" style="float:left">Foto Kondisi Sample</h5><a href="'.base_foto.$data->foto_kondisi.'" style="float:right;border-radius:5px" id="foto-d" type="button" class="btns btn-success">Download</a></div></div></div></div><div class="col-sm-6"><div class="card-body"><div class="text-center"><a href="'.base_foto.$data->foto_lain.'" data-lightbox="image-1" data-title="'.$data->no_sample.'"><img style="width:150px" src="base_api'.$data->foto_lain.'" class="img-fluid"></a></div><div class="card-body"><div><h5 class="card-title" style="float:left">Foto Lain lain</h5><a href="'.base_foto.$data->foto_lain.'" style="float:right;border-radius:5px" id="foto-d" type="button" class="btns btn-success">Download</a></div></div></div></div><div class="col-sm-6"><div class="card-body"><div id="latlongmap" class="cd-4" style="width:100%;margin:5px 0;z-index:0;box-shadow:0 2px 4px rgba(0,0,0,.25);height:300px"></div></div></div></div></div>';
			return $template;
	} 

	public function limbah($data) {

		// if($data->jenis_fungsi_air == null) {
		// 	$j = $data->jenis_fungsi_air;
		// }else {
		// 	$j = preg_replace('~[\\\\/:*?"<>|+-]~', '', $data->jenis_fungsi_air);
		// }
		if($data->pengawet == null) {
			$j1 = $data->pengawet;
		}else {
			$j1 = preg_replace('~[\\\\/:*?"<>|+-]~', '', $data->pengawet);
		}
		if($data->teknik == null) {
			$sampling = $data->teknik;
		}else {
			$sampling = str_replace("_"," ",$data->teknik);
		}
		if($data->perlakuan_penyaringan == null) {
			$per_peny = $data->perlakuan_penyaringan;
		}else {
			$per_peny = str_replace("_", " ", $data->perlakuan_penyaringan);
		}
		if($data->pengendalian_mutu == null) {
			$mutu = $data->pengendalian_mutu;
		}else {
			$mutu =preg_replace('~[\\\\/:*?"<>|+-]~', '', $data->pengendalian_mutu);
		}
		if($data->warna == null) {
			$warna = $data->warna;
		}else {
			$warna = str_replace("_"," ",$data->warna);
		}
		if($data->bau == null) {
			$bau = $data->bau;
		}else {
			$bau = str_replace("_"," ",$data->bau);
		}
		if($data->ipal == null) {
			$ipal = $data->ipal;
		}else {
			$ipal = str_replace("_"," ",$data->ipal);
		}
			$template = '<div class="card-body"><div class="row"><div class="col-sm-3"><div class="card-body"><table><tr><th></th><th></th><th></th></tr><tr class="detail"><td class="data">Nama Sampler</td><td>:</td><td><span>'.$data->sampler.'</span></td></tr><tr class="detail"><td class="data">No Sample</td><td>:</td><td><span>'.$data->no_sample.'</span></td></tr><tr class="detail"><td class="data">No Order</td><td>:</td><td><span>'.$data->no_order.'</span></td></tr><tr class="detail"><td class="data">Jenis Sample</td><td>:</td><td><span>'.$data->jenis.'</span></td></tr><tr class="detail"><td class="data">Nama Perusahaan</td><td>:</td><td><span>'.$data->corp.'</span></td></tr><tr class="detail"><td class="data">Penamaan Titik</td><td>:</td><td><span>'.$data->keterangan.'</span></td></tr><tr class="detail"><td class="data">Penamaan Tambahan</td><td>:</td><td><span>'.$data->info_tambahan.'</span></td></tr><tr class="detail" id="stat_ipal"><td class="data">Status Kesediaan Ipal</td><td>:</td><td><span>'.$ipal.'</span></td></tr><tr class="detail" id="jenisproduksi"><td class="data">Jenis Produksi</td><td>:</td><td><span>'.$data->jenis_produksi.'</span></td></tr><tr class="detail"><td class="data">Jenis Pengawet</td><td>:</td><td><span>'.$j1.'</span></td></tr><tr class="detail" id="loksampling"><td class="data">Lokasi Sampling</td><td>:</td><td><span>'.$data->lok_sampling.'</span></td></tr><tr class="detail"><td class="data">Teknik Sampling</td><td>:</td><td><span>'.$sampling.'</span></td></tr><tr class="detail" id="jam_peng"><td class="data">Jam Pengambilan</td><td>:</td><td><span>'.$data->jam.'</span></td></tr><tr class="detail"><td class="data">Perlakuan Penyaringan</td><td>:</td><td><span>'.$per_peny.'</span></td></tr><tr class="detail"><td class="data">pengendalian Mutu</td><td>:</td><td><span>'.$mutu.'</span></td></tr><tr class="detail"><td class="data">Volume</td><td>:</td><td><span>'.$data->volume.' ml</span></td></tr><tr class="detail"><td class="data">Warna</td><td>:</td><td><span>'.$warna.'</span></td></tr><tr class="detail"><td class="data">Bau</td><td>:</td><td><span>'.$bau.'</span></td></tr><tr class="detail"><td class="data">Ph</td><td>:</td><td><span>'.$data->ph.'</span></td></tr><tr class="detail" id="dhl_"><td class="data">DHL</td><td>:</td><td><span>'.$data->dhl.'</span></td></tr><tr class="detail" id="do_"><td class="data">DO</td><td>:</td><td><span>'.$data->do.'</span></td></tr><tr class="detail"><td class="data">Suhu Air</td><td>:</td><td><span>'.$data->suhu_air.' ℃</span></td></tr><tr class="detail"><td class="data">Suhu Udara</td><td>:</td><td><span>'.$data->suhu_udara.' ℃</span></td></tr><tr class="detail" id="debit_air"><td class="data">Debit</td><td>:</td><td><span>'.$data->debit.'</span></td></tr><tr class="detail"><td class="data">Koordinat</td><td>:</td><td><span id="coor">'.$data->coor.'</span></td></tr></table></div></div><div class="col-sm-6"><div class="card-body"><div class="text-center"><a href="'.base_foto.$data->foto_lok.'" data-lightbox="image-1" data-title="'.$data->no_sample.'"><img style="width:150px" src="'.base_foto.$data->foto_lok.'" class="img-fluid"></a></div><div class="card-body"><div><h5 class="card-title" style="float:left">Foto Lokasi Sample</h5><a href="javascript:;" value="'.$data->foto_lok.'" onclick="fotoD(this);" style="float:right;border-radius:5px" id="foto-d" type="button" class="btns btn-success">Download</a></div></div></div></div><div class="col-sm-6"><div class="card-body"><div class="text-center"><a href="'.base_foto.$data->foto_kondisi.'" data-lightbox="image-1" data-title="'.$data->no_sample.'"><img style="width:150px" src="'.base_foto.$data->foto_kondisi.'" class="img-fluid"></a></div><div class="card-body"><div><h5 class="card-title" style="float:left">Foto Kondisi Sample</h5><a href="'.base_foto.$data->foto_kondisi.'" style="float:right;border-radius:5px" id="foto-d" type="button" class="btns btn-success">Download</a></div></div></div></div><div class="col-sm-6"><div class="card-body"><div class="text-center"><a href="'.base_foto.$data->foto_lain.'" data-lightbox="image-1" data-title="'.$data->no_sample.'"><img style="width:150px" src="'.base_foto.$data->foto_lain.'" class="img-fluid"></a></div><div class="card-body"><div><h5 class="card-title" style="float:left">Foto Lain lain</h5><a href="'.base_foto.$data->foto_lain.'" style="float:right;border-radius:5px" id="foto-d" type="button" class="btns btn-success">Download</a></div></div></div></div><div class="col-sm-6"><div class="card-body"><div id="latlongmap" class="cd-4" style="width:100%;margin:5px 0;z-index:0;box-shadow:0 2px 4px rgba(0,0,0,.25);height:300px"></div></div></div></div></div>';
			return $template;
	} 

		public function bersih($data) {

		// if($data->jenis_fungsi_air == null) {
		// 	$j = $data->jenis_fungsi_air;
		// }else {
		// 	$j = preg_replace('~[\\\\/:*?"<>|+-]~', '', $data->jenis_fungsi_air);
		// }
		if($data->pengawet == null) {
			$j1 = $data->pengawet;
		}else {
			$j1 = preg_replace('~[\\\\/:*?"<>|+-]~', '', $data->pengawet);
		}
		if($data->teknik == null) {
			$sampling = $data->teknik;
		}else {
			$sampling = str_replace("_"," ",$data->teknik);
		}
		if($data->perlakuan_penyaringan == null) {
			$per_peny = $data->perlakuan_penyaringan;
		}else {
			$per_peny = str_replace("_", " ", $data->perlakuan_penyaringan);
		}
		if($data->pengendalian_mutu == null) {
			$mutu = $data->pengendalian_mutu;
		}else {
			$mutu =preg_replace('~[\\\\/:*?"<>|+-]~', '', $data->pengendalian_mutu);
		}
		if($data->warna == null) {
			$warna = $data->warna;
		}else {
			$warna = str_replace("_"," ",$data->warna);
		}
		if($data->bau == null) {
			$bau = $data->bau;
		}else {
			$bau = str_replace("_"," ",$data->bau);
		}
		if($data->ipal == null) {
			$ipal = $data->ipal;
		}else {
			$ipal = str_replace("_"," ",$data->ipal);
		}
			$template = '<div class="card-body"><div class="row"><div class="col-sm-3"><div class="card-body"><table><tr><th></th><th></th><th></th></tr><tr class="detail"><td class="data">Nama Sampler</td><td>:</td><td><span>'.$data->sampler.'</span></td></tr><tr class="detail"><td class="data">No Sample</td><td>:</td><td><span>'.$data->no_sample.'</span></td></tr><tr class="detail"><td class="data">No Order</td><td>:</td><td><span>'.$data->no_order.'</span></td></tr><tr class="detail"><td class="data">Jenis Sample</td><td>:</td><td><span>'.$data->jenis.'</span></td></tr><tr class="detail"><td class="data">Nama Perusahaan</td><td>:</td><td><span>'.$data->corp.'</span></td></tr><tr class="detail"><td class="data">Penamaan Titik</td><td>:</td><td><span>'.$data->info_tambahan.'</span></td></tr><tr class="detail"><td class="data">Penamaan Tambahan</td><td>:</td><td><span>'.$data->keterangan.'</span></td></tr><tr class="detail"><td class="data">Jenis Pengawet</td><td>:</td><td><span>'.$j1.'</span></td></tr><tr class="detail"><td class="data">Teknik Sampling</td><td>:</td><td><span>'.$sampling.'</span></td></tr><tr class="detail" id="jam_peng"><td class="data">Jam Pengambilan</td><td>:</td><td><span>'.$data->jam.'</span></td></tr><tr class="detail"><td class="data">Perlakuan Penyaringan</td><td>:</td><td><span>'.$per_peny.'</span></td></tr><tr class="detail"><td class="data">pengendalian Mutu</td><td>:</td><td><span>'.$mutu.'</span></td></tr><tr class="detail"><td class="data">Volume</td><td>:</td><td><span id="volume">'.$data->volume.' ml</span></td></tr><tr class="detail"><td class="data">Warna</td><td>:</td><td><span>'.$warna.'</span></td></tr><tr class="detail"><td class="data">Bau</td><td>:</td><td><span>'.$bau.'</span></td></tr><tr class="detail"><td class="data">Ph</td><td>:</td><td><span>'.$data->ph.'</span></td></tr><tr class="detail" id="dhl_"><td class="data">DHL</td><td>:</td><td><span>'.$data->dhl.'</span></td></tr><tr class="detail"><td class="data">Suhu Air</td><td>:</td><td><span>'.$data->suhu_air.' ℃</span></td></tr><tr class="detail"><td class="data">Suhu Udara</td><td>:</td><td><span>'.$data->suhu_udara.' ℃</span></td></tr><tr class="detail"><td class="data">Koordinat</td><td>:</td><td><span>'.$data->coor.'</span></td></tr></table></div></div><div class="col-sm-6"><div class="card-body"><div class="text-center"><a href="'.base_foto.$data->foto_lok.'" data-lightbox="image-1" data-title="'.$data->no_sample.'"><img style="width:150px" src="'.base_foto.$data->foto_lok.'" class="img-fluid"></a></div><div class="card-body"><div><h5 class="card-title" style="float:left">Foto Lokasi Sample</h5><a href="javascript:;" value="'.base_foto.$data->foto_lok.'" onclick="fotoD(this);" style="float:right;border-radius:5px" id="foto-d" type="button" class="btns btn-success">Download</a></div></div></div></div><div class="col-sm-6"><div class="card-body"><div class="text-center"><a href="'.base_foto.$data->foto_kondisi.'" data-lightbox="image-1" data-title="'.$data->no_sample.'"><img style="width:150px" src="'.base_foto.$data->foto_kondisi.'" class="img-fluid"></a></div><div class="card-body"><div><h5 class="card-title" style="float:left">Foto Kondisi Sample</h5><a href="'.base_foto.$data->foto_kondisi.'" style="float:right;border-radius:5px" id="foto-d" type="button" class="btns btn-success">Download</a></div></div></div></div><div class="col-sm-6"><div class="card-body"><div class="text-center"><a href="'.base_foto.$data->foto_lain.'" data-lightbox="image-1" data-title="'.$data->no_sample.'"><img style="width:150px" src="'.base_foto.$data->foto_lain.'" class="img-fluid"></a></div><div class="card-body"><div><h5 class="card-title" style="float:left">Foto Lain lain</h5><a href="'.base_foto.$data->foto_lain.'" style="float:right;border-radius:5px" id="foto-d" type="button" class="btns btn-success">Download</a></div></div></div></div><div class="col-sm-6"><div class="card-body"><div id="latlongmap" class="cd-4" style="width:100%;margin:5px 0;z-index:0;box-shadow:0 2px 4px rgba(0,0,0,.25);height:300px"></div></div></div></div></div>';
			return $template;
	} 

		public function khusus($data) {

		// if($data->jenis_fungsi_air == null) {
		// 	$j = $data->jenis_fungsi_air;
		// }else {
		// 	$j = preg_replace('~[\\\\/:*?"<>|+-]~', '', $data->jenis_fungsi_air);
		// }
		if($data->pengawet == null) {
			$j1 = $data->pengawet;
		}else {
			$j1 = preg_replace('~[\\\\/:*?"<>|+-]~', '', $data->pengawet);
		}
		if($data->teknik == null) {
			$sampling = $data->teknik;
		}else {
			$sampling = str_replace("_"," ",$data->teknik);
		}
		if($data->perlakuan_penyaringan == null) {
			$per_peny = $data->perlakuan_penyaringan;
		}else {
			$per_peny = str_replace("_", " ", $data->perlakuan_penyaringan);
		}
		if($data->pengendalian_mutu == null) {
			$mutu = $data->pengendalian_mutu;
		}else {
			$mutu =preg_replace('~[\\\\/:*?"<>|+-]~', '', $data->pengendalian_mutu);
		}
		if($data->warna == null) {
			$warna = $data->warna;
		}else {
			$warna = str_replace("_"," ",$data->warna);
		}
		if($data->bau == null) {
			$bau = $data->bau;
		}else {
			$bau = str_replace("_"," ",$data->bau);
		}
		if($data->ipal == null) {
			$ipal = $data->ipal;
		}else {
			$ipal = str_replace("_"," ",$data->ipal);
		}
			$template = '<div class="card-body"><div class="row"><div class="col-sm-3"><div class="card-body"><table><tr><th></th><th></th><th></th></tr><tr class="detail"><td class="data">Nama Sampler</td><td>:</td><td><span>'.$data->sampler.'</span></td></tr><tr class="detail"><td class="data">No Sample</td><td>:</td><td><span>'.$data->no_sample.'</span></td></tr><tr class="detail"><td class="data">No Order</td><td>:</td><td><span>'.$data->no_order.'</span></td></tr><tr class="detail"><td class="data">Jenis Sample</td><td>:</td><td><span>'.$data->jenis.'</span></td></tr><tr class="detail"><td class="data">Nama Perusahaan</td><td>:</td><td><span>'.$data->corp.'</span></td></tr><tr class="detail"><td class="data">Penamaan Titik</td><td>:</td><td><span>'.$data->keterangan.'</span></td></tr><tr class="detail"><td class="data">Penamaan Tambahan</td><td>:</td><td><span>'.$data->info_tambahan.'</span></td></tr><tr class="detail"><td class="data">Jenis Pengawet</td><td>:</td><td><span>'.$j1.'</span></td></tr><tr class="detail"><td class="data">Teknik Sampling</td><td>:</td><td><span>'.$sampling.'</span></td></tr><tr class="detail" id="jam_peng"><td class="data">Jam Pengambilan</td><td>:</td><td><span>'.$data->jam.'</span></td></tr><tr class="detail"><td class="data">Perlakuan Penyaringan</td><td>:</td><td><span>'.$per_peny.'</span></td></tr><tr class="detail"><td class="data">pengendalian Mutu</td><td>:</td><td><span>'.$mutu.'</span></td></tr><tr class="detail"><td class="data">Volume</td><td>:</td><td><span>'.$data->volume.' ml</span></td></tr><tr class="detail"><td class="data">Warna</td><td>:</td><td><span>'.$warna.'</span></td></tr><tr class="detail"><td class="data">Bau</td><td>:</td><td><span>'.$bau.'</span></td></tr><tr class="detail"><td class="data">Ph</td><td>:</td><td><span>'.$data->ph.'</span></td></tr><tr class="detail" id="dhl_"><td class="data">DHL</td><td>:</td><td><span>'.$data->dhl.'</span></td></tr><tr class="detail"><td class="data">Suhu Air</td><td>:</td><td><span>'.$data->suhu_air.' ℃</span></td></tr><tr class="detail"><td class="data">Suhu Udara</td><td>:</td><td><span>'.$data->suhu_udara.' ℃</span></td></tr><tr class="detail"><td class="data">Koordinat</td><td>:</td><td><span>'.$data->coor.' ℃</span></td></tr></table></div></div><div class="col-sm-6"><div class="card-body"><div class="text-center"><a href="'.base_foto.$data->foto_lok.'" data-lightbox="image-1" data-title="'.$data->no_sample.'"><img style="width:150px" src="'.base_foto.$data->foto_lok.'" class="img-fluid"></a></div><div class="card-body"><div><h5 class="card-title" style="float:left">Foto Lokasi Sample</h5><a href="'.base_foto.$data->foto_lok.'" style="float:right;border-radius:5px" id="foto-d" type="button" class="btns btn-success">Download</a></div></div></div></div><div class="col-sm-6"><div class="card-body"><div class="text-center"><a href="'.base_foto.$data->foto_kondisi.'" data-lightbox="image-1" data-title="'.$data->no_sample.'"><img style="width:150px" src="'.base_foto.$data->foto_kondisi.'" class="img-fluid"></a></div><div class="card-body"><div><h5 class="card-title" style="float:left">Foto Kondisi Sample</h5><a href="'.base_foto.$data->foto_kondisi.'" style="float:right;border-radius:5px" id="foto-d" type="button" class="btns btn-success">Download</a></div></div></div></div><div class="col-sm-6"><div class="card-body"><div class="text-center"><a href="'.base_foto.$data->foto_lain.'" data-lightbox="image-1" data-title="'.$data->no_sample.'"><img style="width:150px" src="'.base_foto.$data->foto_lain.'" class="img-fluid"></a></div><div class="card-body"><div><h5 class="card-title" style="float:left">Foto Lain lain</h5><a href="'.base_foto.$data->foto_lain.'" style="float:right;border-radius:5px" id="foto-d" type="button" class="btns btn-success">Download</a></div></div></div></div><div class="col-sm-6"><div class="card-body"><div id="latlongmap" class="cd-4" style="width:100%;margin:5px 0;z-index:0;box-shadow:0 2px 4px rgba(0,0,0,.25);height:300px"></div></div></div></div></div>';
			return $template;
	} 

		public function tanah($data) {

		if($data->jenis_fungsi_air == null) {
			$j = $data->jenis_fungsi_air;
		}else {
			$j = preg_replace('~[\\\\/:*?"<>|+-]~', '', $data->jenis_fungsi_air);
		}
		if($data->pengawet == null) {
			$j1 = $data->pengawet;
		}else {
			$j1 = preg_replace('~[\\\\/:*?"<>|+-]~', '', $data->pengawet);
		}
		if($data->teknik == null) {
			$sampling = $data->teknik;
		}else {
			$sampling = str_replace("_"," ",$data->teknik);
		}
		if($data->perlakuan_penyaringan == null) {
			$per_peny = $data->perlakuan_penyaringan;
		}else {
			$per_peny = str_replace("_", " ", $data->perlakuan_penyaringan);
		}
		if($data->pengendalian_mutu == null) {
			$mutu = $data->pengendalian_mutu;
		}else {
			$mutu =preg_replace('~[\\\\/:*?"<>|+-]~', '', $data->pengendalian_mutu);
		}
		if($data->warna == null) {
			$warna = $data->warna;
		}else {
			$warna = str_replace("_"," ",$data->warna);
		}
		if($data->bau == null) {
			$bau = $data->bau;
		}else {
			$bau = str_replace("_"," ",$data->bau);
		}
		if($data->ipal == null) {
			$ipal = $data->ipal;
		}else {
			$ipal = str_replace("_"," ",$data->ipal);
		}
			$template = '<div class="card-body"><div class="row"><div class="col-sm-3"><div class="card-body"><table><tr><th></th><th></th><th></th></tr><tr class="detail"><td class="data">Nama Sampler</td><td>:</td><td><span>'.$data->sampler.'</span></td></tr><tr class="detail"><td class="data">No Sample</td><td>:</td><td><span>'.$data->no_sample.'</span></td></tr><tr class="detail"><td class="data">No Order</td><td>:</td><td><span>'.$data->no_order.'</span></td></tr><tr class="detail"><td class="data">Jenis Sample</td><td>:</td><td><span>'.$data->jenis.'</span></td></tr><tr class="detail"><td class="data">Nama Perusahaan</td><td>:</td><td><span>'.$data->corp.'</span></td></tr><tr class="detail"><td class="data">Penamaan Titik</td><td>:</td><td><span>'.$data->keterangan.'</span></td></tr><tr class="detail"><td class="data">Penamaan Tambahan</td><td>:</td><td><span>'.$data->info_tambahan.'</span></td></tr><tr class="detail" id="fungsiair"><td class="data">Jenis Fungsi Air</td><td>:</td><td><span>'.$j.'</span></td></tr><tr class="detail"><td class="data">Jenis Pengawet</td><td>:</td><td><span>'.$j1.'</span></td></tr><tr class="detail"><td class="data">Teknik Sampling</td><td>:</td><td><span>'.$sampling.'</span></td></tr><tr class="detail" id="jam_peng"><td class="data">Jam Pengambilan</td><td>:</td><td><span id="jam">'.$data->jam.'</span></td></tr><tr class="detail"><td class="data">Perlakuan Penyaringan</td><td>:</td><td><span>'.$per_peny.'</span></td></tr><tr class="detail"><td class="data">pengendalian Mutu</td><td>:</td><td><span>'.$mutu.'</span></td></tr><tr class="detail"><td class="data">Volume</td><td>:</td><td><span>'.$data->volume.' ml</span></td></tr><tr class="detail"><td class="data">Warna</td><td>:</td><td><span id="warna">'.$warna.'</span></td></tr><tr class="detail"><td class="data">Bau</td><td>:</td><td><span>'.$bau.'</span></td></tr><tr class="detail"><td class="data">Ph</td><td>:</td><td><span>'.$data->ph.'</span></td></tr><tr class="detail" id="dhl_"><td class="data">DHL</td><td>:</td><td><span>'.$data->dhl.'</span></td></tr><tr class="detail" id="do_"><td class="data">DO</td><td>:</td><td><span>'.$data->do.'</span></td></tr><tr class="detail"><td class="data">Suhu Air</td><td>:</td><td><span>'.$data->suhu_air.' ℃</span></td></tr><tr class="detail"><td class="data">Suhu Udara</td><td>:</td><td><span>'.$data->suhu_udara.' ℃</span></td></tr><tr class="detail" id="diametersumur"><td class="data">Diameter Sumur</td><td>:</td><td><span>'.$data->diameter.' m</span></td></tr><tr class="detail" id="kedalaman1_"><td class="data">Kedalaman Sumur Pertama</td><td>:</td><td><span>'.$data->kedalaman1.' m</span></td></tr><tr class="detail" id="kedalaman2_"><td class="data">Kedalaman Sumur Kedua</td><td>:</td><td><span>'.$data->kedalaman2.' m</span></td></tr><tr class="detail" id="kedalamanambil"><td class="data">Kedalaman Air Terambil</td><td>:</td><td><span>'.$data->kedalamanair.' m</span></td></tr><tr class="detail" id="totalwaktu"><td class="data">Total Waktu Pengambilan</td><td>:</td><td><span>'.$data->total_waktu.' detik</span></td></tr><tr class="detail"><td class="data">Koordinat</td><td>:</td><td><span>'.$data->coor.'</span></td></tr></table></div></div><div class="col-sm-6"><div class="card-body"><div class="text-center"><a href="'.base_foto.$data->foto_lok.'" data-lightbox="image-1" data-title="'.$data->no_sample.'"><img style="width:150px" src="'.base_foto.$data->foto_lok.'" class="img-fluid"></a></div><div class="card-body"><div><h5 class="card-title" style="float:left">Foto Lokasi Sample</h5><a href="'.base_foto.$data->foto_lok.'" style="float:right;border-radius:5px" id="foto-d" type="button" class="btns btn-success">Download</a></div></div></div></div><div class="col-sm-6"><div class="card-body"><div class="text-center"><a href="'.base_foto.$data->foto_kondisi.'" data-lightbox="image-1" data-title="'.$data->no_sample.'"><img style="width:150px" src="'.base_foto.$data->foto_kondisi.'" class="img-fluid"></a></div><div class="card-body"><div><h5 class="card-title" style="float:left">Foto Kondisi Sample</h5><a href="'.base_foto.$data->foto_kondisi.'" style="float:right;border-radius:5px" id="foto-d" type="button" class="btns btn-success">Download</a></div></div></div></div><div class="col-sm-6"><div class="card-body"><div class="text-center"><a href="'.base_foto.$data->foto_lain.'" data-lightbox="image-1" data-title="'.$data->no_sample.'"><img style="width:150px" src="'.base_foto.$data->foto_lain.'" class="img-fluid"></a></div><div class="card-body"><div><h5 class="card-title" style="float:left">Foto Lain lain</h5><a href="'.base_foto.$data->foto_lain.'" style="float:right;border-radius:5px" id="foto-d" type="button" class="btns btn-success">Download</a></div></div></div></div><div class="col-sm-6"><div class="card-body"><div id="latlongmap" class="cd-4" style="width:100%;margin:5px 0;z-index:0;box-shadow:0 2px 4px rgba(0,0,0,.25);height:300px"></div></div></div></div></div>';
			return $template;
	} 
		public function laut($data) {

		if($data->jenis_fungsi_air == null) {
			$j = $data->jenis_fungsi_air;
		}else {
			$j = preg_replace('~[\\\\/:*?"<>|+-]~', '', $data->jenis_fungsi_air);
		}
		if($data->pengawet == null) {
			$j1 = $data->pengawet;
		}else {
			$j1 = preg_replace('~[\\\\/:*?"<>|+-]~', '', $data->pengawet);
		}
		if($data->teknik == null) {
			$sampling = $data->teknik;
		}else {
			$sampling = str_replace("_"," ",$data->teknik);
		}
		if($data->perlakuan_penyaringan == null) {
			$per_peny = $data->perlakuan_penyaringan;
		}else {
			$per_peny = str_replace("_", " ", $data->perlakuan_penyaringan);
		}
		if($data->pengendalian_mutu == null) {
			$mutu = $data->pengendalian_mutu;
		}else {
			$mutu =preg_replace('~[\\\\/:*?"<>|+-]~', '', $data->pengendalian_mutu);
		}
		if($data->warna == null) {
			$warna = $data->warna;
		}else {
			$warna = str_replace("_"," ",$data->warna);
		}
		if($data->bau == null) {
			$bau = $data->bau;
		}else {
			$bau = str_replace("_"," ",$data->bau);
		}
		if($data->ipal == null) {
			$ipal = $data->ipal;
		}else {
			$ipal = str_replace("_"," ",$data->ipal);
		}
		if($data->pasang_surut == null) {
			$pasang_surut = $data->pasang_surut;
		}else {
			$pasang_surut = preg_replace('~[\\\\/:*?"<>|+-]~', '', $data->pasang_surut);
		}
			$template = '<div class="card-body"><div class="row"><div class="col-sm-3"><div class="card-body"><table><tr><th></th><th></th><th></th></tr><tr class="detail"><td class="data">Nama Sampler</td><td>:</td><td><span>'.$data->sampler.'</span></td></tr><tr class="detail"><td class="data">No Sample</td><td>:</td><td><span>'.$data->no_sample.'</span></td></tr><tr class="detail"><td class="data">No Order</td><td>:</td><td><span>'.$data->no_order.'</span></td></tr><tr class="detail"><td class="data">Jenis Sample</td><td>:</td><td><span>'.$data->jenis.'</span></td></tr><tr class="detail"><td class="data">Nama Perusahaan</td><td>:</td><td><span>'.$data->corp.'</span></td></tr><tr class="detail" id="titik_pengambilan"><td class="data">Jumlah Titik Pengambilan</td><td>:</td><td><span>'.$data->jumlah_titik_pengambilan.'</span></td></tr><tr class="detail"><td class="data">Penamaan Titik</td><td>:</td><td><span>'.$data->keterangan.'</span></td></tr><tr class="detail"><td class="data">Penamaan Tambahan</td><td>:</td><td><span>'.$data->info_tambahan.'</span></td></tr><tr class="detail"><td class="data">Jenis Pengawet</td><td>:</td><td><span>'.$j1.'</span></td></tr><tr class="detail" id="lok_pengambilan"><td class="data">Jenis Lokasi Titik Pengambilan</td><td>:</td><td><span>'.$data->lokasi_pengambilan.'</span></td></tr><tr class="detail"><td class="data">Teknik Sampling</td><td>:</td><td><span>'.$sampling.'</span></td></tr><tr class="detail" id="jam_peng"><td class="data">Jam Pengambilan</td><td>:</td><td><span>'.$data->jam.'</span></td></tr><tr class="detail"><td class="data">Perlakuan Penyaringan</td><td>:</td><td><span>'.$per_peny.'</span></td></tr><tr class="detail"><td class="data">pengendalian Mutu</td><td>:</td><td><span>'.$mutu.'</span></td></tr><tr class="detail" id="araharus"><td class="data">Arah Arus</td><td>:</td><td><span>'.$data->arah_arus.'</span></td></tr><tr class="detail" id="lapisanminyak"><td class="data">Lapisan Minyak</td><td>:</td><td><span>'.$data->lapisan_minyak.'</span></td></tr><tr class="detail" id="cuaca_"><td class="data">Cuaca</td><td>:</td><td><span>'.$data->cuaca.'</span></td></tr><tr class="detail"><td class="data">Volume</td><td>:</td><td><span>'.$data->volume.' ml</span></td></tr><tr class="detail"><td class="data">Warna</td><td>:</td><td><span>'.$warna.'</span></td></tr><tr class="detail"><td class="data">Bau</td><td>:</td><td><span>'.$bau.'</span></td></tr><tr class="detail"><td class="data">Ph</td><td>:</td><td><span>'.$data->ph.'</span></td></tr><tr class="detail" id="do_"><td class="data">DO</td><td>:</td><td><span>'.$data->do.'</span></td></tr><tr class="detail"><td class="data">Suhu Air</td><td>:</td><td><span>'.$data->suhu_air.' ℃</span></td></tr><tr class="detail"><td class="data">Suhu Udara</td><td>:</td><td><span>'.$data->suhu_udara.' ℃</span></td></tr><tr class="detail" id="kedalamantitik"><td class="data">Kedalaman Titik Sampling</td><td>:</td><td><span>'.$data->kedalaman_titik.' m</span></td></tr><tr class="detail" id="salinitas_"><td class="data">Salinitas</td><td>:</td><td><span>'.$data->salinitas.' %</span></td></tr><tr class="detail" id="kecepatanarus"><td class="data">Kecepatan Arus</td><td>:</td><td><span>'.$data->kecepatan_arus.' m/detik</span></td></tr><tr class="detail" id="kecerahan_"><td class="data">Kecerahan</td><td>:</td><td><span>'.$data->kecerahan.' m</span></td></tr><tr class="detail" id="pasangsurut"><td class="data">Pasang Surut</td><td>:</td><td><span id="pasang_surut">'.$pasang_surut.'</span></td></tr><tr class="detail"><td class="data">Koordinat</td><td>:</td><td><span>'.$data->coor.'</span></td></tr></table></div></div><div class="col-sm-6"><div class="card-body"><div class="text-center"><a href="'.base_foto.$data->foto_lok.'" data-lightbox="image-1" data-title="'.$data->no_sample.'"><img style="width:150px" src="'.base_foto.$data->foto_lok.'" class="img-fluid"></a></div><div class="card-body"><div><h5 class="card-title" style="float:left">Foto Lokasi Sample</h5><a href="'.base_foto.$data->foto_lok.'" style="float:right;border-radius:5px" id="foto-d" type="button" class="btns btn-success">Download</a></div></div></div></div><div class="col-sm-6"><div class="card-body"><div class="text-center"><a href="'.base_foto.$data->foto_kondisi.'" data-lightbox="image-1" data-title="'.$data->no_sample.'"><img style="width:150px" src="'.base_foto.$data->foto_kondisi.'" class="img-fluid"></a></div><div class="card-body"><div><h5 class="card-title" style="float:left">Foto Kondisi Sample</h5><a href="'.base_foto.$data->foto_kondisi.'" style="float:right;border-radius:5px" id="foto-d" type="button" class="btns btn-success">Download</a></div></div></div></div><div class="col-sm-6"><div class="card-body"><div class="text-center"><a href="'.base_foto.$data->foto_lain.'" data-lightbox="image-1" data-title="'.$data->no_sample.'"><img style="width:150px" src="'.base_foto.$data->foto_lain.'" class="img-fluid"></a></div><div class="card-body"><div><h5 class="card-title" style="float:left">Foto Lain lain</h5><a href="'.base_foto.$data->foto_lain.'" style="float:right;border-radius:5px" id="foto-d" type="button" class="btns btn-success">Download</a></div></div></div></div><div class="col-sm-6"><div class="card-body"><div id="latlongmap" class="cd-4" style="width:100%;margin:5px 0;z-index:0;box-shadow:0 2px 4px rgba(0,0,0,.25);height:300px"></div></div></div></div></div>';
			return $template;
	} 

	public function showData($id){
		$val = $this->model('AirModel')->showDetail($id);
		if( $val->kat_id == 54 || $val->kat_id == 56 || $val->kat_id == 89 || $val->kat_id == 90 || $val->kat_id == 91 || $val->kat_id == 92 || $val->kat_id == 93 || $val->kat_id == 94 || $val->kat_id == 6) {
			$template = Self::permukaan($val);
			
		}else if($val->kat_id == 3 || $val->kat_id == 2 || $val->kat_id == 51) {
			$template = Self::limbah($val);
		}else if($val->kat_id == 1 || $val->kat_id == 4) {
			$template = Self::bersih($val);
		}else if($val->kat_id == 64) {
			$template = Self::khusus($val);
		}else if($val->kat_id == 72) {
			$template = Self::tanah($val);
		}else if($val->kat_id == 5) {
			$template = Self::laut($val);
		}
		$data['title'] = 'APPS INTILAB';
		$data['token'] = $_SESSION['token'];
		$data['template'] = $template;
		$data['lat'] = $val->lat;
		$data['long'] = $val->long;
		$data['coor'] = $val->coor;
		$this->view('templates/header', $data);
		$this->view('templates/sidebar', $data);
		$this->view('air/detail', $data);
		$this->view('templates/footer');
	}
	public function getSampel(){
		$no_sample = $_POST['no_sample'];
		$val = $this->model('AirModel')->GetData($no_sample);
		echo $val;
	}

	public function saveData(){
		$kon = $this->connection();
		$save = $this->model('AirModel')->saveDataAir($kon, $_POST);
		echo json_encode($save['status']);
		// header('location: '. base_url . '/air');
	}

	public function upload_data_to_server(){
		$data = $this->model('AirModel')->syncronize();
		echo $data;
	}

}