<div id="wrapper">   
    <div id="page-wrapper">    
        <div class="container-fluid"> 
			<div class="row">
			    <div class="col-lg-12">
			        <h1 class="page-header">
			            <?php echo $this->lang->line('ADD_APP') ?>
			        </h1>
			        <ol class="breadcrumb">
			            <li class="active">
			                <?php echo $this->lang->line('ADD_APP') ?>
			            </li>
			        </ol>
			    </div>
			</div>
			<div class="row">
				<div class="panel-heading">
					<div class="row">
						<div class="col-md-6">
							<!-- <h5 class="panel-title">Add Category</h5> -->
						</div>
						<div class="col-md-6">
							<div class="text-right">
								<a href="<?php echo base_url(ADMIN_URL); ?>apps/single-user" class="btn btn-primary"><?php echo $this->lang->line('BACK') ?></a>
							</div>						
						</div>
					</div>
				</div>
				<form class="form-horizontal form-validate-jquery cat-add-form" method="post" action="<?php echo base_url(ADMIN_URL) ?>app/single-user/add-process" enctype="multipart/form-data">
					<div class="col-md-6">
						<div class="panel panel-flat">
							<div class="panel-body">
								<?php 
								$error_message = $this->session->flashdata('error_message'); 
								if (isset($error_message) && !empty($error_message)) { ?>
									<div class="form-group">
										<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12"></div>
										<div class="col-lg-9 col-sm-9 col-md-9 col-xs-12">
											<div class="alert alert-danger">
												<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											    	<span aria-hidden="true">&times;</span>
											  	</button>
											  	<?=$error_message?>
											</div>
										</div>
									</div>
								<?php } ?>
								<?php 
								$success_message = $this->session->flashdata('success_message');
								if (isset($success_message) && $success_message!='') { ?>
									<div class="form-group">
										<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12"></div>
										<div class="col-lg-9 col-sm-9 col-md-9 col-xs-12">
											<div class="alert alert-success">
												<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											    	<span aria-hidden="true">&times;</span>
											  	</button>
											  	<?=$success_message?>
											</div>
										</div>
									</div>
								<?php } ?>
								<div class="form-group">
									<label class="col-lg-3 control-label"><?php echo $this->lang->line('APP_TITLE') ?> <span class="text-danger">*</span>:</label>
									<div class="col-lg-9">
										<input type="text" name="appTitle" class="form-control required" placeholder="<?php echo $this->lang->line('ENTER_APP_NAME') ?>" value="<?=$appData->appTitle?>">
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-3 control-label"><?php echo $this->lang->line('APP_TITLE_COLOR') ?> <span class="text-danger">*</span>:</label>
									<div class="col-lg-9">
										<input type="text" name="appTitleColor" class="form-control required jscolor" placeholder="<?php echo $this->lang->line('ENTER_APP_TITLE_COLOR') ?>" value="<?=$appData->titleFontColor?>">
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-3 control-label"><?php echo $this->lang->line('CATEGORY') ?> <span class="text-danger">*</span>:</label>
									<div class="col-lg-9">
										<select name="categoryID" class="select required" >
											<?php if(!empty($AllCategories)): ?>
												<optgroup label="<?php echo $this->lang->line('PARENT_CATEGORIES') ?>">
													<?php foreach ($AllCategories as $Category) { ?>
														<option value="<?php echo $Category->catId ?>" <?=($appData->appCatID==$Category->catId) ? 'selected' : ''?>><?php echo $Category->catName ?></option>
													<?php	} ?>
												</optgroup>
											<?php endif; ?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-3 control-label"><?php echo $this->lang->line('TAGS') ?> <span class="text-danger">*</span>:</label>
									<div class="col-lg-9">
										<input type="text" name="appTags" class="form-control required tokenfield" data-role="tagsinput" placeholder="<?php echo $this->lang->line('ENTER_TAG') ?>" value="<?=$appData->appTags?>">
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-3 control-label"><?php echo $this->lang->line('DESCRIPTION') ?> <span class="text-danger">*</span>:</label>
									<div class="col-lg-9">
										<textarea rows="5" name="appDescription" cols="5" class="form-control required" placeholder="<?php echo $this->lang->line('ENTER_DESCRIPTION') ?>"><?=$appData->appDescription?></textarea>
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-3 control-label"><?php echo $this->lang->line('APP_FEATURED_IMAGE') ?> <span class="text-danger">*</span>:</label>
									<div class="col-lg-9">
										<input type="file" name="appFeaturedImg" class="form-control required appFeaturedImg" accept="image/*">
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-3 control-label"><?php echo $this->lang->line('SHOW_PROFILE_IMAGE') ?> <span class="text-danger">*</span>:</label>
									<div class="col-lg-9">
										<label class="radio-inline"><input type="radio" name="showProfile" value="1" <?=($appData->showImage==1) ? 'checked' :''?>>Show</label>
										<label class="radio-inline"><input type="radio" name="showProfile" value="0" <?=($appData->showImage==0) ? 'checked' :''?>>Hide</label> 
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-3 control-label"><?php echo $this->lang->line('PROFILE_IMAGE_BORDER') ?> <span class="text-danger">*</span>:</label>
									<div class="col-lg-9">
										<label class="radio-inline"><input type="radio" name="profileImgBorder" value="0" <?=($appData->profileImgBorder==0) ? 'checked' :''?>>Rectangle</label>
										<label class="radio-inline"><input type="radio" name="profileImgBorder" value="50%" <?=($appData->profileImgBorder=='50%') ? 'checked' :''?>>Circle</label> 
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-3 control-label"><?php echo $this->lang->line('SHOW_NAME') ?> <span class="text-danger">*</span>:</label>
									<div class="col-lg-9">
										<label class="radio-inline"><input type="radio" name="showName" value="1" <?=($appData->showName==1) ? 'checked' :''?>>Show</label>
										<label class="radio-inline"><input type="radio" name="showName" value="0" <?=($appData->showName==0) ? 'checked' :''?>>Hide</label> 
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-3 control-label"><?php echo $this->lang->line('IS_LOCKED') ?> <span class="text-danger">*</span>:</label>
									<div class="col-lg-9">
										<label class="radio-inline"><input type="radio" name="isLocked" value="1" <?=($appData->isLocked==1) ? 'checked' :''?>>Yes</label>
										<label class="radio-inline"><input type="radio" name="isLocked" value="0" <?=($appData->isLocked==0) ? 'checked' :''?>>No</label> 
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-3 control-label"><?php echo $this->lang->line('APP_BACKGROUND_IMAGE') ?> <span class="text-danger">*</span>:</label>
									<div class="col-lg-9">
										<input type="file" name="appBackgroundImg[]" class="form-control image-input required" accept="image/*"><br>
										<a class="btn btn-primary add-more-image"><i class="fa fa-plus"></i></a>
									</div>
								</div>
								<div class="text-right">
									<button type="submit" class="btn btn-primary"><?php echo $this->lang->line('ADD') ?><i class="icon-arrow-right14 position-right"></i></button>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="app-preview ">
							<div class="user-image-container">
								<div class=" draggable">
									<img src="<?=base_url()?>assets/images/user.png" class="img-responsive resizable" style="height: <?=$appData->profileImgHeight?>px; width: <?=$appData->profileImgWidth?>px; left: <?=$appData->profilePosLeft?>px; top: <?=$appData->profilePosTop?>px">
								</div>
								<input type="hidden" name="imgHeight" class="imgHeight" value="<?=$appData->profileImgHeight?>"><input type="hidden" name="imgWidth" class="imgWidth" value="<?=$appData->profileImgWidth?>">
								<input type="hidden" name="imgTop" class="imgTop" value="<?=$appData->profilePosTop?>"><input type="hidden" name="imgLeft" class="imgLeft" value="<?=$appData->profilePosLeft?>">
							</div>
							<div class="user-name-container">
								<div class=" draggable">
									<span>Username</span>
								</div>
								<input type="hidden" name="nameTop" class="nameTop" value="100"><input type="hidden" name="nameLeft" class="nameLeft" value="0">
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>