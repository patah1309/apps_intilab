 <!-- * App Sidebar -->
 <!-- <style>
    dl, ol, ul {
        margin-top: 11px !important;
        margin-bottom: 1rem;
    }
 </style> -->
 <div id="appCapsule">
    <div class="section mb-5 p-2">
       <form id="form-add">
          <div class="card">
             <div class="card-body pb-1">
                <div class="form-group basic">
                   <div class="input-wrapper">
                      <label class="label">Kode Qr</label>
                      <input type="text" class="form-control" id="kode_qr" name="kode_qr" placeholder="Masukan kode Qr"
                         required value="<?= $data['qr'] ?>">
                      <i class="clear-input">
                         <ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle">
                         </ion-icon>
                      </i>
                   </div>
                </div>
                <div class="form-group basic">
                   <div class="input-wrapper">
                      <label class="label">No Sample</label>
                      <input type="text" class="form-control" id="no_sample" name="no_sample"
                         placeholder="Masukan No Sample" required>
                      <i class="clear-input">
                         <ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle">
                         </ion-icon>
                      </i>
                   </div>
                </div>
                <div class="form-group basic">
                   <div class="input-wrapper">
                      <label class="label">Nama Pelanggan</label>
                      <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukan Nama Pelanggan"
                         required="">
                      <i class="clear-input">
                         <ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle">
                         </ion-icon>
                      </i>
                   </div>
                </div>
                <div class="form-group basic">
                   <div class="input-wrapper">
                      <label class="label">Alamat Lokasi Pengujian</label>
                      <input type="text" class="form-control" id="lokasi_pengujian" name="lokasi_pengujian"
                         placeholder="Alamat Lokasi Pengujian" required>
                      <i class="clear-input">
                         <ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle">
                         </ion-icon>
                      </i>
                   </div>
                </div>
                <div class="form-group basic">
                   <div class="input-wrapper">
                      <label class="label" for="select4">Jenis Bahan Bakar Kendaraan</label>
                      <select class="form-control" id="jenis_kendaraan" name="jenis_kendaraan" value>
                         <option value="">Pilih Bahan Bakar</option>
                         <option value="31" <?=$data['bbm'] == 31 ? ' selected="selected"' : '';?>>Bensin</option>
                         <option value="32" <?=$data['bbm'] == 32 ? ' selected="selected"' : '';?>>Solar</option>
                      </select>
                      <i class="clear-input">
                         <ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle">
                         </ion-icon>
                      </i>
                   </div>
                </div>
                <div id="load"></div>
                <div class="form-group basic">
                   <div class="input-wrapper mb-3">
                      <label class="label" for="select4">Pilih Regulasi</label>
                      <select class="form-control" id="regulasi" name="regulasi" required></select>
                      <i class="clear-input">
                         <ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle">
                         </ion-icon>
                      </i>
                   </div>
                </div>
                <div class="form-group basic">
                   <div class="input-wrapper">
                      <label class="label">Catatan Konsisi Sampling</label>
                      <input type="text" class="form-control" id="catatan" name="catatan" placeholder="Catatan">
                      <i class="clear-input">
                         <ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle">
                         </ion-icon>
                      </i>
                   </div>
                </div>
             </div>
             <div class="card-footer">
                <div class="row mb-2">
                   <div class="col-6">
                      <div class="form-group basic">
                         <button class="btn btn-primary" type="reset" style="width:100%"> Cancel </button>
                      </div>
                   </div>
                   <div class="col-6">
                      <div class="form-group basic">
                         <button class="btn btn-success" type="submit" id="btn-submit" style="width:100%"> Save</button>
                      </div>
                   </div>
                </div>
             </div>
          </div>
       </form>
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
$('#jenis_kendaraan').on('change', function() {
   var nilai = $("#jenis_kendaraan").val();
   31 == nilai ? ($("#load").html(bensin), $("#tahun").datepicker({
      format: "yyyy",
      viewMode: "years",
      minViewMode: "years",
      autoclose: !0
   })) : 32 == nilai ? ($("#load").html(solar), $("#tahun").datepicker({
      format: "yyyy",
      viewMode: "years",
      minViewMode: "years",
      autoclose: !0
   })) : $("#load").empty();
})

