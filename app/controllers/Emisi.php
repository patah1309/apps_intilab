<?php

class Emisi extends Controller {

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
			// $val = $this->model('UserModel')->getUserById();
			$data['nama'] = $_SESSION['name'];
            $data['salam'] = $status;
			// $data['koneksi'] = $this->connection();
			$data['total_data'] = $this->model('EmisiModel')->getJsonData();
			$this->view('templates/header', $data);
			$this->view('templates/sidebar', $data);
			$this->view('emisi/index', $data);
			$this->view('templates/footer');
		}else {
			// session_start();
			session_destroy();
			header('location: '. base_url . '/login');
		}
		
	}

    public function add_data(){
        $data['title'] = 'APPS INTILAB';
		$data['token'] = $_SESSION['token'];
		// $data['data'] = [];
        $this->view('templates/header', $data);
        $this->view('templates/sidebar', $data);
        $this->view('emisi/scanQr', $data);
        $this->view('templates/footer');
    }

    public function scann(){
        $qr = '';
        $no_sample = '';
        $qr = $_POST['qr'];
        $no_sample = $_POST['no_sample'];
		$val = $this->model('EmisiModel')->GetData($qr, $no_sample, $this->connection());
		echo $val;
    }

    public function addOrderemisi(){
        $data['title'] = 'APPS INTILAB';
        $data['qr'] = $_POST['qr'];
        $no_sample = '';
        
        if($this->connection() == true && $_POST['qr'] != ''){
            $val = json_decode($this->model('EmisiModel')->GetData($_POST['qr'], $no_sample, $this->connection()));
            if($val->record > 0){
                $data['id_kendaraan']   = $val->id_kendaraan;
                $data['id_qr']          = $val->id_qr;
                $data['bbm']            = $val->bbm;
                $data['plat']           = $val->plat;
                $data['no_mesin']       = $val->no_mesin;
                $data['merk']           = $val->merk;
                $data['transmisi']      = $val->transmisi;
                $data['tahun']          = $val->tahun;
                $data['cc']             = $val->cc;
                $data['km']             = $val->km;
                $data['kategori']       = $val->kategori;
                $data['bobot']          = $val->bobot;
            }else {
                $data['id_kendaraan']   = '';
                $data['id_qr']          = '';
                $data['bbm']            = '';
                $data['plat']           = '';
                $data['no_mesin']       = '';
                $data['merk']           = '';
                $data['transmisi']      = '';
                $data['tahun']          = '';
                $data['cc']             = '';
                $data['km']             = '';
                $data['kategori']       = '';
                $data['bobot']          = '';
            }
        }else {
            $data['id_kendaraan']   = '';
            $data['id_qr']          = '';
            $data['bbm']            = '';
            $data['plat']           = '';
            $data['no_mesin']       = '';
            $data['merk']           = '';
            $data['transmisi']      = '';
            $data['tahun']          = '';
            $data['cc']             = '';
            $data['km']             = '';
            $data['kategori']       = '';
            $data['bobot']          = '';
        }
        
        $this->view('templates/header', $data);
        $this->view('templates/sidebar', $data);
        $this->view('emisi/input', $data);
        $this->view('templates/footer');
    }

    public function getregulasi(){
        $kon = $this->connection();
        $val = $this->model('EmisiModel')->regulasi($kon);
        if(is_array($val) == true){
            $arr = [];
            foreach($val as $key){
                if($key['id_kategori'] == '5'){
                    array_push($arr , array('id' => $key['id'], 'text' => $key['peraturan']));
                }
            }
            echo json_encode($arr);
        }else {
            echo json_encode($val);
        }
    }

    public function saveData(){
		$kon = $this->connection();
		$save = $this->model('EmisiModel')->saveData($kon, $_POST);
		echo json_encode($save['status']);
	}

    public function upload_data_to_server(){
		$data = $this->model('EmisiModel')->syncronize();
		echo $data;
	}

    public function detailEmisi($id=null){
        if($id){
            $data['qr'] = $id;
        }else {
            $data['qr'] = $_POST['qr_code'];
        }
        $data['title'] = 'APPS INTILAB';
        // $data['data'] = $this->model('EmisiModel')->getDetail($qr);
        $this->view('templates/header', $data);
        $this->view('templates/sidebar', $data);
        $this->view('emisi/detail', $data);
        $this->view('templates/footer');
    }

    public function bensin($data) {
        $co2 = json_encode($data->co2);
        $co = json_encode($data->co);
        $hc = json_encode($data->hc);
        $o2 = json_encode($data->o2);
    $template = '<div class="card-body"><div class="row"><div class="col-sm-4"><div class="card-body"><table><tr><th></th><th></th><th></th></tr><tr class="detail"><td class="data">Kode QR</td><td>:</td><td><span>'.$data->kode_qr.'</span></td></tr><tr class="detail"><td class="data">No Sample</td><td>:</td><td><span>'.$data->no_sample.'</span></td></tr><tr class="detail"><td class="data">Nama Pelanggan</td><td>:</td><td><span>'.$data->nama.'</span></td></tr><tr class="detail"><td class="data">Alamat Lokasi Pengujian</td><td>:</td><td><span>'.$data->lokasi_pengujian.'</span></td></tr><tr class="detail"><td class="data">Jenis Bahan Bakar Kendaraan</td><td>:</td><td><span>'.$data->jenis_kendaraan.'</span></td></tr><tr class="detail"><td class="data">No Polisi</td><td>:</td><td><span>'.$data->no_plat.'</span></td></tr><tr class="detail"><td class="data">Nomor Mesin</td><td>:</td><td><span>'.$data->no_mesin.'</span></td></tr><tr class="detail"><td class="data">Merk Kendaraan</td><td>:</td><td><span>'.$data->merk.'</span></td></tr><tr class="detail"><td class="data">Tranmission</td><td>:</td><td><span>'.$data->transmisi.'</span></td></tr><tr class="detail"><td class="data">Tahun Pembuatan</td><td>:</td><td><span>'.$data->tahun.'</span></td></tr><tr class="detail"><td class="data">Kategori Kendaraan</td><td>:</td><td><span>'.$data->kategori_kendaraan.'</span></td></tr><tr class="detail"><td class="data">KM Kendaraan</td><td>:</td><td><span>'.$data->km.'</span></td></tr><tr class="detail"><td class="data">Kapasitas CC</td><td>:</td><td><span>'.$data->cc.'</span></td></tr><tr class="detail"><td class="data">Bobot Kendaraan</td><td>:</td><td><span>'.$data->bobot_kendaraan.'</span></td></tr><tr class="detail"><td class="data">CO2 %</td><td>:</td><td><span>'.$co2.'</span></td></tr><tr class="detail"><td class="data">CO %</td><td>:</td><td><span>'.$co.'</span></td></tr><tr class="detail"><td class="data">HC %</td><td>:</td><td><span>'.$hc.'</span></td></tr><tr class="detail"><td class="data">O2 %</td><td>:</td><td><span>'.$o2.'</span></td></tr><tr class="detail"><td class="data">Lambda (λ)</td><td>:</td><td><span>'.$data->lamda.'</span></td></tr><tr class="detail"><td class="data">Regulasi</td><td>:</td><td><span>'.$data->regulasi.'</span></td></tr><tr class="detail"><td class="data">Catatan Kondisi Sampling</td><td>:</td><td><span>'.$data->catatan.'</span></td></tr></table></div></div></div></div>';
        return $template;
	}

    public function solar($data) {
        $opasitas = json_encode($data->opasitas);
        $nilai_k = json_encode($data->nilai_k);
        $rpm = json_encode($data->rpm);
        $oli = json_encode($data->oli);
    $template = '<div class="card-body"><div class="row"><div class="col-sm-4"><div class="card-body"><table><tr><th></th><th></th><th></th></tr><tr class="detail"><td class="data">Kode QR</td><td>:</td><td><span>'.$data->kode_qr.'</span></td></tr><tr class="detail"><td class="data">No Sample</td><td>:</td><td><span>'.$data->no_sample.'</span></td></tr><tr class="detail"><td class="data">Nama Pelanggan</td><td>:</td><td><span>'.$data->nama.'</span></td></tr><tr class="detail"><td class="data">Alamat Lokasi Pengujian</td><td>:</td><td><span>'.$data->lokasi_pengujian.'</span></td></tr><tr class="detail"><td class="data">Jenis Bahan Bakar Kendaraan</td><td>:</td><td><span>'.$data->jenis_kendaraan.'</span></td></tr><tr class="detail"><td class="data">No Polisi</td><td>:</td><td><span>'.$data->no_plat.'</span></td></tr><tr class="detail"><td class="data">Nomor Mesin</td><td>:</td><td><span>'.$data->no_mesin.'</span></td></tr><tr class="detail"><td class="data">Merk Kendaraan</td><td>:</td><td><span>'.$data->merk.'</span></td></tr><tr class="detail"><td class="data">Tranmission</td><td>:</td><td><span>'.$data->transmisi.'</span></td></tr><tr class="detail"><td class="data">Tahun Pembuatan</td><td>:</td><td><span>'.$data->tahun.'</span></td></tr><tr class="detail"><td class="data">Kategori Kendaraan</td><td>:</td><td><span>'.$data->kategori_kendaraan.'</span></td></tr><tr class="detail"><td class="data">KM Kendaraan</td><td>:</td><td><span>'.$data->km.'</span></td></tr><tr class="detail"><td class="data">Kapasitas CC</td><td>:</td><td><span>'.$data->cc.'</span></td></tr><tr class="detail"><td class="data">Bobot Kendaraan</td><td>:</td><td><span>'.$data->bobot_kendaraan.'</span></td></tr><tr class="detail"><td class="data">Opasitas (%HSU)</td><td>:</td><td><span>'.$opasitas.'</span></td></tr><tr class="detail"><td class="data">Nilai K(m-1)</td><td>:</td><td><span>'.$nilai_k.'</span></td></tr><tr class="detail"><td class="data">Putaran Mesin (RPM)</td><td>:</td><td><span>'.$rpm.'</span></td></tr><tr class="detail"><td class="data">Temperature Oli</td><td>:</td><td><span>'.$oli.'</span></td></tr><tr class="detail"><td class="data">Regulasi</td><td>:</td><td><span>'.$data->regulasi.'</span></td></tr><tr class="detail"><td class="data">Catatan Kondisi Sampling</td><td>:</td><td><span>'.$data->catatan.'</span></td></tr></table></div></div></div></div>';
        return $template;
	}

    public function detailEmisioff($id){
        $data['title'] = 'APPS INTILAB';
        $val = $this->model('EmisiModel')->getDetailoff($id);
        if($val->jenis_kendaraan == 31) {
			$template = Self::bensin($val);
		}else if($val->jenis_kendaraan == 32) {
			$template = Self::solar($val);
		}
        $data['template'] = $template;
        $this->view('templates/header', $data);
        $this->view('templates/sidebar', $data);
        $this->view('emisi/detailoff', $data);
        $this->view('templates/footer');
    }

    public function getDataDetail(){
        $val = $this->model('EmisiModel')->getDetail($_POST['qr']);
        echo $val;
    }

    public function viewData(){
        $kon = $this->connection();
        $data['koneksi'] = $this->connection();
        $data['title'] = 'APPS INTILAB';
        $val = $this->model('EmisiModel')->getDataEmisi($kon);
        // var_dump($val);die();
        if($konek == true) {
			$data['data'] = $val->data;
		}else {
			$data['data'] = $val;
		}
        $this->view('templates/header', $data);
        $this->view('templates/sidebar', $data);
        $this->view('emisi/data', $data);
        $this->view('templates/footer');
    }

    public function approveEmisi(){
		$id = $_POST['id'];
		$data = $this->model('EmisiModel')->approveData($id);
		echo $data;
	}

    public function hapusData(){
		$id = $_POST['id'];
		$data = $this->model('EmisiModel')->HapusData($id);
		echo $data;
	}

    public function deleteEmisi(){
		$id = $_POST['id'];
		$data = $this->model('EmisiModel')->deleteData($id);
		echo $data;
	}

    public function download_regulasi(){
        $kon = $this->connection();
		$save = $this->model('EmisiModel')->sync_regulasi($kon);
        Flasher::setMessage('Sync Regulasi',$save['message'],$save['status']);
        header('location: '. base_url . '/home');
    }
}