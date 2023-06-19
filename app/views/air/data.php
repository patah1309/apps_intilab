   <div id="appCapsule">
      <!-- <div class="section-title">Data Qr <span id="qr_code"></span></div> -->
      <div class="card">
         <div class="card-body ">
            <div class="table-responsive">
               <table class="loaddata table table-bordered table-striped" id="data-air">
                  <thead>
                     <tr>
                        <th width="50%">#</th>
                        <th nowrap>Tanggal</th>
                        <th nowrap>No Sample</th>
                        <th nowrap>Nama Perusahaan</th>
                        <th nowrap>Jam Pengambilan</th>
                        <th nowrap>Jenis Sample</th>
                     </tr>
                  </thead>
                  <tbody>

                     <?php foreach($data['data']->data as $value):?>
                     <tr>
                        <td>
                           <div class="d-flex">
                              <a href="<?= base_url;?>/air/showData/<?=$value->id?>"><span class="col-blue"><i
                                       class="fa-solid fa-eye"></i></span></a> &nbsp;|&nbsp;
                              <?php 
                           if($value->approve == 0) { ?>
                              <a href="javascript:;" onclick="approve(<?=$value->id?>)"><span class="col-by"><i
                                       class="fa-solid fa-check"></i></span></a>
                              &nbsp;|&nbsp;
                              <a href="javascript:;" onclick="del(<?=$value->id?>)"><span class="col-by"><i
                                       class="fa-solid fa-trash-can"></i></span></a>
                              &nbsp;&nbsp;
                              <?php } ?>
                           </div>
                        </td>
                        <td><?= date('Y-m-d', strtotime($value->add_at))?></td>
                        <td><?= $value->no_sample?></td>
                        <td><?= $value->detail->nama?></td>
                        <td><?= $value->jam_pengambilan?></td>
                        <td><?= $value->jenis_sample?></td>
                     </tr>
                     <?php
                     endforeach;
                     ?>
                  </tbody>
               </table>
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
var tabel = null
$(document).ready(function() {
   tabel = $('#data-air').DataTable()
})

function approve(id) {
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
            url: '/public/air/approvedat',
            method: 'post',
            data: {
               id: id
            },
            success: function(data) {
               Swal.fire({
                  icon: 'success',
                  title: data.message,
                  timer: 3000
               });
               // tabel.ajax.reload();
               window.location.href = "<?= base_url;?>/air/data";
            }
         });
      }
   });
}

function del(id) {
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
            url: '/public/air/hapusdat',
            method: 'post',
            data: {
               id: id
            },
            success: function(data) {
               Swal.fire({
                  icon: 'success',
                  title: data.message,
                  timer: 3000
               });
               window.location.href = "<?= base_url;?>/air/data";
            }
         });
      }
   });
}
   </script>