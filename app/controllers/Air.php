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
		$kateg = $this->model('AirModel')->GetListData();
		$permukaan = [];
		$limbah = [];
		$laut = [];
		$tanah = [];
		$bersih = [];
		$khusus = [];
		$konek = $this->connection();
		if($konek == true) {
			$kateg = $this->model('AirModel')->GetListData($this->connection());
			foreach($kateg->data as $key => $val) {
				if($val->jenis_sample == 'Sungai' || $val->jenis_sample == 'Danau' || $val->jenis_sample == 'Waduk' || $val->jenis_sample == 'Situ' || $val->jenis_sample == 'Akuifer' || $val->jenis_sample == 'Rawa' || $val->jenis_sample == 'Muara' || $val->jenis_sample == 'Air dari Mata Air') {
					array_push($permukaan, $val);
				}else if($val->jenis_sample == 'Limbah Domestik' || $val->jenis_sample == 'Limbah Industri' || $val->jenis_sample == 'Limbah') {
					array_push($limbah, $val);
				}else if($val->lokasi_titik_pengambilan != null || $val->arah_arus != null) {
					array_push($laut, $val);
				}else if($val->jenis_sample == 'Air Sumur Bor' || $val->jenis_sample == 'Air Sumur Gali' || $val->jenis_sample == 'Air Sumur Pantek') {
					array_push($tanah, $val);
				}else if($val->jenis_sample == 'Air Keperluan Hygiene Sanitasi' || $val->jenis_sample == 'Air Khusus RS' || $val->jenis_sample == 'Air Dalam Kemasan' || $val->jenis_sample == 'Air RO') {
					array_push($bersih, $val);
				}else if($val->lokasi_titik_pengambilan == null && $val->jenis_sample == null && $val->keterangan != null) {
					array_push($khusus, $val);
				}
			}
		}
		$data['title'] = 'APPS INTILAB';
		$data['nama'] = $_SESSION['name'];
		$data['salam'] = $status;
		$data['koneksi'] = $this->connection();
		$data['total_data'] = $this->model('AirModel')->getJsonData();
		$data['permukaan'] = count($permukaan);
		$data['limbah'] = count($limbah);
		$data['laut'] = count($laut);
		$data['tanah'] = count($tanah);
		$data['bersih'] = count($bersih);
		$data['khusus'] = count($khusus);
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
		$konek = $this->connection();
		$val = $this->model('AirModel')->GetListData($this->connection());
		if($konek == true) {
			$data['data'] = $val->data;
		}else {
			$data['data'] = $val;
		}
		// var_dump($data['data']);
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
		$val = $this->model('AirModel')->HapusDat($_POST['id'], $this->connection());
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
					$template ='<div class="card-body"><div class="row"><div class="col-sm-3"><div class="card-body"><table><tr><th></th><th></th><th></th></tr><tr class="detail"><td class="data">Nama Sampler</td><td>:</td><td><span>'.$data->sampler.'</span></td></tr><tr class="detail"><td class="data">No Sample</td><td>:</td><td><span>'.$data->no_sample.'</span></td></tr><tr class="detail"><td class="data">No Order</td><td>:</td><td><span>'.$data->no_order.'</span></td></tr><tr class="detail"><td class="data">Jenis Sample</td><td>:</td><td><span>'.$data->jenis.'</span></td></tr><tr class="detail"><td class="data">Nama Perusahaan</td><td>:</td><td><span>'.$data->corp.'</span></td></tr><tr class="detail" id="titik_pengambilan"><td class="data">Jumlah Titik Pengambilan</td><td>:</td><td><span>'.$data->jumlah_titik_pengambilan.'</span></td></tr><tr class="detail"><td class="data">Penamaan Titik</td><td>:</td><td><span>'.$data->keterangan.'</span></td></tr><tr class="detail"><td class="data">Penamaan Tambahan</td><td>:</td><td><span>'.$data->info_tambahan.'</span></td></tr><tr class="detail" id="fungsiair"><td class="data">Jenis Fungsi Air</td><td>:</td><td><span>'.$j.'</span></td></tr><tr class="detail"><td class="data">Jenis Pengawet</td><td>:</td><td><span>'.$j1.'</span></td></tr><tr class="detail"><td class="data">Teknik Sampling</td><td>:</td><td><span>'.$sampling.'</span></td></tr><tr class="detail" id="jam_peng"><td class="data">Jam Pengambilan</td><td>:</td><td><span>'.$data->jam.'</span></td></tr><tr class="detail"><td class="data">Perlakuan Penyaringan</td><td>:</td><td><span>'.$per_peny.'</span></td></tr><tr class="detail"><td class="data">pengendalian Mutu</td><td>:</td><td><span>'.$mutu.'</span></td></tr><tr class="detail" id="pengukuran_debit"><td class="data">Teknik Pengukuran Debit</td><td>:</td><td><span>'.$data->teknik_pengukuran_debit.'</span></td></tr><tr class="detail"><td class="data">Volume</td><td>:</td><td><span>'.$data->volume.' ml</span></td></tr><tr class="detail"><td class="data">Warna</td><td>:</td><td><span>'.$warna.'</span></td></tr><tr class="detail"><td class="data">Bau</td><td>:</td><td><span>'.$bau.'</span></td></tr><tr class="detail"><td class="data">Ph</td><td>:</td><td><span>'.$data->ph.'</span></td></tr><tr class="detail" id="dhl_"><td class="data">DHL</td><td>:</td><td><span>'.$data->dhl.'</span></td></tr><tr class="detail"><td class="data">Suhu Air</td><td>:</td><td><span>'.$data->suhu_air.' ℃</span></td></tr><tr class="detail"><td class="data">Suhu Udara</td><td>:</td><td><span>'.$data->suhu_udara.' ℃</span></td></tr><tr class="detail" id="debit_air"><td class="data">Debit</td><td>:</td><td><span>'.$data->debit.'</span></td></tr><tr class="detail" id="klor_bebas"><td class="data">Klor Bebas</td><td>:</td><td><span>'.$data->klor_bebas.'</span></td></tr><tr class="detail"><td class="data">Koordinat</td><td>:</td><td><span>'.$data->coor.'</span></td></tr></table></div></div><div class="col-sm-6"><div class="card-body"><div class="text-center"><a href="'.base_foto.$data->foto_lok.'" data-lightbox="image-1" data-title="'.$data->no_sample.'"><img style="width:150px" src="'.base_foto.$data->foto_lok.'" class="img-fluid"></a></div><div class="card-body"><div><h5 class="card-title" style="float:left">Foto Lokasi Sample</h5><a href="'.base_foto.$data->foto_lok.'" style="float:right;border-radius:5px" id="foto-d" type="button" class="btns btn-success" download="'.$data->foto_lok.'">Download</a></div></div></div></div><div class="col-sm-6"><div class="card-body"><div class="text-center"><a href="'.base_foto.$data->foto_kondisi.'" data-lightbox="image-1" data-title="'.$data->no_sample.'"><img style="width:150px" src="'.base_foto.$data->foto_kondisi.'" class="img-fluid"></a></div><div class="card-body"><div><h5 class="card-title" style="float:left">Foto Kondisi Sample</h5><a href="'.base_foto.$data->foto_kondisi.'" style="float:right;border-radius:5px" id="foto-d" type="button" class="btns btn-success" download="'.$data->foto_kondisi.'">Download</a></div></div></div></div><div class="col-sm-6"><div class="card-body"><div class="text-center"><a href="'.base_foto.$data->foto_lain.'" data-lightbox="image-1" data-title="'.$data->no_sample.'"><img style="width:150px" src="'.base_foto.$data->foto_lain.'" class="img-fluid"></a></div><div class="card-body"><div><h5 class="card-title" style="float:left">Foto Lain lain</h5><a href="'.base_foto.$data->foto_lain.'" style="float:right;border-radius:5px" id="foto-d" type="button" class="btns btn-success" download="'.$data->foto_lain.'">Download</a></div></div></div></div><div class="col-sm-6"><div class="card-body"><div id="latlongmap" class="cd-4" style="width:100%;margin:5px 0;z-index:0;box-shadow:0 2px 4px rgba(0,0,0,.25);height:300px"></div></div></div></div></div>';
			return $template;
	} 

	public function limbah($data) {
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
			$template = '<div class="card-body"><div class="row"><div class="col-sm-3"><div class="card-body"><table><tr><th></th><th></th><th></th></tr><tr class="detail"><td class="data">Nama Sampler</td><td>:</td><td><span>'.$data->sampler.'</span></td></tr><tr class="detail"><td class="data">No Sample</td><td>:</td><td><span>'.$data->no_sample.'</span></td></tr><tr class="detail"><td class="data">No Order</td><td>:</td><td><span>'.$data->no_order.'</span></td></tr><tr class="detail"><td class="data">Jenis Sample</td><td>:</td><td><span>'.$data->jenis.'</span></td></tr><tr class="detail"><td class="data">Nama Perusahaan</td><td>:</td><td><span>'.$data->corp.'</span></td></tr><tr class="detail"><td class="data">Penamaan Titik</td><td>:</td><td><span>'.$data->keterangan.'</span></td></tr><tr class="detail"><td class="data">Penamaan Tambahan</td><td>:</td><td><span>'.$data->info_tambahan.'</span></td></tr><tr class="detail" id="stat_ipal"><td class="data">Status Kesediaan Ipal</td><td>:</td><td><span>'.$ipal.'</span></td></tr><tr class="detail" id="jenisproduksi"><td class="data">Jenis Produksi</td><td>:</td><td><span>'.$data->jenis_produksi.'</span></td></tr><tr class="detail"><td class="data">Jenis Pengawet</td><td>:</td><td><span>'.$j1.'</span></td></tr><tr class="detail" id="loksampling"><td class="data">Lokasi Sampling</td><td>:</td><td><span>'.$data->lok_sampling.'</span></td></tr><tr class="detail"><td class="data">Teknik Sampling</td><td>:</td><td><span>'.$sampling.'</span></td></tr><tr class="detail" id="jam_peng"><td class="data">Jam Pengambilan</td><td>:</td><td><span>'.$data->jam.'</span></td></tr><tr class="detail"><td class="data">Perlakuan Penyaringan</td><td>:</td><td><span>'.$per_peny.'</span></td></tr><tr class="detail"><td class="data">pengendalian Mutu</td><td>:</td><td><span>'.$mutu.'</span></td></tr><tr class="detail"><td class="data">Volume</td><td>:</td><td><span>'.$data->volume.' ml</span></td></tr><tr class="detail"><td class="data">Warna</td><td>:</td><td><span>'.$warna.'</span></td></tr><tr class="detail"><td class="data">Bau</td><td>:</td><td><span>'.$bau.'</span></td></tr><tr class="detail"><td class="data">Ph</td><td>:</td><td><span>'.$data->ph.'</span></td></tr><tr class="detail" id="dhl_"><td class="data">DHL</td><td>:</td><td><span>'.$data->dhl.'</span></td></tr><tr class="detail" id="do_"><td class="data">DO</td><td>:</td><td><span>'.$data->do.'</span></td></tr><tr class="detail"><td class="data">Suhu Air</td><td>:</td><td><span>'.$data->suhu_air.' ℃</span></td></tr><tr class="detail"><td class="data">Suhu Udara</td><td>:</td><td><span>'.$data->suhu_udara.' ℃</span></td></tr><tr class="detail" id="debit_air"><td class="data">Debit</td><td>:</td><td><span>'.$data->debit.'</span></td></tr><tr class="detail"><td class="data">Koordinat</td><td>:</td><td><span id="coor">'.$data->coor.'</span></td></tr></table></div></div><div class="col-sm-6"><div class="card-body"><div class="text-center"><a href="'.base_foto.$data->foto_lok.'" data-lightbox="image-1" data-title="'.$data->no_sample.'"><img style="width:150px" src="'.base_foto.$data->foto_lok.'" class="img-fluid"></a></div><div class="card-body"><div><h5 class="card-title" style="float:left">Foto Lokasi Sample</h5><a href="'.base_foto.$data->foto_lok.'" style="float:right;border-radius:5px" id="foto-d" type="button" class="btns btn-success" download="'.$data->foto_lok.'">Download</a></div></div></div></div><div class="col-sm-6"><div class="card-body"><div class="text-center"><a href="'.base_foto.$data->foto_kondisi.'" data-lightbox="image-1" data-title="'.$data->no_sample.'"><img style="width:150px" src="'.base_foto.$data->foto_kondisi.'" class="img-fluid"></a></div><div class="card-body"><div><h5 class="card-title" style="float:left">Foto Kondisi Sample</h5><a href="'.base_foto.$data->foto_kondisi.'" style="float:right;border-radius:5px" id="foto-d" type="button" class="btns btn-success" download="'.$data->foto_kondisi.'">Download</a></div></div></div></div><div class="col-sm-6"><div class="card-body"><div class="text-center"><a href="'.base_foto.$data->foto_lain.'" data-lightbox="image-1" data-title="'.$data->no_sample.'"><img style="width:150px" src="'.base_foto.$data->foto_lain.'" class="img-fluid"></a></div><div class="card-body"><div><h5 class="card-title" style="float:left">Foto Lain lain</h5><a href="'.base_foto.$data->foto_lain.'" style="float:right;border-radius:5px" id="foto-d" type="button" class="btns btn-success" download="'.$data->foto_lain.'">Download</a></div></div></div></div><div class="col-sm-6"><div class="card-body"><div id="latlongmap" class="cd-4" style="width:100%;margin:5px 0;z-index:0;box-shadow:0 2px 4px rgba(0,0,0,.25);height:300px"></div></div></div></div></div>';
			return $template;
	} 

		public function bersih($data) {
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
			$template = '<div class="card-body"><div class="row"><div class="col-sm-3"><div class="card-body"><table><tr><th></th><th></th><th></th></tr><tr class="detail"><td class="data">Nama Sampler</td><td>:</td><td><span>'.$data->sampler.'</span></td></tr><tr class="detail"><td class="data">No Sample</td><td>:</td><td><span>'.$data->no_sample.'</span></td></tr><tr class="detail"><td class="data">No Order</td><td>:</td><td><span>'.$data->no_order.'</span></td></tr><tr class="detail"><td class="data">Jenis Sample</td><td>:</td><td><span>'.$data->jenis.'</span></td></tr><tr class="detail"><td class="data">Nama Perusahaan</td><td>:</td><td><span>'.$data->corp.'</span></td></tr><tr class="detail"><td class="data">Penamaan Titik</td><td>:</td><td><span>'.$data->info_tambahan.'</span></td></tr><tr class="detail"><td class="data">Penamaan Tambahan</td><td>:</td><td><span>'.$data->keterangan.'</span></td></tr><tr class="detail"><td class="data">Jenis Pengawet</td><td>:</td><td><span>'.$j1.'</span></td></tr><tr class="detail"><td class="data">Teknik Sampling</td><td>:</td><td><span>'.$sampling.'</span></td></tr><tr class="detail" id="jam_peng"><td class="data">Jam Pengambilan</td><td>:</td><td><span>'.$data->jam.'</span></td></tr><tr class="detail"><td class="data">Perlakuan Penyaringan</td><td>:</td><td><span>'.$per_peny.'</span></td></tr><tr class="detail"><td class="data">pengendalian Mutu</td><td>:</td><td><span>'.$mutu.'</span></td></tr><tr class="detail"><td class="data">Volume</td><td>:</td><td><span id="volume">'.$data->volume.' ml</span></td></tr><tr class="detail"><td class="data">Warna</td><td>:</td><td><span>'.$warna.'</span></td></tr><tr class="detail"><td class="data">Bau</td><td>:</td><td><span>'.$bau.'</span></td></tr><tr class="detail"><td class="data">Ph</td><td>:</td><td><span>'.$data->ph.'</span></td></tr><tr class="detail" id="dhl_"><td class="data">DHL</td><td>:</td><td><span>'.$data->dhl.'</span></td></tr><tr class="detail"><td class="data">Suhu Air</td><td>:</td><td><span>'.$data->suhu_air.' ℃</span></td></tr><tr class="detail"><td class="data">Suhu Udara</td><td>:</td><td><span>'.$data->suhu_udara.' ℃</span></td></tr><tr class="detail"><td class="data">Koordinat</td><td>:</td><td><span>'.$data->coor.'</span></td></tr></table></div></div><div class="col-sm-6"><div class="card-body"><div class="text-center"><a href="'.base_foto.$data->foto_lok.'" data-lightbox="image-1" data-title="'.$data->no_sample.'"><img style="width:150px" src="'.base_foto.$data->foto_lok.'" class="img-fluid"></a></div><div class="card-body"><div><h5 class="card-title" style="float:left">Foto Lokasi Sample</h5><a href="javascript:;" value="'.base_foto.$data->foto_lok.'" onclick="fotoD(this);" style="float:right;border-radius:5px" id="foto-d" type="button" class="btns btn-success" download="'.$data->foto_lok.'">Download</a></div></div></div></div><div class="col-sm-6"><div class="card-body"><div class="text-center"><a href="'.base_foto.$data->foto_kondisi.'" data-lightbox="image-1" data-title="'.$data->no_sample.'"><img style="width:150px" src="'.base_foto.$data->foto_kondisi.'" class="img-fluid"></a></div><div class="card-body"><div><h5 class="card-title" style="float:left">Foto Kondisi Sample</h5><a href="'.base_foto.$data->foto_kondisi.'" style="float:right;border-radius:5px" id="foto-d" type="button" class="btns btn-success" download="'.$data->foto_kondisi.'">Download</a></div></div></div></div><div class="col-sm-6"><div class="card-body"><div class="text-center"><a href="'.base_foto.$data->foto_lain.'" data-lightbox="image-1" data-title="'.$data->no_sample.'"><img style="width:150px" src="'.base_foto.$data->foto_lain.'" class="img-fluid"></a></div><div class="card-body"><div><h5 class="card-title" style="float:left">Foto Lain lain</h5><a href="'.base_foto.$data->foto_lain.'" style="float:right;border-radius:5px" id="foto-d" type="button" class="btns btn-success" download="'.$data->foto_lain.'">Download</a></div></div></div></div><div class="col-sm-6"><div class="card-body"><div id="latlongmap" class="cd-4" style="width:100%;margin:5px 0;z-index:0;box-shadow:0 2px 4px rgba(0,0,0,.25);height:300px"></div></div></div></div></div>';
			return $template;
	} 

		public function khusus($data) {
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
			$template = '<div class="card-body"><div class="row"><div class="col-sm-3"><div class="card-body"><table><tr><th></th><th></th><th></th></tr><tr class="detail"><td class="data">Nama Sampler</td><td>:</td><td><span>'.$data->sampler.'</span></td></tr><tr class="detail"><td class="data">No Sample</td><td>:</td><td><span>'.$data->no_sample.'</span></td></tr><tr class="detail"><td class="data">No Order</td><td>:</td><td><span>'.$data->no_order.'</span></td></tr><tr class="detail"><td class="data">Jenis Sample</td><td>:</td><td><span>'.$data->jenis.'</span></td></tr><tr class="detail"><td class="data">Nama Perusahaan</td><td>:</td><td><span>'.$data->corp.'</span></td></tr><tr class="detail"><td class="data">Penamaan Titik</td><td>:</td><td><span>'.$data->keterangan.'</span></td></tr><tr class="detail"><td class="data">Penamaan Tambahan</td><td>:</td><td><span>'.$data->info_tambahan.'</span></td></tr><tr class="detail"><td class="data">Jenis Pengawet</td><td>:</td><td><span>'.$j1.'</span></td></tr><tr class="detail"><td class="data">Teknik Sampling</td><td>:</td><td><span>'.$sampling.'</span></td></tr><tr class="detail" id="jam_peng"><td class="data">Jam Pengambilan</td><td>:</td><td><span>'.$data->jam.'</span></td></tr><tr class="detail"><td class="data">Perlakuan Penyaringan</td><td>:</td><td><span>'.$per_peny.'</span></td></tr><tr class="detail"><td class="data">pengendalian Mutu</td><td>:</td><td><span>'.$mutu.'</span></td></tr><tr class="detail"><td class="data">Volume</td><td>:</td><td><span>'.$data->volume.' ml</span></td></tr><tr class="detail"><td class="data">Warna</td><td>:</td><td><span>'.$warna.'</span></td></tr><tr class="detail"><td class="data">Bau</td><td>:</td><td><span>'.$bau.'</span></td></tr><tr class="detail"><td class="data">Ph</td><td>:</td><td><span>'.$data->ph.'</span></td></tr><tr class="detail" id="dhl_"><td class="data">DHL</td><td>:</td><td><span>'.$data->dhl.'</span></td></tr><tr class="detail"><td class="data">Suhu Air</td><td>:</td><td><span>'.$data->suhu_air.' ℃</span></td></tr><tr class="detail"><td class="data">Suhu Udara</td><td>:</td><td><span>'.$data->suhu_udara.' ℃</span></td></tr><tr class="detail"><td class="data">Koordinat</td><td>:</td><td><span>'.$data->coor.' ℃</span></td></tr></table></div></div><div class="col-sm-6"><div class="card-body"><div class="text-center"><a href="'.base_foto.$data->foto_lok.'" data-lightbox="image-1" data-title="'.$data->no_sample.'"><img style="width:150px" src="'.base_foto.$data->foto_lok.'" class="img-fluid"></a></div><div class="card-body"><div><h5 class="card-title" style="float:left">Foto Lokasi Sample</h5><a href="'.base_foto.$data->foto_lok.'" style="float:right;border-radius:5px" id="foto-d" type="button" class="btns btn-success" download="'.$data->foto_lok.'">Download</a></div></div></div></div><div class="col-sm-6"><div class="card-body"><div class="text-center"><a href="'.base_foto.$data->foto_kondisi.'" data-lightbox="image-1" data-title="'.$data->no_sample.'"><img style="width:150px" src="'.base_foto.$data->foto_kondisi.'" class="img-fluid"></a></div><div class="card-body"><div><h5 class="card-title" style="float:left">Foto Kondisi Sample</h5><a href="'.base_foto.$data->foto_kondisi.'" style="float:right;border-radius:5px" id="foto-d" type="button" class="btns btn-success" download="'.$data->foto_kondisi.'">Download</a></div></div></div></div><div class="col-sm-6"><div class="card-body"><div class="text-center"><a href="'.base_foto.$data->foto_lain.'" data-lightbox="image-1" data-title="'.$data->no_sample.'"><img style="width:150px" src="'.base_foto.$data->foto_lain.'" class="img-fluid"></a></div><div class="card-body"><div><h5 class="card-title" style="float:left">Foto Lain lain</h5><a href="'.base_foto.$data->foto_lain.'" style="float:right;border-radius:5px" id="foto-d" type="button" class="btns btn-success" download="'.$data->foto_lain.'">Download</a></div></div></div></div><div class="col-sm-6"><div class="card-body"><div id="latlongmap" class="cd-4" style="width:100%;margin:5px 0;z-index:0;box-shadow:0 2px 4px rgba(0,0,0,.25);height:300px"></div></div></div></div></div>';
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
			$template = '<div class="card-body"><div class="row"><div class="col-sm-3"><div class="card-body"><table><tr><th></th><th></th><th></th></tr><tr class="detail"><td class="data">Nama Sampler</td><td>:</td><td><span>'.$data->sampler.'</span></td></tr><tr class="detail"><td class="data">No Sample</td><td>:</td><td><span>'.$data->no_sample.'</span></td></tr><tr class="detail"><td class="data">No Order</td><td>:</td><td><span>'.$data->no_order.'</span></td></tr><tr class="detail"><td class="data">Jenis Sample</td><td>:</td><td><span>'.$data->jenis.'</span></td></tr><tr class="detail"><td class="data">Nama Perusahaan</td><td>:</td><td><span>'.$data->corp.'</span></td></tr><tr class="detail"><td class="data">Penamaan Titik</td><td>:</td><td><span>'.$data->keterangan.'</span></td></tr><tr class="detail"><td class="data">Penamaan Tambahan</td><td>:</td><td><span>'.$data->info_tambahan.'</span></td></tr><tr class="detail" id="fungsiair"><td class="data">Jenis Fungsi Air</td><td>:</td><td><span>'.$j.'</span></td></tr><tr class="detail"><td class="data">Jenis Pengawet</td><td>:</td><td><span>'.$j1.'</span></td></tr><tr class="detail"><td class="data">Teknik Sampling</td><td>:</td><td><span>'.$sampling.'</span></td></tr><tr class="detail" id="jam_peng"><td class="data">Jam Pengambilan</td><td>:</td><td><span id="jam">'.$data->jam.'</span></td></tr><tr class="detail"><td class="data">Perlakuan Penyaringan</td><td>:</td><td><span>'.$per_peny.'</span></td></tr><tr class="detail"><td class="data">pengendalian Mutu</td><td>:</td><td><span>'.$mutu.'</span></td></tr><tr class="detail"><td class="data">Volume</td><td>:</td><td><span>'.$data->volume.' ml</span></td></tr><tr class="detail"><td class="data">Warna</td><td>:</td><td><span id="warna">'.$warna.'</span></td></tr><tr class="detail"><td class="data">Bau</td><td>:</td><td><span>'.$bau.'</span></td></tr><tr class="detail"><td class="data">Ph</td><td>:</td><td><span>'.$data->ph.'</span></td></tr><tr class="detail" id="dhl_"><td class="data">DHL</td><td>:</td><td><span>'.$data->dhl.'</span></td></tr><tr class="detail" id="do_"><td class="data">DO</td><td>:</td><td><span>'.$data->do.'</span></td></tr><tr class="detail"><td class="data">Suhu Air</td><td>:</td><td><span>'.$data->suhu_air.' ℃</span></td></tr><tr class="detail"><td class="data">Suhu Udara</td><td>:</td><td><span>'.$data->suhu_udara.' ℃</span></td></tr><tr class="detail" id="diametersumur"><td class="data">Diameter Sumur</td><td>:</td><td><span>'.$data->diameter.' m</span></td></tr><tr class="detail" id="kedalaman1_"><td class="data">Kedalaman Sumur Pertama</td><td>:</td><td><span>'.$data->kedalaman1.' m</span></td></tr><tr class="detail" id="kedalaman2_"><td class="data">Kedalaman Sumur Kedua</td><td>:</td><td><span>'.$data->kedalaman2.' m</span></td></tr><tr class="detail" id="kedalamanambil"><td class="data">Kedalaman Air Terambil</td><td>:</td><td><span>'.$data->kedalamanair.' m</span></td></tr><tr class="detail" id="totalwaktu"><td class="data">Total Waktu Pengambilan</td><td>:</td><td><span>'.$data->total_waktu.' detik</span></td></tr><tr class="detail"><td class="data">Koordinat</td><td>:</td><td><span>'.$data->coor.'</span></td></tr></table></div></div><div class="col-sm-6"><div class="card-body"><div class="text-center"><a href="'.base_foto.$data->foto_lok.'" data-lightbox="image-1" data-title="'.$data->no_sample.'"><img style="width:150px" src="'.base_foto.$data->foto_lok.'" class="img-fluid"></a></div><div class="card-body"><div><h5 class="card-title" style="float:left">Foto Lokasi Sample</h5><a href="'.base_foto.$data->foto_lok.'" style="float:right;border-radius:5px" id="foto-d" type="button" class="btns btn-success" download="'.$data->foto_lok.'">Download</a></div></div></div></div><div class="col-sm-6"><div class="card-body"><div class="text-center"><a href="'.base_foto.$data->foto_kondisi.'" data-lightbox="image-1" data-title="'.$data->no_sample.'"><img style="width:150px" src="'.base_foto.$data->foto_kondisi.'" class="img-fluid"></a></div><div class="card-body"><div><h5 class="card-title" style="float:left">Foto Kondisi Sample</h5><a href="'.base_foto.$data->foto_kondisi.'" style="float:right;border-radius:5px" id="foto-d" type="button" class="btns btn-success" download="'.$data->foto_kondisi.'">Download</a></div></div></div></div><div class="col-sm-6"><div class="card-body"><div class="text-center"><a href="'.base_foto.$data->foto_lain.'" data-lightbox="image-1" data-title="'.$data->no_sample.'"><img style="width:150px" src="'.base_foto.$data->foto_lain.'" class="img-fluid"></a></div><div class="card-body"><div><h5 class="card-title" style="float:left">Foto Lain lain</h5><a href="'.base_foto.$data->foto_lain.'" style="float:right;border-radius:5px" id="foto-d" type="button" class="btns btn-success" download="'.$data->foto_lain.'">Download</a></div></div></div></div><div class="col-sm-6"><div class="card-body"><div id="latlongmap" class="cd-4" style="width:100%;margin:5px 0;z-index:0;box-shadow:0 2px 4px rgba(0,0,0,.25);height:300px"></div></div></div></div></div>';
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
			$template = '<div class="card-body"><div class="row"><div class="col-sm-3"><div class="card-body"><table><tr><th></th><th></th><th></th></tr><tr class="detail"><td class="data">Nama Sampler</td><td>:</td><td><span>'.$data->sampler.'</span></td></tr><tr class="detail"><td class="data">No Sample</td><td>:</td><td><span>'.$data->no_sample.'</span></td></tr><tr class="detail"><td class="data">No Order</td><td>:</td><td><span>'.$data->no_order.'</span></td></tr><tr class="detail"><td class="data">Jenis Sample</td><td>:</td><td><span>'.$data->jenis.'</span></td></tr><tr class="detail"><td class="data">Nama Perusahaan</td><td>:</td><td><span>'.$data->corp.'</span></td></tr><tr class="detail" id="titik_pengambilan"><td class="data">Jumlah Titik Pengambilan</td><td>:</td><td><span>'.$data->jumlah_titik_pengambilan.'</span></td></tr><tr class="detail"><td class="data">Penamaan Titik</td><td>:</td><td><span>'.$data->keterangan.'</span></td></tr><tr class="detail"><td class="data">Penamaan Tambahan</td><td>:</td><td><span>'.$data->info_tambahan.'</span></td></tr><tr class="detail"><td class="data">Jenis Pengawet</td><td>:</td><td><span>'.$j1.'</span></td></tr><tr class="detail" id="lok_pengambilan"><td class="data">Jenis Lokasi Titik Pengambilan</td><td>:</td><td><span>'.$data->lokasi_pengambilan.'</span></td></tr><tr class="detail"><td class="data">Teknik Sampling</td><td>:</td><td><span>'.$sampling.'</span></td></tr><tr class="detail" id="jam_peng"><td class="data">Jam Pengambilan</td><td>:</td><td><span>'.$data->jam.'</span></td></tr><tr class="detail"><td class="data">Perlakuan Penyaringan</td><td>:</td><td><span>'.$per_peny.'</span></td></tr><tr class="detail"><td class="data">pengendalian Mutu</td><td>:</td><td><span>'.$mutu.'</span></td></tr><tr class="detail" id="araharus"><td class="data">Arah Arus</td><td>:</td><td><span>'.$data->arah_arus.'</span></td></tr><tr class="detail" id="lapisanminyak"><td class="data">Lapisan Minyak</td><td>:</td><td><span>'.$data->lapisan_minyak.'</span></td></tr><tr class="detail" id="cuaca_"><td class="data">Cuaca</td><td>:</td><td><span>'.$data->cuaca.'</span></td></tr><tr class="detail"><td class="data">Volume</td><td>:</td><td><span>'.$data->volume.' ml</span></td></tr><tr class="detail"><td class="data">Warna</td><td>:</td><td><span>'.$warna.'</span></td></tr><tr class="detail"><td class="data">Bau</td><td>:</td><td><span>'.$bau.'</span></td></tr><tr class="detail"><td class="data">Ph</td><td>:</td><td><span>'.$data->ph.'</span></td></tr><tr class="detail" id="do_"><td class="data">DO</td><td>:</td><td><span>'.$data->do.'</span></td></tr><tr class="detail"><td class="data">Suhu Air</td><td>:</td><td><span>'.$data->suhu_air.' ℃</span></td></tr><tr class="detail"><td class="data">Suhu Udara</td><td>:</td><td><span>'.$data->suhu_udara.' ℃</span></td></tr><tr class="detail" id="kedalamantitik"><td class="data">Kedalaman Titik Sampling</td><td>:</td><td><span>'.$data->kedalaman_titik.' m</span></td></tr><tr class="detail" id="salinitas_"><td class="data">Salinitas</td><td>:</td><td><span>'.$data->salinitas.' %</span></td></tr><tr class="detail" id="kecepatanarus"><td class="data">Kecepatan Arus</td><td>:</td><td><span>'.$data->kecepatan_arus.' m/detik</span></td></tr><tr class="detail" id="kecerahan_"><td class="data">Kecerahan</td><td>:</td><td><span>'.$data->kecerahan.' m</span></td></tr><tr class="detail" id="pasangsurut"><td class="data">Pasang Surut</td><td>:</td><td><span id="pasang_surut">'.$pasang_surut.'</span></td></tr><tr class="detail"><td class="data">Koordinat</td><td>:</td><td><span>'.$data->coor.'</span></td></tr></table></div></div><div class="col-sm-6"><div class="card-body"><div class="text-center"><a href="'.base_foto.$data->foto_lok.'" data-lightbox="image-1" data-title="'.$data->no_sample.'"><img style="width:150px" src="'.base_foto.$data->foto_lok.'" class="img-fluid"></a></div><div class="card-body"><div><h5 class="card-title" style="float:left">Foto Lokasi Sample</h5><a href="'.base_foto.$data->foto_lok.'" style="float:right;border-radius:5px" id="foto-d" type="button" class="btns btn-success" download="'.$data->foto_lok.'">Download</a></div></div></div></div><div class="col-sm-6"><div class="card-body"><div class="text-center"><a href="'.base_foto.$data->foto_kondisi.'" data-lightbox="image-1" data-title="'.$data->no_sample.'"><img style="width:150px" src="'.base_foto.$data->foto_kondisi.'" class="img-fluid"></a></div><div class="card-body"><div><h5 class="card-title" style="float:left">Foto Kondisi Sample</h5><a href="'.base_foto.$data->foto_kondisi.'" style="float:right;border-radius:5px" id="foto-d" type="button" class="btns btn-success" download="'.$data->foto_kondisi.'">Download</a></div></div></div></div><div class="col-sm-6"><div class="card-body"><div class="text-center"><a href="'.base_foto.$data->foto_lain.'" data-lightbox="image-1" data-title="'.$data->no_sample.'"><img style="width:150px" src="'.base_foto.$data->foto_lain.'" class="img-fluid"></a></div><div class="card-body"><div><h5 class="card-title" style="float:left">Foto Lain lain</h5><a href="'.base_foto.$data->foto_lain.'" style="float:right;border-radius:5px" id="foto-d" type="button" class="btns btn-success" download="'.$data->foto_lain.'">Download</a></div></div></div></div><div class="col-sm-6"><div class="card-body"><div id="latlongmap" class="cd-4" style="width:100%;margin:5px 0;z-index:0;box-shadow:0 2px 4px rgba(0,0,0,.25);height:300px"></div></div></div></div></div>';
			return $template;
	} 
	
	public function permukaanoff($data) {
			$debit = '-';
			if($data->sel_debit == 'Input Data' && $data->sel_debit != ''){
				if ($data->satuan_debit != '' && $data->debit_air != '') {
					$debit =  $data->debit_air . ' ' . $data->satuan_debit;
				} else if ($data->debit_air != '') {
					$debit         = $data->debit_air;
				}
			}else if($data->sel_debit == 'Data By Customer' && $data->sel_debit != ''){
				if($data->sel_data_by_cust == 'Email' && $data->sel_data_by_cust != ''){
					$debit = 'Data By Customer('.$data->sel_data_by_cust.')';
				}else if($data->sel_data_by_cust == 'Input Data' && $data->sel_data_by_cust != ''){
					if ($data->satuan_debit_by_cust != '' && $data->debit_air_by_cust != '') {
							$debit =  'Data By Customer('.$data->debit_air_by_cust . ' ' . $data->satuan_debit_by_cust. ')';
					} else if ($data->debit_air != '') {
							$debit         = 'Data By Customer('.$data->debit_air_by_cust.')';
					}
				}
			}
			if (in_array('kimia', $data->parent_pengawet) == true) { // array in_array ('variable', array) == true
				$pengawet = str_replace("[", "", json_encode($data->parent_pengawet));
				$pengawet = str_replace("]", "", $pengawet);
				$pengawet = str_replace('"', "", $pengawet);
				$pengawet = str_replace(",", ", ", $pengawet);
				$pengawet = $pengawet . '-' . json_encode($data->jenis_pengawet);
			} else {
				$pengawet = str_replace("[", "", json_encode($data->parent_pengawet));
				$pengawet = str_replace("]", "", $pengawet);
				$pengawet = str_replace('"', "", $pengawet);
			}
			
		$jeni = preg_replace('~[\\\\/:*?"<>|+-]~', '', json_encode($data->jenis_fungsi));
		$mutu = preg_replace('~[\\\\/:*?"<>|+-]~', '', json_encode($data->mutu));
			$template ='<div class="card-body"><div class="row"><div class="col-sm-3"><div class="card-body"><table><tr><th></th><th></th><th></th></tr><tr class="detail"><td class="data">No Sample</td><td>:</td><td><span>'.$data->no_sample.'</span></td></tr><tr class="detail"><td class="data">Jenis Sample</td><td>:</td><td><span>'.$data->jenis_sample.'</span></td></tr><tr class="detail" id="titik_pengambilan"><td class="data">Jumlah Titik Pengambilan</td><td>:</td><td><span>'.$data->jumlah_titik.'</span></td></tr><tr class="detail"><td class="data">Penamaan Titik</td><td>:</td><td><span>'.$data->keterangan_1.'</span></td></tr><tr class="detail"><td class="data">Penamaan Tambahan</td><td>:</td><td><span>'.$data->information.'</span></td></tr><tr class="detail" id="fungsiair"><td class="data">Jenis Fungsi Air</td><td>:</td><td><span>'.$jeni.'</span></td></tr><tr class="detail"><td class="data">Jenis Pengawet</td><td>:</td><td><span>'.$pengawet.'</span></td></tr><tr class="detail"><td class="data">Teknik Sampling</td><td>:</td><td><span>'.$data->teknik_sampling.'</span></td></tr><tr class="detail" id="jam_peng"><td class="data">Jam Pengambilan</td><td>:</td><td><span>'.$data->jam.'</span></td></tr><tr class="detail"><td class="data">Perlakuan Penyaringan</td><td>:</td><td><span>'.$data->penyaringan.'</span></td></tr><tr class="detail"><td class="data">pengendalian Mutu</td><td>:</td><td><span>'.$mutu.'</span></td></tr><tr class="detail" id="pengukuran_debit"><td class="data">Teknik Pengukuran Debit</td><td>:</td><td><span>'.$debit.'</span></td></tr><tr class="detail"><td class="data">Volume</td><td>:</td><td><span>'.$data->volume.' ml</span></td></tr><tr class="detail"><td class="data">Warna</td><td>:</td><td><span>'.$data->warna.'</span></td></tr><tr class="detail"><td class="data">Bau</td><td>:</td><td><span>'.$data->bau.'</span></td></tr><tr class="detail"><td class="data">Ph</td><td>:</td><td><span>'.$data->ph.'</span></td></tr><tr class="detail" id="dhl_"><td class="data">DHL</td><td>:</td><td><span>'.$data->dhl.'</span></td></tr><tr class="detail"><td class="data">Suhu Air</td><td>:</td><td><span>'.$data->suhu_air.' ℃</span></td></tr><tr class="detail"><td class="data">Suhu Udara</td><td>:</td><td><span>'.$data->suhu_udara.' ℃</span></td></tr><tr class="detail" id="debit_air"><td class="data">Debit</td><td>:</td><td><span>test</span></td></tr><tr class="detail" id="klor_bebas"><td class="data">Klor Bebas</td><td>:</td><td><span>'.$data->klor.'</span></td></tr><tr class="detail"><td class="data">Koordinat</td><td>:</td><td><span>'.$data->posisi.'</span></td></tr></table></div></div></div></div>';
			return $template;
	} 

	public function limbahoff($data) {
			$debit = '-';
			if($data->sel_debit == 'Input Data' && $data->sel_debit != ''){
				if ($data->satuan_debit != '' && $data->debit_air != '') {
					$debit =  $data->debit_air . ' ' . $data->satuan_debit;
				} else if ($data->debit_air != '') {
					$debit         = $data->debit_air;
				}
			}else if($data->sel_debit == 'Data By Customer' && $data->sel_debit != ''){
				if($data->sel_data_by_cust == 'Email' && $data->sel_data_by_cust != ''){
					$debit = 'Data By Customer('.$data->sel_data_by_cust.')';
				}else if($data->sel_data_by_cust == 'Input Data' && $data->sel_data_by_cust != ''){
					if ($data->satuan_debit_by_cust != '' && $data->debit_air_by_cust != '') {
							$debit =  'Data By Customer('.$data->debit_air_by_cust . ' ' . $data->satuan_debit_by_cust. ')';
					} else if ($data->debit_air != '') {
							$debit         = 'Data By Customer('.$data->debit_air_by_cust.')';
					}
				}
			}
			if (in_array('kimia', $data->parent_pengawet) == true) { // array in_array ('variable', array) == true
				$pengawet = str_replace("[", "", json_encode($data->parent_pengawet));
				$pengawet = str_replace("]", "", $pengawet);
				$pengawet = str_replace('"', "", $pengawet);
				$pengawet = str_replace(",", ", ", $pengawet);
				$pengawet = $pengawet . '-' . json_encode($data->jenis_pengawet);
			} else {
				$pengawet = str_replace("[", "", json_encode($data->parent_pengawet));
				$pengawet = str_replace("]", "", $pengawet);
				$pengawet = str_replace('"', "", $pengawet);
			}
		$per_peny = preg_replace('~[\\\\/:*?"<>|+-]~', '', json_encode($data->penyaringan));
		$mutu = preg_replace('~[\\\\/:*?"<>|+-]~', '', json_encode($data->mutu));	
		$template = '<div class="card-body"><div class="row"><div class="col-sm-3"><div class="card-body"><table><tr><th></th><th></th><th></th></tr><tr class="detail"><td class="data">No Sample</td><td>:</td><td><span>'.$data->no_sample.'</span></td></tr><tr class="detail"><td class="data">Jenis Sample</td><td>:</td><td><span>'.$data->jenis_sample.'</span></td></tr><tr class="detail"><td class="data">Penamaan Titik</td><td>:</td><td><span>'.$data->keterangan_1.'</span></td></tr><tr class="detail"><td class="data">Penamaan Tambahan</td><td>:</td><td><span>'.$data->information.'</span></td></tr><tr class="detail" id="stat_ipal"><td class="data">Status Kesediaan Ipal</td><td>:</td><td><span>'.$data->ipal.'</span></td></tr><tr class="detail" id="jenisproduksi"><td class="data">Jenis Produksi</td><td>:</td><td><span>'.$data->jenis_produksi.'</span></td></tr><tr class="detail"><td class="data">Jenis Pengawet</td><td>:</td><td><span>'.$pengawet.'</span></td></tr><tr class="detail" id="loksampling"><td class="data">Lokasi Sampling</td><td>:</td><td><span>'.$data->lokasi_sampling.'</span></td></tr><tr class="detail"><td class="data">Teknik Sampling</td><td>:</td><td><span>'.$data->teknik_sampling.'</span></td></tr><tr class="detail" id="jam_peng"><td class="data">Jam Pengambilan</td><td>:</td><td><span>'.$data->jam.'</span></td></tr><tr class="detail"><td class="data">Perlakuan Penyaringan</td><td>:</td><td><span>'.$per_peny.'</span></td></tr><tr class="detail"><td class="data">pengendalian Mutu</td><td>:</td><td><span>'.$mutu.'</span></td></tr><tr class="detail"><td class="data">Volume</td><td>:</td><td><span>'.$data->volume.' ml</span></td></tr><tr class="detail"><td class="data">Warna</td><td>:</td><td><span>'.$data->warna.'</span></td></tr><tr class="detail"><td class="data">Bau</td><td>:</td><td><span>'.$data->bau.'</span></td></tr><tr class="detail"><td class="data">Ph</td><td>:</td><td><span>'.$data->ph.'</span></td></tr><tr class="detail" id="dhl_"><td class="data">DHL</td><td>:</td><td><span>'.$data->dhl.'</span></td></tr><tr class="detail" id="do_"><td class="data">DO</td><td>:</td><td><span>'.$data->do.'</span></td></tr><tr class="detail"><td class="data">Suhu Air</td><td>:</td><td><span>'.$data->suhu_air.' ℃</span></td></tr><tr class="detail"><td class="data">Suhu Udara</td><td>:</td><td><span>'.$data->suhu_udara.' ℃</span></td></tr><tr class="detail" id="debit_air"><td class="data">Debit</td><td>:</td><td><span>'.$debit.'</span></td></tr><tr class="detail"><td class="data">Koordinat</td><td>:</td><td><span>'.$data->posisi.'</span></td></tr></table></div></div></div></div>';
			return $template;
	} 
		public function bersihoff($data) {
			if (in_array('kimia', $data->parent_pengawet) == true) { // array in_array ('variable', array) == true
				$pengawet = str_replace("[", "", json_encode($data->parent_pengawet));
				$pengawet = str_replace("]", "", $pengawet);
				$pengawet = str_replace('"', "", $pengawet);
				$pengawet = str_replace(",", ", ", $pengawet);
				$pengawet = $pengawet . '-' . json_encode($data->jenis_pengawet);
			} else {
				$pengawet = str_replace("[", "", json_encode($data->parent_pengawet));
				$pengawet = str_replace("]", "", $pengawet);
				$pengawet = str_replace('"', "", $pengawet);
			}
		$per_peny = preg_replace('~[\\\\/:*?"<>|+-]~', '', json_encode($data->penyaringan_));
		$mutu = preg_replace('~[\\\\/:*?"<>|+-]~', '', json_encode($data->mutu));	
			$template = '<div class="card-body"><div class="row"><div class="col-sm-3"><div class="card-body"><table><tr><th></th><th></th><th></th></tr><tr class="detail"><td class="data">No Sample</td><td>:</td><td><span>'.$data->no_sample.'</span></td></tr><tr class="detail"><td class="data">Jenis Sample</td><td>:</td><td><span>'.$data->jenis_sample.'</span></td></tr><tr class="detail"><td class="data">Penamaan Titik</td><td>:</td><td><span>'.$data->keterangan_1.'</span></td></tr><tr class="detail"><td class="data">Penamaan Tambahan</td><td>:</td><td><span>'.$data->information.'</span></td></tr><tr class="detail"><td class="data">Jenis Pengawet</td><td>:</td><td><span>'.$pengawet.'</span></td></tr><tr class="detail"><td class="data">Teknik Sampling</td><td>:</td><td><span>'.$data->teknik_sampling.'</span></td></tr><tr class="detail" id="jam_peng"><td class="data">Jam Pengambilan</td><td>:</td><td><span>'.$data->jam.'</span></td></tr><tr class="detail"><td class="data">Perlakuan Penyaringan</td><td>:</td><td><span>'.$per_peny.'</span></td></tr><tr class="detail"><td class="data">pengendalian Mutu</td><td>:</td><td><span>'.$mutu.'</span></td></tr><tr class="detail"><td class="data">Volume</td><td>:</td><td><span id="volume">'.$data->volume.' ml</span></td></tr><tr class="detail"><td class="data">Warna</td><td>:</td><td><span>'.$data->warna.'</span></td></tr><tr class="detail"><td class="data">Bau</td><td>:</td><td><span>'.$data->bau.'</span></td></tr><tr class="detail"><td class="data">Ph</td><td>:</td><td><span>'.$data->ph.'</span></td></tr><tr class="detail" id="dhl_"><td class="data">DHL</td><td>:</td><td><span>'.$data->dhl.'</span></td></tr><tr class="detail"><td class="data">Suhu Air</td><td>:</td><td><span>'.$data->suhu_air.' ℃</span></td></tr><tr class="detail"><td class="data">Suhu Udara</td><td>:</td><td><span>'.$data->suhu_udara.' ℃</span></td></tr><tr class="detail"><td class="data">Koordinat</td><td>:</td><td><span>'.$data->posisi.'</span></td></tr></table></div></div></div></div>';
			return $template;
	} 

		public function khususoff($data) {
			if (in_array('kimia', $data->parent_pengawet) == true) { // array in_array ('variable', array) == true
				$pengawet = str_replace("[", "", json_encode($data->parent_pengawet));
				$pengawet = str_replace("]", "", $pengawet);
				$pengawet = str_replace('"', "", $pengawet);
				$pengawet = str_replace(",", ", ", $pengawet);
				$pengawet = $pengawet . '-' . json_encode($data->jenis_pengawet);
			} else {
				$pengawet = str_replace("[", "", json_encode($data->parent_pengawet));
				$pengawet = str_replace("]", "", $pengawet);
				$pengawet = str_replace('"', "", $pengawet);
			}
		$per_peny = preg_replace('~[\\\\/:*?"<>|+-]~', '', json_encode($data->penyaringan));
		$mutu = preg_replace('~[\\\\/:*?"<>|+-]~', '', json_encode($data->mutu));	
			$template = '<div class="card-body"><div class="row"><div class="col-sm-3"><div class="card-body"><table><tr><th></th><th></th><th></th></tr><tr class="detail"><td class="data">No Sample</td><td>:</td><td><span>'.$data->no_sample.'</span></td></tr><tr class="detail"><td class="data">Penamaan Titik</td><td>:</td><td><span>'.$data->keterangan_1.'</span></td></tr><tr class="detail"><td class="data">Penamaan Tambahan</td><td>:</td><td><span>'.$data->information.'</span></td></tr><tr class="detail"><td class="data">Jenis Pengawet</td><td>:</td><td><span>'.$pengawet.'</span></td></tr><tr class="detail"><td class="data">Teknik Sampling</td><td>:</td><td><span>'.$data->teknik_sampling.'</span></td></tr><tr class="detail" id="jam_peng"><td class="data">Jam Pengambilan</td><td>:</td><td><span>'.$data->jam.'</span></td></tr><tr class="detail"><td class="data">Perlakuan Penyaringan</td><td>:</td><td><span>'.$per_peny.'</span></td></tr><tr class="detail"><td class="data">pengendalian Mutu</td><td>:</td><td><span>'.$mutu.'</span></td></tr><tr class="detail"><td class="data">Volume</td><td>:</td><td><span>'.$data->volume.' ml</span></td></tr><tr class="detail"><td class="data">Warna</td><td>:</td><td><span>'.$data->warna.'</span></td></tr><tr class="detail"><td class="data">Bau</td><td>:</td><td><span>'.$data->bau.'</span></td></tr><tr class="detail"><td class="data">Ph</td><td>:</td><td><span>'.$data->ph.'</span></td></tr><tr class="detail" id="dhl_"><td class="data">DHL</td><td>:</td><td><span>'.$data->dhl.'</span></td></tr><tr class="detail"><td class="data">Suhu Air</td><td>:</td><td><span>'.$data->suhu_air.' ℃</span></td></tr><tr class="detail"><td class="data">Suhu Udara</td><td>:</td><td><span>'.$data->suhu_udara.' ℃</span></td></tr><tr class="detail"><td class="data">Koordinat</td><td>:</td><td><span>'.$data->posisi.' ℃</span></td></tr></table></div></div></div></div>';
			return $template;
	} 

		public function tanahoff($data) {
			if (in_array('kimia', $data->parent_pengawet) == true) { // array in_array ('variable', array) == true
				$pengawet = str_replace("[", "", json_encode($data->parent_pengawet));
				$pengawet = str_replace("]", "", $pengawet);
				$pengawet = str_replace('"', "", $pengawet);
				$pengawet = str_replace(",", ", ", $pengawet);
				$pengawet = $pengawet . '-' . json_encode($data->jenis_pengawet);
			} else {
				$pengawet = str_replace("[", "", json_encode($data->parent_pengawet));
				$pengawet = str_replace("]", "", $pengawet);
				$pengawet = str_replace('"', "", $pengawet);
			}
			$jeni = preg_replace('~[\\\\/:*?"<>|+-]~', '', json_encode($data->jenis_fungsi));
			$per_peny = preg_replace('~[\\\\/:*?"<>|+-]~', '', json_encode($data->penyaringan));
			$mutu = preg_replace('~[\\\\/:*?"<>|+-]~', '', json_encode($data->mutu));	
			$template = '<div class="card-body"><div class="row"><div class="col-sm-3"><div class="card-body"><table><tr><th></th><th></th><th></th></tr><tr class="detail"><td class="data">No Sample</td><td>:</td><td><span>'.$data->no_sample.'</span></td></tr><tr class="detail"><td class="data">Jenis Sample</td><td>:</td><td><span>'.$data->jenis_sample.'</span></td></tr><tr class="detail"><td class="data">Penamaan Titik</td><td>:</td><td><span>'.$data->keterangan_1.'</span></td></tr><tr class="detail"><td class="data">Penamaan Tambahan</td><td>:</td><td><span>'.$data->information.'</span></td></tr><tr class="detail" id="fungsiair"><td class="data">Jenis Fungsi Air</td><td>:</td><td><span>'.$jeni.'</span></td></tr><tr class="detail"><td class="data">Jenis Pengawet</td><td>:</td><td><span>'.$pengawet.'</span></td></tr><tr class="detail"><td class="data">Teknik Sampling</td><td>:</td><td><span>'.$data->teknik_sampling.'</span></td></tr><tr class="detail" id="jam_peng"><td class="data">Jam Pengambilan</td><td>:</td><td><span id="jam">'.$data->jam.'</span></td></tr><tr class="detail"><td class="data">Perlakuan Penyaringan</td><td>:</td><td><span>'.$per_peny.'</span></td></tr><tr class="detail"><td class="data">pengendalian Mutu</td><td>:</td><td><span>'.$mutu.'</span></td></tr><tr class="detail"><td class="data">Volume</td><td>:</td><td><span>'.$data->volume.' ml</span></td></tr><tr class="detail"><td class="data">Warna</td><td>:</td><td><span>'.$data->warna.'</span></td></tr><tr class="detail"><td class="data">Bau</td><td>:</td><td><span>'.$data->bau.'</span></td></tr><tr class="detail"><td class="data">Ph</td><td>:</td><td><span>'.$data->ph.'</span></td></tr><tr class="detail" id="dhl_"><td class="data">DHL</td><td>:</td><td><span>'.$data->dhl.'</span></td></tr><tr class="detail" id="do_"><td class="data">DO</td><td>:</td><td><span>'.$data->do.'</span></td></tr><tr class="detail"><td class="data">Suhu Air</td><td>:</td><td><span>'.$data->suhu_air.' ℃</span></td></tr><tr class="detail"><td class="data">Suhu Udara</td><td>:</td><td><span>'.$data->suhu_udara.' ℃</span></td></tr><tr class="detail" id="diametersumur"><td class="data">Diameter Sumur</td><td>:</td><td><span>'.$data->diameter_sumur.' m</span></td></tr><tr class="detail" id="kedalaman1_"><td class="data">Kedalaman Sumur Pertama</td><td>:</td><td><span>'.$data->kedalaman_sumur_pertama.' m</span></td></tr><tr class="detail" id="kedalaman2_"><td class="data">Kedalaman Sumur Kedua</td><td>:</td><td><span>'.$data->kedalaman_sumur_kedua.' m</span></td></tr><tr class="detail" id="kedalamanambil"><td class="data">Kedalaman Air Terambil</td><td>:</td><td><span>'.$data->kedalaman_sumur_terambil.' m</span></td></tr><tr class="detail" id="totalwaktu"><td class="data">Total Waktu Pengambilan</td><td>:</td><td><span>'.$data->total_waktu.' detik</span></td></tr><tr class="detail"><td class="data">Koordinat</td><td>:</td><td><span>'.$data->posisi.'</span></td></tr></table></div></div></div></div>';
			return $template;
	} 
		public function lautoff($data) {
			if (in_array('kimia', $data->parent_pengawet) == true) { // array in_array ('variable', array) == true
				$pengawet = str_replace("[", "", json_encode($data->parent_pengawet));
				$pengawet = str_replace("]", "", $pengawet);
				$pengawet = str_replace('"', "", $pengawet);
				$pengawet = str_replace(",", ", ", $pengawet);
				$pengawet = $pengawet . '-' . json_encode($data->jenis_pengawet);
			} else {
				$pengawet = str_replace("[", "", json_encode($data->parent_pengawet));
				$pengawet = str_replace("]", "", $pengawet);
				$pengawet = str_replace('"', "", $pengawet);
			}
				
			if ($data->jam_pengamatan != null) {
				$a = count($data->jam_pengamatan);
				$pasang_surut = array();
				for ($i = 0; $i < $a; $i++) {
						$pasang_surut[] = [
							'jam' => $data->jam_pengamatan[$i],
							'hasil_pengamatan' => $data->hasil_pengamatan[$i]
						];
				}
			}
			$per_peny = preg_replace('~[\\\\/:*?"<>|+-]~', '', json_encode($data->penyaringan));
			$mutu = preg_replace('~[\\\\/:*?"<>|+-]~', '', json_encode($data->mutu));		
			$template = '<div class="card-body"><div class="row"><div class="col-sm-3"><div class="card-body"><table><tr><th></th><th></th><th></th></tr><tr class="detail"><td class="data">No Sample</td><td>:</td><td><span>'.$data->no_sample.'</span></td></tr><tr class="detail"><td class="data">Kedalaman Titik Samping</td><td>:</td><td><span>'.$data->kedalaman.'</span></td></tr><tr class="detail"><td class="data">Lokasi Titik Pengambilan</td><td>:</td><td><span>'.$data->titik_lokasi.'</span></td></tr><tr class="detail" id="titik_pengambilan"><td class="data">Jumlah Titik Pengambilan</td><td>:</td><td><span>'.$data->jtpeng.'</span></td></tr><tr class="detail"><td class="data">Penamaan Titik</td><td>:</td><td><span>'.$data->keterangan_1.'</span></td></tr><tr class="detail"><td class="data">Penamaan Tambahan</td><td>:</td><td><span>'.$data->information.'</span></td></tr><tr class="detail"><td class="data">Jenis Pengawet</td><td>:</td><td><span>'.$pengawet.'</span></td></tr><tr class="detail"><td class="data">Teknik Sampling</td><td>:</td><td><span>'.$data->teknik_sampling.'</span></td></tr><tr class="detail" id="jam_peng"><td class="data">Jam Pengambilan</td><td>:</td><td><span>'.$data->jam.'</span></td></tr><tr class="detail"><td class="data">Perlakuan Penyaringan</td><td>:</td><td><span>'.$per_peny.'</span></td></tr><tr class="detail"><td class="data">pengendalian Mutu</td><td>:</td><td><span>'.$mutu.'</span></td></tr><tr class="detail" id="araharus"><td class="data">Arah Arus</td><td>:</td><td><span>'.$data->arah_arus.'</span></td></tr><tr class="detail" id="lapisanminyak"><td class="data">Lapisan Minyak</td><td>:</td><td><span>'.$data->minyak.'</span></td></tr><tr class="detail" id="cuaca_"><td class="data">Cuaca</td><td>:</td><td><span>'.$data->cuaca.'</span></td></tr><tr class="detail"><td class="data">Volume</td><td>:</td><td><span>'.$data->volume.' ml</span></td></tr><tr class="detail"><td class="data">Warna</td><td>:</td><td><span>'.$data->warna.'</span></td></tr><tr class="detail"><td class="data">Bau</td><td>:</td><td><span>'.$data->bau.'</span></td></tr><tr class="detail"><td class="data">Ph</td><td>:</td><td><span>'.$data->ph.'</span></td></tr><tr class="detail" id="do_"><td class="data">DO</td><td>:</td><td><span>'.$data->do.'</span></td></tr><tr class="detail"><td class="data">Suhu Air</td><td>:</td><td><span>'.$data->suhu_air.' ℃</span></td></tr><tr class="detail"><td class="data">Suhu Udara</td><td>:</td><td><span>'.$data->suhu_udara.' ℃</span></td></tr><tr class="detail" id="salinitas_"><td class="data">Salinitas</td><td>:</td><td><span>'.$data->salinitas.' %</span></td></tr><tr class="detail" id="kecepatanarus"><td class="data">Kecepatan Arus</td><td>:</td><td><span>'.$data->kecepatan_arus.' m/detik</span></td></tr><tr class="detail" id="kecerahan_"><td class="data">Kecerahan</td><td>:</td><td><span>'.$data->kecerahan.' m</span></td></tr><tr class="detail" id="pasangsurut"><td class="data">Pasang Surut</td><td>:</td><td><span>'.json_encode($pasang_surut).'</span></td></tr><tr class="detail"><td class="data">Koordinat</td><td>:</td><td><span>'.$data->posisi.'</span></td></tr></table></div></div></div></div>';
			return $template;
	} 

	public function showData($id){
		$val = $this->model('AirModel')->showDetail($id, $this->connection());
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
		$data['lat'] = $val->lat;
		$data['long'] = $val->long;
		$data['coor'] = $val->coor;
		$data['title'] = 'APPS INTILAB';
		$data['token'] = $_SESSION['token'];
		$data['template'] = $template;
		$this->view('templates/header', $data);
		$this->view('templates/sidebar', $data);
		$this->view('air/detail', $data);
		$this->view('templates/footer');
	}

	public function showDataoff($id) {
		// var_dump($id);
		$val = $this->model('AirModel')->showDetail($id, $this->connection());
		if( $val->kat_id == 54 || $val->kat_id == 56 || $val->kat_id == 89 || $val->kat_id == 90 || $val->kat_id == 91 || $val->kat_id == 92 || $val->kat_id == 93 || $val->kat_id == 94 || $val->kat_id == 6) {
			$template = Self::permukaanoff($val);
		}else if($val->kat_id == 3 || $val->kat_id == 2 || $val->kat_id == 51) {
			$template = Self::limbahoff($val);
		}else if($val->kat_id == 1 || $val->kat_id == 4) {
			$template = Self::bersihoff($val);
		}else if($val->kat_id == 64) {
			$template = Self::khususoff($val);
		}else if($val->kat_id == 72) {
			$template = Self::tanahoff($val);
		}else if($val->kat_id == 5) {
			$template = Self::lautoff($val);
		}

		$data['title'] = 'APPS INTILAB';
		$data['token'] = $_SESSION['token'];
		$data['template'] = $template;
		$this->view('templates/header', $data);
		$this->view('templates/sidebar', $data);
		$this->view('air/detailoff', $data);
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