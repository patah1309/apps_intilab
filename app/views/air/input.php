<div id="appCapsule">
   <div class="section mb-5 p-2">
      <form id="form-add" method="POST" action="<?= base_url; ?>/air/saveData">
         <div class="card">
            <div class="card-body pb-1">
               <div class="row">
                  <div class="col-12 text-center">
                     <label for="">FDL Air</label>
                  </div>
               </div>
               <div class="form-group basic">
                  <div class="input-wrapper">
                     <label class="label">No Sample</label>
                     <input type="text" class="form-control" id="no_sample" name="no_sample"
                        placeholder="Masukan No Sample" required>
                     <!-- <input type="hidden" id="id_kat" name="id_kat"> -->
                     <input type="hidden" id="katVal" name="kat_id">
                     <i class="clear-input">
                        <ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle">
                        </ion-icon>
                     </i>
                  </div>
               </div>
               <div id="selectkategori"></div>
               <div id="limbah"></div>
               <div id="foto" class="mt-1"></div>
               <div id="foto2" class="mt-1"></div>
               <div class="row mb-2">
                  <div class="col-6">
                     <div class="form-group basic">
                        <a href="javascript:;" class="btn btn-primary" style="width:100%" onclick="reset()"> Cancel </a>
                     </div>
                  </div>
                  <div class="col-6">
                     <div class="form-group basic">
                        <button class="btn btn-success" type="submit" style="width:100%" id="btn-submit"> Save</button>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </form>
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
let data_kategori = [{
      id: '',
      text: '--Pilih Kategori--'
   },
   {
      id: '5-Laut',
      text: 'Laut'
   },
   {
      id: '4-Minum',
      text: 'Minum'
   },
   {
      id: '92-Rawa',
      text: 'Rawa'
   },
   {
      id: '90-Situ',
      text: 'Situ'
   },
   {
      id: '1-Bersih',
      text: 'Bersih (Air Keperluan Hygiene Sanitasi, Air Khusus RS, Air Dalam Kemasan, Air RO)'
   },
   {
      id: '56-Danau',
      text: 'Danau'
   },
   {
      id: '89-Waduk',
      text: 'Waduk'
   },
   {
      id: '93-Muara',
      text: 'Muara'
   },
   {
      id: '72-Tanah',
      text: 'Tanah (Air Sumur Bor, Air Sumur Gali, Air Sumur Pantek)'
   },
   {
      id: '51-Limbah',
      text: 'Limbah'
   },
   {
      id: '54-Sungai',
      text: 'Sungai'
   },
   {
      id: '64-Khusus',
      text: 'Khusus'
   },
   {
      id: '91-Akuifer',
      text: 'Akuifer'
   },
   {
      id: '6-Permukaan',
      text: 'Permukaan'
   },
   {
      id: '2-Limbah Domestik',
      text: 'Limbah Domestik'
   },
   {
      id: '3-Limbah Industri',
      text: 'Limbah Industri'
   },
   {
      id: '94-Air dari Mata Air',
      text: 'Air dari Mata Air'
   },
]

let uri = '<?= base_url; ?>/assets/sound/';
var success = new Audio(uri + 'success.wav');
var error = new Audio(uri + 'error.mp3');

var getDataSample = function(no_sample) {
   var deffered = $.Deferred()
   $.ajax({
      url: '/public/air/getSampel',
      method: 'POST',
      data: {
         no_sample: no_sample
      },
      success: function(resp) {
         deffered.resolve(resp)
      },
      error: function(err) {
         deffered.reject(err)
      }
   })
   return deffered
}

$("#no_sample").on('keydown', function(e) {

   $('#limbah').html('')
   $('#foto').html('')
   $('#foto2').html('')
   if (e.key === "Enter") {
      let net = $('#status-text').text();
      if (net == "Online") {
         $.when(getDataSample($("#no_sample").val())).then(function(resp) {
            render_template(JSON.parse(resp))
         })
         $('#selectkategori').empty()
      } else {
         $('#selectkategori').empty()
         var html = '<select id="kategori-air" class="form-control"></select>'
         $('#selectkategori').append(html)

         $('#kategori-air').select2({
            data: data_kategori,
            placeholder: 'Select Kategori Air'
         })

         $('#kategori-air').on('change', function() {
            let data_select = $(this).val()
            if (data_select != '') {
               let array_data = {
                  'id_ket': data_select.split('-')[0],
                  'id_ket2': 1,
                  'jenis': data_select.split('-')[1],
                  'keterangan': ''
               }
               render_template(array_data);
            }
         })
      }
      e.preventDefault()
      return false;
   }
});

