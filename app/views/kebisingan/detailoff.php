 <!-- * App Sidebar -->
 <div id="appCapsule">
    <!-- <div class="section-title">Data Qr <span id="qr_code"></span></div> -->
    <div class="row">
       <div class="col-12">
          <div class="card">
             <div class="modal-header">
                <h6 class="modal-title" id="myModalLabel">Detail Data Offline Lapangan</h6>
                <a href="./datakebisingan" class="item">
                   <div class="icon-box bg-danger">
                      <ion-icon name="close-outline"></ion-icon>
                   </div>
                </a>
             </div>
             <div class="card-body">
                <div class="row">
                   <div class="col-sm-3">
                      <div class="card-body">
                         <table>
                            <tr>
                               <th></th>
                               <th></th>
                               <th></th>
                            </tr>
                            <tr class="detail">
                               <td class="data">No Sample</td>
                               <td>:</td>
                               <td><?= $data['data']->no_sample ?></td>
                            </tr>
                            <tr class="detail">
                               <td class="data">Penamaan Tambahan</td>
                               <td>:</td>
                               <td><?= $data['data']->information ?></td>
                            </tr>
                            <tr class="detail">
                               <td class="data">Penamaan Titik</td>
                               <td>:</td>
                               <td><?= $data['data']->keterangan_4 ?></td>
                            </tr>
                            <tr class="detail" id="jam_peng">
                               <td class="data">Jam Pengambilan</td>
                               <td>:</td>
                               <td><?= $data['data']->waktu ?></td>
                            </tr>
                            <tr class="detail">
                               <td class="data">Sumber Kebisingan</td>
                               <td>:</td>
                               <td><?= $data['data']->sumber_keb ?></td>
                            </tr>
                            <tr class="detail">
                               <td class="data">Frekuensi Kebisingan</td>
                               <td>:</td>
                               <td><?= $data['data']->jen_frek ?></td>
                            </tr>
                            <tr class="detail">
                               <td class="data">Kategori Kebisingan</td>
                               <td>:</td>
                               <td><?= $data['data']->jenis_kat ?></td>
                            </tr>
                            <tr class="detail">
                               <td class="data">Shift Pengambilan</td>
                               <td>:</td>
                               <td><?= $data['data']->durasi_sampl ?></td>
                            </tr>
                            <tr class="detail">
                               <td class="data">Durasi Sampling</td>
                               <td>:</td>
                               <td><?= $data['data']->jenis_durasi ?></td>
                            </tr>
                            <tr class="detail">
                               <td class="data">Suhu Udara</td>
                               <td>:</td>
                               <td><?= $data['data']->suhu_udara ?> ℃</td>
                            </tr>
                            <tr class="detail">
                               <td class="data">Kelembaban Udara</td>
                               <td>:</td>
                               <td><?= $data['data']->kelembapan_udara ?> %</td>
                            </tr>
                            <tr class="detail">
                               <td class="data">Koordinat</td>
                               <td>:</td>
                               <td><?= $data['data']->posisi ?></td>
                            </tr>
                         </table>
                      </div>
                   </div>
                   <div class="col-sm-3">
                      <div class="card-body">
                         <div class="row" id="value-kebisingan">
                            <?php
                                    foreach($data['data']->kebisingan as $value){
                                ?>
                            <div class="col-2 border">
                               <span id="hasil"><?= $value; ?></span>
                            </div>
                            <?php } ?>
                         </div>
                      </div>
                   </div>
                </div>
             </div>
          </div>
       </div>
    </div>
 </div>
 <div class="btnBottom">
    <div class="btnTengah" onclick="location.href='kebisingan/add_data'"></a></div>
    <div class="btnMenu">
       <ul>
          <li style="--i:0.1s;"><a href="<?= base_url;?>/home"><i class="fa-solid fa-gauge"></i></a></li>
          <li style="--i:0.2s;"><a href="<?= base_url;?>/kebisingan"><i class="fa-solid fa-house"></i></a></li>
          <li></li>
          <li style="--i:0.2s;"><a href="<?= base_url;?>/kebisingan/viewDatakebisingan"><i
                   class="fa-solid fa-file-lines"></i></a></li>
          <li style="--i:0.1s;"><a href="<?= base_url;?>/profile"><i class="fa-solid fa-user"></i></a></li>
       </ul>
    </div>
 </div>