<div id="appCapsule">
   <!-- Wallet Card -->
   <div class="section wallet-card-section pt-1">
      <div class="wallet-card">
         <div class="row">
            <?php if($data['message'] != "") { ?>
            <marquee behavior="" direction="" class="col-sm-12" style="height: 80px;font-size: 25px;padding: 25px;">
               <?= $data['message'] ?></marquee>
            <?php }else { ?>
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
               <div class="carousel-inner">
                  <div class="carousel-item active">
                     <img class="d-block w-100 h-50 rounded" src="<?= base_url; ?>/img/gbr1.jpg" alt="First slide">
                  </div>
                  <div class="carousel-item">
                     <img class="d-block w-100 h-50 rounded" src="<?= base_url; ?>/img/gbr2.jpg" alt="Second slide">
                  </div>
                  <div class="carousel-item">
                     <img class="d-block w-100 h-50 rounded" src="<?= base_url; ?>/img/gbr3.jpg" alt="Third slide">
                  </div>

               </div>
            </div>
            <?php } ?>
         </div>

         <div class="d-flex justify-content-center">
            <b>Home Page</b>
         </div>

         <!-- Wallet Footer -->
         <div class="atas"></div>

         <div class="row
                        px-1 mt-1">
            <div class="col-4">
               <div class="box-item">
                  <a href="<?= base_url; ?>/emisi">
                     <div class="itemm">
                        <div class="bg-white itemm2">
                           <img src="<?= base_url; ?>/img/emisi.png" width="55" height="55">
                        </div>
                     </div>
                  </a>
               </div>
               <div class="text-center">
                  <h6 class="text-back mt-1">Emisi
                     Kendaraan</h6>
               </div>
            </div>
            <!-- =============================KEBISINGAN=============================== -->
            <div class="col-4">
               <div class="box-item">
                  <a href="<?= base_url; ?>/kebisingan">
                     <div class="itemm">
                        <div class="bg-white itemm2">
                           <img src="<?= base_url; ?>/img/bising.png" width="55" height="55">
                        </div>
                     </div>
                  </a>
               </div>
               <div class="text-center">
                  <h6 class="text-back mt-1">Kebisingan</h6>
               </div>
            </div>
            <!-- =========================END KEBISINGAN======================================= -->
            <div class="col-4">
               <div class="box-item">
                  <a href="<?= base_url; ?>/air">
                     <div class="itemm">
                        <div class="bg-white itemm2">
                           <img src="<?= base_url; ?>/img/limbah.png" width="55" height="55">
                        </div>
                     </div>
                  </a>
               </div>
               <div class="text-center">
                  <h6 class="text-back mt-1">Air</h6>
               </div>
            </div>
         </div>

         <div class="row
                        px-1 mt-1">
            <div class="col-4">
               <div class="box-item">
                  <a href="./foto">
                     <div class="itemm">
                        <div class="bg-white itemm2">
                           <img src="<?= base_url; ?>/img/qc.jpg" width="55" height="55">
                        </div>
                     </div>
                  </a>
               </div>
               <div class="text-center">
                  <h6 class="text-back mt-1">Foto</h6>
               </div>
            </div>
            <div class="col-4">
               <div class="box-item">
                  <a href="<?= base_url; ?>/cahaya">
                     <div class="itemm">
                        <div class="bg-white itemm2">
                           <img src="<?= base_url; ?>/img/cahaya.jpg" width="55" height="55">
                        </div>
                     </div>
                  </a>
               </div>
               <div class="text-center">
                  <h6 class="text-back mt-1">Cahaya</h6>
               </div>
            </div>
            <div class="col-4">
               <div class="box-item">
                  <a href="<?= base_url; ?>/getaranling">
                     <div class="itemm">
                        <div class="bg-white itemm2">
                           <img src="<?= base_url; ?>/img/getaranLing.png" width="55" height="55">
                        </div>
                     </div>
                  </a>
               </div>
               <div class="text-center">
                  <h6 class="text-back mt-1">Getaran Lingkungan</h6>
               </div>
            </div>
         </div>
         <div class="row
                        px-1 mt-1">
            <div class="col-4">
               <div class="box-item">
                  <a href="./getaranPer">
                     <div class="itemm">
                        <div class="bg-white itemm2">
                           <img src="<?= base_url; ?>/img/getaranPer.png" width="55" height="55">
                        </div>
                     </div>
                  </a>
               </div>
               <div class="text-center">
                  <h6 class="text-back mt-1">Getaran
                     Personal</h6>
               </div>
            </div>
            <div class="col-4">
               <div class="box-item">
                  <a href="./iklimPanas">
                     <div class="itemm">
                        <div class="bg-white itemm2">
                           <img src="<?= base_url; ?>/img/iklim.png" width="55" height="55">
                        </div>
                     </div>
                  </a>
               </div>
               <div class="text-center">
                  <h6 class="text-back mt-1">Iklim
                     Kerja(Panas)</h6>
               </div>
            </div>
            <div class="col-4">
               <div class="box-item">
                  <a href="./iklimDingin">
                     <div class="itemm">
                        <div class="bg-white itemm2">
                           <img src="<?= base_url; ?>/img/iklimDingin.png" width="55" height="55">
                        </div>
                     </div>
                  </a>
               </div>
               <div class="text-center">
                  <h6 class="text-back mt-1">Iklim
                     Kerja(Dingin)</h6>
               </div>
            </div>
         </div>
         <div class="row
                        px-1 mt-1">
            <div class="col-4">
               <div class="box-item">
                  <a href="./partikulat">
                     <div class="itemm">
                        <div class="bg-white itemm2">
                           <img src="<?= base_url; ?>/img/pm.jpg" width="55" height="55">
                        </div>
                     </div>
                  </a>
               </div>
               <div class="text-center">
                  <h6 class="text-back mt-1">Sensoric PM</h6>
               </div>
            </div>
            <div class="col-4">
               <div class="box-item">
                  <a href="./medanLM">
                     <div class="itemm">
                        <div class="bg-white itemm2">
                           <img src="<?= base_url; ?>/img/medanLM.png" width="55" height="55">
                        </div>
                     </div>
                  </a>
               </div>
               <div class="text-center">
                  <h6 class="text-back mt-1">Listrik & Magnet</h6>
               </div>
            </div>
            <div class="col-4">
               <div class="box-item">
                  <a href="./sinarUV">
                     <div class="itemm">
                        <div class="bg-white itemm2">
                           <img src="<?= base_url; ?>/img/sinar uv.png" width="55" height="55">
                        </div>
                     </div>
                  </a>
               </div>
               <div class="text-center">
                  <h6 class="text-back mt-1">Sinar UV</h6>
               </div>
            </div>
         </div>
         <div class="row
                        px-1 mt-1">
            <div class="col-4">
               <div class="box-item">
                  <a href="./direct">
                     <div class="itemm">
                        <div class="bg-white itemm2">
                           <img src="<?= base_url; ?>/img/direct.jpg" width="55" height="55">
                        </div>
                     </div>
                  </a>
               </div>
               <div class="text-center">
                  <h6 class="text-back mt-1">Direct Lainnya</h6>
               </div>
            </div>
            <div class="col-4">
               <div class="box-item">
                  <a href="./kebisinganP">
                     <div class="itemm">
                        <div class="bg-white itemm2">
                           <img src="<?= base_url; ?>/img/kebisinganp.png" width="55" height="55">
                        </div>
                     </div>
                  </a>
               </div>
               <div class="text-center">
                  <h6 class="text-back mt-1">Kebisingan Personal</h6>
               </div>
            </div>
            <div class="col-4">
               <div class="box-item">
                  <a href="./lingkunganHidup">
                     <div class="itemm">
                        <div class="bg-white itemm2">
                           <img src="<?= base_url; ?>/img/Lhidup.png" width="55" height="55">
                        </div>
                     </div>
                  </a>
               </div>
               <div class="text-center">
                  <h6 class="text-back mt-1">Lingkungan Hidup</h6>
               </div>
            </div>
         </div>
         <div class="row
                        px-1 mt-1">
            <div class="col-4">
               <div class="box-item">
                  <a href="./lingkunganKerja">
                     <div class="itemm">
                        <div class="bg-white itemm2">
                           <img src="<?= base_url; ?>/img/Lkerja.jpg" width="55" height="55">
                        </div>
                     </div>
                  </a>
               </div>
               <div class="text-center">
                  <h6 class="text-back mt-1">Lingkungan Kerja</h6>
               </div>
            </div>
            <div class="col-4">
               <div class="box-item">
                  <a href="./swabTest">
                     <div class="itemm">
                        <div class="bg-white itemm2">
                           <img src="<?= base_url; ?>/img/swabtest.jpg" width="55" height="55">
                        </div>
                     </div>
                  </a>
               </div>
               <div class="text-center">
                  <h6 class="text-back mt-1">Swab Test</h6>
               </div>
            </div>
            <div class="col-4">
               <div class="box-item">
                  <a href="./microBio">
                     <div class="itemm">
                        <div class="bg-white itemm2">
                           <img src="<?= base_url; ?>/img/microBio.png" width="55" height="55">
                        </div>
                     </div>
                  </a>
               </div>
               <div class="text-center">
                  <h6 class="text-back mt-1">Microbiologi Udara</h6>
               </div>
            </div>
         </div>
         <div class="row
                        px-1 mt-1">
            <div class="col-4">
               <div class="box-item">
                  <a href="./emisiCerobong">
                     <div class="itemm">
                        <div class="bg-white itemm2" style="overflow: hidden;">
                           <img src="<?= base_url; ?>/img/emisiCer.jpg" width="60" height="60">
                        </div>
                     </div>
                  </a>
               </div>
               <div class="text-center">
                  <h6 class="text-back mt-1">Emisi Cerobong</h6>
               </div>
            </div>
            <div class="col-4">
               <div class="box-item">
                  <a href="./partikulatIsokinetik">
                     <div class="itemm">
                        <div class="bg-white itemm2">
                           <img src="<?= base_url; ?>/img/isokinetik.png" width="55" height="55">
                        </div>
                     </div>
                  </a>
               </div>
               <div class="text-center">
                  <h6 class="text-back mt-1">Partikulat Isokinetik</h6>
               </div>
            </div>
            <div class="col-4">
               <div class="box-item">
                  <a href="./kalkulatorDebit">
                     <div class="itemm">
                        <div class="bg-white itemm2">
                           <img src="<?= base_url; ?>/img/calculator-icon.png" width="55" height="55">
                        </div>
                     </div>
                  </a>
               </div>
               <div class="text-center">
                  <h6 class="text-back mt-1">Kalkulator Debit</h6>
               </div>
            </div>
         </div>
         <!-- * Wallet Footer -->
         <div class="mb-3"></div>
      </div>
   </div>