<div id="appCapsule">
   <div class="section wallet-card-section pt-1">
      <div class="wallet-card">
         <div class="balance">
            <div class="left">
               <span class="title"><?= $data['salam']; ?></span>
               <h1 class="total"><span><?= $data['nama']; ?></span></h1>
            </div>
         </div>
         <!-- * Balance -->
         <!-- Wallet Footer -->
         <div class="wallet-footer">
            <div class="item">
               <a href="./addDatakebisingan">
                  <div class="icon-wrapper bg-primary">
                     <ion-icon name="add-outline"></ion-icon>
                  </div>
                  <strong>Add Data</strong>
               </a>
            </div>
            <div class="item">
               <a href="./datakebisingan">
                  <div class="icon-wrapper bg-danger">
                     <ion-icon name="document-text-outline"></ion-icon>
                  </div>
                  <strong>Data</strong>
               </a>
            </div>
         </div>
      </div>
   </div>
</div>


<div class="btnBottom">
   <div class="btnTengah" onclick="location.href='air/add_data'"></a></div>
   <div class="btnMenu">
      <ul>
         <li style="--i:0.1s;"><a href="<?= base_url;?>/home">
               <ion-icon name="speedometer"></ion-icon>
            </a></li>
         <li style="--i:0.2s;"><a href="<?= base_url;?>/air">
               <ion-icon name="home"></ion-icon>
            </a></li>
         <li></li>
         <li style="--i:0.2s;"><a href="<?= base_url;?>/dataair">
               <ion-icon name="document-text"></ion-icon>
            </a></li>
         <li style="--i:0.1s;"><a href="<?= base_url;?>/profile">
               <ion-icon name="person"></ion-icon>
            </a></li>
      </ul>
   </div>
</div>