function render_template(e) {
   if (e.id_ket === '2' || e.id_ket === '3' || e.id_ket === '51') {
      $('#limbah').html(limbah).fadeIn('slow');
      $('#foto').html(foto).fadeIn('slow');
      $('#jenis_sample').val(e.jenis);
      $('#keterangan-1').val(e.keterangan);
      $('#katVal').val(e.id_ket);
      $('#turunan-pengawet').hide();
      $('#btnBawah').hide()
      $('#jenis-pengawet').on('change', function() {
         var e = $('#jenis-pengawet').val();

         if (e.includes('kimia')) {
            $('#turunan-pengawet').show();
         } else {
            $('#turunan-pengawet').hide();
         }
      });
      $('#jam').clockTimePicker();
      $('#jamm').clockTimePicker();
      $('.select2').select2()
      valDecimal();
      $('#selectkategori').empty()
   } else if (e.id_ket === '5') {
      $('#limbah').html(laut).fadeIn('slow');
      $('#foto').html(foto).fadeIn('slow');
      $('#keterangan-1').val(e.keterangan);
      $('#katVal').val(e.id_ket);
      $('#turunan-pengawet').hide();
      $('#turunan-titik-pegambilan').hide();
      $('#btnBawah').hide()
      $('#selectkategori').empty()
      $('#jenis-pengawet').on('change', function() {
         var e = $('#jenis-pengawet').val();

         if (e.includes('kimia')) {
            $('#turunan-pengawet').show();
         } else {
            $('#turunan-pengawet').hide();
         }
      });

      $('#titik_lokasi').on('change', function() {
         if ($('#titik_lokasi').val() == 'Estuari') {
            $('#turunan-titik-pegambilan').show();
            if ($('#kedalaman').val() <= 1) {
               $('#jtpeng').val('0.5 D');
            } else {
               $('#jtpeng').val('0.2 D, 0.5 D, 0.8 D');
            }
         } else if ($('#titik_lokasi').val() == 'Pesisir') {
            $('#turunan-titik-pegambilan').show();
            if ($('#kedalaman').val() >= 0 && $('#kedalaman').val() <= 1) {
               $('#jtpeng').val('0.2 D, 0.5 D, 0.8 D');
            }
         } else {
            $('#turunan-titik-pegambilan').show();
            if ($('#kedalaman').val() <= 100) {
               $('#jtpeng').val('0.2 D, 0.5 D, 0.8 D');
            } else {
               $('#jtpeng').val('0.2 D, 0.4 D, 0.6 D, 0.8 D');
            }
         }

      });

      $('#kedalaman').on('keyup', function() {
         if ($('#titik_lokasi').val() == 'Estuari') {
            $('#turunan-titik-pegambilan').show();
            if ($('#kedalaman').val() <= 1) {
               $('#jtpeng').val('0.5 D');
            } else if ($('#kedalaman').val() > 1) {
               $('#jtpeng').val('0.2 D, 0.5 D, 0.8 D');
            } else {
               $('#jtpeng').val('Kedalaman tidak sesuai');
            }
         } else if ($('#titik_lokasi').val() == 'Pesisir') {
            $('#turunan-titik-pegambilan').show();
            if ($('#kedalaman').val() >= 0 && $('#kedalaman').val() <= 1) {
               $('#jtpeng').val('0.2 D, 0.5 D, 0.8 D');
            } else if ($('#kedalaman').val() > 1) {
               $('#jtpeng').val('Kedalaman tidak sesuai');
            }
         } else if ($('#titik_lokasi').val() == 'Laut_Lepas') {
            $('#turunan-titik-pegambilan').show();
            if ($('#kedalaman').val() >= 1 && $('#kedalaman').val() <= 100) {
               $('#jtpeng').val('0.2 D, 0.5 D, 0.8 D');
            } else if ($('#kedalaman').val() > 100) {
               $('#jtpeng').val('0.2 D, 0.4 D, 0.6 D, 0.8 D');
            } else {
               $('#jtpeng').val('Kedalaman tidak sesuai');
            }
         }

      });

      $('#jam').clockTimePicker();
      $('#jamm').clockTimePicker();

      $("#addRow").click(function() {
         var html = '';
         html += '<div class="mb-2" id="inputFormRow">'
         html += '<div class="row">'
         html += '<div class="col-4">'
         html += '<div class="form-group basic">'
         html += '<div class="input-wrapper">'
         html +=
            '<input type="text" class="form-control jam" name="jam_pengamatan[]" autocomplete="off" readonly>'
         html += '</div></div></div>'
         html += '<div class="col-8">'
         html += '<div class="form-group basic">'
         html += '<div class="input-wrapper">'
         html += '<div class="input-group">'
         html +=
            '<input type="number" class="form-control" name="hasil_pengamatan[]" autocomplete="off" step="any">'
         html += '<div class="input-group-append">'
         html += '<span class="input-group-text" style="font-size: 10px">m</span>'
         html +=
            '<button id="removeRow" type="button" class="btns btn-danger"><i class="fa fa-close"></i></button>'
         html += '</div>'
         html += '</div></div></div>'
         html += '</div>'
         html += '</div>'
         html += '</div>'
         $('#newRow').append(html);
         $('.jam').clockTimePicker();
      });
      $(document).on('click', '#removeRow', function() {
         $(this).closest('#inputFormRow').remove();
      });
      $('.select2').select2()
      valDecimal();
   } else if (e.id_ket === '54' || e.id_ket === '56' || e.id_ket === '89' || e.id_ket ===
      '90' || e.id_ket === '91' || e.id_ket === '92' || e.id_ket === '93' || e.id_ket ===
      '94' || e.id_ket === '6') {
      $('#limbah').html(permukaan).fadeIn('slow');
      $('#foto').html(foto).fadeIn('slow');
      $('#jenis_sample').val(e.jenis);
      $('#keterangan-1').val(e.keterangan);
      $('#katVal').val(e.id_ket);
      $('#turunan-pengawet').hide();
      $('#btnBawah').hide()
      $('#selectkategori').empty()
      $('#jenis-pengawet').on('change', function() {
         var e = $('#jenis-pengawet').val();

         if (e.includes('kimia')) {
            $('#turunan-pengawet').show();
         } else {
            $('#turunan-pengawet').hide();
         }
      });
      $('#jam').clockTimePicker();
      $('#jamm').clockTimePicker();
      $('.select2').select2()
      valDecimal()
   } else if (e.id_ket === '72') {
      $('#limbah').html(tanah).fadeIn('slow');
      $('#foto').html(foto).fadeIn('slow');
      $('#jenis_sample').val(e.jenis);
      $('#keterangan-1').val(e.keterangan);
      $('#katVal').val(e.id_ket);
      $('#turunan-pengawet').hide();
      $('#btnBawah').hide()
      $('#jenis-pengawet').on('change', function() {
         var e = $('#jenis-pengawet').val();

         if (e.includes('kimia')) {
            $('#turunan-pengawet').show();
         } else {
            $('#turunan-pengawet').hide();
         }
      });
      $('#jam').clockTimePicker();
      $('#jamm').clockTimePicker();
      $('.select2').select2();
      valDecimal();
      $('#kedalaman_sumur_kedua').on('change keyup', function() {
         var a = $('#kedalaman_sumur_pertama').val();
         var b = $('#kedalaman_sumur_kedua').val();
         var c = (b - a);
         $('#kedalaman_sumur_terambil').val(c);
      })
      $('#selectkategori').empty()
   } else if (e.id_ket === '1' || e.id_ket === '4') {
      $('#limbah').html(airBersih).fadeIn('slow');
      $('#foto').html(foto).fadeIn('slow');
      $('#jenis_sample').val(e.jenis);
      $('#keterangan-1').val(e.keterangan);
      $('#katVal').val(e.id_ket);
      $('#turunan-pengawet').hide();
      $('#btnBawah').hide()
      $('#jenis-pengawet').on('change', function() {
         var e = $('#jenis-pengawet').val();

         if (e.includes('kimia')) {
            $('#turunan-pengawet').show();
         } else {
            $('#turunan-pengawet').hide();
         }
      });

      $('#jam').clockTimePicker();
      $('#jamm').clockTimePicker();
      $('.select2').select2()
      valDecimal();
      $('#selectkategori').empty()
   } else if (e.id_ket === '64') {
      $('#limbah').html(khusus).fadeIn('slow');
      $('#foto').html(foto).fadeIn('slow');
      $('#jenis_sample').val(e.jenis);
      $('#keterangan-1').val(e.keterangan);
      $('#katVal').val(e.id_ket);
      $('#turunan-pengawet').hide();
      $('#btnBawah').hide()
      $('#jenis-pengawet').on('change', function() {
         var e = $('#jenis-pengawet').val();

         if (e.includes('kimia')) {
            $('#turunan-pengawet').show();
         } else {
            $('#turunan-pengawet').hide();
         }
      });

      $('#jam').clockTimePicker();
      $('#jamm').clockTimePicker();
      $('.select2').select2()
      valDecimal();
      $('#selectkategori').empty()
   } else {
      error.play();
      Swal.fire({
         title: 'Tidak ada kategori FDL air di No Sample tersebut',
         icon: 'warning',
         confirmButtonColor: '#3085d6',
      })
      $('#limbah').empty();
      $('#selectkategori').empty()
   }
}

