<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php include "html_header.php"; ?>
<?php
//PERHITUNGAN SKOR
foreach($kategoridiagnostic as $diagnostic){
	foreach($datasoal as $soal){
		if($soal->id_diagnostic == $diagnostic->id_diagnostic){
			foreach($jumlahbenar as $datanilai){
				if($datanilai->id_diagnostic == $diagnostic->id_diagnostic){
					
					$skor[$diagnostic->id_diagnostic] = round(($datanilai->jumlah_benar / $soal->jumlah)*100, 2);
					
					$soalbenar[$diagnostic->id_diagnostic] = $datanilai->jumlah_benar;
					
					$jumlahsoalasli[$diagnostic->id_diagnostic] = $soal->jumlah;
					
					$soalsalah[$diagnostic->id_diagnostic] = $soal->jumlah - $datanilai->jumlah_benar;
				}
			}
		}
	}
}

foreach($kategoridiagnostic as $diagnostic){
	if(!isset($skor[$diagnostic->id_diagnostic])){
		$skor[$diagnostic->id_diagnostic] = 0;
	}
	if($skor[$diagnostic->id_diagnostic] < 40){
		$kategori[$diagnostic->id_diagnostic] = "Sangat Rendah";
	}elseif($skor[$diagnostic->id_diagnostic] >= 40 AND $skor[$diagnostic->id_diagnostic] < 56){
		$kategori[$diagnostic->id_diagnostic] = "Rendah";
	}elseif($skor[$diagnostic->id_diagnostic] >= 56 AND $skor[$diagnostic->id_diagnostic] < 71){
		$kategori[$diagnostic->id_diagnostic] = "Sedang";
	}elseif($skor[$diagnostic->id_diagnostic] >= 71 AND $skor[$diagnostic->id_diagnostic] < 86){
		$kategori[$diagnostic->id_diagnostic] = "Tinggi";
	}elseif($skor[$diagnostic->id_diagnostic] >= 86){
		$kategori[$diagnostic->id_diagnostic] = "Sangat Tinggi";
	}
}

foreach($kategoridiagnostic as $diagnostic){
	foreach($jumlahhasil as $jumlah){
		if($jumlah->id_diagnostic == $diagnostic->id_diagnostic){
			foreach($jumlahbenarhasil as $jumlahbenar){
				if($jumlahbenar->id_diagnostic == $diagnostic->id_diagnostic){
					$average[$diagnostic->id_diagnostic] = round(($jumlahbenar->jumlah_benar / $jumlah->jumlah_soal) * 100, 2);
					
					
				}
			}
		}
		$jumlahsoalasli[$diagnostic->id_diagnostic] = $jumlah->jumlah_soal;
	}
}
?>

<?php
	$total = $totalv + $totala + $totalk;
	
	if($totalv == 0){
		$persenv = 0;
	}else{
		$persenv = ($totalv / $total) * 100;
	}
	
	if($totala == 0){
		$persena = 0;
	}else{
		$persena = ($totalv / $total) * 100;
	}
	
	if($totalk == 0){
		$persenk = 0;
	}else{
		$persenk = ($totalv / $total) * 100;
	}
	
?>

<?php 
	$rank = array();
	$skor_maxmin = array();
	$rankkelas = array();
	foreach ($kategoridiagnostic as $diagnostic) {
		foreach ($hasildiagnostic as $hasil) {
			if($hasil->id_diagnostic == $diagnostic->id_diagnostic){
				//rank[id_diagnostic][id_siswa] = jumlah_status
				$rank[$diagnostic->id_diagnostic][] = $hasil->id_siswa;
				foreach ($datasoal as $soal) {
					if($soal->id_diagnostic == $diagnostic->id_diagnostic){
						$skor_maxmin[$diagnostic->id_diagnostic][] = round((($hasil->jumlah_status / $soal->jumlah) * 100), 2);
					}
				}

			}
		}
	}
	foreach ($peringkatsiswa as $kelas) {
		$rankkelas[] = $kelas->id_siswa;
	}
	
	if(!isset($skor)){
		$skor = 0;
	}

