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
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="header">
                <h4 class="title">Data Kelas Paralel <?php echo $sekolah->nama_sekolah;?></h4>
              </div>
              <div class="content">
                <div class="row">
                  <div class="col-md-4">
					<form action="<?php echo base_url("psep_sekolah/kelas_paralel/proses_edit");?>" method="post">
						<h4>Edit Kelas paralel</h4>
						<input type="hidden" name="idkelasparalel" value="<?php echo $kelasparalel->id_kelas_paralel;?>"/>
						<p>Kelas
						<select class="form-control" name="kelas" required>
							<option value="<?php echo $kelasparalel->id_kelas;?>"><?php echo $kelasparalel->alias_kelas;?></option>
							<?php
								foreach($datakelas as $kelas){
							?>
							<option value="<?php echo $kelas->id_kelas;?>"><?php echo $kelas->alias_kelas;?></option>
							<?php
								}
							?>
						</select>
						<p>Kelas paralel
						<input type="text" name="kelasparalel" class="form-control"value="<?php echo $kelasparalel->kelas_paralel;?>" required />
						<p>
						<input type="submit" class="btn btn-primary" value="Simpan Kelas paralel" />
					</form>
				  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div> <!-- end .container-fluid -->
    </div> <!-- end .content -->

    <?php include "footer.php"; ?>

  </div>
</div>

</body>

<!--   Core JS Files   -->
<script src="<?php echo base_url('assets/js/jquery-1.10.2.js" type="text/javascript');?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap.min.js" type="text/javascript');?>"></script>

<!--  Nestable Plugin    -->
<script src="<?php echo base_url('assets/js/plugins/nestable/jquery.nestable.js');?>"></script>

<!--  Checkbox, Radio & Switch Plugins -->
<script src="<?php echo base_url('assets/js/bootstrap-checkbox-radio-switch.js');?>"></script>

<!--  Notifications Plugin    -->
<script src="<?php echo base_url('assets/js/bootstrap-notify.js');?>"></script>


<!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
<script src="<?php echo base_url('assets/js/light-bootstrap-dashboard.js');?>"></script>

<!-- PLUGINS FUNCTION -->
 <!-- Nestable plugin  -->



</html>