function valDecimal() {
   var p = 100;
   // $('#volume').empty();
   var htm = '<select class="form-control" name="volume"><option>Select</option>'
   for (q = 1; q <= p; q++) {
      var nn = q * 100;
      htm += '<option value="' + nn + '">' + nn + '</option>'
   }
   htm += '</select>';

   $('#volume').html(htm);

   $(".selInput").select2({
      tags: true
   });
   $('#sel_debit').change(function() {
      var status_deb = $('#sel_debit').val();
      $('#input_deb').empty()
      $('#opt_deb_cust').empty()
      $('#data_by_cust').empty()
      if (status_deb == 'Input Data') {
         $('#satDebit').show();
         var aa = '<div class="form-group basic">'
         aa += '<div class="input-wrapper">'
         aa += '<label class="label label-1" for="modalInputusername">Debit Air</label>'
         aa += '<div class="input-group">'
         aa +=
            '<input type="number" class="form-control" name="debit_air" id="debit" autocomplete="off" step="0.01" required>'
         aa += '</div>'
         aa +=
            '<span class="text-danger text-bold" id="valdebit" style="font-size:10px;display:none">Ex. 14.00</span>'
         aa +=
            '<span class="text-success" id="cekdebit" style="font-size:10px;display:none">Desimal sesuai</span>'
         aa += '</div>'
         $('#input_deb').append(aa)
      } else if (status_deb == 'Data By Customer') {
         $('#satDebit').hide();
         var ab = '<div class="form-group basic">'
         ab += '<div class="input-wrapper">'
         ab += '<label class="label label-1" for="modalInputusername">Data By Customer</label>'
         ab += '<select class="form-control" id="sel_data_by_cust" name="sel_data_by_cust">'
         ab += '<option>-</option>'
         ab += '<option value="Email">Email</option>'
         ab += '<option value="Input Data">Input Data</option>'
         ab += '</select>'
         ab += '</div>'
         ab += '</div>'
         $(".selInput").select2({
            tags: true
         });
         $('#opt_deb_cust').append(ab)
      } else {
         $('#satDebit').hide();
         $('#input_deb').empty()
         $('#opt_deb_cust').empty()
         $('#data_by_cust').empty()
      }
      $('#sel_data_by_cust').change(function() {
         var sel_data_by_cust = $('#sel_data_by_cust').val();
         if (sel_data_by_cust == 'Input Data') {
            var ac = '<div class="form-group basic">'
            ac += '<div class="input-wrapper">'
            ac += '<label class="label label-1" for="modalInputusername">Debit Air</label>'
            ac += '<div class="input-group">'
            ac +=
               '<input type="number" class="form-control" name="debit_air_by_cust" id="debit_air_by_cust" autocomplete="off" step="0.01" required>'
            ac += '<div class="input-group-append" style="font-size:10px">'
            ac +=
               '<select class="form-control" name="satuan_debit_by_cust" style="font-size:10px">'
            ac += '<option value="mL/detik" style="font-size:10px">mL/detik</option>'
            ac += '<option value="L/detik" style="font-size:10px">L/detik</option>'
            ac += '<option value="L/jam" style="font-size:10px">L/jam</option>'
            ac += '<option value="L/hari" style="font-size:10px">L/hari</option>'
            ac += '</select>'
            ac += '</div>'
            ac += '</div>'
            ac +=
               '<span class="text-danger text-bold" id="valdebit_by_cust" style="font-size:10px;display:none">Ex. 14.00</span>'
            ac +=
               '<span class="text-success" id="cekdebit_by_cust" style="font-size:10px;display:none">Desimal sesuai</span>'
            ac += '</div>'
            ac += '</div>'
            $('#data_by_cust').append(ac)
         } else {
            $('#data_by_cust').empty()
         }
         $("#debit_air_by_cust").on('keyup', function() {
            var ul1 = $("#debit_air_by_cust").val();
            if (ul1 !== ".") {
               $('#valdebit_by_cust').show();
               $('#cekdebit_by_cust').hide();
            }
            if (ul1.includes('.')) {
               ul1 = $("#debit_air_by_cust").val();
               var nil2 = ul1.toString().split(".")[1].length;
               if (nil2 > 1) {
                  $('#valdebit_by_cust').hide();
                  $('#cekdebit_by_cust').show();
               }
               if (nil2 > 2) {
                  $('#valdebit_by_cust').show();
                  $('#cekdebit_by_cust').hide();
               }
            }
         })
      })
      $("#debit").on('keyup', function() {
         var ul1 = $("#debit").val();
         if (ul1 !== ".") {
            $('#valdebit').show();
         }
         if (ul1.includes('.')) {
            ul1 = $("#debit").val();
            var nil2 = ul1.toString().split(".")[1].length;
            if (nil2 > 1) {
               $('#valdebit').hide();
            }
            if (nil2 > 2) {
               $('#valdebit').show();
            }
         }
      })
   })

   $("#klor").on('keyup', function() {
      var ul1 = $("#klor").val();
      if (ul1 !== ".") {
         $('#valklor').show();
      }
      if (ul1.includes('.')) {
         ul1 = $("#klor").val();
         var nil2 = ul1.toString().split(".")[1].length;
         if (nil2 > 1) {
            $('#valklor').hide();
         }
         if (nil2 > 2) {
            $('#valklor').show();
         }
      }
   })

   $("#ph").on('keyup', function() {
      var ul1 = $("#ph").val();
      if (ul1 !== ".") {
         $('#valph').show();
      }
      if (ul1.includes('.')) {
         ul1 = $("#ph").val();
         var nil2 = ul1.toString().split(".")[1].length;
         if (nil2 > 1) {
            $('#valph').hide();
         }
         if (nil2 > 2) {
            $('#valph').show();
         }
      }
   })

   $("#do").on('keyup', function() {
      var ul1 = $("#do").val();
      if (ul1 !== ".") {
         $('#valdo').show();
      }
      if (ul1.includes('.')) {
         ul1 = $("#do").val();
         var nil2 = ul1.toString().split(".")[1].length;
         if (nil2 == 1) {
            $('#valdo').hide();
         }
         if (nil2 > 1) {
            $('#valdo').show();
         }
      }
   })

   $("#dhl").on('keyup', function() {
      var ul1 = $("#dhl").val();
      if (ul1 !== ".") {
         $('#valdhl').show();
      }
      if (ul1.includes('.')) {
         ul1 = $("#dhl").val();
         var nil2 = ul1.toString().split(".")[1].length;
         if (nil2 == 1) {
            $('#valdhl').hide();
         }
         if (nil2 > 1) {
            $('#valdhl').show();
         }
      }
   })

   $("#suhuAir").on('keyup', function() {
      var ul1 = $("#suhuAir").val();
      if (ul1 !== ".") {
         $('#valsuhuAir').show();
      }
      if (ul1.includes('.')) {
         ul1 = $("#suhuAir").val();
         var nil2 = ul1.toString().split(".")[1].length;
         if (nil2 == 1) {
            $('#valsuhuAir').hide();
         }
         if (nil2 > 1) {
            $('#valsuhuAir').show();
         }
      }
   })

   $("#suhuUdara").on('keyup', function() {
      var ul1 = $("#suhuUdara").val();
      if (ul1 !== ".") {
         $('#valsuhuUdara').show();
      }
      if (ul1.includes('.')) {
         ul1 = $("#suhuUdara").val();
         var nil2 = ul1.toString().split(".")[1].length;
         if (nil2 == 1) {
            $('#valsuhuUdara').hide();
         }
         if (nil2 > 1) {
            $('#valsuhuUdara').show();
         }
      }
   })
}

