   <div id="appCapsule">
      <div class="section mb-5 p-2">
         <form id="form-add">
            <div class="card">
               <div class="card-body pb-1">
                  <div class="row">
                     <div class="col-12 text-center">
                        <label for="">FDL Pencahayaan</label>
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
                  <div id="isiCahaya"></div>
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
      <div class="btnTengah" onclick="location.href='<?= base_url;?>/cahaya/add_data'"></a></div>
      <div class="btnMenu">
         <ul>
            <li style="--i:0.1s;"><a href="<?= base_url;?>/home"><i class="fa-solid fa-gauge"></i></a></li>
            <li style="--i:0.2s;"><a href="<?= base_url;?>/cahaya"><i class="fa-solid fa-house"></i></a></li>
            <li></li>
            <li style="--i:0.2s;"><a href="<?= base_url;?>/cahaya/data"><i class="fa-solid fa-file-lines"></i></a></li>
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
         $('#isiCahaya').empty();
         $('#no_sample').val('');
         $("#foto_lain").val('')
      }
   });
}

function rumus() {
   $("#panjang").keyup(function() {
      var panjang = $("#panjang").val();
      if (panjang !== ".") {
         $("#valpanjang").show(),
            $("#cekpanjang").hide()
      }
      if (panjang.includes('.')) {
         var nil = panjang.toString().split(".")[1].length;
         if (nil == 1) {
            $('#valpanjang').hide();
            $('#cekpanjang').show();
         }
         if (nil > 1) {
            $('#valpanjang').show();
            $('#cekpanjang').hide();
         }
      }

   })
   $("#lebar").keyup(function() {
      var lebar = $("#lebar").val();
      if (lebar !== ".") {
         $("#vallebar").show(),
            $("#ceklebar").hide()
      }
      if (lebar.includes('.')) {
         var nil = lebar.toString().split(".")[1].length;
         if (nil == 1) {
            $('#vallebar').hide();
            $('#ceklebar').show();
         }
         if (nil > 1) {
            $('#vallebar').show();
            $('#ceklebar').hide();
         }
      }

   })
   $("#panjang, #lebar").keyup(function() {
      var lebar = $("#lebar").val();
      var panjang = $("#panjang").val();
      if (panjang == null) {
         panjang = 0;
      } else if (lebar == null) {
         lebar = 0;
      } else {
         var jml = panjang * lebar;
         if (jml < 50) {
            var titik = jml / 3
         } else if (jml < 99) {
            titik = jml / 2
         } else if (jml >= 100) {
            titik = jml / 2.8
         }
         var titik_p = Math.ceil(titik)
         $("#jml_titik_p").val(titik_p);
         $("#total-k").html(titik_p);
         $("#luas").val(jml.toFixed(2));
         input_pencahayaan();
         selected(titik_p);
      }
   })
   $("#titik_p").keyup(function() {
      var titik_p = Math.ceil($("#titik_p").val())
      $("#total-k").html(titik_p);
      input_pencahayaanS();
      selected(titik_p);
   })
}

$("#no_sample").on('keydown', function(e) {
   $('#udara').html('')
   $('#isiCahaya').html('')
   if (e.key === "Enter") {
      let net = $('#status-text').text();
      if (net == "Online") {
         var no_sample = $("#no_sample").val();
         $.ajax({
            url: '/public/cahaya/getSampel',
            method: 'POST',
            data: {
               no_sample: no_sample
            },
            success: function(resp) {
               e = JSON.parse(resp);
               if (e.id_ket == '28') {
                  $('#udara').html(selectt).fadeIn('slow');
                  $("#foto_lain").val('')
                  rumus();
                  jenisCaha(e.id_ket, e.keterangan);
               } else {
                  error.play();
                  Swal.fire({
                     title: 'Tidak ada kategori FDL pencahayaan di No Sample tersebut',
                     icon: 'warning',
                     confirmButtonColor: '#3085d6',
                  })
               }
            },
            error: function(e) {
               e = JSON.parse(e)
               Swal.fire({
                  icon: 'error',
                  title: 'Ooooops.....',
                  text: e.message
               })
            }
         })
      } else {
         Swal.fire({
            icon: 'info',
            title: 'Anda Sedang Offline',
            timer: 3000
         })
         $('#udara').html(selectt).fadeIn('slow');
         $("#foto_lain").val('')
         rumus();
         jenisCaha(e.id_ket, e.keterangan);
      }
      return false;
   }
});

function jenisCaha(dat, dat2) {
   $('#pilihJenis').on('change', function() {
      var jenis = $('#pilihJenis').val()
      if (jenis == 'umum') {
         $('#btnBawah').hide()
         $("#isiCahaya").html(cahayaUmum);
         $('#id_kat').val(dat);
         $('#keterangan-4').val(dat2);
         $('#time').clockTimePicker();
         $('#timee').clockTimePicker();
         rumus()
         var o = "";
         for (i = 1; i <= 12; i++) {
            for (o += "<tr>", a = 1; a <= 12; a++) o += "<td></td>";
            o += "</tr>";
         }
         $("#html-content-holder").empty(), $("#html-content-holder").html(o);

         $("#html-content-holder").on("click", "td", function() {
            if ($(this).hasClass('crossed SizeChooser-selected')) {
               $(this).removeClass('crossed SizeChooser-selected')
            } else {
               $(this).addClass('crossed SizeChooser-selected')
            }
         });

      } else if (jenis == 'setempat') {
         $('#btnBawah').hide()
         $("#isiCahaya").html(cahayaSetempat);
         $('#keterangan-4').val(dat2);
         $('#id_kat').val(dat);
         $('#time').clockTimePicker();
         rumus()
         var o = "";
         for (i = 1; i <= 12; i++) {
            for (o += "<tr>", a = 1; a <= 12; a++) o += "<td></td>";
            o += "</tr>";
         }
         $("#html-content-holder").empty(), $("#html-content-holder").html(o);

         $("#html-content-holder").on("click", "td", function() {
            if ($(this).hasClass('crossed SizeChooser-selected')) {
               $(this).removeClass('crossed SizeChooser-selected')
            } else {
               $(this).addClass('crossed SizeChooser-selected')
            }
         });
      } else {
         $("#isiCahaya").empty()
      }

   });
}

