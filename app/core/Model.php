<?php

class Model {
    public function before_save($modul, $data){
		if (!file_exists('file/'.date('Y-m-d'))) {
			// mkdir('file/'.date('Y-m-d'), 0777, true);
			mkdir('file/'.date('Y-m-d').'/'.$modul, 0777, true);
			// tempat data
			if(file_exists('file/'.date('Y-m-d').'/'.$modul.'/'.$modul.'.json')){
				$file = file_get_contents('file/'.date('Y-m-d').'/'.$modul.'/'.$modul.'.json');
				if($file){
					$value = json_decode($file, true);
					file_put_contents('file/'.date('Y-m-d').'/'.$modul.'/'.$modul.'.json', json_encode($value, JSON_PRETTY_PRINT));
					return true;
				}
			}else {
				$array = [];
				array_push($array, $data);
				$file = file_put_contents('file/'.date('Y-m-d').'/'.$modul.'/'.$modul.'.json', json_encode($array, JSON_PRETTY_PRINT));
				return true;
			}
		}else {
			if (!file_exists('file/'.date('Y-m-d').'/'.$modul)) {
				mkdir('file/'.date('Y-m-d').'/'.$modul, 0777, true);
				// tempat data
				if(file_exists('file/'.date('Y-m-d').'/'.$modul.'/'.$modul.'.json')){
					$file = file_get_contents('file/'.date('Y-m-d').'/'.$modul.'/'.$modul.'.json');
					if($file){
						$value = json_decode($file, true);
						array_push($value, $data);
						file_put_contents('file/'.date('Y-m-d').'/'.$modul.'/'.$modul.'.json', json_encode($value, JSON_PRETTY_PRINT));
						return true;
					}
				}else {
					$array = [];
					array_push($array, $data);
					$file = file_put_contents('file/'.date('Y-m-d').'/'.$modul.'/'.$modul.'.json', json_encode($array, JSON_PRETTY_PRINT));
					return true;
				}
			}else {
				if(file_exists('file/'.date('Y-m-d').'/'.$modul.'/'.$modul.'.json')){
					$file = file_get_contents('file/'.date('Y-m-d').'/'.$modul.'/'.$modul.'.json');
					if($file){
						$value = json_decode($file, true);
						array_push($value, $data);
						file_put_contents('file/'.date('Y-m-d').'/'.$modul.'/'.$modul.'.json', json_encode($value, JSON_PRETTY_PRINT));
						return true;
					}
				}else {
					$array = [];
					array_push($array, $data);
					$file = file_put_contents('file/'.date('Y-m-d').'/'.$modul.'/'.$modul.'.json', json_encode($array, JSON_PRETTY_PRINT));
					return true;
				}
			}
		}
	}
}