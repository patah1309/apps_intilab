<div id="appCapsule">
   <div class="section wallet-card-section pt-1">
      <div class="wallet-card">
         <div class="balance">
            <div class="left">
               <span class="title"><?= $data['salam']; ?></span>
               <h1 class="total"><span><?= $data['nama']; ?></span></h1>
            </div>
            <div class="right">
               <span class="title">Total Data Offline : <?= $data['total_data']; ?></span>
               <button class="btn btn-success" id="sync"><i class="fa-solid fa-upload"></i> Upload Data</button>
            </div>
         </div>

         <!-- * Balance -->
         <!-- Wallet Footer -->
         <div class="wallet-footer">
            <div class="item">
               <a href="<?= base_url;?>/air/add_data">
                  <div class="icon-wrapper bg-primary">
                     <i class="fa-solid fa-plus"></i>
                  </div>
                  <strong>Add Data</strong>
               </a>
            </div>
            <div class="item">
               <a href="<?= base_url;?>/air/data">
                  <div class="icon-wrapper bg-danger">
                     <i class="fa-solid fa-file-lines"></i>
                  </div>
                  <strong>Data</strong>
               </a>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="row px-4">
   <div class="col-12 mt-3 mb-3">
      <div class="row d-flex justify-content-center">
         <div class="col-4 d-flex justify-content-center mb-3">
            <div class="itemair" style="background-color: #15bdb4;">
               <div class="text-center">
                  <h1 class="text-white"><?= $data['permukaan'] ?></h1>
                  <h3 class="text-white">Pemukaan</h3>
               </div>
            </div>
         </div>
         <div class="col-4 d-flex justify-content-center mb-3">
            <div class="itemair" style="background-color: #2229ba;">
               <div class="text-center">
                  <h1 class="text-white"><?= $data['limbah'] ?></h1>
                  <h3 class="text-white">Limbah</h3>
               </div>
            </div>
         </div>
         <div class="col-4 d-flex justify-content-center mb-3">
            <div class="itemair" style="background-color: #3095e3;">
               <div class="text-center">
                  <h1 class="text-white"><?= $data['laut'] ?></h1>
                  <h3 class="text-white">Laut</h3>
               </div>
            </div>
         </div>
         <div class="col-4 d-flex justify-content-center mb-3">
            <div class="itemair" style="background-color: #282a57;">
               <div class="text-center">
                  <h1 class="text-white"><?= $data['tanah'] ?></h1>
                  <h3 class="text-white">Tanah</h3>
               </div>
            </div>
         </div>
         <div class="col-4 d-flex justify-content-center mb-3">
            <div class="itemair" style="background-color: #db3be3;">
               <div class="text-center">
                  <h1 class="text-white"><?= $data['bersih'] ?></h1>
                  <h3 class="text-white">Bersih</h3>
               </div>
            </div>
         </div>
         <div class="col-4 d-flex justify-content-center mb-3">
            <div class="itemair" style="background-color: #541bb5;">
               <div class="text-center">
                  <h1 class="text-white"><?= $data['khusus'] ?></h1>
                  <h3 class="text-white">Khusus</h3>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<div class="btnBottom">
   <div class="btnTengah" onclick="location.href='<?= base_url;?>/air/add_data'"></a></div>
   <div class="btnMenu">
      <ul>
         <li style="--i:0.1s;"><a href="<?= base_url;?>/home"><i class="fa-solid fa-gauge"></i></a></li>
         <li style="--i:0.2s;"><a href="<?= base_url;?>/air"><i class="fa-solid fa-house"></i></a></li>
         <li></li>
         <li style="--i:0.2s;"><a href="<?= base_url;?>/air/data"><i class="fa-solid fa-file-lines"></i></a></li>
         <li style="--i:0.1s;"><a href="<?= base_url;?>/profile"><i class="fa-solid fa-user"></i></a></li>
      </ul>
   </div>
</div>

<script>
$('#sync').on('click', function() {
   let net = $('#status-text').text();
   if (net == "Online") {
      //   var no_sample = $("#no_sample").val();
      $.ajax({
         url: '/public/air/upload_data_to_server',
         method: 'POST',
         beforeSend: function() {
            Swal.fire({
               title: "Please Wait !",
               allowOutsideClick: !1,
               showConfirmButton: !1,
               onBeforeOpen() {
                  Swal.showLoading()
               }
            })
         },
         success: function(resp) {
            resp = JSON.parse(resp)
            if (resp.message == "Ada data offline gagal upload ke server.!") {
               Swal.fire({
                  title: resp.message,
                  icon: "info",
                  timer: 2000
               })
               setTimeout(() => {
                  location.href = "<?= base_url;?>/air";
               }, 3000);
            } else {
               Swal.fire({
                  title: "Data Berhasil Disimpan",
                  icon: "success",
                  timer: 2000
               })
               setTimeout(() => {
                  location.href = "<?= base_url;?>/air";
               }, 3000);

            }
         },
         error: function(e) {
            Swal.fire({
               icon: 'error',
               title: 'Tidak Dapat Mengirim Data.!',
            })
         }
      })
   } else {
      Swal.fire({
         icon: 'error',
         title: 'Anda Sedang Offline, Tidak Dapat Melakukan Sinkronisasi',
      })
   }
})
</script>