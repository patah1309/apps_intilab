<div id="appCapsule">
   <div class="row">
      <div class="col-12">
         <div class="card">
            <div class="modal-header">
               <h6 class="modal-title" id="myModalLabel">Detail Offline Data Lapangan</h6>
               <a href="<?= base_url;?>/air/data" class="item">
                  <div class="icon-box bg-danger">
                     <i class="fa-solid fa-xmark"></i>
                  </div>
               </a>
            </div>
            <?= $data['template'] ?>
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