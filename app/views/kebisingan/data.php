 <!-- * App Sidebar -->
 <div id="appCapsule">
    <!-- <div class="section-title">Data Qr <span id="qr_code"></span></div> -->
    <div class="card">
       <div class="card-body ">
          <div class="table-responsive">
             <table class="loaddata table table-bordered table-striped" id="data">
                <thead>
                   <tr>
                      <th>#</th>
                      <th nowrap>Tanggal Uji</th>
                      <th nowrap>No Sample</th>
                      <?php if($data['koneksi'] == true) {?>
                      <th nowrap>Nama Perusahaan</th>
                      <?php }?>
                      <th nowrap>Shift Pengambilan</th>
                   </tr>
                </thead>
                <tbody>
                   <?php foreach($data['data'] as $value):?>
                   <tr>
                      <td>
                         <div class="d-flex">
                            <?php if($data['koneksi'] == true) {?>
                            <a href="<?= base_url;?>/kebisingan/showData/<?=$value->id?>"><span class="col-blue"><i
                                     class="fa-solid fa-eye"></i></span></a> &nbsp;|&nbsp;
                            <?php }else { ?>
                            <a
                               href="<?= base_url;?>/kebisingan/showDataoff/<?= str_replace("/","_", $value->no_sample)?>"><span
                                  class="col-blue"><i class="fa-solid fa-eye"></i></span></a> &nbsp;|&nbsp;
                            <?php } ?>
                            <?php 
                           if($value->approve == 0) { ?>
                            <?php if($data['koneksi'] == true) {?>
                            <a href="javascript:;" onclick="approve(<?=$value->id?>)"><span class="col-by"><i
                                     class="fa-solid fa-check"></i></span></a>
                            &nbsp;|&nbsp;
                            <a href="javascript:;" onclick="del(<?=$value->id?>)"><span class="col-by"><i
                                     class="fa-solid fa-trash-can"></i></span></a>
                            &nbsp;&nbsp;
                            <?php }else{  ?>
                            <a href="javascript:;" onclick="del('<?= str_replace('/','_', $value->no_sample) ?>')"><span
                                  class="col-by"><i class="fa-solid fa-trash-can"></i></span></a>
                            &nbsp;&nbsp;
                            <?php } ?>
                            <?php } ?>
                         </div>
                      </td>
                      <td><?= date('Y-m-d', strtotime($value->add_at)) ?></td>
                      <td><?= $value->no_sample; ?></td>
                      <?php if($data['koneksi'] == true) {?>
                      <td><?= $value->nama; ?></td>
                      <td><?= $value->jenis_durasi_sampling; ?></td>
                      <?php }?>
                      <td><?= $value->durasi_sampl; ?></td>
                   </tr>
                   <?php endforeach; ?>
                </tbody>
             </table>
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

 <script>
var toastMixin = Swal.mixin({
   toast: true,
   icon: 'success',
   title: 'General Title',
   animation: false,
   position: 'top-right',
   showConfirmButton: false,
   timer: 2000,
   timerProgressBar: true,
   didOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
   }
});

var table = null;

$(document).ready(function() {
   if ($('#status-text').text() == 'Offline') {
      Swal.fire({
         icon: 'info',
         title: 'Oooops....',
         text: 'Saat ini anda sedang offline...!',
         timer: 3000
      })
   }
   tabel = $('#data').DataTable()
})

function approve(id) {
   Swal.fire({
      title: 'Are you sure APPROVE this data?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, Approve it!'
   }).then((result) => {
      if (result.isConfirmed) {
         $.ajax({
            url: '/public/kebisingan/approveKebisingan',
            method: 'POST',
            data: {
               id: id
            },
            success: function(resp) {
               e = JSON.parse(resp)
               if (e.length == 0) {
                  Swal.fire({
                     icon: 'error',
                     title: 'Approve Data Galal.!',
                  })
               } else {
                  Swal.fire({
                     title: e.message,
                     icon: "success",
                     timer: 2000
                  })
                  window.location.href = "<?= base_url; ?>/kebisingan/viewDatakebisingan";
               }
            }
         })
      }
   });
}

function del(id) {
   Swal.fire({
      title: 'Are you sure DELETE this data?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, Delete it!',
      cancelButtonText: 'No'
   }).then((result) => {
      if (result.isConfirmed) {
         $.ajax({
            url: '/public/kebisingan/deleteKebisingan',
            method: 'POST',
            data: {
               id: id
            },
            success: function(resp) {
               e = JSON.parse(resp)
               if (e.length == 0) {
                  Swal.fire({
                     icon: 'error',
                     title: 'Delete Data Galal.!',
                  })
               } else {
                  Swal.fire({
                     title: e.message,
                     icon: "success",
                     timer: 2000
                  })
                  window.location.href = "<?= base_url; ?>/kebisingan/viewDatakebisingan";
               }
            }
         })
      }
   });
}
 </script>