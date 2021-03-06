<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php include "html_header.php"; ?>

<div class="wrapper">
  <?php include "sidebar.php"; ?>

  <div class="main-panel">
    <?php include "navbar.php"; ?>
    
    <div class="content">      
      <div class="container-fluid">
        <?php echo $this->session->flashdata('alert');?>

        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="header">
                <a href="<?php echo base_url('pg_admin/log/grafik')?>" class="btn btn-fill btn-info pull-right"><i class="glyphicon glyphicon-dashboard"></i> Grafik Akses</a>
                <h4 class="title">Log Akses Siswa Aktif</h4>
                <p class="category">Daftar Riwayat Akses Siswa Aktif</p>
              </div>
              <div class="content">
                <div class="table-responsive">
                  <table id="my_datatable" class="table table-striped table-hover">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Sekolah</th>
                        <th>Email &amp; HP</th>
                        <th class="text-center">Total Akses</th>
                        <th class="text-center">Terakhir Akses</th>
                        <th class="text-center">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        $no = 1; 
                        foreach ($table_data as $item) 
                        {
                      ?>
                        <tr>
                          <td><?php echo $no;?></td>
                          <td><b><?php echo $item->nama_siswa?></b></td>
                          <td><?php echo $item->alias_kelas?></td>
                          <td><?php echo $item->asal_sekolah?></td>
                          <td><?php echo ($item->email ? $item->email : '-') .'<br>'. ($item->telepon ? $item->telepon : '-');?></td>
                          <td class="text-center"><?php echo isset($item->total_akses) ? $item->total_akses." x" : "0 x"?></td>
                          <td class="text-center"><?php echo date('d M Y', strtotime($item->timestamp)) .'<br>'. date('(H:i)',  strtotime($item->timestamp))?></td>
                          <td class="text-center">
                            <div class="button-group">
                              <a href="<?php echo $form_action . 'manajemen/detail_log?id=' . $item->id_siswa ?>" class="btn btn-info btn-xs" title="Lihat Detail Log"><i class="glyphicon glyphicon-eye-open"></i></a>
                              <button type="button" class="btn btn-danger btn-xs" title="Reset Log" data-number="<?php echo $no?>" value="<?php echo $item->id_siswa?>" data-toggle="modal" data-target="#deleteRow_modal"><i class="glyphicon glyphicon-repeat"></i></button>
                            </div>
                          </td>
                        </tr>
                      <?php
                        $no++;
                        }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div> 
    </div> <!-- end .content -->

    <?php include "footer.php"; ?>
    
  </div> <!-- end .main-panel -->
</div>

<?php include "alert_modal.php"; ?>
</body>

<!--   Core JS Files   -->
<script src="<?php echo base_url('assets/js/jquery-1.10.2.js" type="text/javascript');?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap.min.js" type="text/javascript');?>"></script>

<!--  Checkbox, Radio & Switch Plugins -->
<script src="<?php echo base_url('assets/js/bootstrap-checkbox-radio-switch.js');?>"></script>

<!--  Datatables Plugin -->
<script type="text/javascript" src="<?php echo base_url('assets/js/plugins/datatables/jquery.dataTables.min.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/plugins/datatables/dataTables.bootstrap.min.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/plugins.js');?>"></script>

<!--  Notifications Plugin    -->
<script src="<?php echo base_url('assets/js/bootstrap-notify.js');?>"></script>

<!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
<script src="<?php echo base_url('assets/js/light-bootstrap-dashboard.js');?>"></script>

 <!-- JS Function for this Modal -->
<script type="text/javascript">
  $('#deleteRow_modal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var rownumber = button.data('number') // Extract info from data-* attributes
    var id = button.attr('value')
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this)
    modal.find('.number').text("#" + rownumber + "?")
    modal.find('input[name=hidden_row_id]').val(id)
  })
</script>


</html>