$(document).ready(function() {
   var nilai = '<?= $data['bbm']; ?>';
   31 == nilai ? ($("#load").html(bensin), $("#tahun").datepicker({
      format: "yyyy",
      viewMode: "years",
      minViewMode: "years",
      autoclose: !0
   })) : 32 == nilai ? ($("#load").html(solar), $("#tahun").datepicker({
      format: "yyyy",
      viewMode: "years",
      minViewMode: "years",
      autoclose: !0
   })) : $("#load").empty();

   $.ajax({
      url: '<?= base_url; ?>/emisi/getregulasi',
      success: function(e) {
         e = JSON.parse(e)
         console.log(e)
         $('#regulasi').select2({
            data: e,
            placeholder: '--Pilih Regulasi--'
         })
      }
   })

   if ('<?= $data['qr'] ?>' == '') {
      Swal.fire({
         icon: "info",
         title: 'Input Kode Qr secara manual',
         timer: 3000
      })
   }
})

var timeout = null
$('#no_sample').on('keyup', function() {

   clearTimeout(timeout)
   timeout = setTimeout(function() {
      var no_sample = document.getElementById('no_sample').value;
      $.ajax({
         url: 'scann',
         type: "post",
         data: {
            no_sample: no_sample,
            qr: null
         },
         success: function(e) {
            e = JSON.parse(e)
            if (e.message != 'No Data') {
               $('#nama').val(e.client);
            }
         }
      })
   }, 3000)
})

var getEmisi = function(no_sample = null) {
   var deferred = $.Deferred()
   $.ajax({
      url: 'scann',
      type: "post",
      data: {
         no_sample: no_sample,
         qr: null
      },
      success: function(ff) {
         deferred.resolve(ff)
      },
      error: function(err) {
         deferred.reject(err)
      }
   })
   return deferred.promise()
}

$('#form-add').on('submit', function(e) {
   e.preventDefault()
   let data_form = $(this).serialize();
   $('#btn-submit').prop('disabled', true);
   if ($('#no_sample').val() == '' || $('#nama').val() == '') {
      Swal.fire({
         icon: 'error',
         title: 'No Sample dan Nama PT harus diisi.!!!'
      })
   } else {
      var no_sample = document.getElementById('no_sample').value;
      $.when(getEmisi(no_sample)).then(function(ff) {
         ff = JSON.parse(ff)
         if (ff.message != 'No Data') {
            if (ff.kategori_3 != $('#jenis_kendaraan').val()) {
               Swal.fire({
                  icon: 'error',
                  title: 'Jenis bahan bakar tidak sama, pastikan no sample berbahan bakar sama dengan nomor Qr Code.!!!'
               })
            } else {
               $.ajax({
                  statusCode: {
                     500: function() {
                        Swal.fire({
                           icon: 'error',
                           title: 'Server Error',
                           timer: 3000
                        })
                        $('#btn-submit').prop('disabled', false);
                     }
                  },
                  url: 'saveData',
                  method: 'POST',
                  data: data_form,
                  success: function(resp) {
                     resp = JSON.parse(resp)
                     if (resp == 'success') {
                        Swal.fire({
                           icon: 'success',
                           title: 'Success',
                           text: 'Data hasbeen Save',
                           timer: 3000
                        })
                        document.getElementById("form-add").reset();
                        $('#btn-submit').prop('disabled', false);
                        $('#load').empty();
                     } else {
                        Swal.fire({
                           icon: 'error',
                           title: 'Opps..!',
                           text: 'Please Check the Data.',
                           timer: 3000
                        })
                        $('#btn-submit').prop('disabled', false);
                     }
                  },
                  error: function(err) {
                     Swal.fire({
                        icon: 'error',
                        title: err.responseJSON,
                        timer: 3000
                     })
                     $('#btn-submit').prop('disabled', false);
                  }
               })
            }
         } else {
            $.ajax({
               statusCode: {
                  500: function() {
                     Swal.fire({
                        icon: 'error',
                        title: 'Server Error',
                        timer: 3000
                     })
                     $('#btn-submit').prop('disabled', false);
                  }
               },
               url: 'saveData',
               method: 'POST',
               data: data_form,
               success: function(resp) {
                  resp = JSON.parse(resp)
                  if (resp == 'success') {
                     Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Data hasbeen Save',
                        timer: 3000
                     })
                     document.getElementById("form-add").reset();
                     $('#btn-submit').prop('disabled', false);
                     $('#load').empty();
                  } else {
                     Swal.fire({
                        icon: 'error',
                        title: 'Opps..!',
                        text: 'Please Check the Data.',
                        timer: 3000
                     })
                     $('#btn-submit').prop('disabled', false);
                  }
               },
               error: function(err) {
                  Swal.fire({
                     icon: 'error',
                     title: err.responseJSON,
                     timer: 3000
                  })
                  $('#btn-submit').prop('disabled', false);
               }
            })
         }
      })
   }
})