function input_pencahayaanS() {
   $("#pencahayaan").empty();
   var total_t = $("#titik_p").val();
   for (hi = 1; hi <= total_t; hi++) {
      var boddi = '<div class="peng-cahaya-' + hi + '" style="display: none;">'
      boddi += '<div class="mb-1 row p-3">'
      boddi += '<div class="col-6 mb-2">'
      boddi += '<div class="form-group basic">'
      boddi += '<div class="input-wrapper">'
      boddi += '<label class="label label-1">Nilai Ulangan 1</label>'
      boddi += '<input id="ulangan1-' + hi + '" type="number" class="' + hi +
         ' form-control" name="ulangan1[]" autocomplete="off" step="any" required>'
      boddi += '</div>'
      boddi += '</div>'
      boddi += '</div>'
      boddi += '<div class="col-6">'
      boddi += '<div class="form-group basic">'
      boddi += '<div class="input-wrapper">'
      boddi += '<label class="label label-1">Keterangan</label>'
      boddi += '<select name="ket_peng[]" id="ket_peng-' + hi +
         '" class="form-control" style="font-size: 10px;" required>'
      boddi += '<option value="">--Input Keterangan--</option>'
      boddi += '<option value="Lampu Stabil">Lampu Stabil</option>'
      boddi += '<option value="Lampu Tidak Stabil">Lampu Tidak Stabil</option>'
      boddi += '<option value="Dekat Jendela & Cuaca Cerah">Dekat Jendela & Cuaca Cerah</option>'
      boddi += '<option value="Dekat Jendela & Cuaca Mendung">Dekat Jendela & Cuaca Mendung</option>'
      boddi += '<option value="Tidak ada Penerangan">Tidak ada Penerangan</option>'
      boddi += '</select>'
      boddi += '</div>'
      boddi += '</div>'
      boddi += '</div>'
      boddi += '<div class="col-6 mb-2">'
      boddi += '<div class="form-group basic">'
      boddi += '<div class="input-wrapper">'
      boddi += '<label class="label label-1">Nilai Ulangan 2</label>'
      boddi += '<input id="ulangan2-' + hi + '" type="number" class="' + hi +
         ' form-control" name="ulangan2[]" autocomplete="off" step="any" required>'
      boddi += '</div>'
      boddi += '</div>'
      boddi += '</div>'
      boddi += '<div class="col-6">'
      boddi += '<div class="form-group basic">'
      boddi += '<div class="input-wrapper">'
      boddi += '<label class="label label-1">Kendala Lampu</label>'
      boddi += '<select name="ken_lampu[]" id="ken_lampu-' + hi +
         '" class="form-control" style="font-size: 10px;" required>'
      boddi += '<option value="">--Input Kendala--</option>'
      boddi += '<option value="Lampu Normal">Lampu Normal</option>'
      boddi += '<option value="Lampu Mati">Lampu Mati</option>'
      boddi += '<option value="Lampu Berkedip">Lampu Berkedip</option>'
      boddi += '<option value="Lampu Redup">Lampu Redup</option>'
      boddi += '<option value="Lampu Tinggi">Lampu Tinggi</option>'
      boddi += '<option value="Lampu Tertutup">Lampu Tertutup</option>'
      boddi += '</select>'
      boddi += '</div>'
      boddi += '</div>'
      boddi += '</div>'
      boddi += '<div class="col-6 mb-2">'
      boddi += '<div class="form-group basic">'
      boddi += '<div class="input-wrapper">'
      boddi += '<label class="label label-1">Nilai Ulangan 3</label>'
      boddi += '<input id="ulangan3-' + hi + '" type="number" class="' + hi +
         ' form-control" name="ulangan3[]"  autocomplete="off" step="any" required>'
      boddi += '</div>'
      boddi += '</div>'
      boddi += '</div>'
      boddi += '<div class="col-6">'
      boddi += '<div class="form-group basic">'
      boddi += '<div class="input-wrapper">'
      boddi += '<label class="label label-1">Warna Lampu</label>'
      boddi += '<select name="war_lampu[]" id="war_lampu-' + hi +
         '" class="form-control" style="font-size: 10px;" required>'
      boddi += '<option value="">--Input Warna--</option>'
      boddi += '<option value="Putih">Putih</option>'
      boddi += '<option value="Kuning">Kuning</option>'
      boddi += '<option value="Biru">Biru</option>'
      boddi += '<option value="Ungu">Ungu</option>'
      boddi += '<option value="Merah">Merah</option>'
      boddi += '</select>'
      boddi += '</div>'
      boddi += '</div>'
      boddi += '</div>'
      boddi += '<div class="col-6">'
      boddi += '<div class="form-group basic">'
      boddi += '<div class="input-wrapper">'
      boddi += '<label class="label label-1">Nilai Rata-Rata</label>'
      boddi += '<input id="rata-' + hi +
         '" type="number" class=" form-control" name="ratarata[]" autocomplete="off" step="any" readonly>'
      boddi += '</div>'
      boddi += '</div>'
      boddi += '</div>'
      boddi += '</div>'
      boddi += '</div>'
      $('#pencahayaan').append(boddi);
      $('.peng-cahaya-1').show();

      $("#btnAksi").empty();
      var btn =
         '<div class="mb-2 mt-2"><div class="row justify-content-center"><div class="col-6"><div class="form-group basic"><button type="button" class="btn btn-success w-100" id="prev" style="font-size: 10px;">&laquo; Titik Sebelumnya</button></div></div><div class="col-6"><div class="form-group basic"><button type="button" class="btn btn-success w-100" id="next" style="font-size: 10px;">Titik Selanjutnya &raquo;</button></div></div></div></div>'
      $('#btnAksi').append(btn);
      $('.btnK').show();

      $('#ulangan1-' + hi + '').on('keyup', function() {
         var hi = this.classList[0]
         var ul11 = $("#ulangan1-" + hi + "").val();
         var ul21 = $("#ulangan2-" + hi + "").val();
         var ul31 = $("#ulangan3-" + hi + "").val();
         if (ul11 == "") {
            ul11 = 0
         } else if (ul21 == "") {
            ul21 = 0
         } else if (ul31 == "") {
            ul31 = 0
         } else {
            var u11 = parseFloat(ul11)
            var u21 = parseFloat(ul21)
            var u31 = parseFloat(ul31)
            var kali1 = u11 * u21 * u31;
            var sum1 = u11 + u21 + u31;
            var rata1 = sum1 / 3
            var c_rata1 = rata1.toFixed(2)
            $("#rata-" + hi + "").val(c_rata1);
         }
      })

      $('#ulangan2-' + hi + '').on('keyup', function() {
         var hi = this.classList[0]
         var ul12 = $("#ulangan1-" + hi + "").val();
         var ul22 = $("#ulangan2-" + hi + "").val();
         var ul32 = $("#ulangan3-" + hi + "").val();
         if (ul12 == "") {
            ul12 = 0
         } else if (ul22 == "") {
            ul22 = 0
         } else if (ul32 == "") {
            ul32 = 0
         } else {
            var u12 = parseFloat(ul12)
            var u22 = parseFloat(ul22)
            var u32 = parseFloat(ul32)
            var kali2 = u12 * u22 * u32;
            var sum2 = u12 + u22 + u32;
            var rata2 = sum2 / 3
            var c_rata2 = rata2.toFixed(2)
            $("#rata-" + hi + "").val(c_rata2);
         }
      })
      $('#ulangan3-' + hi + '').on('keyup', function() {
         var hi = this.classList[0]
         var ul13 = $("#ulangan1-" + hi + "").val();
         var ul23 = $("#ulangan2-" + hi + "").val();
         var ul33 = $("#ulangan3-" + hi + "").val();
         if (ul13 == "") {
            ul13 = 0
         } else if (ul23 == "") {
            ul23 = 0
         } else if (ul33 == "") {
            ul33 = 0
         } else {
            var u13 = parseFloat(ul13)
            var u23 = parseFloat(ul23)
            var u33 = parseFloat(ul33)
            var kali3 = u13 * u23 * u33;
            var sum3 = u13 + u23 + u33;
            var rata3 = sum3 / 3
            var c_rata3 = rata3.toFixed(2)
            $("#rata-" + hi + "").val(c_rata3);
         }
      })
   }

   // $('#next').prop("disabled", false)
   // $('#prev').prop("disabled", true)
   let vi = 1,
      fi = 0,
      wi = 0,
      fe = 0,
      we = 0;
   $('#next').prop("disabled", false)
   $('#prev').prop("disabled", true)
   $('#titik_k').html(vi);

   $('#next').click(function() {
      fi = ++vi
      wi = vi - 1;
      $('#titik_k').html(vi);
      $('#prev').prop("disabled", false)
      if (fi == total_t) {
         $('#next').prop("disabled", true)
      }
      // console.log(vi)
      $('.peng-cahaya-' + fi).show();
      $('.peng-cahaya-' + wi).hide();

   });
   $('#prev').click(function() {
      fe = vi--
      we = vi
      $('#titik_k').html(we);
      if (fe == 2) {
         $('#prev').prop("disabled", true)
      }
      $('.peng-cahaya-' + fe).hide();
      $('.peng-cahaya-' + we).show();
      $('#next').prop("disabled", false)
   });
}

