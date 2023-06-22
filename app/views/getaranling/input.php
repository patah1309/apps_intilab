   <div id="appCapsule">
      <div class="section mb-5 p-2">
         <form id="form-add">
            <div class="card">
               <div class="card-body pb-1">
                  <div class="row">
                     <div class="col-12 text-center">
                        <label for="">FDL Getaran Lingkungan</label>
                     </div>
                  </div>
                  <div class="form-group basic">
                     <div class="input-wrapper">
                        <label class="label">No Sample</label>
                        <input type="text" class="form-control" id="no_sample" name="no_sample"
                           placeholder="Masukan No Sample" required>
                        <input type="hidden" id="id_kat" name="id_kat">
                        <i class="clear-input">
                           <ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle">
                           </ion-icon>
                        </i>
                     </div>
                  </div>

                  <div id="udara"></div>
                  <div class="row mb-2">
                     <div class="col-6">
                        <div class="form-group basic">
                           <button class="btn btn-primary" type="reset" onclick="ress()" style="width:100%"> Cancel
                           </button>
                        </div>
                     </div>
                     <div class="col-6">
                        <div class="form-group basic">
                           <!-- <button class="btn btn-success" type="button" style="width:100%" onclick="valid()"> Save</button> -->
                           <button class="btn btn-success" type="submit" style="width:100%" id="btn-submit"> Save
                           </button>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </form>
      </div>
   </div>
   <div class="btnBottom">
      <div class="btnTengah" onclick="location.href='<?= base_url;?>/getaranling/add_data'"></a></div>
      <div class="btnMenu">
         <ul>
            <li style="--i:0.1s;"><a href="<?= base_url;?>/home"><i class="fa-solid fa-gauge"></i></a></li>
            <li style="--i:0.2s;"><a href="<?= base_url;?>/getaranling"><i class="fa-solid fa-house"></i></a></li>
            <li></li>
            <li style="--i:0.2s;"><a href="<?= base_url;?>/getaranling/data"><i class="fa-solid fa-file-lines"></i></a>
            </li>
            <li style="--i:0.1s;"><a href="<?= base_url;?>/profile"><i class="fa-solid fa-user"></i></a></li>
         </ul>
      </div>
   </div>

   <script>
let uri = '<?= base_url; ?>/assets/sound/';
var success = new Audio(uri + 'success.wav');
var error = new Audio(uri + 'error.mp3');

function ress() {
   Swal.fire({
      icon: 'info',
      title: 'Apakah ingin meng-cancel data.?',
      showCancelButton: true,
      confirmButtonText: 'Yes',
   }).then((result) => {
      if (result.isConfirmed) {
         $('#udara').empty();
         $('#no_sample').val('');
      }
   });
}

$("#no_sample").on('keydown', function(e) {
   $('#udara').html('')
   $('#isiCahaya').html('')
   if (e.key === "Enter") {
      let net = $('#status-text').text();
      if (net == "Online") {
         var no_sample = $("#no_sample").val();
         $.ajax({
            url: '/public/getaranling/getSampel',
            method: 'POST',
            data: {
               no_sample: no_sample
            },
            success: function(resp) {
               e = JSON.parse(resp);
               if (e.id_ket == '13' || e.id_ket == '15' || e.id_ket == '16' || e.id_ket == '18' || e
                  .id_ket == '14' || e.id_ket == '19') {

                  $('#udara').html(getaranLingkungan).fadeIn('slow');
                  $('#keterangan-4').val(e.keterangan);
                  $('#id_kat').val(e.id_ket);
                  getling();
                  input_getLing();
                  $('#btnBawah').hide()
                  $('#time').clockTimePicker();
               } else {
                  error.play();
                  Swal.fire({
                     title: 'Tidak ada kategori FDL getaran lingkungan di No Sample tersebut',
                     icon: 'warning',
                     confirmButtonColor: '#3085d6',
                  })
               }
            },
            error: function(e) {
               Swal.fire({
                  icon: 'error',
                  title: e.responseJSON.message,
               })
            }
         })
      } else {
         Swal.fire({
            icon: 'info',
            title: 'Anda Sedang Offline',
            timer: 3000
         })
      }
      return false;
   }
});

