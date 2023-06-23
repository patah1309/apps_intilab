<?php error_reporting(0); ?>
<!DOCTYPE html>
<html lang="id-ID" xml:lang="id-ID">

<head>

   <!--Viewport -->
   <meta content="width=device-width, initial-scale=1.0" name="viewport" />
   <meta content="text/html; charset=UTF-8" http-equiv="Content-Type" />
   <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible" />
   <!--Title-->
   <title><?= $data['title']; ?></title>

   <!--verification-->
   <meta name="yandex-verification" content="" />
   <meta name="p:domain_verify" content="" />
   <meta name="msvalidate.01" content="" />
   <meta name="google-site-verification" content="" />
   <meta name="dmca-site-verification" content="" />
   <meta name="facebook-domain-verification" content="" />


   <!--resource-->
   <link rel='stylesheet' href='<?= base_url;?>/assets/css/sweetalert2.min.css'>
   <script src="<?= base_url;?>/assets/js/sweetalert2.all.min.js"></script>
   <link href="//fonts.googleapis.com" rel="preconnect dns-prefetch" />
   <link href="//api.github.com" rel="preconnect dns-prefetch" />
   <link href="//api.mapbox.com" rel="preconnect dns-prefetch" />
   <link href="//cdnjs.cloudflare.com" rel="preconnect dns-prefetch" />
   <link href="//unpkg.com" rel="preconnect dns-prefetch" />
   <link href="//kit.fontawesome.com" rel="preconnect dns-prefetch" />
   <!--CSS-->
   <link rel="stylesheet" href="<?= base_url;?>/assets/css/style.css">
   <link rel="stylesheet" href="<?= base_url;?>/assets/css/sw-custom.css">
   <script src="<?= base_url;?>/assets/js/lib/jquery-3.4.1.min.js"></script>
   <link rel="stylesheet"
      href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
   <link rel="stylesheet" href="<?= base_url;?>/assets/js/plugins/select2/css/select2.min.css">
   <link rel="stylesheet" href="<?= base_url;?>/assets/js/plugins/datatables/dataTables.bootstrap.css">
   <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.3/dist/leaflet.css">
   <script src="https://unpkg.com/leaflet@1.3.3/dist/leaflet.js"
      integrity="sha512-tAGcCfR4Sc5ZP5ZoVz0quoZDYX5aCtEm/eu1KhSLj2c9eFrylXZknQYmxUssFaVJKvvc0dJQixhGjG2yXWiV9Q=="
      crossorigin="">
   </script>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css"
      integrity="sha512-ZKX+BvQihRJPA8CROKBhDNvoc2aDMOdAlcm7TUQY+35XYtrd3yh95QOOhsPDQY9QnKE0Wqag9y38OIgEvb88cA=="
      crossorigin="anonymous" referrerpolicy="no-referrer" />
   <link rel="stylesheet" href="<?= base_url;?>/assets/js/plugins/datepicker/bootstrap-datepicker.css">
</head>
<style>
body {
   font-family: "Poppins", sans-serif;
   font-size: 15px;
   line-height: 1.6rem;
   letter-spacing: 0.004em;
   color: #6c757d;
   background: #00b4ff;
   width: 100%;
   height: 100%;
   overflow-x: hidden;
   user-select: none;
   -moz-user-select: none;
   -webkit-user-select: none;
}

.icon-custom {
   width: 50%;
   height: 65px;
   border-radius: 20px;
   text-align: center;
   align-items: center;
}

.atas {
   border-top: 1px solid #DCDCE9 !important;
}

.tengah {
   padding-top: 20px;
   display: flex;
   align-items: flex-start;
   justify-content: space-between;
}

.bawah {
   border-bottom: 1px solid #DCDCE9 !important;
}

.wallet-card .wallet-footer {
   border-top: 0px solid #DCDCE9;
   padding-top: 20px;
   display: flex;
   align-items: flex-start;
   justify-content: space-between;
}

.box-item {
   display: flex;
   justify-content: center;
   align-items: center;
}