function input_pencahayaan() {
   $("#pencahayaan").empty();
   var total_t = $("#jml_titik_p").val();
   for (hi = 1; hi <= total_t; hi++) {
      var boddi = '<div class="peng-cahaya-' + hi + '" style="display: none;">'
      boddi += '<div class="mb-1 row p-3">'
      boddi += '<div class="col-6 mb-2">'
      boddi += '<div class="form-group basic">'
      boddi += '<div class="input-wrapper">'
      boddi += '<label class="label label-1">Nilai Ulangan 1</label>'
      boddi += '<input id="ulangan1-' + hi + '" type="number" class="' + hi +
         ' form-control" name="ulangan1[]" autocomplete="off" step="any" required>'
      boddi += '</div>'
      boddi += '</div>'
      boddi += '</div>'
      boddi += '<div class="col-6">'
      boddi += '<div class="form-group basic">'
      boddi += '<div class="input-wrapper">'
      boddi += '<label class="label label-1">Keterangan</label>'
      boddi += '<select name="ket_peng[]" id="ket_peng-' + hi +
         '" class="form-control" style="font-size: 10px;" required>'
      boddi += '<option value="">--Input Keterangan--</option>'
      boddi += '<option value="Lampu Stabil">Lampu Stabil</option>'
      boddi += '<option value="Lampu Tidak Stabil">Lampu Tidak Stabil</option>'
      boddi += '<option value="Dekat Jendela & Cuaca Cerah">Dekat Jendela & Cuaca Cerah</option>'
      boddi += '<option value="Dekat Jendela & Cuaca Mendung">Dekat Jendela & Cuaca Mendung</option>'
      boddi += '<option value="Tidak ada Penerangan">Tidak ada Penerangan</option>'
      boddi += '</select>'
      boddi += '</div>'
      boddi += '</div>'
      boddi += '</div>'
      boddi += '<div class="col-6 mb-2">'
      boddi += '<div class="form-group basic">'
      boddi += '<div class="input-wrapper">'
      boddi += '<label class="label label-1">Nilai Ulangan 2</label>'
      boddi += '<input id="ulangan2-' + hi + '" type="number" class="' + hi +
         ' form-control" name="ulangan2[]" autocomplete="off" step="any" required>'
      boddi += '</div>'
      boddi += '</div>'
      boddi += '</div>'
      boddi += '<div class="col-6">'
      boddi += '<div class="form-group basic">'
      boddi += '<div class="input-wrapper">'
      boddi += '<label class="label label-1">Kendala Lampu</label>'
      boddi += '<select name="ken_lampu[]" id="ken_lampu-' + hi +
         '" class="form-control" style="font-size: 10px;" required>'
      boddi += '<option value="">--Input Kendala--</option>'
      boddi += '<option value="Lampu Normal">Lampu Normal</option>'
      boddi += '<option value="Lampu Mati">Lampu Mati</option>'
      boddi += '<option value="Lampu Berkedip">Lampu Berkedip</option>'
      boddi += '<option value="Lampu Redup">Lampu Redup</option>'
      boddi += '<option value="Lampu Tinggi">Lampu Tinggi</option>'
      boddi += '<option value="Lampu Tertutup">Lampu Tertutup</option>'
      boddi += '</select>'
      boddi += '</div>'
      boddi += '</div>'
      boddi += '</div>'
      boddi += '<div class="col-6 mb-2">'
      boddi += '<div class="form-group basic">'
      boddi += '<div class="input-wrapper">'
      boddi += '<label class="label label-1">Nilai Ulangan 3</label>'
      boddi += '<input id="ulangan3-' + hi + '" type="number" class="' + hi +
         ' form-control" name="ulangan3[]"  autocomplete="off" step="any" required>'
      boddi += '</div>'
      boddi += '</div>'
      boddi += '</div>'
      boddi += '<div class="col-6">'
      boddi += '<div class="form-group basic">'
      boddi += '<div class="input-wrapper">'
      boddi += '<label class="label label-1">Warna Lampu</label>'
      boddi += '<select name="war_lampu[]" id="war_lampu-' + hi +
         '" class="form-control" style="font-size: 10px;" required>'
      boddi += '<option value="">--Input Warna--</option>'
      boddi += '<option value="Putih">Putih</option>'
      boddi += '<option value="Kuning">Kuning</option>'
      boddi += '<option value="Biru">Biru</option>'
      boddi += '<option value="Ungu">Ungu</option>'
      boddi += '<option value="Merah">Merah</option>'
      boddi += '</select>'
      boddi += '</div>'
      boddi += '</div>'
      boddi += '</div>'
      boddi += '<div class="col-6">'
      boddi += '<div class="form-group basic">'
      boddi += '<div class="input-wrapper">'
      boddi += '<label class="label label-1">Nilai Rata-Rata</label>'
      boddi += '<input id="rata-' + hi +
         '" type="number" class=" form-control" name="ratarata[]" autocomplete="off" step="any" readonly>'
      boddi += '</div>'
      boddi += '</div>'
      boddi += '</div>'
      boddi += '</div>'
      boddi += '</div>'
      $('#pencahayaan').append(boddi);
      $('.peng-cahaya-1').show();

      $("#btnAksi").empty();
      var btn =
         '<div class="mb-2 mt-2"><div class="row justify-content-center"><div class="col-6"><div class="form-group basic"><button type="button" class="btn btn-success w-100" id="prev" style="font-size: 10px;">&laquo; Titik Sebelumnya</button></div></div><div class="col-6"><div class="form-group basic"><button type="button" class="btn btn-success w-100" id="next" style="font-size: 10px;">Titik Selanjutnya &raquo;</button></div></div></div></div>'
      $('#btnAksi').append(btn);
      $('.btnK').show();

      $('#ulangan1-' + hi + '').on('keyup', function() {
         var hi = this.classList[0]
         var ul11 = $("#ulangan1-" + hi + "").val();
         var ul21 = $("#ulangan2-" + hi + "").val();
         var ul31 = $("#ulangan3-" + hi + "").val();
         if (ul11 == "") {
            ul11 = 0
         } else if (ul21 == "") {
            ul21 = 0
         } else if (ul31 == "") {
            ul31 = 0
         } else {
            var u11 = parseFloat(ul11)
            var u21 = parseFloat(ul21)
            var u31 = parseFloat(ul31)
            var kali1 = u11 * u21 * u31;
            var sum1 = u11 + u21 + u31;
            var rata1 = sum1 / 3
            var c_rata1 = rata1.toFixed(2)
            $("#rata-" + hi + "").val(c_rata1);
         }
      })
      $('#ulangan2-' + hi + '').on('keyup', function() {
         var hi = this.classList[0]
         var ul12 = $("#ulangan1-" + hi + "").val();
         var ul22 = $("#ulangan2-" + hi + "").val();
         var ul32 = $("#ulangan3-" + hi + "").val();
         if (ul12 == "") {
            ul12 = 0
         } else if (ul22 == "") {
            ul22 = 0
         } else if (ul32 == "") {
            ul32 = 0
         } else {
            var u12 = parseFloat(ul12)
            var u22 = parseFloat(ul22)
            var u32 = parseFloat(ul32)
            var kali2 = u12 * u22 * u32;
            var sum2 = u12 + u22 + u32;
            var rata2 = sum2 / 3
            var c_rata2 = rata2.toFixed(2)
            $("#rata-" + hi + "").val(c_rata2);
         }
      })
      $('#ulangan3-' + hi + '').on('keyup', function() {
         var hi = this.classList[0]
         var ul13 = $("#ulangan1-" + hi + "").val();
         var ul23 = $("#ulangan2-" + hi + "").val();
         var ul33 = $("#ulangan3-" + hi + "").val();
         if (ul13 == "") {
            ul13 = 0
         } else if (ul23 == "") {
            ul23 = 0
         } else if (ul33 == "") {
            ul33 = 0
         } else {
            var u13 = parseFloat(ul13)
            var u23 = parseFloat(ul23)
            var u33 = parseFloat(ul33)
            var kali3 = u13 * u23 * u33;
            var sum3 = u13 + u23 + u33;
            var rata3 = sum3 / 3
            var c_rata3 = rata3.toFixed(2)
            $("#rata-" + hi + "").val(c_rata3);
         }
      })
   }

   // $('#next').prop("disabled", false)
   // $('#prev').prop("disabled", true)
   let vi = 1,
      fi = 0,
      wi = 0,
      fe = 0,
      we = 0;
   $('#next').prop("disabled", false)
   $('#prev').prop("disabled", true)
   $('#titik_k').html(vi);

   $('#next').click(function() {
      fi = ++vi
      wi = vi - 1;
      $('#titik_k').html(vi);
      $('#prev').prop("disabled", false)
      if (fi == total_t) {
         $('#next').prop("disabled", true)
      }
      // console.log(vi)
      $('.peng-cahaya-' + fi).show();
      $('.peng-cahaya-' + wi).hide();

   });
   $('#prev').click(function() {
      fe = vi--
      we = vi
      $('#titik_k').html(we);
      if (fe == 2) {
         $('#prev').prop("disabled", true)
      }
      $('.peng-cahaya-' + fe).hide();
      $('.peng-cahaya-' + we).show();
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

function reset() {
   Swal.fire({
      icon: 'info',
      title: 'Apakah ingin meng-cancel data.?',
      showCancelButton: true,
      confirmButtonText: 'Yes',
   }).then((result) => {
      if (result.isConfirmed) {
         document.getElementById("form-add").reset();
         $('#limbah').empty();
         $('#foto').empty();
         $('#foto2').empty();
      }
   });
}

$('#form-add').on('submit', function(e) {
   e.preventDefault()
   let data_form = $(this).serialize();
   // $('#btn-submit').prop('disabled', true);
   if ($("input[name=permis]").is(':checked')) {
      if ($("#lokasi").hasClass("sukses") && $("#lain").hasClass("sukses")) {

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
            url: '/public/cahaya/saveData',
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
                  document.getElementById("lain").style.setProperty("background-color", "#00B4FF",
                     "important");
                  document.getElementById("lain").style.setProperty("border-color", "#00B4FF",
                     "important");
                  $("#no_sample").val('')
                  $("#foto_lain").val('')
                  $('#udara').empty();
                  $('#isiCahaya').empty();
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
            title: 'Foto lokasi dan foto roadmap masih kosong.!',
            timer: 3000
         })
      }
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
   document.getElementById("lain").classList.remove("sukses");
   document.getElementById("lain").style.setProperty("background-color", "#00B4FF", "important");
   document.getElementById("lain").style.setProperty("border-color", "#00B4FF", "important");
   if ($('#tblsz').hasClass("d-none")) {
      $('#resetB').text(" Draw");
      // $('#resetB').removeClass("fa-camera");
      // $('#resetB').addClass('fa fa-solid fa-pencil');
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

function show() {
   $('#tblsz').removeClass("d-none");
   $('#resetB').text("Reset Titik");
   $('#attch').addClass('d-none');
   $('#saveT').removeClass('d-none');
   $('#resetT').removeClass('d-none');
   document.getElementById("lain").style.setProperty("background-color", "#00B4FF", "important");
   document.getElementById("lain").style.setProperty("border-color", "#00B4FF", "important");
   document.getElementById("lain").classList.remove("sukses");
}

function resett() {
   if ($('#tblsz').hasClass("d-none")) {
      $('#resetB').text("Reset Titik");
      $('#tblsz').removeClass("d-none");
      $('#attch').addClass('d-none');
      $('#saveT').removeClass('d-none');
      $('#resetT').removeClass('d-none');
      document.getElementById("lain").style.setProperty("background-color", "#00B4FF", "important");
      document.getElementById("lain").style.setProperty("border-color", "#00B4FF", "important");
      document.getElementById("lain").classList.remove("sukses");
   } else {
      $(".SizeChooser-selected").removeClass('crossed SizeChooser-selected');
   }
}

function resett2() {
   if ($('#tblsz').hasClass("d-none")) {
      $('#resetB').text("Reset Titik");
      $('#tblsz').removeClass("d-none");
      $('#attch').addClass('d-none');
      $('#saveT').removeClass('d-none');
      $('#resetT').removeClass('d-none');
      document.getElementById("lain").style.setProperty("background-color", "#00B4FF", "important");
      document.getElementById("lain").style.setProperty("border-color", "#00B4FF", "important");
      document.getElementById("lain").classList.remove("sukses");
   } else {
      $(".SizeChooser-selected").removeClass('crossed SizeChooser-selected');
   }
}

function convert() {
   if ($('#jml_titik_p').val() != $(".SizeChooser-selected").length) {
      Swal.fire({
         icon: 'info',
         title: 'Pengisian denah titik tidak sesuai dengan jumlah titik',
         timer: 2000
      });
   } else if (!$('td').hasClass('SizeChooser-selected')) {
      Swal.fire({
         icon: 'info',
         title: 'Denah Masih kosong!',
         timer: 2000
      });
   } else {
      html2canvas(document.getElementById("html-content-holder")).then(function(canvas) {
         var anchorTag = document.createElement("a");
         document.body.appendChild(anchorTag);
         anchorTag.href = canvas.toDataURL("image/jpeg");
         $("#foto_lain").val(anchorTag.href);
      });
      document.getElementById("lain").style.setProperty("background-color", "#09810f", "important");
      document.getElementById("lain").style.setProperty("border-color", "#09810f", "important");
      document.getElementById("lain").classList.add("sukses");
      $('#tblsz').addClass("d-none");
      $('#resetT').removeClass('d-none');
      $('#saveT').removeClass('d-none');
   }
}

function show2() {
   $('#tblsz').removeClass("d-none");
   $('#resetB').text("Reset Titik");
   $('#attch').addClass('d-none');
   $('#saveT').removeClass('d-none');
   $('#resetT').removeClass('d-none');
   document.getElementById("lain").style.setProperty("background-color", "#00B4FF", "important");
   document.getElementById("lain").style.setProperty("border-color", "#00B4FF", "important");
   document.getElementById("lain").classList.remove("sukses");
}

function convert2() {
   if ($('#titik_p').val() != $(".SizeChooser-selected").length) {
      Swal.fire({
         icon: 'info',
         title: 'Pengisian lokasi titik tidak sesuai dengan jumlah titik',
         timer: 2000
      });
   } else if (!$('td').hasClass('SizeChooser-selected')) {
      Swal.fire({
         icon: 'info',
         title: 'Denah Masih kosong!',
         timer: 2000
      });
   } else {
      html2canvas(document.getElementById("html-content-holder")).then(function(canvas) {
         var anchorTag = document.createElement("a");
         document.body.appendChild(anchorTag);
         anchorTag.href = canvas.toDataURL("image/jpeg");
         $("#foto_lain").val(anchorTag.href);
      });
      document.getElementById("lain").style.setProperty("background-color", "#09810f", "important");
      document.getElementById("lain").style.setProperty("border-color", "#09810f", "important");
      document.getElementById("lain").classList.add("sukses");
      $('#tblsz').addClass("d-none");
      $('#resetT').removeClass('d-none');
      $('#saveT').removeClass('d-none');
   }
}

function clear() {
   document.getElementById("lain").style.setProperty("background-color", "#00B4FF", "important");
   document.getElementById("lain").style.setProperty("border-color", "#00B4FF", "important");
   document.getElementById("lain").classList.remove("sukses");
   $('#tblsz').addClass("d-none");
   document.getElementById("form-add").reset();
   $('#udara').empty();
}

function mulai() {
   var date = new Date();
   jam = date.getHours();
   jam = ("0" + jam).slice(-2);
   menit = date.getMinutes();
   menit = ("0" + menit).slice(-2);
   $('#time').val(jam + ":" + menit);
}

function selesai() {
   var date = new Date();
   jam = date.getHours();
   jam = ("0" + jam).slice(-2);
   menit = date.getMinutes();
   menit = ("0" + menit).slice(-2);
   $('#timee').val(jam + ":" + menit);
}
var selectt =
   '<div class="mb-3 mt-2"><div class="form-group basic"><div class="input-wrapper"><select class="form-control" id="pilihJenis"><option>Select Jenis pencahayaan</option><option value="umum">Pencahayaan Umum</option><option value="setempat">Pencahayaan Setempat</option></select></div></div></div>';
var cahayaUmum =
   '<div class="mb-2"><div class="row"><div class="col-sm-12"><div class="form-group basic"><div class="input-wrapper"><input name="categori" id="categori" value="Pencahayaan Umum" style="display:none"><label class="label label-1">Penamaan Titik</label><input type="text" name="keterangan_4" id="keterangan-4" class="form-control" autocomplete="off"></div></div></div></div></div><div class="mb-2"><div class="row"><div class="col-sm-12"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1">Penamaan Tambahan</label><textarea class="form-control rounded" name="information" id="penamaan_tambahan" required></textarea></div></div></div></div></div><div class="row mb-2"><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Jumlah Tenaga Kerja</label><div class="input-group"><input type="number" class="form-control" name="jml_kerja" id="jml_kerja" autocomplete="off" step="any" required><div class="input-group-append"><span class="input-group-text" style="font-size:10px">Orang</span></div></div></div></div></div><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1">Jenis Pencahayaan</label><select name="jenis_cahaya" id="jenis_cahaya" class="form-control" style="font-size:10px" required><option value="">--Pilih Jenis--</option><option value="Alami">Alami</option><option value="Buatan">Buatan</option><option value="Campuran">Campuran</option></select></div></div></div></div><div class="row mb-2"><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1">Jenis Lampu</label><select name="jenis_lamp" id="jenis_lamp" class="form-control" style="font-size:10px" required><option value="">--Pilih Jenis--</option><option value="LED">LED</option><option value="UV Lamp">UV Lamp</option><option value="Neon TL">Neon TL</option><option value="Natrium">Natrium</option><option value="Infrared">Infrared</option><option value="Fluorescent">Fluorescent</option><option value="Bohlam Pijar">Bohlam Pijar</option><option value="Halogen (Lampu Tembak)">Halogen (Lampu Tembak)</option></select></div></div></div></div><div class="mb-2"><div class="row"><div class="col-sm-12"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1">Aktifitas Setiap Area</label><textarea class="form-control rounded" name="aktifitas" id="aktifitas" required></textarea></div></div></div></div></div><div class="mb-2"><div class="row"><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Panjang Area</label><div class="input-group"><input id="panjang" type="number" class="form-control" name="panjang" autocomplete="off" step="0.1" required><div class="input-group-append"><span class="input-group-text" style="font-size:10px">m</span></div></div><span class="text-danger" id="valpanjang" style="font-size:8px;display:none">Ex. 0.7</span><span class="text-success" id="cekpanjang" style="font-size:8px;display:none">Desimal sesuai</span></div></div></div><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Lebar Area</label><div class="input-group"><input id="lebar" type="number" class="form-control" name="lebar" autocomplete="off" step="0.1" required><div class="input-group-append"><span class="input-group-text" style="font-size:10px">m</span></div></div><span class="text-danger" id="vallebar" style="font-size:8px;display:none">Ex. 0.7</span><span class="text-success" id="ceklebar" style="font-size:8px;display:none">Desimal sesuai</span></div></div></div></div></div><div class="mb-2"><div class="row"><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Luas Area</label><div class="input-group"><input id="luas" type="number" class="form-control" name="luas" autocomplete="off" step="any" readonly="readonly"><div class="input-group-append"><span class="input-group-text" style="font-size:10px">m<sup>2</sup></span></div></div></div></div></div><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Jumlah Titik Pengukuran</label><div class="input-group"><input id="jml_titik_p" type="number" class="form-control" name="jml_titik_p" autocomplete="off" step="any" readonly="readonly"><div class="input-group-append"><span class="input-group-text" style="font-size:10px">Titik</span></div></div></div></div></div></div></div><div class="row mb-2"><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Jam Mulai Pengukuran</label><div class="input-group"><div class="row"><div class="col-8"><input type="text" class="form-control" name="mulai" id="time" readonly="readonly"></div><div class="col-2 px-0"><span class="d-flex align-items-center btn btn-danger"><a onclick="mulai()"><i class="fa-regular fa-clock"></i></a></span></div></div></div></div></div></div></div><div class="border border-dash-gray rounded"><div class="row justify-content-center mt-2"><div class="col-12 text-center"><label class="mb-0">PENGUJIAN CAHAYA</label></div><div class="col-8 d-flex justify-content-between"><label>Total Titik :<span id="total-k"></span></label><label>Titik Ke :<span id="titik_k"></span></label></div></div><div id="pencahayaan"></div></div><div id="btnAksi" class="mb-2"></div><div class="row mb-2"><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1">Jam Selesai Pengukuran</label><div class="input-group"><div class="row"><div class="col-8"><input type="text" class="form-control" name="selesai" id="timee" readonly="readonly"></div><div class="col-2 px-0"><span class="d-flex align-items-center btn btn-danger"><a onclick="selesai()"><i class="fa-regular fa-clock"></i></a></span></div></div></div></div></div></div></div><label class="mt-1">Dokumentasi</label><div class="row mb-2"><div class="col-6"><div class="form-group basic"><label class="label label-1 mb-1">Lokasi Sampling<sup>*</sup></label><label for="file1"><span class="btn btn-primary" id="lokasi"><hi class="fa fa-camera"></hi>Ambil Gambar</span><input type="file" id="file1" accept="image/*" capture="environment" style="display:none" onchange="preview_image(1)"></label><textarea id="foto_lok" name="foto_lok" class="d-none"></textarea></div></div><div class="col-6" id="attch"><div class="form-group basic"><label class="label label-1 mb-1">Attachment<sup>*</sup></label><label for="btnShow"><span class="btn btn-primary"><hi class="fa fa-solid fa-pencil"></hi>Draw</span><input type="button" id="btnShow" class="btn btn-primary" onclick="show()" style="display:none"></label></div></div></div><div class="table_size_chooser mb-2 d-none" id="tblsz"><div class="SizeChooser"><label class="label label-1 mb-1">Denah Titik</label><table id="html-content-holder"><tbody id="tes"></tbody></table><br></div></div><div class="row mb-2"><div class="col-6 d-none" id="resetT"><div class="form-group basic"><label class="label label-1 mb-1">Reset Titik</label><label for="btnReset"><span class="btn btn-primary" id="resetB"><hi class="fa fa-camera"></hi>Reset Titik</span><input type="button" id="btnReset" class="btn btn-primary" onclick="resett()" style="display:none"></label></div></div><div class="col-6 d-none" id="saveT"><div class="form-group basic"><label class="label label-1 mb-1">Save Draw Titik<sup>*</sup></label><label for="btnConvert"><span class="btn btn-primary" id="lain"><hi class="fa fa-camera"></hi>Save Titik</span><input type="button" id="btnConvert" class="btn btn-primary" onclick="convert()" style="display:none"></label><textarea id="foto_lain" name="foto_lain" class="d-none"></textarea></div></div></div><div class="mb-2"><label style="border:1px solid #ced4da;padding:5px;border-radius:10px"><input type="checkbox" name="permis" value="1"><span>Data dan Informasi Pengambilan Sampel Ini adalah yang Sebenar-benarnya</span></label></div>';
var cahayaSetempat =
   '<div class="mb-2"><div class="row"><div class="col-sm-12"><div class="form-group basic"><div class="input-wrapper"><input name="categori" id="categori" value="Pencahayaan Setempat" style="display:none"><label class="label label-1">Penamaan Titik</label><input type="text" name="keterangan_4" id="keterangan-4" class="form-control" autocomplete="off"></div></div></div></div></div><div class="mb-2"><div class="row"><div class="col-sm-12"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1">Penamaan Tambahan</label><textarea class="form-control rounded" name="information" id="penamaan_tambahan" required></textarea></div></div></div></div></div><div class="row mb-2"><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1">Jenis Pencahayaan</label><select name="jenis_cahaya" id="jenis_cahaya" class="form-control" style="font-size:10px" required><option value="">--Pilih Jenis--</option><option value="Alami">Alami</option><option value="Buatan">Buatan</option><option value="Campuran">Campuran</option></select></div></div></div><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1">Jenis Lampu</label><select name="jenis_lamp" id="jenis_lamp" class="form-control" style="font-size:10px" required><option value="">--Pilih Jenis--</option><option value="LED">LED</option><option value="UV Lamp">UV Lamp</option><option value="Neon TL">Neon TL</option><option value="Natrium">Natrium</option><option value="Infrared">Infrared</option><option value="Fluorescent">Fluorescent</option><option value="Bohlam Pijar">Bohlam Pijar</option><option value="Halogen (Lampu Tembak)">Halogen (Lampu Tembak)</option></select></div></div></div></div><div class="mb-2"><div class="row"><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1">Jenis Penempatan Sensor</label><select name="jenis_penem" id="jenis_penem" class="form-control" style="font-size:10px" required><option value="">--Pilih Jenis--</option><option value="Meja Kerja">Meja Kerja</option><option value="Bidang Vertikal">Bidang Vertikal</option><option value="Stasiun Kerja Komputer">Stasiun Kerja Komputer</option><option value="Sejajar Dengan Permukaan">Sejajar Dengan Permukaan</option></select></div></div></div><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Jumlah Titik Pengukuran</label><div class="input-group"><input id="titik_p" type="number" class="form-control" name="jml_titik_p" autocomplete="off" step="any" required><div class="input-group-append"><span class="input-group-text" style="font-size:10px">Titik</span></div></div></div></div></div></div></div><div class="row"><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label">Jam Pengambilan</label><div class="row"><div class="col-8"><input type="text" class="form-control" name="waktu" id="time" readonly="readonly"></div><div class="col-2 px-0"><span class="d-flex align-items-center btn btn-danger"><a onclick="mulai()"><i class="fa-regular fa-clock"></i></a></span></div></div></div></div></div></div><div class="border border-dash-gray rounded"><div class="row justify-content-center mt-2"><div class="col-12 text-center"><label class="mb-0">PENGUJIAN CAHAYA</label></div><div class="col-8 d-flex justify-content-between"><label>Total Titik :<span id="total-k"></span></label><label>Titik Ke :<span id="titik_k"></span></label></div></div><div id="pencahayaan"></div></div><div id="btnAksi" class="mb-2"></div><label class="mt-1">Dokumentasi</label><div class="row mb-2"><div class="col-6"><div class="form-group basic"><label class="label label-1 mb-1">Lokasi Sampling<sup>*</sup></label><label for="file1"><span class="btn btn-primary" id="lokasi"><hi class="fa fa-camera"></hi>Ambil Gambar</span><input type="file" id="file1" accept="image/*" capture="environment" style="display:none" onchange="preview_image(1)"></label><textarea id="foto_lok" name="foto_lok" class="d-none"></textarea></div></div><div class="col-6" id="attch"><div class="form-group basic"><label class="label label-1 mb-1">Attachment<sup>*</sup></label><label for="btnShow"><span class="btn btn-primary"><hi class="fa fa-solid fa-pencil"></hi>Draw</span><input type="button" id="btnShow" class="btn btn-primary" onclick="show2()" style="display:none"></label></div></div></div><div class="table_size_chooser mb-2 d-none" id="tblsz"><div class="SizeChooser"><label class="label label-1 mb-1">Denah Titik</label><table id="html-content-holder"><tbody id="tes"></tbody></table><br></div></div><div class="row mb-2"><div class="col-6 d-none" id="resetT"><div class="form-group basic"><label class="label label-1 mb-1">Reset Titik</label><label for="btnReset"><span class="btn btn-primary" id="resetB"><hi class="fa fa-camera"></hi>Reset Titik</span><input type="button" id="btnReset" class="btn btn-primary" onclick="resett2()" style="display:none"></label></div></div><div class="col-6 d-none" id="saveT"><div class="form-group basic"><label class="label label-1 mb-1">Save Draw Titik<sup>*</sup></label><label for="btnConvert"><span class="btn btn-primary" id="lain"><hi class="fa fa-camera"></hi>Save Titik</span><input type="button" id="btnConvert" class="btn btn-primary" onclick="convert2()" style="display:none"></label><textarea id="foto_lain" name="foto_lain" class="d-none"></textarea></div></div></div><div class="mb-2"><label style="border:1px solid #ced4da;padding:5px;border-radius:10px"><input type="checkbox" name="permis" value="1"><span>Data dan Informasi Pengambilan Sampel Ini adalah yang Sebenar-benarnya</span></label></div>';
   </script>