function getling() {

   $("#jarak").on('keyup', function() {
      var ul1 = $("#jarak").val();
      if (ul1 !== ".") {
         $('#valjarak').show();
         $('#cekjarak').hide();
      }
      if (ul1.includes('.')) {
         ul1 = $("#jarak").val();
         var nil2 = ul1.toString().split(".")[1].length;
         if (nil2 == 1) {
            $('#valjarak').hide();
            $('#cekjarak').show();
         }
         if (nil2 > 1) {
            $('#valjarak').show();
            $('#cekjarak').hide();
         }
      }
   })
}

function input_getLing() {
   $("#pengukuran").empty();
   for (i = 1; i <= 3; i++) {
      var boddi = '<div class="peng-getLing-' + i + '" style="display: none;">'
      boddi += '<div class="row">'
      boddi += '<div class="col-6 mb-2">'
      boddi += '<div class="form-group basic">'
      boddi += '<div class="input-wrapper">'
      boddi += '<label class="label label-1" for="modalInputusername">Percepatan (PEAK) Max</label>'
      boddi += '<input id="maxPer-' + i + '" type="number" class="' + i +
         ' form-control" name="max_per[]" autocomplete="off" step="0.0001" required>'
      boddi += '<span class="text-danger text-bold" id="valid2-' + i +
         '" style="font-size: 10px; display: none;">(Ex. 0.0005)</span>'
      boddi += '<span class="text-success" id="ceklis2-' + i +
         '" style="font-size: 10px; display: none;">Desimal sesuai</span>'
      boddi += '</div>'
      boddi += '</div>'
      boddi += '</div>'
      boddi += '<div class="col-6 mb-2">'
      boddi += '<div class="form-group basic">'
      boddi += '<div class="input-wrapper">'
      boddi += '<label class="label label-1" for="modalInputusername">Percepatan (PEAK) Min</label>'
      boddi += '<input id="minPer-' + i + '" type="number" class="' + i +
         ' form-control" name="min_per[]" autocomplete="off" step="0.0001" required>'
      boddi += '<span class="text-danger text-bold" id="valid1-' + i +
         '" style="font-size: 10px; display: none;">(Ex. 0.0005)</span>'
      boddi += '<span class="text-success" id="ceklis1-' + i +
         '" style="font-size: 10px; display: none;">Desimal sesuai</span>'
      boddi += '</div>'
      boddi += '</div>'
      boddi += '</div>'
      boddi += '</div>'
      boddi += '<div class="mb-1 row">'
      boddi += '<div class="col-6 mb-2">'
      boddi += '<div class="form-group basic">'
      boddi += '<div class="input-wrapper">'
      boddi += '<label class="label label-1" for="modalInputusername">Kecepatan (PEAK) Max</label>'
      boddi += '<input id="maxKec-' + i + '" type="number" class="' + i +
         ' form-control" name="max_kec[]" autocomplete="off" step="0.0001" required>'
      boddi += '<span class="text-danger text-bold" id="valid4-' + i +
         '" style="font-size: 10px; display: none;">(Ex. 0.0005)</span>'
      boddi += '<span class="text-success" id="ceklis4-' + i +
         '" style="font-size: 10px; display: none;">Desimal sesuai</span>'
      boddi += '</div>'
      boddi += '</div>'
      boddi += '</div>'
      boddi += '<div class="col-6 mb-2">'
      boddi += '<div class="form-group basic">'
      boddi += '<div class="input-wrapper">'
      boddi += '<label class="label label-1" for="modalInputusername">Kecepatan (PEAK) Min</label>'
      boddi += '<input id="minKec-' + i + '" type="number" class="' + i +
         ' form-control" name="min_kec[]" autocomplete="off" step="0.0001" required>'
      boddi += '<span class="text-danger text-bold" id="valid3-' + i +
         '" style="font-size: 10px; display: none;">(Ex. 0.0005)</span>'
      boddi += '<span class="text-success" id="ceklis3-' + i +
         '" style="font-size: 10px; display: none;">Desimal sesuai</span>'
      boddi += '</div>'
      boddi += '</div>'
      boddi += '</div>'
      boddi += '</div>'
      boddi += '</div>'
      $('#pengukuran').append(boddi);
      $('.peng-getLing-1').show();

      $("#btnAksi").empty();
      var btn =
         '<div class="mb-2 mt-2"><div class="row justify-content-center"><div class="col-6"><div class="form-group basic"><button type="button" class="btn btn-success w-100" id="prev">&laquo; Sebelumnya</button></div></div><div class="col-6"><div class="form-group basic"><button type="button" class="btn btn-success w-100" id="next">Selanjutnya &raquo;</button></div></div></div></div>'
      $('#btnAksi').append(btn);

      $('#minPer-' + i + '').on('keyup', function() {
         var i = this.classList[0]
         var ul1 = $("#minPer-" + i + "").val();
         var ul2 = $("#maxPer-" + i + "").val();
         if (ul1 > ul2) {
            Swal.fire({
               icon: 'info',
               title: 'Nilai percepatan Min tidak boleh melebihi nilai percepatan Max..',
               timer: 3000
            });
         }
         if (ul1 !== ".") {
            $('#valid1-' + i + '').show();
            $('#ceklis1-' + i + '').hide();
         }
         if (ul1.includes('.')) {
            ul1 = $("#minPer-" + i + "").val();
            var nil2 = ul1.toString().split(".")[1].length;
            if (nil2 > 3) {
               $('#valid1-' + i + '').hide();
               $('#ceklis1-' + i + '').show();
            }
            if (nil2 > 4) {
               $('#valid1-' + i + '').show();
               $('#ceklis1-' + i + '').hide();
            }
         }
      })

      $('#maxPer-' + i + '').on('keyup', function() {
         var i = this.classList[0]
         var ul1 = $("#maxPer-" + i + "").val();

         if (ul1 !== ".") {
            $('#valid2-' + i + '').show();
            $('#ceklis2-' + i + '').hide();
         }
         if (ul1.includes('.')) {
            ul1 = $("#maxPer-" + i + "").val();
            var nil2 = ul1.toString().split(".")[1].length;
            if (nil2 > 3) {
               $('#valid2-' + i + '').hide();
               $('#ceklis2-' + i + '').show();
            }
            if (nil2 > 4) {
               $('#valid2-' + i + '').show();
               $('#ceklis2-' + i + '').hide();
            }
         }
      })

      $('#minKec-' + i + '').on('keyup', function() {
         var i = this.classList[0]
         var ul1 = $("#minKec-" + i + "").val();
         var ul2 = $("#maxKec-" + i + "").val();
         if (ul1 > ul2) {
            Swal.fire({
               icon: 'info',
               title: 'Nilai kecepatan Min tidak boleh melebihi nilai kecepatan Max..',
               timer: 3000
            });
         }
         if (ul1 !== ".") {
            $('#valid3-' + i + '').show();
            $('#ceklis3-' + i + '').hide();
         }
         if (ul1.includes('.')) {
            ul1 = $("#minKec-" + i + "").val();
            var nil2 = ul1.toString().split(".")[1].length;
            if (nil2 > 3) {
               $('#valid3-' + i + '').hide();
               $('#ceklis3-' + i + '').show();
            }
            if (nil2 > 4) {
               $('#valid3-' + i + '').show();
               $('#ceklis3-' + i + '').hide();
            }
         }
      })

      $('#maxKec-' + i + '').on('keyup', function() {
         var i = this.classList[0]
         var ul1 = $("#maxKec-" + i + "").val();

         if (ul1 !== ".") {
            $('#valid4-' + i + '').show();
            $('#ceklis4-' + i + '').hide();
         }
         if (ul1.includes('.')) {
            ul1 = $("#maxKec-" + i + "").val();
            var nil2 = ul1.toString().split(".")[1].length;
            if (nil2 > 3) {
               $('#valid4-' + i + '').hide();
               $('#ceklis4-' + i + '').show();
            }
            if (nil2 > 4) {
               $('#valid4-' + i + '').show();
               $('#ceklis4-' + i + '').hide();
            }
         }
      })

   }

   let vi = 1,
      fi = 0,
      wi = 0,
      fe = 0,
      we = 0;
   $('#next').prop("disabled", false)
   $('#prev').prop("disabled", true)
   $('#peng_k').html(vi);

   $('#next').click(function() {
      fi = ++vi
      wi = vi - 1;
      $('#peng_k').html(vi);
      $('#prev').prop("disabled", false)
      if (fi == 3) {
         $('#next').prop("disabled", true)
      }
      // console.log(vi)
      $('.peng-getLing-' + fi).show();
      $('.peng-getLing-' + wi).hide();

   });
   $('#prev').click(function() {
      fe = vi--
      we = vi
      $('#peng_k').html(we);
      if (fe == 2) {
         $('#prev').prop("disabled", true)
      }
      $('.peng-getLing-' + fe).hide();
      $('.peng-getLing-' + we).show();
      $('#next').prop("disabled", false)
   });
}