if(empty($data_eq)){
	$skor_aq = 0;
	$skor_eq = 0;
	$skor_am = 0;
}else{
	$skor_aq = $data_eq->skor_aq;
	$skor_eq = $data_eq->skor_eq;
	$skor_am = $data_eq->skor_am;
}
?>
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
                <h4 class="title">Report AGCU Siswa</h4>
                <p class="category">Report analisis AGCU siswa</p>
              </div>
              <div class="content">
                <div class="row">
				  <div class="col-md-6">
                    <table class="table">
						<tr>
							<td>Nama Siswa</td>
							<td>:</td>
							<td><?php echo $infosiswa->nama_siswa;?></td>
						</tr>
						<tr>
							<td>Sekolah</td>
							<td>:</td>
							<td><?php echo $infosiswa->nama_sekolah;?></td>
						</tr>
						<tr>
							<td>Kelas</td>
							<td>:</td>
							<td><?php echo $infosiswa->alias_kelas;?></td>
						</tr>
					</table>
                  </div>
				  <div class="col-md-6">
					&nbsp;
				  </div>
				  <div class="col-md-12">
					&nbsp;
				  </div>
                  <div class="col-md-4">
                    <canvas id="myChart" width="400" height="400"></canvas>
                  </div>
				  <div class="col-md-8">
					<table class="table table-bordered">
						<tr class="diagnistic-title">
						  <th>Bid. Studi</th>
						  <th>Nilai</th>
						  <th>Rata-rata Kelas</th>
						  <th>Rank. Bid Studi</th>
						  <th>Kategori</th>
						</tr>
						<?php
							foreach($kategoridiagnostic as $diagnostic){
						?>
							<tr>
								<td>
									<?php echo $diagnostic->nama_kategori; ?>
								</td>
								<td align="center">
									<?php
										
										echo number_format($skor[$diagnostic->id_diagnostic], 2, '.', ',');
									?>
								</td>
								<td align="center">
									<?php 
									if(isset($average[$diagnostic->id_diagnostic])){
										echo number_format($average[$diagnostic->id_diagnostic], 2, '.', ',');
									}else{
										echo 0;
									}
									; 
									
									?>
								</td>
								<td align="center">
									<?php 
										echo (array_search($idsiswa, $rank[$diagnostic->id_diagnostic])) + 1;
									?> 
								</td>
								<td align="center">
									<?php
										
										echo $kategori[$diagnostic->id_diagnostic];
									?>
								</td>
							</tr>
						<?php
							}
						?>
						<tr>
							<td>Jumlah Nilai</td>
							<td align="center"><?php 
							if($skor !== 0){
								echo array_sum($skor);
							}else{
								echo "0";
							}
							?></td>
							<td align="center" colspan="3">Peringkat</td>
						</tr>
						<tr>
							<td>Nilai Rata-rata</td>
							<td align="center">
							<?php
								if($skor !== 0){
									$jumlaharray = count($skor);
									echo number_format((array_sum($skor)/$jumlaharray),2,'.',',');
								}else{
									echo "0";
								}
							?>
							</td>
							<td align="center" colspan="3">
								<?php $r = array_search($idsiswa, $rankkelas);?>
								Rangking <?php echo !empty($rankkelas) ? ($r+1) : 0 ?> dari <?php echo count($rankkelas)?> Siswa</td>
						</tr>
					  </table>
                  </div>
				  
				  <div class="col-md-12">
					<h4>LEARNING STYLE</h4>
						<table class="table table-bordered">
						  <tr>
							<th>&nbsp;</th>
							<th>&nbsp;</th>
							<th style="text-align:center;">Skor</th>
							<th>Dominasi : 
							<span class="hasil">
							<?php
								if($dominasi == "V"){
									echo "VISUAL";
								}elseif($dominasi == "A"){
									echo "AUDITORI";
								}elseif($dominasi == "K"){
									echo "KINESTETIK";
								}elseif($dominasi == "VA"){
									echo "VISUAL - AUDITORI";
								}elseif($dominasi == "VK"){
									echo "VISUAL - KINESTETIK";
								}elseif($dominasi == "AK"){
									echo "AUDITORI - KINESTETIK";
								}
							?>
							</span></th>
						  </tr>
						  <tr>
							<td><img src="<?php echo base_url('assets/dashboard/images/visual.jpg');?>"></td>
							<td>VISUAL</td>
							<td><?php echo $totalv; ?></td>
							<td>
							  <div class="progress">
								<div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $persenv; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $persenv; ?>%;">
								  <span class="sr-only"><?php echo $persenv; ?>%</span>
								</div>
							  </div>
							</td>
						  </tr>
						  <tr>
							<td><img src="<?php echo base_url('assets/dashboard/images/auditori.jpg');?>"></td>
							<td>AUDITORI</td>
							<td><?php echo $totala; ?></td>
							<td>
							  <div class="progress">
								<div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $persena; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $persena; ?>%;">
								  <span class="sr-only"><?php echo $persena; ?>%</span>
								</div>
							  </div>
							</td>
						  </tr>
						  <tr>
							<td><img src="<?php echo base_url('assets/dashboard/images/kinestetik.jpg');?>"></td>
							<td>KINESTETIK</td>
							<td><?php echo $totalk; ?></td>
							<td>
							  <div class="progress">
								<div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $persenk; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $persenk; ?>%;">
								  <span class="sr-only"><?php echo $persenk; ?>%</span>
								</div>
							  </div>
							</td>
						  </tr>
						</table>
						
						<h4>PSYCHOLOGY POTENTIAL TEST</h4>
						<table class="table table-bordered">
						  <tr>
							<th>&nbsp;</th>
							<th>&nbsp;</th>
							<th style="text-align:center;">Skor</th>
							<th>Kategori</th>
						  </tr>
						  <tr>
							<td><img src="<?php echo base_url('assets/dashboard/images/aq.jpg');?>"></td>
							<td>AQ (ADVERSITY QUOTIENT) - DAYA JUANG</td>
							<td><?php echo $skor_aq; ?></td>
							<td><?php
								if($skor_aq < 7){
									echo "Rendah";
								}elseif($skor_aq <= 11){
									echo "Rata-Rata Bawah";
								}elseif($skor_aq <= 21){
									echo "Rata-Rata";
								}elseif($skor_aq <= 26){
									echo "Rata-Rata Atas";
								}elseif($skor_aq <= 32){
									echo "Tinggi";
								}
							?></td>
						  </tr>
						  <tr>
							<td><img src="<?php echo base_url('assets/dashboard/images/eq.jpg');?>"></td>
							<td>EQ (EMOTIONAL QUOTIENT) - KECERDASAN EMOSI</td>
							<td><?php echo $skor_eq; ?></td>
							<td>
							<?php
							if($skor_eq < 7){
								echo "Rendah";
							}elseif($skor_eq <= 11){
								echo "Rata-Rata Bawah";
							}elseif($skor_eq <= 21){
								echo "Rata-Rata";
							}elseif($skor_eq <= 26){
								echo "Rata-Rata Atas";
							}elseif($skor_eq <= 32){
								echo "Tinggi";
							}
							?>
							</td>
						  </tr>
						  <tr>
							<td><img src="<?php echo base_url('assets/dashboard/images/am.jpg');?>"></td>
							<td>AM (ACHIEVEMENT MOTIVATION) - MOTIVASI BERPRESTASI</td>
							<td><?php echo $skor_am; ?></td>
							<td>
							<?php
							if($skor_am < 7){
								echo "Rendah";
							}elseif($skor_am <= 11){
								echo "Rata-Rata Bawah";
							}elseif($skor_am <= 21){
								echo "Rata-Rata";
							}elseif($skor_am <= 26){
								echo "Rata-Rata Atas";
							}elseif($skor_am <= 32){
								echo "Tinggi";
							}
							?>
							</td>
						  </tr>
						</table>
					<h4>LEARNING STYLE ANALISYS RESULT</h4>
						<div class="result">
						  <div class="title" style="text-align: center;">
							<?php
							if($dominasi == "V"){
							?>
							<img src="<?php echo base_url('assets/dashboard/images/visual.jpg');?>">
							<h5>VISUAL</h5>
							<?php
							}elseif($dominasi == "A"){
							?>
							<img src="<?php echo base_url('assets/dashboard/images/auditori.jpg');?>">
							<h5>AUDITORI</h5>
							<?php
							}elseif($dominasi == "K"){
							?>
							<img src="<?php echo base_url('assets/dashboard/images/kinestetik.jpg');?>">
							<h5>KINESTETIK</h5>
							<?php
							}elseif($dominasi == "VA"){
							?>
							<img src="<?php echo base_url('assets/dashboard/images/visual.jpg');?>">
							<img src="<?php echo base_url('assets/dashboard/images/auditori.jpg');?>">
							<h5>VISUAL-AUDITORI</h5>
							<?php
							}elseif($dominasi == "VK"){
							?>
							<img src="<?php echo base_url('assets/dashboard/images/visual.jpg');?>">
							<img src="<?php echo base_url('assets/dashboard/images/kinestetik.jpg');?>">
							<h5>VISUAL-KINESTETIK</h5>
							<?php
							}elseif($dominasi == "AK"){
							?>
							<img src="<?php echo base_url('assets/dashboard/images/auditori.jpg');?>">
							<img src="<?php echo base_url('assets/dashboard/images/kinestetik.jpg');?>">
							<h5>AUDITORI-KINESTETIK</h5>
							<?php
							}
							?>
							
						  </div>
						  <p>Berdasarkan data dan Modalitas Belajar di atas, maka yang menonjol adalah kemampuan 
						  <?php
							if($dominasi == "V"){
								echo "VISUAL";
							}elseif($dominasi == "A"){
								echo "AUDITORI";
							}elseif($dominasi == "K"){
								echo "KINESTETIK";
							}elseif($dominasi == "VA"){
								echo "VISUAL - AUDITORI";
							}elseif($dominasi == "VK"){
								echo "VISUAL - KINESTETIK";
							}elseif($dominasi == "AK"){
								echo "AUDITORI - KINESTETIK";
							}
							?>.<br/>
							Putra - putri Bapak/Ibu adalah Pelajar dengan tipe
							<?php
							if($dominasi == "V"){
								echo "VISUAL";
							}elseif($dominasi == "A"){
								echo "AUDITORI";
							}elseif($dominasi == "K"){
								echo "KINESTETIK";
							}elseif($dominasi == "VA"){
								echo "VISUAL - AUDITORI";
							}elseif($dominasi == "VK"){
								echo "VISUAL - KINESTETIK";
							}elseif($dominasi == "AK"){
								echo "AUDITORI - KINESTETIK";
							}
							?>
							. Dengan karakteristik umum dan pola belajar serta metode belajar yang tepat, sebagai berikut.</p>
						</div>
						<div class="desc">
						  <div class="title">KARAKTERISTIK</div>
						  <div class="content">
						   <?php echo $karakteristik; ?>
						  </div>
						</div>
						<div class="desc">
						  <div class="title">SARAN STRATEGI BELAJAR</div>
						  <div class="content">
							<?php echo $saran; ?>
						  </div>
						</div>
						
						<!-- hasil test psychological test -->
					<h4>PSYCOLOGY POTENTIAL TEST ANALISYS RESULT</h4>
						<table class="table table-striped table-bordered">
							<tr>
								<td>AQ (ADVERSITY QUOTIENT) <br/><b>DAYA JUANG</b></td>
								<td> Hasil : 
								<?php
								if($skor_aq < 7){
									echo "Rendah";
								}elseif($skor_aq <= 11){
									echo "Rata-Rata Bawah";
								}elseif($skor_aq <= 21){
									echo "Rata-Rata";
								}elseif($skor_aq <= 26){
									echo "Rata-Rata Atas";
								}elseif($skor_aq <= 32){
									echo "Tinggi";
								}
								?>
								</td>
							</tr>
							<tr>
								<td><img src="<?php echo base_url('assets/dashboard/images/aqBlue.jpg');?>"></td>
								<td>
									<?php echo $analisis_aq;?>
								</td>
							</tr>
						</table>
						<table class="table table-striped table-bordered">
							<tr>
								<td>EQ (EMOTIONAL QUOTIENT) <br/><b>KECERDASAN EMOSI</b></td>
								<td> Hasil : 
								<?php
								if($skor_eq < 7){
									echo "Rendah";
								}elseif($skor_eq <= 11){
									echo "Rata-Rata Bawah";
								}elseif($skor_eq <= 21){
									echo "Rata-Rata";
								}elseif($skor_eq <= 26){
									echo "Rata-Rata Atas";
								}elseif($skor_eq <= 32){
									echo "Tinggi";
								}
								?>
								</td>
							</tr>
							<tr>
								<td><img src="<?php echo base_url('assets/dashboard/images/eqBlue.jpg');?>"></td>
								<td>
									<?php echo $analisis_eq;?>
								</td>
							</tr>
						</table>
						<table class="table table-striped table-bordered">
							<tr>
								<td>AM (ACHIEVEMENT MOTIVATION) <br/><b>MOTIVASI BERPRESTASI</b></td>
								<td> Hasil : 
								<?php
								if($skor_am < 7){
									echo "Rendah";
								}elseif($skor_am <= 11){
									echo "Rata-Rata Bawah";
								}elseif($skor_am <= 21){
									echo "Rata-Rata";
								}elseif($skor_am <= 26){
									echo "Rata-Rata Atas";
								}elseif($skor_am <= 32){
									echo "Tinggi";
								}
								?>
								</td>
							</tr>
							<tr>
								<td><img src="<?php echo base_url('assets/dashboard/images/amBlue.jpg');?>"></td>
								<td>
									<?php echo $analisis_am;?>
								</td>
							</tr>
						</table>
						
						<!-- end hasil test psychological test -->
						
						
					<h4>DIAGNOSTIC TEST</h4>
					  <div class="hasil-nilai-wrapper">
						 <!-- ANALISIS TOPIK -->
						<?php
							$clr = array('c65304','14ab1d','3a41a0','36A2EB');
							$w = 0;
							foreach($kategoridiagnostic as $diagnostic){								
					?>
						<div class="hasil-nilai-container">
								<h4 style="background:#<?php echo $clr[$w]; ?>"><?php echo $diagnostic->nama_kategori; ?></h4>
								<table class="table table-striped">
									<thead>
										<tr>
											<th width="75%" style="text-align: center;">INDIKATOR</th>
											<th colspan="2" width="25%" style="text-align: center;">KETUNTASAN</th>
										</tr>
									</thead>
									<tbody>
										<?php
											foreach($analisistopik as $analisis){
												if($analisis->id_diagnostic == $diagnostic->id_diagnostic){
										?>
											<tr>
												<td>
													<?php echo $analisis->topik; ?>
												</td>
												<td>
													<?php
														if($analisis->status == 1){
															echo "Tuntas";
														}else{
															echo "Belum Tuntas";
														}
													?>
												</td>
												<td style="text-align: center;">
													<?php
														if($analisis->status == 1){
															echo '<span class="glyphicon glyphicon-thumbs-up" aria-hidden="true" style="color: green"></span>';
														}else{
															echo '<span class="glyphicon glyphicon-thumbs-down" aria-hidden="true" style="color: red"></span>';
														}
													?>
												</td>
											</tr>
										<?php
												}
											}
										?>
										
									</tbody>
								</table>
								
								<div class="col-md-6">
								<table class="table table-bordered" style="width:100%">
									<tr>
										<th style="text-align:center">Nilai</th>
									</tr>
									<tr>
										<td align="center"><?php echo $skor[$diagnostic->id_diagnostic] ;?></td>
									</tr>
								</table>
								</div>

								<div class="col-md-6">
								<table class="table table-bordered" style="width:100%">
									<tr>
										<th style="text-align:center">Kategori</th>
									</tr>
									<tr>
										<td align="center"><?php echo $kategori[$diagnostic->id_diagnostic];?></td>
									</tr>
								</table>
								</div>

								<div class="col-md-12">
								<table class="table table-bordered" style="width:100%">
									<tr>
										<th style="text-align:center" colspan="3">Ketuntasan</th>
									</tr>
									<tr>
										<td align="center" width="33.33%">Tuntas</td>
										<td align="center" width="33.33%">
										<?php
										if(isset($soalbenar[$diagnostic->id_diagnostic])){
											echo $soalbenar[$diagnostic->id_diagnostic];
										}else{
											echo 0;
										}
										?> Soal
										</td>
										<td align="center" width="33.33%">
										<?php echo $skor[$diagnostic->id_diagnostic] ;?> %
										</td>
									</tr>
									<tr>
										<td align="center">Belum Tuntas</td>
										<td align="center">
										<?php
										if(isset($soalsalah[$diagnostic->id_diagnostic])){
											echo $soalsalah[$diagnostic->id_diagnostic];
										}else{
											echo $jumlahsoalasli[$diagnostic->id_diagnostic];
										}
										?> Soal
										</td>
										<td align="center">
										<?php echo 100-$skor[$diagnostic->id_diagnostic] ;?> %
										</td>
									</tr>
								</table>
								</div>
								
								<div class="clearfix"></div>
						</div>
						<?php
							$w++;
							}
						?>
					<!-- END ANALISIS TOPIK -->
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
<script type="text/javascript" src="<?php echo base_url('assets/js/Chart.js');?>"></script>
<script>
var ctx = document.getElementById("myChart");
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [
		<?php
		foreach($kategoridiagnostic as $diagnostic){
			echo '"'.$diagnostic->nama_kategori.'",';
		}
		?>
		],
        datasets: [{
            label: '# Nilai Mata Pelajaran',
            data: [
			<?php
			foreach($kategoridiagnostic as $diagnostic){
				echo $skor[$diagnostic->id_diagnostic].",";
			}
			?>
			],
            backgroundColor: [
			<?php
			$clr = array('c65304','14ab1d','3a41a0','36A2EB');
			$i = 0;
			foreach($kategoridiagnostic as $diagnostic){
			?>
				"#<?php echo $clr[$i]; ?>",
			<?php
			$i++;
			}
			?>
			],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});
</script>

</html>
