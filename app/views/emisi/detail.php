 <!-- * App Sidebar -->
 <div id="appCapsule">
    <div id="load-detail"></div>
    <div class="section mt-2">
       <div class="section-title"></div>
       <div id="load-hasil"></div>
    </div>
 </div>
 <div class="btnBottom">
    <div class="btnTengah" onclick="location.href='emisi/add_data'"></a></div>
    <div class="btnMenu">
       <ul>
          <li style="--i:0.1s;"><a href="<?= base_url;?>/home"><i class="fa-solid fa-gauge"></i></a></li>
          <li style="--i:0.2s;"><a href="<?= base_url;?>/emisi"><i class="fa-solid fa-house"></i></a></li>
          <li></li>
          <li style="--i:0.2s;"><a href="<?= base_url;?>/emisi/viewData"><i class="fa-solid fa-file-lines"></i></a></li>
          <li style="--i:0.1s;"><a href="<?= base_url;?>/profile"><i class="fa-solid fa-user"></i></a></li>
       </ul>
    </div>
 </div>

 <script>
$(document).ready(function() {
   if ('<?= $data['qr'] ?>' != '') {
      $.ajax({
         url: '<?= base_url; ?>/emisi/getDataDetail',
         method: 'POST',
         data: {
            qr: '<?= $data['qr'] ?>'
         },
         success: function(a) {
            a = JSON.parse(a)
            $('#load-detail').empty()
            $('#load-hasil').empty()
            if (a.record == 0) {
               $('#load-detail').empty()
               $('#load-hasil').empty()
               $("#load-detail").html(
                  '<div class="alert alert-warning mt-2" role="alert"><ion-icon name="alert-circle-outline" role="img" class="md hydrated" aria-label="alert circle outline"></ion-icon> Data Not Found.!</div>'
               )
            } else {
               var html =
                  '<div class="section wallet-card-section pt-1"><div class="wallet-card"><div class="balance"><div class="left"><span style="font-size:16px">Detail Kendaraan</span></div></div><div class="wallet-footer"><table><tr><th></th><th style="padding-right:20px"></th><th></th></tr><tr><td>Merk Kendaraan</td><td>:</td><td>' +
                  a.detail.merk_kendaraan + '</td></tr><tr><td>Transmisi</td><td>:</td><td>' + a
                  .detail.transmisi + '</td></tr><tr><td>Tahun Pembuatan</td><td>:</td><td>' + a
                  .detail.tahun_pembuatan + '</td></tr><tr><td>Nomor Plat</td><td>:</td><td>' + a
                  .detail.no_polisi + '</td></tr><tr><td>Nomor Mesin</td><td>:</td><td>' + a.detail
                  .no_mesin + '</td></tr><tr><td>Bahan Bakar</td><td>:</td><td>' + a.detail
                  .bahan_bakar + '</td></tr><tr><td>Kapasitas CC</td><td>:</td><td>' + a.detail
                  .kapasitas_cc + '</td></tr></table></div></div></div>'
               $('#load-detail').html(html)
               for (i = 0; i < a.hasil.length; i++) {
                  var hasil =
                     '<div class="card mb-2"><div class="card-body table-responsive"><div class="loaddata"><table class="table table-bordered"><thead><tr><th>Tgl Uji</th><th colspan="2">' +
                     a.hasil[i].tgl_uji +
                     '</th></tr><tr><th>Parameter</th><th>Hasil</th><th>Status</th></tr></thead><tbody id="dt-' +
                     i + '"></tbody></table></div></div></div>'
                  $('#load-hasil').append(hasil)

                  for (b = 0; b < a.hasil[i].parameters.length; b++) {
                     var nilai = '<tr><td>' + a.hasil[i].parameters[b].parameter + '</td><td>' + a
                        .hasil[i].parameters[b].hasil + '</td><td>' + a.hasil[i].parameters[b]
                        .status + '</td></tr>'

                     $('#dt-' + i + '').append(nilai)
                  }
               }
            }
         }
      })
   } else $("#load-detail").html(
      '<div class="alert alert-warning mt-2" role="alert" style="color: #856404;background-color: #fff3cd;border-color: #ffeeba;"><i class="fa-solid fa-triangle-exclamation fa-beat"></i> Data Not Found.!</div>'
   )
})
 </script>