function getlocation() {
   navigator.geolocation ? (geoloc = navigator.geolocation, watchID = geoloc.getCurrentPosition(showPosition)) : Swal
      .fire({
         icon: "error",
         title: "Geolocation is not supported by this browser."
      })
}

function showPosition(position) {

   var t = position.coords.latitude;
   var e = position.coords.longitude;
   $('#lat').val(t);
   $('#longi').val(e);
   getdms(t, e)
   var lat = getdms(t, !0);
   var long = getdms(e, !1);
   $('#posisi').val(lat + ' ' + long)
   navigator.geolocation.clearWatch(watchID);
   watchID = false;
}

function getdms(t, e) {
   var n = 0,
      a = 0,
      m = 0,
      l = "X";
   return l = e && 0 > t ? "S" : !e && 0 > t ? "W" : e ? "N" : "E", d = Math.abs(t), n = Math.floor(d), m = 3600 * (
         d - n),
      a = Math.floor(m / 60),
      m = Math.round(1e4 * (m - 60 * a)) / 1e4, l + "" + n + "°" + a + "'" + m
}

$('#form-add').on('submit', function(e) {
   e.preventDefault()
   let data_form = $(this).serialize();
   // $('#btn-submit').prop('disabled', true);
   if ($("input[name=permis]").is(':checked')) {
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
         url: '/public/getaranling/saveData',
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
               document.getElementById("lokasi").style.setProperty("background-color", "#00B4FF",
                  "important");
               document.getElementById("lokasi").style.setProperty("border-color", "#00B4FF",
                  "important");
               document.getElementById("sample").style.setProperty("background-color", "#00B4FF",
                  "important");
               document.getElementById("sample").style.setProperty("border-color", "#00B4FF",
                  "important");
               document.getElementById("lain").style.setProperty("background-color", "#00B4FF",
                  "important");
               document.getElementById("lain").style.setProperty("border-color", "#00B4FF", "important");
               $('#udara').empty();
               $('#no_sample').val('');
               $('#btnBawah').show()
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
   } else {
      error.play();
      Swal.fire({
         icon: 'info',
         title: 'Please checked Confirm permission',
         timer: 3000
      })
   }
})

