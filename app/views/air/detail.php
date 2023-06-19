<div id="appCapsule">
   <div class="row">
      <div class="col-12">
         <div class="card">
            <div class="modal-header">
               <h6 class="modal-title" id="myModalLabel">Detail Data Lapangan</h6>
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
<script>
function fotoD(file) {
   var path = 'http://localhost/eng/backend/public/dokumentasi/'
   var filename = file.getAttribute("value");

   var file_path = path + filename;
   var a = document.createElement('a');
   a.href = file_path;
   a.download = file_path.substr(file_path.lastIndexOf('/') + 1);
   document.body.appendChild(a);
   a.click();
   document.body.removeChild(a);
}

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