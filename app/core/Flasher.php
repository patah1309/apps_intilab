<?php

class Flasher{

    public static function setMessage($pesan, $aksi, $type, $data='')
    {
        
            $_SESSION['msg'] = [
                'pesan' => $pesan,
                'aksi'  => $aksi,
                'type'  => $type,
                'data'  => $data,
            ];
           
    }

    public static function Message(){
        if( isset($_SESSION['msg']) )
        {

            echo '<div class="alert alert-'. $_SESSION['msg']['type'] .' alert-dismissible fade show" role="alert">'.
                    $_SESSION['msg']['data'].' <strong>'. $_SESSION['msg']['pesan'] .'</strong> '. $_SESSION['msg']['aksi'] .'
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                  </div>';

            unset($_SESSION['msg']);
        }

    }
}