function selected(titik) {
   $("#foto_lain").val('');
   document.getElementById("attachment").style.setProperty("background-color", "#00B4FF", "important");
   document.getElementById("attachment").style.setProperty("border-color", "#00B4FF", "important");
   if ($('#tblsz').hasClass("d-none")) {
      $('#resetB').text(" Draw");
      // $('#resetB').removeClass("fa-camera");
      $('#resetB').addClass('fa fa-solid fa-pencil');
   }
   var n = Math.floor(Math.sqrt(titik));
   var m = n + 1
   var tot = m * n
   if (tot > titik) {
      m = n
   }
   var m = m - 1,
      n = n - 1;
   $('td').removeClass('SizeChooser-selected');
   $('tr').each(function(y) {
      $(this).find('td').each(function(x) {
         if (x <= n && y <= m) {
            $(this).addClass('crossed SizeChooser-selected');
            // 
         }
      })
   })
}

function mulai() {
   var date = new Date();
   jam = date.getHours();
   jam = ("0" + jam).slice(-2);
   menit = date.getMinutes();
   menit = ("0" + menit).slice(-2);
   $('#time').val(jam + ":" + menit);
}

var getaranLingkungan =
   '<div class="mb-2"><div class="row"><div class="col-sm-12"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Penamaan Titik</label><input type="text" name="keterangan_4" id="keterangan-4" class="form-control" autocomplete="off"></div></div></div></div></div><div class="mb-2"><div class="row"><div class="col-sm-12"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1">Penamaan Tambahan</label><textarea class="form-control rounded" name="keterangan_2" id="keterangan_2" required></textarea><p class="text-danger mb-0 mt-0" style="font-size:10px">*ex. nama mesin / nama pekerja</p></div></div></div></div></div><div class="mb-2"><div class="row"><div class="col-sm-12"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1">Sumber Getaran</label><textarea class="form-control rounded" name="sumber" id="sumber" required></textarea></div></div></div></div></div><div class="mb-2"><div class="row"><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Jarak Sumber Getaran</label><div class="input-group"><input id="jarak" type="number" class="form-control" name="jarak" autocomplete="off" step="0.1" placeholder="0" required><div class="input-group-append"><span class="input-group-text" style="font-size:10px">m</span></div></div><span class="text-danger text-bold" id="valjarak" style="font-size:10px;display:none">(Ex. 0.7)</span><span class="text-success" id="cekjarak" style="font-size:10px;display:none">Desimal sesuai</span></div></div></div></div></div><div class="row mb-2"><p class="text-danger mb-0 mt-0" style="font-size:10px">*Penilaian kondisi berdasarkan observasi subjectif</p><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1">Kondisi</label><select name="kondisi" id="kondisi" class="form-control" autocomplete="off" style="font-size:10px" required><option value="">--Pilih Kondisi--</option><option value="Sangat Kuat">Sangat Kuat</option><option value="Kuat">Kuat</option><option value="Lemah">Lemah</option><option value="Tidak Terasa">Tidak Terasa</option></select></div></div></div><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1">Intensitas</label><select name="intensitas" id="intensitas" class="form-control" style="font-size:10px" required><option value="">--Pilih Intensitas--</option><option value="Konstan">Konstan</option><option value="Kejut">Kejut</option></select></div></div></div></div><div class="row mb-2"><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Jam Pengambilan</label><div class="input-group"><div class="row"><div class="col-8"><input type="text" class="form-control" name="waktu" id="time" readonly="readonly"></div><div class="col-2 px-0"><span class="d-flex align-items-center btn btn-danger"><a class="fa fa-clock-o" onclick="mulai()"></a></span></div></div></div></div></div></div><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Frekuensi</label><div class="input-group"><input type="number" class="form-control" name="frekuensi" id="frekuensi" autocomplete="off" step="any" placeholder="0"><div class="input-group-append"><span class="input-group-text" style="font-size:10px">Hz</span></div></div></div></div></div></div><div class="row mb-2"><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Satuan Percepatan (PEAK)</label><select name="satKec" id="satKec" class="form-control" style="font-size:9px" required><option value="">--Input Satuan--</option><option value="mm/s=">mm/s</option><option value="mm/s2">mm/s<sup>2</sup></option><option value="m/s2">m/s<sup>2</sup></option></select></div></div></div><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Satuan Kecepatan (PEAK)</label><select name="satPer" id="satPer" class="form-control" style="font-size:9px" required><option value="">--Input Satuan--</option><option value="mm/s=">mm/s</option><option value="mm/s2">mm/s<sup>2</sup></option><option value="m/s2">m/s<sup>2</sup></option></select></div></div></div></div><div class="border border-dash-gray rounded"><div class="row justify-content-center mt-2"><div class="col-12 text-center"><label class="mb-0">PENGUKURAN</label></div><div class="col-12 d-flex justify-content-between px-4" style="font-size:12px"><label>Total Pengukuran :<span>3</span></label><label>Pengukuran Ke :<span id="peng_k"></span></label></div></div><div id="pengukuran"></div></div><div id="btnAksi"></div><label class="mt-1">Dokumentasi</label><div class="row mb-2"><div class="col-6"><div class="form-group basic"><label class="label label-1 mb-1">Lokasi Sampling<sup>*</sup></label><label for="file1"><span class="btn btn-primary" id="lokasi"><hi class="fa fa-camera"></hi>Ambil Gambar</span><input type="file" id="file1" accept="image/*" capture="environment" style="display:none" onchange="preview_image(1)"></label><textarea id="foto_lok" name="foto_lok" class="d-none"></textarea></div></div><div class="col-6"><div class="form-group basic"><label class="label label-1 mb-1">Foto Lain - Lain</label><label for="file3"><span class="btn btn-primary" id="lain"><i class="fa fa-camera"></i>Ambil Gambar</span><input type="file" id="file3" accept="image/*" capture @change="setImage" style="display:none" onchange="preview_image(3)"></label><textarea id="foto_lain" name="foto_lain" class="d-none"></textarea></div></div></div><div class="mb-2"><label style="border:1px solid #ced4da;padding:5px;border-radius:10px"><input type="checkbox" name="permis" value="1"><span>Data dan Informasi Pengambilan Sampel Ini adalah yang Sebenar-benarnya</span></label></div>';
   </script>