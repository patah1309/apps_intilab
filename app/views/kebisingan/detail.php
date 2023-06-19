 <!-- * App Sidebar -->
 <div id="appCapsule">
     <!-- <div class="section-title">Data Qr <span id="qr_code"></span></div> -->
     <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="modal-header">
                    <h6 class="modal-title" id="myModalLabel">Detail Data Lapangan</h6>
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
                                        <td class="data">Nama Sampler</td>
                                        <td>:</td>
                                        <td><?= $data['data']->sampler ?></td>
                                    </tr>
                                    <tr class="detail">
                                        <td class="data">No Sample</td>
                                        <td>:</td>
                                        <td><?= $data['data']->no_sample ?></td>
                                    </tr>
                                    <tr class="detail">
                                        <td class="data">No Order</td>
                                        <td>:</td>
                                        <td><?= $data['data']->no_order ?></td>
                                    </tr>
                                    <tr class="detail">
                                        <td class="data">Nama Perusahaan</td>
                                        <td>:</td>
                                        <td><?= $data['data']->corp ?></td>
                                    </tr>
                                    <tr class="detail">
                                        <td class="data">Kategori-3</td>
                                        <td>:</td>
                                        <td><?= $data['data']->categori ?></td>
                                    </tr>
                                    <tr class="detail">
                                        <td class="data">Penamaan Tambahan</td>
                                        <td>:</td>
                                        <td><?= $data['data']->info_tambahan ?></td>
                                    </tr>
                                    <tr class="detail">
                                        <td class="data">Penamaan Titik</td>
                                        <td>:</td>
                                        <td><?= $data['data']->keterangan ?></td>
                                    </tr>
                                    <tr class="detail" id="jam_peng">
                                        <td class="data">Jam Pengambilan</td>
                                        <td>:</td>
                                        <td><?= $data['data']->jam ?></td>
                                    </tr>
                                    <tr class="detail">
                                        <td class="data">Sumber Kebisingan</td>
                                        <td>:</td>
                                        <td><?= $data['data']->sumber_keb ?></td>
                                    </tr>
                                    <tr class="detail">
                                        <td class="data">Frekuensi Kebisingan</td>
                                        <td>:</td>
                                        <td><?= $data['data']->jenis_frek ?></td>
                                    </tr>
                                    <tr class="detail">
                                        <td class="data">Kategori Kebisingan</td>
                                        <td>:</td>
                                        <td><?= $data['data']->jenis_kate ?></td>
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
                                        <td><?= $data['data']->kelem_udara ?> %</td>
                                    </tr>
                                    <tr class="detail">
                                        <td class="data">Koordinat</td>
                                        <td>:</td>
                                        <td><?= $data['data']->tikoor ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="card-body">
                                <div class="row" id="value-kebisingan">
                                <?php
                                    foreach(json_decode($data['data']->val_kebisingan) as $value){
                                ?>
                                    <div class="col-2 border">
                                        <span id="hasil"><?= $value; ?></span>
                                    </div>
                                <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card-body">
                                <div id="foto-s" class="text-center"></div>
                                        <div class="card-body">
                                            <div id="keter-sample"></div>
                                        </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card-body">
                                <div id="foto-ss" class="text-center"></div>
                                        <div class="card-body">
                                            <div id="keter-samplee"></div>
                                        </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card-body">
                                <div id="latlongmap" class="cd-4" style="width:100%; margin:5px 0; z-index:0; box-shadow:0 2px 4px rgba(0,0,0,.25); height: 300px;">
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
            <li style="--i:0.2s;"><a href="<?= base_url;?>/kebisingan/viewDatakebisingan"><i class="fa-solid fa-file-lines"></i></a></li>
            <li style="--i:0.1s;"><a href="<?= base_url;?>/profile"><i class="fa-solid fa-user"></i></a></li>
        </ul>
    </div>
</div>
<script>
var e = '<?= $data['lat'] ?>',
   n = '<?= $data['long'] ?>',
   coor = "<?= $data['coor']?>";

var mymap = L.map("latlongmap"),
   mmr = L.marker([0, 0]);

if (e != null || n != null) {
   setui(coor, e, n),
      mmr.setLatLng(L.latLng(e, n)),
      mymap.setView([e, n], 15);
}

mmr.bindPopup(coor), mmr.addTo(mymap), L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png?{foo}", {
   foo: "bar",
   attribution: '&copy; <a href="https://www.intilab.com">Inti Surya Laboratotium</a>',
}).addTo(mymap), mymap.setZoom(15);

function setui(t, e, n) {
   mmr.setPopupContent(t).openPopup();
}
</script>