function mulai() {
   var date = new Date();
   jam = date.getHours();
   jam = ("0" + jam).slice(-2);
   menit = date.getMinutes();
   menit = ("0" + menit).slice(-2);
   $('#jam').val(jam + ":" + menit);
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
   if ($("input[name=permis]").is(':checked')) {
      if ($("#lokasi").hasClass("sukses") && $("#sample").hasClass("sukses") && $("#lain").hasClass("sukses")) {
         // $('#btn-submit').prop('disabled', true);
         $.ajax({
            statusCode: {
               500: function() {
                  Swal.fire({
                     icon: 'error',
                     title: 'Server Error',
                     timer: 3000
                  })
                  // $('#btn-submit').prop('disabled', false);
               }
            },
            url: '/public/air/saveData',
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
                  document.getElementById("lain").style.setProperty("border-color", "#00B4FF",
                     "important");
                  $('#limbah').empty();
                  $('#foto').empty();
                  $('#foto2').empty();
                  $('#btnBawah').show()
               } else {
                  Swal.fire({
                     icon: 'error',
                     title: 'Opps..!',
                     text: 'Please Check the Data.',
                     timer: 3000
                  })
                  // $('#btn-submit').prop('disabled', false);
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
            title: 'Foto lokasi, Foto sample, Foto lain-lain wajib ada.!',
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

var foto2 =
   '<label class="mt-1">Dokumentasi 2</label><div class="row"><div class="col-4"><div class="form-group basic"><label class="label label-1 mb-1">Lokasi Sampling<sup>*</sup></label><label for="file1"><span class="btn btn-primary" id="lokasi" onclick="configure(1)"><i class="fa fa-camera"></i>Ambil Gambar</span></label><textarea id="foto_lok" name="foto_lok" class="d-none"></textarea></div></div><div class="col-4"><div class="form-group basic"><label class="label label-1 mb-1">Kondisi Sample<sup>*</sup></label><label for="file2"><span class="btn btn-primary" id="sample" onclick="configure(2)"><i class="fa fa-camera"></i>Ambil Gambar</span></label><textarea id="foto_sampl" name="foto_sampl" class="d-none"></textarea></div></div><div class="col-4"><div class="form-group basic"><label class="label label-1 mb-1">Foto Lain - Lain</label><label for="file3"><span class="btn btn-primary" id="lain" onclick="configure(3)"><i class="fa fa-camera"></i>Ambil Gambar</span></label><textarea id="foto_lain" name="foto_lain" class="d-none"></textarea></div></div></div><div class="row"><div class="col-6"><div class="form-group basic"><label class="label label-1 mb-1">Tidak bisa buka kamera</label><label for="file3"><span class="btn btn-info" id="bukaas" onclick="bukaCam1()"><i class="fa fa-camera"></i>Buka Kamera 1</span></label></div></div></div><div class="mb-2"><label style="margin-top:20px;border:1px solid #ced4da;padding:5px;border-radius:10px;font-size:14px"><input type="checkbox" name="permis" value="1"><span style="margin-left:12px">Data dan Informasi Pengambilan Sampel Ini adalah yang Sebenar-benarnya</span></label></div>';

var foto =
   '<canvas class="d-none" id="canvas"></canvas><label class="mt-1">Dokumentasi</label><div class="row"><div class="col-4"><div class="form-group basic"><label class="label label-1 mb-1">Lokasi Sampling<sup>*</sup></label><label for="file1"><span class="btn btn-primary" id="lokasi"><i class="fa fa-camera"></i>Ambil Gambar</span><input type="file" id="file1" accept="image/*" capture @change="setImage" style="display:none" onchange="preview_image(1)"></label><textarea id="foto_lok" name="foto_lok" class="d-none"></textarea></div></div><div class="col-4"><div class="form-group basic"><label class="label label-1 mb-1">Kondisi Sample<sup>*</sup></label><label for="file2"><span class="btn btn-primary" id="sample"><i class="fa fa-camera"></i>Ambil Gambar</span><input type="file" id="file2" accept="image/*" capture @change="setImage" style="display:none" onchange="preview_image(2)"></label><textarea id="foto_sampl" name="foto_sampl" class="d-none"></textarea></div></div><div class="col-4"><div class="form-group basic"><label class="label label-1 mb-1">Foto Lain - Lain</label><label for="file3"><span class="btn btn-primary" id="lain"><i class="fa fa-camera"></i>Ambil Gambar</span><input type="file" id="file3" accept="image/*" capture @change="setImage" style="display:none" onchange="preview_image(3)"></label><textarea id="foto_lain" name="foto_lain" class="d-none"></textarea></div></div></div><div class="row"><div class="col-6"><div class="form-group basic"><label class="label label-1 mb-1">Tidak bisa buka kamera</label><label for="file3"><span class="btn btn-danger" id="bukaas" onclick="bukaCam()"><i class="fa fa-camera"></i>Buka Kamera 2</span></label></div></div></div><div class="mb-2"><label style="margin-top:20px;border:1px solid #ced4da;padding:5px;border-radius:10px;font-size:14px"><input type="checkbox" name="permis" value="1"><span style="margin-left:12px">Data dan Informasi Pengambilan Sampel Ini adalah yang Sebenar-benarnya</span></label></div>';

function bukaCam() {
   $('#foto').empty();
   $('#foto2').html(foto2);
}

function bukaCam1() {
   $('#foto2').empty();
   $('#foto').html(foto);
}

var khusus =
   '<div class="mb-2"><div class="row"><div class="col-sm-12"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1">Penamaan Titik</label><input type="text" name="keterangan_1" id="keterangan-1" class="form-control" autocomplete="off"></div></div></div></div></div><div class="mb-2"><div class="row"><div class="col-sm-12"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1">Penamaan Tambahan</label><textarea class="form-control rounded" name="information"></textarea></div></div></div></div></div><div class="form-group basic"><div class="row"><div class="col-sm-12"><label class="label label-1">Titik Koordinat Sampling</label><div class="input-groups input-group-sm mb-2"><input type="hidden" name="lat" id="lat"> <input type="hidden" name="longi" id="longi"><div class="row"><div class="col-8"><input type="text" class="form-control" name="posisi" id="posisi" autocomplete="off" style="font-size:12px" required></div><div class="col-4"><span class="input-group-prepends" style="width:30%"><a class="btn btn-info" onclick="getlocation()"><i class="fa-solid fa-location-dot"></i> Get Location</a></span></div></div></div></div></div></div><div class="mb-2 row"><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Teknik Sampling</label><select class="form-control" name="teknik_sampling"><option value="Sesaat">Sesaat</option><option value="Gabungan_Waktu">Gabungan Waktu</option><option value="Gabungan_Tempat">Gabungan Tempat</option></select></div></div></div><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1">Jam Pengambilan</label><div class="row"><div class="col-8"><input type="text" class="form-control" name="jam" id="jam" readonly="readonly"></div><div class="col-2 px-0"><span class="d-flex align-items-center btn btn-danger"><a onclick="mulai()"><i class="fa-regular fa-clock"></i></a></span></div></div></div></div></div></div><div class="mb-2"><div class="row"><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Volume (ml)</label><select class="form-control" id="volume" name="volume" required></select></div></div></div><div class="form-group basic"><div class="input-wrapper"><label>Jenis Pengawet</label><select class="form-control select2" name="parent_pengawet[]" id="jenis-pengawet" multiple="multiple" data-placeholder="Pilih jenis Pengawet" style="width:100%" required><option value="fisika">Fisika</option><option value="kimia">Kimia</option></select></div></div></div></div><div class="mb-2" id="turunan-pengawet"><label class="label label-1" for="modalInputusername">Jenis Pengawet</label><div class="row"><div class="col-sm-3"><label><input type="checkbox" name="jenis_pengawet[]" id="iCheck1" value="H2SO4"><span>H2SO4</span></label></div><div class="col-sm-3"><label><input type="checkbox" name="jenis_pengawet[]" id="iCheck2" value="HNO3"><span>HNO3</span></label></div><div class="col-sm-3"><label><input type="checkbox" name="jenis_pengawet[]" id="iCheck3" value="HCI"><span>HCI</span></label></div><div class="col-sm-3"><label><input type="checkbox" name="jenis_pengawet[]" id="iCheck4" value="NaOH"><span>NaOH</span></label></div></div></div><div class="mb-2"><div class="row"><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Perlakuan Penyaringan</label><select class="form-control" name="penyaringan" id="penyaringan" required><option value="">-</option><option value="Ada">Ada</option><option value="Tidak_Ada">Tidak Ada</option></select></div></div></div><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Pengendalian Mutu</label><select class="form-control select2" name="mutu[]" multiple="multiple" data-placeholder="Pilih Pengendalian Mutu" style="width:100%"><option value="Split">Split</option><option value="Duplikat">Duplikat</option><option value="Blangko_Media">Blangko Media</option><option value="Blangko_Perjalanan">Blangko Perjalanan</option></select></div></div></div></div></div><div class="mb-2"><div class="row"><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">DHL</label><div class="input-group"><input type="number" class="form-control" name="dhl" id="dhl" autocomplete="off" step="0.1" required><div class="input-group-append"><span class="input-group-text" style="font-size:10px">µS/cm</span></div></div><span class="text-danger text-bold" id="valdhl" style="font-size:10px;display:none">Ex. 14.0</span></div></div></div><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">pH</label><input type="number" class="form-control" name="ph" id="ph" autocomplete="off" step="0.01" required></div><span class="text-danger text-bold" id="valph" style="font-size:10px;display:none">Ex. 14.00</span></div></div></div></div><div class="mb-2"><div class="row"><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Suhu Air</label><div class="input-group"><input type="number" class="form-control" id="suhuAir" name="suhu_air" autocomplete="off" step="0.1" required><div class="input-group-append"><span class="input-group-text" style="font-size:10px">°C</span></div></div><span class="text-danger text-bold" id="valsuhuAir" style="font-size:10px;display:none">Ex. 14.0</span></div></div></div><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Suhu Udara</label><div class="input-group"><input type="number" class="form-control" id="suhuUdara" name="suhu_udara" autocomplete="off" step="0.1" required><div class="input-group-append"><span class="input-group-text" style="font-size:10px">°C</span></div></div><span class="text-danger text-bold" id="valsuhuUdara" style="font-size:10px;display:none">Ex. 14.0</span></div></div></div></div></div><div class="mb-2"><div class="row"><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Warna</label><select class="form-control" name="warna" id="warna" required><option value="">-</option><option value="Berwarna">Berwarna</option><option value="Tidak Berwarna">Tidak Berwarna</option></select></div></div></div><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Bau</label><select class="form-control" name="bau" id="bau" required><option value="">-</option><option value="Berbau">Berbau</option><option value="Tidak Berbau">Tidak Berbau</option></select></div></div></div></div></div>';
var airBersih =
   '<div class="row mb-2"><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1">Jenis Sample</label><select name="jenis_sample" class="form-control" id="jenis_sample" autocomplete="off"><option>Air Keperluan Hygiene Sanitasi</option><option>Air Khusus RS</option><option>Air Dalam Kemasan</option><option>Air RO</option></select></div></div></div></div><div class="mb-2"><div class="row"><div class="col-sm-12"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1">Penamaan Titik</label><input type="text" name="keterangan_1" id="keterangan-1" class="form-control" autocomplete="off"></div></div></div></div></div><div class="mb-2"><div class="row"><div class="col-sm-12"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1">Penamaan Tambahan</label><textarea class="form-control rounded" name="information"></textarea></div></div></div></div></div><div class="row"><div class="col-sm-12"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1">Titik Koordinat Sampling</label><div class="input-groups input-group-sm mb-2"><input type="hidden" name="lat" id="lat"> <input type="hidden" name="longi" id="longi"><div class="row"><div class="col-8"><input type="text" class="form-control" name="posisi" id="posisi" required autocomplete="off" style="font-size:12px" required></div><div class="col-4"><span class="input-group-prepends" style="width:30%"><a class="btn btn-info" onclick="getlocation()"><i class="fa-solid fa-location-dot"></i> Get Location</a></span></div></div></div></div></div></div></div><div class="mb-2 row"><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Teknik Sampling</label><select class="form-control" name="teknik_sampling"><option value="Sesaat">Sesaat</option><option value="Gabungan_Waktu">Gabungan Waktu</option><option value="Gabungan_Tempat">Gabungan Tempat</option></select></div></div></div><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1">Jam Pengambilan</label><div class="row"><div class="col-8"><input type="text" class="form-control" name="jam" id="jam" readonly="readonly"></div><div class="col-2 px-0"><span class="d-flex align-items-center btn btn-danger"><a onclick="mulai()"><i class="fa-regular fa-clock"></i></a></span></div></div></div></div></div></div><div class="mb-2"><div class="row"><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Volume (ml)</label><select class="form-control" id="volume" name="volume" required></select></div></div></div><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label>Jenis Pengawet</label><select class="form-control select2" name="parent_pengawet[]" id="jenis-pengawet" multiple="multiple" data-placeholder="Pilih jenis Pengawet" style="width:100%" required><option value="fisika">Fisika</option><option value="kimia">Kimia</option></select></div></div></div></div></div><div class="mb-2" id="turunan-pengawet"><label class="label label-1" for="modalInputusername">Jenis Pengawet</label><div class="row"><div class="col-sm-3"><label><input type="checkbox" name="jenis_pengawet[]" id="iCheck1" value="H2SO4"><span>H2SO4</span></label></div><div class="col-sm-3"><label><input type="checkbox" name="jenis_pengawet[]" id="iCheck2" value="HNO3"><span>HNO3</span></label></div><div class="col-sm-3"><label><input type="checkbox" name="jenis_pengawet[]" id="iCheck3" value="HCI"><span>HCI</span></label></div><div class="col-sm-3"><label><input type="checkbox" name="jenis_pengawet[]" id="iCheck4" value="NaOH"><span>NaOH</span></label></div></div></div><div class="mb-2"><div class="row"><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Perlakuan Penyaringan</label><select class="form-control" name="penyaringan " id="penyaringan" required><option value="">-</option><option value="Ada">Ada</option><option value="Tidak_Ada">Tidak Ada</option></select></div></div></div><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Pengendalian Mutu</label><select class="form-control select2" name="mutu[]" multiple="multiple" data-placeholder="Pilih Pengendalian Mutu" style="width:100%"><option value="Split">Split</option><option value="Duplikat">Duplikat</option><option value="Blangko_Media">Blangko Media</option><option value="Blangko_Perjalanan">Blangko Perjalanan</option></select></div></div></div></div></div><div class="mb-2"><div class="row"><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">DHL</label><div class="input-group"><input type="number" class="form-control" name="dhl" id="dhl" autocomplete="off" step="0.1" required><div class="input-group-append"><span class="input-group-text" style="font-size:10px">µS/cm</span></div></div><span class="text-danger text-bold" id="valdhl" style="font-size:10px;display:none">Ex. 14.0</span></div></div></div><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">pH</label><input type="number" class="form-control" name="ph" id="ph" autocomplete="off" step="0.01" required></div><span class="text-danger text-bold" id="valph" style="font-size:10px;display:none">Ex. 14.00</span></div></div></div></div><div class="mb-2"><div class="row"><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Suhu Air</label><div class="input-group"><input type="number" class="form-control" id="suhuAir" name="suhu_air" autocomplete="off" step="0.1" required><div class="input-group-append"><span class="input-group-text" style="font-size:10px">°C</span></div></div><span class="text-danger text-bold" id="valsuhuAir" style="font-size:10px;display:none">Ex. 14.0</span></div></div></div><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Suhu Udara</label><div class="input-group"><input type="number" class="form-control" id="suhuUdara" name="suhu_udara" autocomplete="off" step="0.1" required><div class="input-group-append"><span class="input-group-text" style="font-size:10px">°C</span></div></div><span class="text-danger text-bold" id="valsuhuUdara" style="font-size:10px;display:none">Ex. 14.0</span></div></div></div></div></div><div class="mb-2"><div class="row"><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Warna</label><select class="form-control" name="warna" id="warna" required><option value="">-</option><option value="Berwarna">Berwarna</option><option value="Tidak Berwarna">Tidak Berwarna</option></select></div></div></div><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Bau</label><select class="form-control" name="bau" id="bau" required><option value="">-</option><option value="Berbau">Berbau</option><option value="Tidak Berbau">Tidak Berbau</option></select></div></div></div></div></div>';
var tanah =
   '<div class="row mb-2"><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1">Jenis Sample</label><select name="jenis_sample" class="form-control" id="jenis_sample" autocomplete="off"><option>Air Sumur Bor</option><option>Air Sumur Gali</option><option>Air Sumur Pantek</option></select></div></div></div></div><div class="mb-2"><div class="form-group basic"><div class="input-wrapper"><label>Jenis Fungsi Air</label><select name="jenis_fungsi[]" class="select2" multiple="multiple" data-placeholder="Pilih jenis fungsi air" style="width:100%"><option>Air Pemantauan Pencemaran Pertanian</option><option>Air Pemantauan Pencemaran Industri</option><option>Air Pemantauan Pencemaran Industri Air Laut</option><option>Air Sumber Keperluan Sehari-hari</option></select></div></div></div><div class="mb-2"><div class="row"><div class="col-sm-12"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1">Penamaan Titik</label><input type="text" name="keterangan_1" id="keterangan-1" class="form-control" autocomplete="off"></div></div></div></div></div><div class="mb-2"><div class="row"><div class="col-sm-12"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1">Penamaan Tambahan</label><textarea class="form-control rounded" name="information"></textarea></div></div></div></div></div><div class="mb-2"><div class="row"><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Diameter Dalam Sumur</label><div class="input-group"><input type="number" class="form-control" name="diameter_sumur" autocomplete="off" step="any"><div class="input-group-append"><span class="input-group-text" style="font-size:10px">m</span></div></div></div></div></div><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Kedalaman Sumur Pertama</label><div class="input-group"><input type="number" class="form-control" name="kedalaman_sumur_pertama" id="kedalaman_sumur_pertama" autocomplete="off" step="any"><div class="input-group-append"><span class="input-group-text" style="font-size:10px">m</span></div></div></div></div></div></div></div><div class="mb-2"><div class="row"><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Kedalaman Sumur Kedua</label><div class="input-group"><input type="number" class="form-control" name="kedalaman_sumur_kedua" id="kedalaman_sumur_kedua" autocomplete="off" step="any"><div class="input-group-append"><span class="input-group-text" style="font-size:10px">m</span></div></div></div></div></div><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Kedalaman Air Terambil</label><div class="input-group"><input type="number" class="form-control" name="kedalaman_sumur_terambil" id="kedalaman_sumur_terambil" autocomplete="off" readonly="readonly"><div class="input-group-append"><span class="input-group-text" style="font-size:10px">m</span></div></div></div></div></div></div></div><div class="mb-2"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Total Waktu Pengambilan</label><div class="input-group"><input type="number" class="form-control" name="total_waktu" id="total_waktu" autocomplete="off" step="any"><div class="input-group-append"><span class="input-group-text" style="font-size:10px">detik</span></div></div></div></div></div><div class="row"><div class="col-sm-12"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1">Titik Koordinat Sampling</label><div class="input-groups input-group-sm mb-2"><input type="hidden" name="lat" id="lat"> <input type="hidden" name="longi" id="longi"><div class="row"><div class="col-8"><input type="text" class="form-control" name="posisi" id="posisi" autocomplete="off" style="font-size:12px" required></div><div class="col-4"><span class="input-group-prepends" style="width:30%"><a class="btn btn-info" onclick="getlocation()"><i class="fa-solid fa-location-dot"></i> Get Location</a></span></div></div></div></div></div></div></div><div class="mb-2 row"><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Teknik Sampling</label><select class="form-control" name="teknik_sampling"><option value="Sesaat">Sesaat</option><option value="Gabungan_Waktu">Gabungan Waktu</option><option value="Gabungan_Tempat">Gabungan Tempat</option></select></div></div></div><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1">Jam Pengambilan</label><div class="row"><div class="col-8"><input type="text" class="form-control" name="jam" id="jam" readonly="readonly"></div><div class="col-2 px-0"><span class="d-flex align-items-center btn btn-danger"><a onclick="mulai()"><i class="fa-regular fa-clock"></i></a></span></div></div></div></div></div></div><div class="mb-2"><div class="row"><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Volume (ml)</label><select class="form-control" id="volume" name="volume" required></select></div></div></div><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label>Jenis Pengawet</label><select class="form-control select2" name="parent_pengawet[]" id="jenis-pengawet" multiple="multiple" data-placeholder="Pilih jenis Pengawet" style="width:100%"><option value="fisika">Fisika</option><option value="kimia">Kimia</option></select></div></div></div></div></div><div class="mb-2" id="turunan-pengawet"><label class="label label-1" for="modalInputusername">Jenis Pengawet</label><div class="row"><div class="col-sm-3"><label><input type="checkbox" name="jenis_pengawet[]" id="iCheck1" value="H2SO4"><span>H2SO4</span></label></div><div class="col-sm-3"><label><input type="checkbox" name="jenis_pengawet[]" id="iCheck2" value="HNO3"><span>HNO3</span></label></div><div class="col-sm-3"><label><input type="checkbox" name="jenis_pengawet[]" id="iCheck3" value="HCI"><span>HCI</span></label></div><div class="col-sm-3"><label><input type="checkbox" name="jenis_pengawet[]" id="iCheck4" value="NaOH"><span>NaOH</span></label></div></div></div><div class="mb-2"><div class="row"><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Perlakuan Penyaringan</label><select class="form-control" name="penyaringan" id="penyaringan" required><option value="">-</option><option value="Ada">Ada</option><option value="Tidak_Ada">Tidak Ada</option></select></div></div></div><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Pengendalian Mutu</label><select class="form-control select2" name="mutu[]" multiple="multiple" data-placeholder="Pilih Pengendalian Mutu" style="width:100%"><option value="Split">Split</option><option value="Duplikat">Duplikat</option><option value="Blangko_Media">Blangko Media</option><option value="Blangko_Perjalanan">Blangko Perjalanan</option></select></div></div></div></div></div><div class="mb-2"><div class="row"><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">DO</label><div class="input-group"><input type="number" class="form-control" name="do" id="do" autocomplete="off" step="any"><div class="input-group-append"><span class="input-group-text" style="font-size:10px">mg/L</span></div></div><span class="text-danger text-bold" id="valdo" style="font-size:10px;display:none">Ex. 14.0</span></div></div></div><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">pH</label><input type="number" class="form-control" name="ph" id="ph" autocomplete="off" step="0.01" min="0.00" max="14.00" required></div><span class="text-danger text-bold" id="valph" style="font-size:10px;display:none">Ex. 14.00</span></div></div></div></div><div class="mb-2"><div class="row"><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Suhu Air</label><div class="input-group"><input type="number" class="form-control" id="suhuAir" name="suhu_air" autocomplete="off" step="0.1" required><div class="input-group-append"><span class="input-group-text" style="font-size:10px">°C</span></div></div><span class="text-danger text-bold" id="valsuhuAir" style="font-size:10px;display:none">Ex. 14.0</span></div></div></div><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Suhu Udara</label><div class="input-group"><input type="number" class="form-control" id="suhuUdara" name="suhu_udara" autocomplete="off" step="0.1" required><div class="input-group-append"><span class="input-group-text" style="font-size:10px">°C</span></div></div><span class="text-danger text-bold" id="valsuhuUdara" style="font-size:10px;display:none">Ex. 14.0</span></div></div></div></div></div><div class="mb-2"><div class="row"><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">DHL</label><div class="input-group"><input type="number" class="form-control" name="dhl" id="dhl" autocomplete="off" step="0.1" required><div class="input-group-append"><span class="input-group-text" style="font-size:10px">µS/cm</span></div></div><span class="text-danger text-bold" id="valdhl" style="font-size:10px;display:none">Ex. 14.0</span></div></div></div></div></div><div class="mb-2"><div class="row"><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Warna</label><select class="form-control" name="warna" id="warna" required><option value="">-</option><option value="Berwarna">Berwarna</option><option value="Tidak Berwarna">Tidak Berwarna</option></select></div></div></div><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Bau</label><select class="form-control" name="bau" id="bau" required><option value="">-</option><option value="Berbau">Berbau</option><option value="Tidak Berbau">Tidak Berbau</option></select></div></div></div></div></div>';
var laut =
   '<div class="mb-2"><div class="row"><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Kedalaman Titik Samping</label><div class="input-group"><input type="number" class="form-control" name="kedalaman" id="kedalaman" autocomplete="off" step="any" required><div class="input-group-append"><span class="input-group-text" style="font-size:10px">m</span></div></div></div></div></div><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Lokasi Titik Pengambilan</label><select class="form-control" name="titik_lokasi" id="titik_lokasi"><option>-</option><option value="Estuari">Estuari</option><option value="Pesisir">Pesisir</option><option value="Laut_Lepas">Laut Lepas</option></select></div></div></div></div></div><div class="mb-2" id="turunan-titik-pegambilan"><div class="row"><div class="col-sm-12"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1">Jumlah Titik Pengambilan</label><input type="text" name="jtpeng" id="jtpeng" class="form-control" autocomplete="off" readonly="readonly"></div></div></div></div></div><div class="mb-2"><div class="row"><div class="col-sm-12"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1">Penamaan Titik</label><input type="text" name="keterangan_1" id="keterangan-1" class="form-control" autocomplete="off"></div></div></div></div></div><div class="mb-2"><div class="row"><div class="col-sm-12"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1">Penamaan Tambahan</label><textarea class="form-control rounded" name="information"></textarea></div></div></div></div></div><div class="row"><div class="col-sm-12"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1">Titik Koordinat Sampling</label><div class="input-groups input-group-sm mb-2"><input type="hidden" name="lat" id="lat"> <input type="hidden" name="longi" id="longi"><div class="row"><div class="col-8"><input type="text" class="form-control" name="posisi" id="posisi" required autocomplete="off" style="font-size:12px" required></div><div class="col-4"><span class="input-group-prepends" style="width:30%"><a class="btn btn-info" onclick="getlocation()"><i class="fa-solid fa-location-dot"></i> Get Location</a></span></div></div></div></div></div></div></div><div class="mb-2 row"><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Teknik Sampling</label><select class="form-control" name="teknik_sampling"><option value="Sesaat">Sesaat</option><option value="Gabungan_Kedalaman">Gabungan Kedalaman</option></select></div></div></div><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1">Jam Pengambilan</label><div class="row"><div class="col-8"><input type="text" class="form-control" name="jam" id="jam" readonly="readonly"></div><div class="col-2 px-0"><span class="d-flex align-items-center btn btn-danger"><a onclick="mulai()"><i class="fa-regular fa-clock"></i></a></span></div></div></div></div></div></div><div class="mb-2"><div class="row"><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Volume (ml)</label><select class="form-control" id="volume" name="volume" required></select></div></div></div><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label>Jenis Pengawet</label><select class="form-control select2" name="parent_pengawet[]" id="jenis-pengawet" multiple="multiple" data-placeholder="Pilih jenis Pengawet" style="width:100%"><option value="fisika">Fisika</option><option value="kimia">Kimia</option></select></div></div></div></div></div><div class="mb-2" id="turunan-pengawet"><label class="label label-1" for="modalInputusername">Jenis Pengawet</label><div class="row"><div class="col-sm-3"><label><input type="checkbox" name="jenis_pengawet[]" id="iCheck1" value="H2SO4"><span>H2SO4</span></label></div><div class="col-sm-3"><label><input type="checkbox" name="jenis_pengawet[]" id="iCheck2" value="HNO3"><span>HNO3</span></label></div><div class="col-sm-3"><label><input type="checkbox" name="jenis_pengawet[]" id="iCheck3" value="HCI"><span>HCI</span></label></div><div class="col-sm-3"><label><input type="checkbox" name="jenis_pengawet[]" id="iCheck4" value="NaOH"><span>NaOH</span></label></div></div></div><div class="mb-2"><div class="row"><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Perlakuan Penyaringan</label><select class="form-control" name="penyaringan" id="penyaringan" required><option value="">-</option><option value="Ada">Ada</option><option value="Tidak_Ada">Tidak Ada</option></select></div></div></div><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Pengendalian Mutu</label><select class="form-control select2" name="mutu[]" multiple="multiple" data-placeholder="Pilih Pengendalian Mutu" style="width:100%"><option value="Split">Split</option><option value="Duplikat">Duplikat</option><option value="Blangko_Media">Blangko Media</option><option value="Blangko_Perjalanan">Blangko Perjalanan</option></select></div></div></div></div></div><div class="mb-2"><div class="row"><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">DO</label><div class="input-group"><input type="number" class="form-control" name="do" id="do" autocomplete="off" step="any"><div class="input-group-append"><span class="input-group-text" style="font-size:10px">mg/L</span></div></div><span class="text-danger text-bold" id="valdo" style="font-size:10px;display:none">Ex. 14.0</span></div></div></div><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">pH</label><input type="number" class="form-control" name="ph" id="ph" autocomplete="off" step="0.01" min="0.00" max="14.00" required></div><span class="text-danger text-bold" id="valph" style="font-size:10px;display:none">Ex. 14.00</span></div></div></div></div><div class="mb-2"><div class="row"><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Suhu Air</label><div class="input-group"><input type="number" class="form-control" id="suhuAir" name="suhu_air" autocomplete="off" step="0.1" required><div class="input-group-append"><span class="input-group-text" style="font-size:10px">°C</span></div></div><span class="text-danger text-bold" id="valsuhuAir" style="font-size:10px;display:none">Ex. 14.0</span></div></div></div><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Suhu Udara</label><div class="input-group"><input type="number" class="form-control" id="suhuUdara" name="suhu_udara" autocomplete="off" step="0.1" required><div class="input-group-append"><span class="input-group-text" style="font-size:10px">°C</span></div></div><span class="text-danger text-bold" id="valsuhuUdara" style="font-size:10px;display:none">Ex. 14.0</span></div></div></div></div></div><div class="mb-2"><div class="row"><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Salinitas</label><div class="input-group"><input type="number" class="form-control" name="salinitas" autocomplete="off" step="any"><div class="input-group-append"><span class="input-group-text" style="font-size:10px">‰</span></div></div></div></div></div><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Kecepatan Arus</label><div class="input-group"><input type="number" class="form-control" name="kecepatan_arus" autocomplete="off" step="any"><div class="input-group-append"><span class="input-group-text" style="font-size:10px">m/detik</span></div></div></div></div></div></div></div><div class="row mb-2"><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1">Arah Arus</label><select class="form-control" name="arah_arus"><option>Utara</option><option>Timur Laut</option><option>Timur</option><option>Tenggara</option><option>Selatan</option><option>Barat Daya</option><option>Barat</option><option>Barat Laut</option></select></div></div></div></div><div class="mb-2"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Pasang Surut Air Laut</label><div class="col-12 mb-2"><button id="addRow" type="button" class="btns btn-info">Tambah Pengamatan</button></div><div class="mb-2"><div id="newRow"></div></div></div></div></div><div class="mb-2"><div class="row"><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Kecerahan</label><div class="input-group"><input type="number" class="form-control" name="kecerahan" autocomplete="off" step="any"><div class="input-group-append"><span class="input-group-text" style="font-size:10px">m</span></div></div></div></div></div><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Warna</label><select class="form-control" name="warna" id="warna" required><option value="">-</option><option value="Berwarna">Berwarna</option><option value="Tidak_Berwarna">Tidak Berwarna</option></select></div></div></div></div></div><div class="row mb-2"><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Bau</label><select class="form-control" name="bau" id="bau" required><option value="">-</option><option value="Berbau">Berbau</option><option value="Tidak_Berbau">Tidak Berbau</option></select></div></div></div><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Lapisan Minyak</label><select class="form-control" name="minyak" id="penyaringan"><option value="">-</option><option value="Ada">Ada</option><option value="Tidak_Ada">Tidak Ada</option></select></div></div></div></div><div class="row mb-3"><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1">Cuaca</label><select class="form-control" name="cuaca" id="penyaringan"><option value="Cerah">Cerah</option><option value="Mendung">Mendung</option><option value="Berawan">Berawan</option><option value="Setelah_Hujan">Setelah Hujan</option></select></div></div></div></div>';
var permukaan =
   '<div class="row mb-2"><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1">Jenis Sample</label><input type="text" name="jenis_sample" class="form-control" id="jenis_sample" autocomplete="off" readonly="readonly"></div></div></div><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1">Jumlah Titik Pengambilan</label><select class="form-control" name="jumlah_titik"><option value="">Pilih Titik</option><option value="1 Titik">1 Titik</option><option value="2 Titik">2 Titik</option><option value="3 Titik">3 Titik</option><option value="4 Titik">4 Titik</option><option value="5 Titik">5 Titik</option><option value="6 Titik">6 Titik</option><option value="7 Titik">7 Titik</option><option value="8 Titik">8 Titik</option><option value="9 Titik">9 Titik</option><option value="10 Titik">10 Titik</option></select></div></div></div></div><div class="mb-2"><div class="form-group basic"><div class="input-wrapper"><label>Jenis Fungsi Air</label><select class="select2" name="jenis_fungsi[]" class="select2" multiple="multiple" data-placeholder="Pilih jenis fungsi air" style="width:100%"><option>Air Alamiah</option><option>Air untuk Perkotaan</option><option>Air untuk Industri</option><option>Air yang Sudah Tercampur Limbah</option><option>Air yang Siap Masuk ke Danau/Laut</option></select></div></div></div><div class="mb-2"><div class="row"><div class="col-sm-12"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1">Penamaan Titik</label><input type="text" name="keterangan_1" id="keterangan-1" class="form-control" autocomplete="off"></div></div></div></div></div><div class="mb-2"><div class="row"><div class="col-sm-12"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1">Penamaan Tambahan</label><textarea class="form-control rounded" name="information"></textarea></div></div></div></div></div><div class="row"><div class="col-sm-12"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1">Titik Koordinat Sampling</label><div class="input-groups input-group-sm mb-2"><input type="hidden" name="lat" id="lat"> <input type="hidden" name="longi" id="longi"><div class="row"><div class="col-8"><input type="text" class="form-control" name="posisi" id="posisi" autocomplete="off" style="font-size:12px" required></div><div class="col-4"><span class="input-group-prepends" style="width:30%"><a class="btn btn-info" onclick="getlocation()"><i class="fa-solid fa-location-dot"></i> Get Location</a></span></div></div></div></div></div></div></div><div class="mb-2 row"><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Teknik Sampling</label><select class="form-control" name="teknik_sampling"><option value="Sesaat">Sesaat</option><option value="Gabungan_Kedalaman">Gabungan Kedalaman</option></select></div></div></div><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1">Jam Pengambilan</label><div class="row"><div class="col-8"><input type="text" class="form-control" name="jam" id="jam" readonly="readonly"></div><div class="col-2 px-0"><span class="d-flex align-items-center btn btn-danger"><a onclick="mulai()"><i class="fa-regular fa-clock"></i></a></span></div></div></div></div></div></div><div class="mb-2"><div class="row"><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Volume (ml)</label><select class="form-control" id="volume" name="volume" required></select></div></div></div><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label>Jenis Pengawet</label><select class="form-control select2" name="parent_pengawet[]" id="jenis-pengawet" multiple="multiple" data-placeholder="Pilih jenis Pengawet" style="width:100%"><option value="fisika">Fisika</option><option value="kimia">Kimia</option></select></div></div></div></div></div><div class="mb-2" id="turunan-pengawet"><label class="label label-1" for="modalInputusername">Jenis Pengawet</label><div class="row"><div class="col-sm-3"><label><input type="checkbox" name="jenis_pengawet[]" id="iCheck1" value="H2SO4"><span>H2SO4</span></label></div><div class="col-sm-3"><label><input type="checkbox" name="jenis_pengawet[]" id="iCheck2" value="HNO3"><span>HNO3</span></label></div><div class="col-sm-3"><label><input type="checkbox" name="jenis_pengawet[]" id="iCheck3" value="HCI"><span>HCI</span></label></div><div class="col-sm-3"><label><input type="checkbox" name="jenis_pengawet[]" id="iCheck4" value="NaOH"><span>NaOH</span></label></div></div></div><div class="mb-2"><div class="row"><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Perlakuan Penyaringan</label><select class="form-control" name="penyaringan" id="penyaringan"><option value="">-</option><option value="Ada">Ada</option><option value="Tidak_Ada">Tidak Ada</option></select></div></div></div><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Pengendalian Mutu</label><select class="form-control select2" name="mutu[]" multiple="multiple" data-placeholder="Pilih Pengendalian Mutu" style="width:100%"><option value="Split">Split</option><option value="Duplikat">Duplikat</option><option value="Blangko_Media">Blangko Media</option><option value="Blangko_Perjalanan">Blangko Perjalanan</option></select></div></div></div></div></div><div class="mb-2"><div class="row"><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Teknik Pengukuran Debit</label><select class="form-control" name="pengukuran_debit" id="pengukuran_debit"><option>-</option><option value="Sederhana">Sederhana</option><option value="Instrument Current Meter">Instrument Current Meter</option></select></div></div></div><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Pilih Debit Air</label><select class="form-control" id="sel_debit" name="sel_debit"><option>-</option><option value="Input Data">Input Data</option><option value="Data By Customer">Data By Customer</option></select></div></div></div></div></div><div class="row"><div class="col-6" id="opt_deb_cust"></div><div class="col-6" id="data_by_cust"></div></div><div class="row"><div class="col-6" id="input_deb"></div><div class="col-6" style="display:none" id="satDebit"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1 mb-1">Satuan Debit</label><select name="satuan_debit" class="form-control selInput" autocomplete="off" style="width:100%"><option value="mL/detik" style="font-size:10px">mL/detik</option><option value="L/detik" style="font-size:10px">L/detik</option><option value="L/jam" style="font-size:10px">L/jam</option><option value="L/hari" style="font-size:10px">L/hari</option></select></div></div></div></div><div class="mb-2"><div class="row"><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">pH</label><input type="number" class="form-control" name="ph" id="ph" autocomplete="off" step="0.01" min="0.00" max="14.00" required></div><span class="text-danger text-bold" id="valph" style="font-size:10px;display:none">Ex. 14.00</span></div></div></div></div><div class="mb-2"><div class="row"><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Suhu Air</label><div class="input-group"><input type="number" class="form-control" id="suhuAir" name="suhu_air" autocomplete="off" step="0.1" required><div class="input-group-append"><span class="input-group-text" style="font-size:10px">°C</span></div></div><span class="text-danger text-bold" id="valsuhuAir" style="font-size:10px;display:none">Ex. 14.0</span></div></div></div><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Suhu Udara</label><div class="input-group"><input type="number" class="form-control" id="suhuUdara" name="suhu_udara" autocomplete="off" step="0.1" required><div class="input-group-append"><span class="input-group-text" style="font-size:10px">°C</span></div></div><span class="text-danger text-bold" id="valsuhuUdara" style="font-size:10px;display:none">Ex. 14.0</span></div></div></div></div></div><div class="mb-2"><div class="row"><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">DHL</label><div class="input-group"><input type="number" class="form-control" name="dhl" id="dhl" autocomplete="off" step="0.1" required><div class="input-group-append"><span class="input-group-text" style="font-size:10px">µS/cm</span></div></div><span class="text-danger text-bold" id="valdhl" style="font-size:10px;display:none">Ex. 7.0</span></div></div></div><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Klor Bebas</label><div class="input-group"><input type="number" class="form-control" name="klor" id="klor" autocomplete="off" step="any"><div class="input-group-append"><span class="input-group-text" style="font-size:10px">mg/L</span></div></div><span class="text-danger text-bold" id="valklor" style="font-size:10px;display:none">Ex. 14.00</span></div></div></div></div></div><div class="mb-2"><div class="row"><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Warna</label><select class="form-control" name="warna" id="warna" required><option value="">-</option><option value="Berwarna">Berwarna</option><option value="Tidak Berwarna">Tidak Berwarna</option></select></div></div></div><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Bau</label><select class="form-control" name="bau" id="bau" required><option value="">-</option><option value="Berbau">Berbau</option><option value="Tidak Berbau">Tidak Berbau</option></select></div></div></div></div></div>';
var limbah =
   '<div class="mb-2"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1">Jenis Sample</label><input type="text" name="jenis_sample" class="form-control" id="jenis_sample" autocomplete="off" readonly="readonly"></div></div></div><div class="mb-2"><div class="row"><div class="col-sm-12"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1">Jenis Produksi</label><textarea class="form-control rounded" name="jenis_produksi"></textarea></div></div></div></div></div><div class="mb-2 row"><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Status Ketersediaan Ipal</label><select class="form-control" name="ipal"><option>-</option><option value="Ada">Ada</option><option value="Tidak_Ada">Tidak Ada</option></select></div></div></div><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Lokasi Sampling</label><select class="form-control" name="lokasi_sampling"><option>-</option><option value="Inlet">Inlet</option><option value="Outlet">Outlet</option><option value="Outfall">Outfall</option></select></div></div></div></div><div class="mb-2"><div class="row"><div class="col-sm-12"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1">Penamaan Titik</label><input type="text" name="keterangan_1" id="keterangan-1" class="form-control" autocomplete="off"></div></div></div></div></div><div class="mb-2"><div class="row"><div class="col-sm-12"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1">Penamaan Tambahan</label><textarea class="form-control rounded" name="information"></textarea></div></div></div></div></div><div class="form-group basic"><div class="row"><div class="col-sm-12"><label class="label label-1">Titik Koordinat</label><div class="input-groups input-group-sm mb-2"><input type="hidden" name="lat" id="lat"> <input type="hidden" name="longi" id="longi"><div class="row"><div class="col-8"><input type="text" class="form-control" name="posisi" id="posisi" autocomplete="off" style="font-size:12px" required></div><div class="col-4"><span class="input-group-prepends" style="width:30%"><a class="btn btn-info" onclick="getlocation()"><i class="fa-solid fa-location-dot"></i> Get Location</a></span></div></div></div></div></div></div><div class="mb-2 row"><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Teknik Sampling</label><select class="form-control" name="teknik_sampling"><option value="Sesaat">Sesaat</option><option value="Gabungan_Waktu">Gabungan Waktu</option><option value="Gabungan_Tempat">Gabungan Tempat</option><option value="Gabungan_Waktu_dan_Tempat">Gabungan Waktu & Tempat</option></select></div></div></div><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1">Jam Pengambilan</label><div class="row"><div class="col-8"><input type="text" class="form-control" name="jam" id="jam" readonly="readonly"></div><div class="col-2 px-0"><span class="d-flex align-items-center btn btn-danger"><a onclick="mulai()"><i class="fa-regular fa-clock"></i></a></span></div></div></div></div></div></div><div class="mb-2"><div class="row"><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Volume (ml)</label><select class="form-control" id="volume" name="volume" required></select></div></div></div><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label>Jenis Pengawet</label><select class="form-control select2" name="parent_pengawet[]" id="jenis-pengawet" multiple="multiple" data-placeholder="Pilih jenis Pengawet" style="width:100%"><option value="fisika">Fisika</option><option value="kimia">Kimia</option></select></div></div></div></div></div><div class="mb-2" id="turunan-pengawet"><label class="label label-1" for="modalInputusername">Jenis Pengawet</label><div class="row"><div class="col-sm-3"><label><input type="checkbox" name="jenis_pengawet[]" id="iCheck1" value="H2SO4"><span>H2SO4</span></label></div><div class="col-sm-3"><label><input type="checkbox" name="jenis_pengawet[]" id="iCheck2" value="HNO3"><span>HNO3</span></label></div><div class="col-sm-3"><label><input type="checkbox" name="jenis_pengawet[]" id="iCheck3" value="HCI"><span>HCI</span></label></div><div class="col-sm-3"><label><input type="checkbox" name="jenis_pengawet[]" id="iCheck4" value="NaOH"><span>NaOH</span></label></div></div></div><div class="mb-2"><div class="row"><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Perlakuan Penyaringan</label><select class="form-control" name="penyaringan" id="penyaringan"><option value="">-</option><option value="Ada">Ada</option><option value="Tidak_Ada">Tidak Ada</option></select></div></div></div><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Pengendalian Mutu</label><select class="form-control select2" name="mutu[]" multiple="multiple" data-placeholder="Pilih Pengendalian Mutu" style="width:100%"><option value="Split">Split</option><option value="Duplikat">Duplikat</option><option value="Blangko_Media">Blangko Media</option><option value="Blangko_Perjalanan">Blangko Perjalanan</option></select></div></div></div></div></div><div class="mb-2"><div class="row"><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">DO</label><div class="input-group"><input type="number" class="form-control" name="do" id="do" autocomplete="off" step="any"><div class="input-group-append"><span class="input-group-text" style="font-size:10px">mg/L</span></div></div><span class="text-danger text-bold" id="valdo" style="font-size:10px;display:none">Ex. 14.0</span></div></div></div><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Pilih Debit Air</label><select class="form-control" id="sel_debit" name="sel_debit"><option>-</option><option value="Input Data">Input Data</option><option value="Data By Customer">Data By Customer</option></select></div></div></div></div></div><div class="row"><div class="col-6" id="opt_deb_cust"></div><div class="col-6" id="data_by_cust"></div></div><div class="row"><div class="col-6" id="input_deb"></div><div class="col-6" style="display:none" id="satDebit"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1 mb-1">Satuan Debit</label><select name="satuan_debit" class="form-control selInput" autocomplete="off" style="width:100%"><option value="mL/detik" style="font-size:10px">mL/detik</option><option value="L/detik" style="font-size:10px">L/detik</option><option value="L/jam" style="font-size:10px">L/jam</option><option value="L/hari" style="font-size:10px">L/hari</option></select></div></div></div></div><div class="mb-2"><div class="row"><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">pH</label><input type="number" class="form-control" name="ph" id="ph" autocomplete="off" step="0.01" min="0.00" max="14.00" required></div><span class="text-danger text-bold" id="valph" style="font-size:10px;display:none">Ex. 14.00</span></div></div><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Suhu Air</label><div class="input-group"><input type="number" class="form-control" id="suhuAir" name="suhu_air" autocomplete="off" step="0.1" required><div class="input-group-append"><span class="input-group-text" style="font-size:10px">°C</span></div></div><span class="text-danger text-bold" id="valsuhuAir" style="font-size:10px;display:none">Ex. 14.0</span></div></div></div></div></div><div class="mb-2"><div class="row"><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Suhu Udara</label><div class="input-group"><input type="number" class="form-control" id="suhuUdara" name="suhu_udara" autocomplete="off" step="0.1" required><div class="input-group-append"><span class="input-group-text" style="font-size:10px">°C</span></div></div><span class="text-danger text-bold" id="valsuhuUdara" style="font-size:10px;display:none">Ex. 14.0</span></div></div></div><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">DHL</label><div class="input-group"><input type="number" class="form-control" name="dhl" id="dhl" autocomplete="off" step="0.1" required><div class="input-group-append"><span class="input-group-text" style="font-size:10px">µS/cm</span></div></div><span class="text-danger text-bold" id="valdhl" style="font-size:10px;display:none">Ex. 7.0</span></div></div></div></div></div><div class="mb-2"><div class="row"><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Warna</label><select class="form-control" name="warna" id="warna" required><option value="">-</option><option value="Berwarna">Berwarna</option><option value="Tidak_Berwarna">Tidak Berwarna</option></select></div></div></div><div class="col-6"><div class="form-group basic"><div class="input-wrapper"><label class="label label-1" for="modalInputusername">Bau</label><select class="form-control" name="bau" id="bau" required><option value="">-</option><option value="Bau">Bau</option><option value="Tidak_Bau">Tidak Bau</option></select></div></div></div></div></div>';
</script>