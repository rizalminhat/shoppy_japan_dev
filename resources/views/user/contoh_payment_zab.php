<?php
$page = 'sumbangan';
include('../includes/connection.php');
include('../includes/auth.php');	

if(isset($_GET['type']) && $_GET['type'] == 'yuran'){
	$headunit = '<h3  style="text-transform:uppercase;">Bayaran Yuran</h3>';
	$title = 'Bayaran Yuran Khairat';
}else{
	$headunit = '<h3  style="text-transform:uppercase;">Sumbangan</h3>';
	$title = 'Sumbangan';
}

if(isset($_GET['debug']) && $_GET['debug'] == 'session')
{
	print_r($_SESSION);
} 

if(isset($_GET['ssl']) && $_GET['ssl'] == $_SESSION['ssl'])
{
	
	
	$namalogin=$_SESSION['namapengguna'];
    $id = $_SESSION['id'];
	$sql_sesi = "(SELECT * FROM user INNER JOIN user_login ON user_id = login_id_link WHERE login_id = '$id' AND login_position='user')";
	
    $result_sesi = mysqli_query($connection, $sql_sesi);
	
    while($row_sesi = mysqli_fetch_array($result_sesi))  
    {  
		$user_statuss=$row_sesi["user_status"];
		$positi=$row_sesi["user_name"];
		$ic_link = $row_sesi["user_ic"];
		$id_link = $row_sesi["login_id_link"];
		$profilepic = $row_sesi["user_profilepic"];
		$user_dituntut = $row_sesi["user_dituntut"];
		$user_email = $row_sesi['user_email'];
    }

?>
<!DOCTYPE html>
<html lang="en">

<head>
  	<?php include "../header.php" ?>
    <?php include "../css_file.php" ?>
</head>

<body>
    <div id="app">
       <?php include "../sidebar_v2.php"; ?>
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

            <div class="page-heading">
                <div class="page-title">
                    <div class="row">
                        <div class="col-12 col-md-8 order-md-1 order-last">
                            <?php echo $headunit;?>
                        </div>
                        <div class="col-12 col-md-4 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                  <?php 
									if(isset($_GET['type']) && $_GET['type'] == 'yuran')
									{
										?>
										<li class="breadcrumb-item">
											<a href="#">Bayaran Yuran Akhirat</a>
										</li>
										<?php
									}
									else
									{
										?>
										<li class="breadcrumb-item">
											<a href="#">Sumbangan</a>
										</li>
										<?php
									}
									?>
                                   
                                    <li class="breadcrumb-item active">
										<div class="avatar me-3">
                                      <?php echo '<img src="../../user/profilepicture/'.$profilepic.'" height="100" width="100" alt="">';?>
                            			</div>
									</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                
              <?php  $sql ="SELECT * FROM ahli INNER JOIN user on user_id = ahli_id_link  WHERE ahli.ahli_id_link = $id_link AND (user.user_status = 2 OR user.user_status=3 OR user.user_status = 6)";
				$res = mysqli_query($connection,$sql);
				if(mysqli_num_rows($res) > 0)
				{
				while($row = mysqli_fetch_assoc($res))
					{
					//	$status = $row['ahli_status'];
					//	$bayaran_date = strtotime($row['bayaran_date']);
							?>
                <section class="section">
                    <div class="row" id="table-responsive">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-body">
                                    <h6 class="card-title"  style="text-transform:uppercase;"><?php echo $title;?></h6>
                                    <hr>
                                    <form action="../../zpay/request.php" method="post" enctype="multipart/form-data">
										<!-- **form tuntutan tanggungan -->
										<?php 
											if(isset($_GET['type']) && $_GET['type'] == 'yuran'){
												?>
										<div class="row">
											<!-- <label class="cs-font">Lengkapkan maklumat bertanda <span class="text-danger">*</span></label> -->
											<div class="col-md-2 col-12">
												<div class="form-group">
													<label  style="font-size:13px;color: black"><span class="text-danger">*</span><strong>TAHUN</strong></label>
												</div>
											</div>
											<div class="col-md-5 col-12">
											
												<!-- <input type="text" class="form-control"  style="color: black" value="<?php echo date('Y');?>" readonly>  -->
												<fieldset class="form-group">
                                                    <select class="form-select" id="yearSelect" name="yuran_year">
                                                        <option value='' disabled selected>--SILA PILIH TAHUN--</option>
														<?php 
														$date = date('Y');
														for($x=$date; $x>=2015; $x--)
														{
														echo '<option value="'.$x.'">'.$x.'</option>';
														}
														?>
                                                    </select>
                                                </fieldset>
												
											</div>
										</div>
										<div class="row">
											
<!--												<input type="hidden" name="item" value="yuran"/>-->
												<input type="hidden" id="typeOnline" name="type" value="yuran"/>
												<div class="col-md-2 col-12">
													<div class="form-group">
														<label  style="font-size:13px;color: black"><span class="text-danger">*</span><strong>JENIS YURAN</strong></label>
													</div>
												</div>
												<div class="col-md-5 col-12">
													<div class="form-group">
														
<!--
														<input type="radio" name="item" id="yearly" value="Yuran Tahunan"/> Yuran Tahunan
														<input type="radio" name="item" id="full" value="Yuran Seumur Hidup"/> Yuran Seumur Hidup
-->
													<ul class="list-unstyled mt-2">
															<li class=" me-2 mb-1">
																<div class="form-check">
																	<div class="radio">
																	<input type="radio" id="yearly" class="form-check-input check-2" value="Yuran Tahunan" name="item" >
																	<label for="checkbox1" class="cs-font">Yuran Tahunan [RM50]</label>
																	</div>
																</div>
															</li>

															<li class="d-inline-block me-2 mb-1">
																<div class="form-check">
																	<div class="radio">
																		<input type="radio" class="form-check-input check-2" id="full" value="Yuran Seumur Hidup" name="item">
																		<label for="checkbox2" class="cs-font">Yuran Seumur Hidup [RM500]</label>
																	</div>
																</div>
															</li>
														</ul>
													</div>
												</div>
											</div> 
											<div class="row">
												<div class="col-md-2 col-12">
													<div class="form-group">
														<label  class="cs-font"><strong>Jumlah Yuran</strong></label>
													</div>
												</div>
												<div class="col-md-5 col-12">
													<div class="form-group">
														<div class="input-group">
														<div class="input-group-prepend"><span class="input-group-text">RM</span>
														</div>
														<input type="text" class="form-control amount" name="amount" style="color: black" id="amount" readonly required>
													</div>
													</div>
												</div>
											</div>
												
											<?php
											}else{
											?>
											<input type="hidden" name="item" value="sumbangan"/>
											<input type="hidden" name="type" value="user_open" id="typeOnline"/>
											<div class="row">
												<div class="col-md-2 col-12">
													<div class="form-group">
														<label  style="font-size:13px;color: black"><strong>JUMLAH SUMBANGAN</strong></label>
													</div>
												</div>
												<div class="col-md-5 col-12">
													<div class="form-group">
														<div class="input-group">
														<div class="input-group-prepend"><span class="input-group-text">RM</span>
														</div>
														<input type="number"  min="1.00" max="29998" class="form-control numeric" name="amount" style="color: black"  id="amount2" required>
														</div>
													</div>
												</div>
											</div>
											
											
												<?php }?>
											<div class="row">
												<div class="col-md-2 col-12">
													<div class="form-group">
														<label  style="font-size:13px; color: black"><strong>TARIKH</strong></label>
													</div>
												</div>
												<?php $date = date("Y-m-d"); ?>
												<div class="col-md-5 col-12">
													<div class="form-group">
													   <input type="date" class="form-control" name="tarikh" style="text-transform:uppercase;  font-size:13px; color: black" value="<?php echo $date?>" readonly>
													</div>
												</div>
											</div>
											
										<div class="row">
											<div class="col-md-2 col-12">
                                                <div class="form-group">
                                                    <label  style="font-size:13px; color: black"><strong>KAEDAH PEMBAYARAN</strong></label>
                                                </div>
                                            </div>
											<div class="col-md-5 col-12">
                                                <div class="form-group">
													<select id="paytype" class="form-control" style="text-transform:uppercase;  font-size:13px; color: black"
                                                            name="paytype" required>
															<option value="FPX">Financial Process Exchange (FPX)</option>
													</select>
                                                </div>
                                            </div>
										</div>
										<div class="row">
											<div class="col-md-2 col-12">
                                                <div class="form-group">
                                                    <label  style="font-size:13px; color: black"><strong>PILIHAN BANK</strong></label>
                                                </div>
                                            </div>
											<div class="col-md-5 col-12">
                                                <div class="form-group">
													<select id="bankpay" class="form-control" style="text-transform:uppercase;  font-size:13px; color: black"
                                                            name="bankpay" required>
														<option value="" disabled selected>--Pilih Bank--</option>
														<?php
														foreach($data as $dk => $dv)
														{
															$dlist = preg_split("/@/",$dv);
															if($dlist[2] == 0)
															{
																echo '<option value="'.$dlist[0].'" disabled="disabled">'.$dlist[1].' (Offline)</option>';
															}
															else
															{
																echo '<option value="'.$dlist[0].'">'.$dlist[1].'</option>';
															}
														}
														?>
													</select>
                                                </div>
                                            </div>
										</div>
										<div class="row">
											<div class="col-md-2 col-12">
                                                <div class="form-group">
                                                    <label  style="font-size:13px; color: black"><strong>EMEL</strong></label>
                                                </div>
                                            </div>
											<div class="col-md-5 col-12">
                                                <div class="form-group">
													<input type="email" class="form-control" name="useremail" style="font-size:13px; color: black" value="<?php echo $user_email?>" required>
                                                </div>
                                            </div>
										</div>
										<div class="row">								
											<div class="col-md-2 col-12">
												<div class="form-group">
													<label  class="cs-font"><strong>Caj Transaksi</strong></label>
												</div>
											</div>
											<div class="col-md-5 col-12">
												<div class="form-group">
													<div class="input-group">
														<div class="input-group-prepend"><span class="input-group-text">RM</span>
														</div>
														<input type="text" class="form-control"  value="<?php echo number_format(1.50,2) ?>" readonly>
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-2 col-12">
												<div class="form-group">
													<label  style="font-size:13px;color: black"><strong>JUMLAH PERLU DIBAYAR</strong></label>
												</div>
											</div>
											<div class="col-md-5 col-12">
												<div class="form-group">
													<div class="input-group">
														<div class="input-group-prepend"><span class="input-group-text">RM</span></div>
														<input id="totalAll" type="number" class="form-control"  style="color: black" step="0.01" readonly>
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-12 my-3">
												<div class="form-check">
												  <input class="form-check-input checkfpx" type="checkbox" value="" id="checkbyr">
												  <label class="form-check-label" for="flexCheckDefault">
													 <p style="color: black">
													  

													Dengan klik pada butang  <b>“Teruskan Pembayaran”</b>, anda bersetuju dengan
												  <a style="cursor: pointer; color:blue;" onclick="javascript:window.open('https://www.mepsfpx.com.my/FPXMain/termsAndConditions.jsp', 'cont', 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no,titlebar=no, width=550, height=500');"><b> <u>Terma &amp; Syarat FPX</u></b></a></p>
												  </label>
												</div>


											</div>
										</div>
										<div class="row">
											<div class="col-md-6 col-lg-3 bg-payment">
											<img class="img-payment m-1" src="../../sistem/assets/images/backgrounds/zPay(kuningputih)-min.png" width="90px"alt="">
												
											<img class="img-payment m-1" src="../../sistem/assets/images/backgrounds/fpx.png" alt="" width="110px">
											</div>
										</div>
										<div class="row">
											<div class="col-md-5 col-12">
                                                <div class="form-group">
													<input type="hidden" name="user_id" value="<?php echo $id_link?>">
													<input type="hidden" value="<?php echo $ic_link?>" name="user_ic">
													<input type="hidden" value="<?php echo $positi?>" name="user_name">
                                                </div>
                                            </div>
										</div>
											<div class="text-right">
												<button type="submit"
													class="btn btn-primary me-1 mb-1 btn-sm" name="sumbang" style="font-size: 13px" disabled id="btn-byr1">TERUSKAN PEMBAYARAN</button>
												<input type="reset" class="btn btn-light-secondary me-1 mb-1 btn-sm" style="font-size: 13px" value="TETAPKAN SEMULA">
											</div>
                                        </div>
                                    </form>
                                    </div> 
                                </div>
                                
                            </div>
                        </div>
                    </div>
				
				<?php if(!isset($_GET['type']) && empty($_GET['type']))
				{
															
				?>							
				<div class="row">
					<div class="col-md-12">
						<div class="card">
							<div class="card-content">
								<div class="card-body">
									<h6 class="card-title text-uppercase">Rekod Sumbangan</h6>
									<hr>
									<div class="table-responsive">
										<table class="table table-striped table-bordered" id="table2">
											<thead style="background-color: lightsteelblue">
											<tr>
												<td class="text-center cs-font"><b>BIL</b></td>
												<td class="cs-font"><b>NAMA BANK</b></td>
												<td class="cs-font"><b>NO RUJUKAN</b></td>
												
												<td class="text-center cs-font"><b>JUMLAH (RM)</b></td>
												<td class="text-center cs-font"><b> TARIKH DAN MASA</b></td>
												
											</tr>
										</thead>
										<tbody style="text-transform:uppercase;  font-size:13px;">
										<?php
										$i=1;
										$sql="SELECT *, DATE_FORMAT(online_trans_status_datetime, '%d-%m-%Y %r')AS tarikh_sumbang FROM sumbangan LEFT JOIN online_payment ON sumbangan_online_ref = online_trans_status_trid LEFT JOIN online_order ON online_order_token = online_trans_code WHERE sumbangan_user_link = '$id_link' ORDER BY tarikh_sumbang DESC";
										$result2 = mysqli_query($connection, $sql);
										if (mysqli_num_rows($result2) > 0) 
										{	
											while($row = mysqli_fetch_assoc($result2))
											{
												$bankName = $row['online_order_bank_code'];
												$jumlah = number_format($row['sumbangan_jumlah'],2); 
											?>
											<tr>
												<td class="text-center cs-font"><?php echo $i++; ?></td>
												
												<td class="cs-font">
												<?php 
												foreach($data as $dk => $dv)
												{
													$dlist = preg_split("/@/",$dv);

													if($dlist[0] === $bankName)
													{
														echo $dlist[1];
													}
													
												}
												?>
												</td>
												<td class="text-left cs-font"><?php echo $row['sumbangan_online_ref']; ?></td>
												<td class="text-right cs-font"><?php echo strtoupper($jumlah); ?> </td>
												<td class="text-center cs-font"><?php echo $row['tarikh_sumbang']; ?></td>
												
											</tr>
											<?php
											}
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
			<?php } ?>
<!--endrekod-->
</section>
				
             
		<?php 
			}
				}
				else if ($user_statuss== 1)
				{ 
				?>
				<div class="row">
					<div class="col-md-12">
						<div class="card">
							<div class="card-content">
								<div class="card-body">
									<div class="col-md-12">
									<?php
									$findBayaran = "SELECT * FROM `bayaran` WHERE bayaran_id_link = $id_link  AND bayaran_tahun = YEAR (CURDATE())";
									$result = mysqli_query($connection, $findBayaran);
									if(mysqli_num_rows($result)> 0 )
									{
										$row = mysqli_fetch_assoc($result);
										$online_ref = $row['bayaran_online_ref'];
										$payment_method = $row['bayaran_kaedah'];

										echo '<h4 class="text-danger">Anda Sudah Mendaftar Sebagai Ahli Khairat. Sila Tunggu Untuk Pengesahan Bayaran</h4>';

									}
									else
									{
										echo '<h4 class="text-danger">Bayaran Yuran Keahlian Tidak Lengkap</h4>';
										echo '<a class="btn btn-success" href="bayaran_semula.php?ssl='.$_SESSION['ssl'].'">Bayar Semula Yuran </a>';
									}
									?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php
				}
					
					
					else if ($user_statuss==0){ ?>
					
                    <div class="row">
                        <div class="col-md-12">
							<div class="card">
							<div class="card-content">
									<div class="card-body">
											<div class="col-md-12">
												<h4 class="text-danger">Anda Masih Belum Mendaftar Sebagai Ahli Khairat</h4>
												<a class="btn btn-success" href="../khairat/daftar.php?ssl=<?php echo 
												$_SESSION['ssl']; ?>" >Daftar</a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					<?php } else if ($user_statuss== 4 ){ ?>
					
                    <div class="row">
                        <div class="col-md-12">
							<div class="card">
							<div class="card-content">
									<div class="card-body">
											<div class="col-md-12">
												<h4 class="text-danger">Keahlian Anda Sudah Terbatal. Anda Perlu Mendaftar Sebagai Ahli Khairat</h4>
												<a class="btn btn-success" href="../khairat/reactive_ahli.php?ssl=<?php echo 
												$_SESSION['ssl']; ?>" >Daftar</a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					
					<?php } ?>
           		

            <?php 
            include "../footer.php"; ?>
						 </div>
        </div>
    </div>
	<div class="modal fade text-left" id="large" tabindex="-1" style="display: none;" aria-labelledby="myModalLabel17"  aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered  modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header text-center bg-primary">
					<h3 class="modal-title mx-auto  text-white" id="myModalLabel17">PERINGATAN PEMBAYARAN MENGGUNAKAN ZPAY</h3>
					<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><i data-feather="x"></i>
					</button>
				</div>
				<div class="modal-body">
					<div class="row my-3">
<!--
					<div class="mb-3 text-center">
						<img src="khairat/logo/logo_ekhairat.png" alt="" width="30%">
					</div>
-->
					
						<h6 class="text-danger">PERINGATAN </h6>
						
					   <p class="mx-auto text-justify"><span class="text-danger">*</span> SELEPAS BERJAYA MEMBUAT PEMBAYARAN, PASTIKAN HALAMAN TERAKHIR ANDA SEPERTI GAMBAR DIBAWAH SUPAYA SETIAP TRANSAKSI YANG DIBUAT DAPAT DISIMPAN.</p>
					   <p class="text-uppercase">Terima Kasih.</p>
					   <img src="../assets/images/notis-zpay.png" alt="">
					</div>
					
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-bs-dismiss="modal">
						<i class="bx bx-x d-sm-none"></i>
						<span class="d-sm-block">Tutup</span>
					</button>

				</div>
			</div>
		</div>
	</div>
    <?php include "../js_file.php"; ?>

    <?php }
 	else
    {
		include('../logout_v2.php');
    } 
	?>
    <!-- **** addon script ****-->
        <!-- **** script sweetalert****-->
    <?php
	if(isset($_SESSION['semak']) && $_SESSION['semak'] != '')
	{
		?>
	<script>	
	Swal.fire({
		title: '<?php echo  $_SESSION['semak'];?>',
		//text: 'Do you want to continue',
		icon: '<?php echo  $_SESSION['semak_code'];?>',
		confirmButtonText: 'Keluar'
	})
	</script>
	<?php
	unset($_SESSION['semak']);
	}
	?>

     <!-- **** script toastify ****-->
    <?php
	if(isset($_SESSION['update']) && $_SESSION['update'] != '')
	{
		?>
	<script>	
        Toastify({
        text: '<?php echo  $_SESSION['update'];?>',
        duration: 5000,
        close:true,
        gravity:"top",
        position: "right",
        backgroundColor: "#4fbe87",
    }).showToast();
	</script>
	<?php
	unset($_SESSION['update']);
	}
	?>

    <script>
       
		
		function valueTanggungan(sum)
	{
		let checktgg1 = [];
		$.each($("input:checkbox[class=nilai_tuntutbaru]:checked"), function() 
		{
			checktgg1.push($(this).data('value'));

		});
		
		let result = checktgg1.map(i=>Number(i));
		console.log(checktgg1);
		console.log(result);
		
		var sum = result.reduce(function(a, b){
		return a + b ;
		});
		
		console.log(sum);
		var display = document.getElementById("hasil").value = sum;

	};
		
		

		
	$("input[name='item']").click(function()
	{
		var radioValue = $(this).val();
		 if($(this).prop("checked")== true)
		 {
//			 console.log(radioValue);
//			 checkFpx()
		 }
		if(radioValue == 'Yuran Seumur Hidup'){
			$("#amount").val('500.00');
		}
		else{
			$("#amount").val('50.00');
		}
	});
		
	
    </script>	
	<?php if(!isset($_GET['type']) && empty($_GET['type']))
	{
		?>
		<script>
			let dataTable = new simpleDatatables.DataTable(table2);
		</script>
		<?php
	}
	?>
	<script>
		let table2 = document.querySelector('#table2');
        
		var type = document.getElementById("typeOnline").value;
		var checkByr = document.getElementById("checkbyr");
		var check2 = document.getElementsByClassName("check-2");
		var full = document.getElementById("full");
		var yearly = document.getElementById("yearly");
		var btn = document.getElementById("btn-byr1");
		var totalSumbangan = document.getElementById("amount2");
		var inputTotal = document.getElementById("totalAll");
		
		
	 	checkByr.addEventListener('change', (event) => {
			if (event.currentTarget.checked) 
			{
				if(type == 'user_open')
				{

					btn.disabled = false;
				}

				if(type == 'yuran')
				{
					if(yearly.checked || full.checked)
					{			
						let s = document.getElementById('yearSelect');
						var sValue = s.options[s.selectedIndex].value;
						if(sValue != '')
						{
							btn.disabled = false;
						}
					}
				}
			} 
			else 
			{
				btn.disabled = true;
			}
		});
		
		if(type == 'user_open')
		{
			totalSumbangan.addEventListener('keyup', function(e){
				var count = totalSumbangan.value;
				var tot1 = parseFloat(count) + 1.50;
				inputTotal.value =  tot1.toFixed(2);

    		});  
		}
		
		if(type=='yuran')
		{
			let yuranType  = document.getElementsByClassName("check-2");
			for (let i = 0; i < yuranType.length; i++) 
			{
			  
				yuranType[i].addEventListener('click', function(e)
			  	{
					let amount1 = document.getElementById("amount").value;

					let totYuran = parseFloat(amount1) + 1.50;
					inputTotal.value = totYuran.toFixed(2);
				});
			}	
		}

	</script>
	
	<?php
if(isset($_SESSION['tuntut']) && $_SESSION['tuntut'] != '')
	{
		?>
	<script>	
	Swal.fire({
		title: '<?php echo  $_SESSION['tuntut'];?>',
		// text: '',
		icon: '<?php echo  $_SESSION['tuntut_code'];?>',
		confirmButtonText: 'Keluar'
	})
	</script>
	<?php
	unset($_SESSION['tuntut']);
	}
	?>

</body>
</html>
<script>
	$(document).ready(function(){
        $("#large").modal('show');
    });
</script>