.itemm {
   background-color: #00b4ff;
   border-radius: 10px;
   width: 70px;
   height: 70px;
   box-shadow: 3px 3px 3px #e06666;
   display: flex;
   justify-content: center;
   align-items: center;
}

.itemm2 {
   display: flex;
   justify-content: center;
   align-items: center;
   height: 60px;
   width: 60px;
   border-radius: 10px;
}

.itemm:active {
   background-color: #18de5a;
   transition: 0s;
}

.btnBottom {
   height: 56px;
   position: fixed;
   z-index: 999;
   bottom: 0;
   width: 100%;
   background: #ffffff;
   border-top: 27px solid #ffffff;
   display: flex;
   justify-content: center;
   align-items: center;
}

.btnTengah {
   position: relative;
   width: 65px;
   height: 65px;
   background: rgb(254, 35, 35);
   border: 5px solid rgb(255, 255, 255);
   border-radius: 50%;
   cursor: pointer;
   display: flex;
   justify-content: center;
   align-items: center;
   z-index: 10;
   /* background-image: url('icon/icon-add-pe.png'); */
   transform: translateY(-30px);

}

.btnTengah::before {
   content: '+';
   position: absolute;
   font-size: 3em;
   color: rgb(255, 255, 255);
   /* transition: 1.5s; */
}

/* .btnTengah.active::before {
         transform: rotate(225deg);
        } */
.btnTengah i {
   position: absolute;
   inset: 0;
}

.btnTengah i::before {
   content: '';
   position: absolute;
   top: 22px;
   left: -23px;
   width: 20px;
   height: 20px;
   background: transparent;
   border-top-right-radius: 20px;
   box-shadow: 3px -6px #ffffff;
}

.btnTengah i::after {
   content: '';
   position: absolute;
   top: 22px;
   right: -23px;
   width: 20px;
   height: 20px;
   background: transparent;
   border-top-left-radius: 20px;
   box-shadow: -3px -6px #ffffff;
}

.btnMenu {
   position: absolute;
   width: 100%;
   height: 70px;
   background: #4778e9;
   border-top-left-radius: 20px;
   border-top-right-radius: 20px;
}

.btnMenu ul {
   position: relative;
   left: -18px;
   display: flex;
   justify-content: center;
   align-items: center;
   gap: 35px;
   line-height: 60px;
}

.btnMenu ul li {
   list-style: none;
   cursor: pointer;
}

.btnMenu ul li:nth-child(3) {
   width: 30px;
}

.btnMenu ul li a {
   display: block;
   font-size: 2em;
   text-decoration: none;
   color: #ffffff;
}

.btnMenu ul li:hover a {
   color: cyan;
}

.itemair {
   border-radius: 10%;
   width: 110px;
   height: 110px;
   box-shadow: 8px 8px 8px #eff757;
   display: flex;
   justify-content: center;
   align-items: center;

}

.itemair:active {
   filter: brightness(150%);
}


.SizeChooser table {
   border-collapse: separate;
   border-spacing: 3px;
}

.SizeChooser td {
   cursor: pointer;
   border: 1px #ccc solid;
   height: 22px;
   min-width: 22px;
   border-radius: 2px;
   /* line-height: 10px; */
}

.SizeChooser-selected {
   position: relative;
   height: 9px;
   /* this can be anything */
   width: 9px;
   /* ...but maintain 1:1 aspect ratio */
   border: 1px #050505 solid !important;
}

.SizeChooser-selected::before,
.SizeChooser-selected::after {
   margin-top: -1px;
   margin-left: -1px;
   position: absolute;
   content: '';
   width: 100%;
   height: 2px;
   /* cross thickness */
   background-color: black;
}

.SizeChooser-selected::before {
   transform: rotate(45deg);
}

.SizeChooser-selected::after {
   transform: rotate(-45deg);
}

.SizeChooser-hover {
   background-color: #DEF;
}

.table_size_chooser {
   width: 100%;
}
</style>