var bensin =
   '<div class="form-group basic"><div class="input-wrapper"><label class="label">No Polisi</label><input type="text" class="form-control tgl" id="no_plat" name="no_plat" placeholder="Masukkan No Polisi" required value="<?= $data['plat'] ?>"><i class="clear-input"><ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon></i></div></div><div class="form-group basic"><div class="input-wrapper"><label class="label">Nomor Mesin</label><input type="text" class="form-control tgl" id="no_mesin" name="no_mesin" placeholder="Masukkan No Mesin" required value="<?= $data['no_mesin'] ?>"><i class="clear-input"><ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon></i></div></div><div class="form-group basic"><div class="input-wrapper"><label class="label">Merk Kendaraan</label><input type="text" class="form-control tgl" id="merk" name="merk" placeholder="Masukkan Merk" required value="<?= $data['merk'] ?>"><i class="clear-input"><ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon></i></div></div><div class="form-group basic"><div class="input-wrapper"><label class="label" for="select4">Transmision</label><select class="form-control" id="transmisi" name="transmisi"><option value="">Pilih Transmisi</option><option value="Automatic" <?=$data['transmisi'] == 'Automatic' ? ' selected="selected"' : '';?>>Automatic</option><option value="Manual" <?=$data['transmisi'] == 'Manual' ? ' selected="selected"' : '';?>>Manual</option></select><i class="clear-input"><ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon></i></div></div><div class="form-group basic"><div class="input-wrapper"><label class="label">Tahun Pembuatan</label><input type="text" class="form-control tgl" id="tahun" name="tahun" placeholder="Masukkan Tahun Pembuatan" required readonly="readonly" value="<?= $data['tahun'] ?>"><i class="clear-input"><ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon></i></div></div><div class="form-group basic"><div class="input-wrapper"><label class="label" for="select4">Kategori Kendaraan</label><select class="form-control" id="kategori_kendaraan" name="kategori_kendaraan"><option value="Angkutan Orang" <?=$data['kategori'] == 'Angkutan Orang' ? ' selected="selected"' : '';?>>M: Angkutan Orang</option><option value="Angkutan Barang" <?=$data['kategori'] == 'Angkutan Barang' ? ' selected="selected"' : '';?>>N: Angkutan Barang</option><option value="Angkutan Untuk Gandeng / Tempel" <?=$data['kategori'] == 'Angkutan Untuk Gandeng / Tempel' ? ' selected="selected"' : '';?>>O: Angkutan Untuk Gandeng / Tempel</option><option value="Kendaraan Beroda Kurang Dari Empat">L: Kendaraan Beroda Kurang Dari Empat</option></select><i class="clear-input"><ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon></i></div></div><div class="form-group basic"><div class="input-wrapper"><label class="label">KM Kendaraan</label><input type="number" class="form-control" id="km" name="km" placeholder="Masukkan Km Kendaraan" step="any" required value="<?= $data['km'] ?>"><i class="clear-input"><ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon></i></div></div><div class="form-group basic"><div class="input-wrapper"><label class="label">Kapasitas CC</label><input type="number" class="form-control" id="cc" name="cc" placeholder="Masukkan CC Kendaraan" step="any" required value="<?= $data['cc'] ?>"><i class="clear-input"><ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon></i></div></div><div class="form-group basic"><div class="input-wrapper"><label class="label">Bobot Kendaraan (Ton)</label><input type="number" class="form-control" id="bobot_kendaraan" name="bobot_kendaraan" placeholder="Masukkan Bobot Kendaraan" required="" step="any" value="<?= $data['bobot'] ?>"><i class="clear-input"><ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon></i></div></div><div class="row mb-2"><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label">CO2 (%)</label><input type="number" class="form-control mb-2" id="co2-0" name="co2[]" placeholder="CO2 dalam %" autocomplete="off" step="any"><i class="clear-input"><ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon></i><input type="number" class="form-control mb-2" id="co2-1" name="co2[]" placeholder="CO2 dalam %" autocomplete="off" step="any"><i class="clear-input"><ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon></i><input type="number" class="form-control mb-2" id="co2-2" name="co2[]" placeholder="CO2 dalam %" autocomplete="off" step="any"><i class="clear-input"><ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon></i></div></div></div><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label">CO (%)</label><input type="number" class="form-control mb-2" id="co-0" name="co[]" placeholder="CO dalam %" autocomplete="off" step="any"><i class="clear-input"><ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon></i><input type="number" class="form-control mb-2" id="co-1" name="co[]" placeholder="CO dalam %" autocomplete="off" step="any"><i class="clear-input"><ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon></i><input type="number" class="form-control mb-2" id="co-2" name="co[]" placeholder="CO dalam %" autocomplete="off" step="any"><i class="clear-input"><ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon></i></div></div></div></div><div class="row mb-2"><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label">HC (%)</label><input type="number" class="form-control mb-2" id="hc-0" name="hc[]" placeholder="HC dalam %" autocomplete="off" step="any"><i class="clear-input"><ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon></i><input type="number" class="form-control mb-2" id="hc-1" name="hc[]" placeholder="HC dalam %" autocomplete="off" step="any"><i class="clear-input"><ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon></i><input type="number" class="form-control mb-2" id="hc-2" name="hc[]" placeholder="HC dalam %" autocomplete="off" step="any"><i class="clear-input"><ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon></i></div></div></div><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label">O2 (%)</label><input type="number" class="form-control mb-2" id="o2-0" name="o2[]" placeholder="O2 dalam %" autocomplete="off" step="any"><i class="clear-input"><ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon></i><input type="number" class="form-control mb-2" id="o2-1" name="o2[]" placeholder="O2 dalam %" autocomplete="off" step="any"><i class="clear-input"><ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon></i><input type="number" class="form-control mb-2" id="o2-2" name="o2[]" placeholder="O2 dalam %" autocomplete="off" step="any"><i class="clear-input"><ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon></i></div></div></div></div><div class="form-group basic"><div class="input-wrapper"><label class="label">Lambda (λ)</label><input type="number" class="form-control" id="lamda" name="lamda" placeholder="Masukkan Nilai Lamda" step="any"><i class="clear-input"><ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon></i></div></div>'
