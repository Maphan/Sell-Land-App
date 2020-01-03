<div class="col-lg-3">
				<div class="well text-center" style="border: 1px solid #BCBCBC;">
					<form id="signinForm" action="#" enctype="multipart/form-data" method="post">
				  		<table width="100%" height="320px;" border="0" cellspacing="0" cellpadding="0">
						  <tbody>
							<tr>
								<td valign="top" align="center" height="50px">
									<span class="glyphicon glyphicon-cog color-main2" style="font-size: 60px;"></span><br>
								</td>
							</tr>
							<tr>
							  <td id="detail_user" valign="top" height="21%" align="left" class="font text-size-20" style="padding-left:5px;">
                              		<div class="text-center" style="border-bottom: 1px solid #FFF; margin: 10px;">
										<span class="text-size-22"><b> <?php echo $row_Myuser['Username'];?></b>
                                    </div>
                                    <span class="glyphicon glyphicon-envelope text-size-12 color-main1"></span><span><b> <?php echo $row_Myuser['Email']; ?></b></span><br>
                                    <span class="glyphicon glyphicon-phone-alt text-size-12 color-main1"></span><span><b><?php echo $row_Myuser['Phone1']; ?></b></span><br>
                                    <?php if($row_Myuser['Phone2']!=NULL){?>
                                    <span class="glyphicon glyphicon-phone-alt text-size-12 color-main1"></span><span><b><?php echo $row_Myuser['Phone2']; ?></b></span><br><?php }else{}?>
                                    <?php if($row_Myuser['Line']!=NULL){?>
                                    <b><span class="color-main1">Line ID</span> : <?php echo $row_Myuser['Line']; ?></b></span><br><?php }else{}?>
                                     <?php if($row_Myuser['FB']!=NULL){?>
                                    <span><a target="_blank" href="<?php echo $row_Myuser['FB']; ?>"><b>Facebook</b></a></span><br><?php }else{}?>
							  </td>
							</tr>
							<tr>
							  <td valign="top" align="center">
							  	<hr>
								 <a href="chang_pass.php?id_user=<?php echo $row_Myuser['ID_user']; ?>" type="submit" class="btn btn-warning" style="width:80%;"><span class="glyphicon glyphicon-lock"></span>เปลี่ยนรหัสผ่าน</a>
							  </td>
							</tr>
                            <tr>
							  <td valign="top" align="center">
								 <a href="edit_profile.php?id_user=<?php echo $row_Myuser['ID_user']; ?>" type="submit" class="btn btn-warning" style="width:80%;"><span class="glyphicon glyphicon-pencil"></span>แก้ไขข้อมูล</a>
							  </td>
							</tr>						
						  </tbody>
						</table>
					</form>
				</div>
                
                <a href="dashboard.php" class="btn btn-warning" style="width:100%; margin-bottom:5px;">
                	<span class="glyphicon glyphicon-list-alt"></span>ประกาศทั้งหมด
                </a>
                <a href="profile.php?id_user=<?php echo $row_Myuser['ID_user']; ?>" class="btn btn-warning" style="width:100%; margin-bottom:5px;">
                	<span class="glyphicon glyphicon-bullhorn"></span>ประกาศของฉัน
                </a> 
                <a href="user_members.php" class="btn btn-warning" style="width:100%; margin-bottom:5px;">
                	<span class="glyphicon glyphicon-user"></span>บัญชีผู้ใช้งานทั้งหมด
                </a>
                
                
			</div>