var solar =
   '<div class="form-group basic"><div class="input-wrapper"><label class="label">No Polisi</label><input type="text" class="form-control tgl" id="no_plat" name="no_plat" placeholder="Masukkan No Polisi" value="<?= $data['plat'] ?>"><i class="clear-input"><ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon></i></div></div><div class="form-group basic"><div class="input-wrapper"><label class="label">Nomor Mesin</label><input type="text" class="form-control tgl" id="no_mesin" name="no_mesin" placeholder="Masukkan No Mesin" value="<?= $data['no_mesin'] ?>"><i class="clear-input"><ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon></i></div></div><div class="form-group basic"><div class="input-wrapper"><label class="label">Merk Kendaraan</label><input type="text" class="form-control tgl" id="merk" name="merk" placeholder="Masukkan Merk" required value="<?= $data['merk'] ?>"><i class="clear-input"><ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon></i></div></div><div class="form-group basic"><div class="input-wrapper"><label class="label" for="select4">Transmision</label><select class="form-control" id="transmisi" name="transmisi"><option value="">Pilih Transmisi</option><option value="Automatic" <?=$data['transmisi'] == 'Automatic' ? ' selected="selected"' : '';?>>Automatic</option><option value="Manual" <?=$data['transmisi'] == 'Manual' ? ' selected="selected"' : '';?>>Manual</option></select><i class="clear-input"><ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon></i></div></div><div class="form-group basic"><div class="input-wrapper"><label class="label">Tahun Pembuatan</label><input type="text" class="form-control tgl" id="tahun" name="tahun" placeholder="Masukkan Tahun Pembuatan" required readonly="readonly" value="<?= $data['tahun'] ?>"><i class="clear-input"><ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon></i></div></div><div class="form-group basic"><div class="input-wrapper"><label class="label" for="select4">Kategori Kendaraan</label><select class="form-control" id="kategori_kendaraan" name="kategori_kendaraan"><option value="Angkutan Orang" <?=$data['kategori'] == 'Angkutan Orang' ? ' selected="selected"' : '';?>>M: Angkutan Orang</option><option value="Angkutan Barang" <?=$data['kategori'] == 'Angkutan Barang' ? ' selected="selected"' : '';?>>N: Angkutan Barang</option><option value="Angkutan Untuk Gandeng / Tempel" <?=$data['kategori'] == 'Angkutan Untuk Gandeng / Tempel' ? ' selected="selected"' : '';?>>O: Angkutan Untuk Gandeng / Tempel</option></select><i class="clear-input"><ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon></i></div></div><div class="form-group basic"><div class="input-wrapper"><label class="label">KM Kendaraan</label><input type="number" class="form-control" id="km" name="km" placeholder="Masukkan Km Kendaraan" step="any" required value="<?= $data['km'] ?>"><i class="clear-input"><ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon></i></div></div><div class="form-group basic"><div class="input-wrapper"><label class="label">Kapasitas CC</label><input type="number" class="form-control" id="cc" name="cc" placeholder="Masukkan CC Kendaraan" step="any" required value="<?= $data['cc'] ?>"><i class="clear-input"><ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon></i></div></div><div class="form-group basic"><div class="input-wrapper"><label class="label">Bobot Kendaraan (Ton)</label><input type="number" class="form-control" id="bobot_kendaraan" name="bobot_kendaraan" placeholder="Masukkan Bobot Kendaraan" required="" step="any" value="<?= $data['bobot'] ?>"><i class="clear-input"><ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon></i></div></div><div class="row mb-2"><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label">Opasitas (%HSU)</label><input type="number" class="form-control mb-2" id="opasitas-0" name="opasitas[]" placeholder=" Nilai Opasitas" autocomplete="off" step="any"><i class="clear-input"><ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon></i><input type="number" class="form-control mb-2" id="opasitas-1" name="opasitas[]" placeholder=" Nilai Opasitas" autocomplete="off" step="any"><i class="clear-input"><ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon></i><input type="number" class="form-control mb-2" id="opasitas-2" name="opasitas[]" placeholder=" Nilai Opasitas" autocomplete="off" step="any"><i class="clear-input"><ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon></i></div></div></div><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label">Nilai K(m-1)</label><input type="number" class="form-control mb-2" id="nilai_k-0" name="nilai_k[]" placeholder="Maukan Nilai" autocomplete="off" step="any"><i class="clear-input"><ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon></i><input type="number" class="form-control mb-2" id="nilai_k-1" name="nilai_k[]" placeholder="Maukan Nilai" autocomplete="off" step="any"><i class="clear-input"><ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon></i><input type="number" class="form-control mb-2" id="nilai_k-2" name="nilai_k[]" placeholder="Maukan Nilai" autocomplete="off" step="any"><i class="clear-input"><ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon></i></div></div></div></div><div class="row mb-2"><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label">Putaran Mesin (RPM)</label><input type="number" class="form-control mb-2" id="rpm-0" name="rpm[]" placeholder=" Nilai Rpm" autocomplete="off" step="any"><i class="clear-input"><ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon></i><input type="number" class="form-control mb-2" id="rpm-1" name="rpm[]" placeholder=" Nilai Rpm" autocomplete="off" step="any"><i class="clear-input"><ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon></i><input type="number" class="form-control mb-2" id="rpm-2" name="rpm[]" placeholder=" Nilai Rpm" autocomplete="off" step="any"><i class="clear-input"><ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon></i></div></div></div><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label">Temperature Oli</label><input type="number" class="form-control mb-2" id="oli-0" name="oli[]" placeholder="Maukan Suhu Oli" autocomplete="off" step="any"><i class="clear-input"><ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon></i><input type="number" class="form-control mb-2" id="oli-1" name="oli[]" placeholder="Maukan Suhu Oli" autocomplete="off" step="any"><i class="clear-input"><ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon></i><input type="number" class="form-control mb-2" id="oli-2" name="oli[]" placeholder="Maukan Suhu Oli" autocomplete="off" step="any"><i class="clear-input"><ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon></i></div></div></div></div>'
 </script>