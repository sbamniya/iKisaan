<div id="wrapper">   
    <div id="page-wrapper">    
        <div class="container-fluid"> 
			<div class="row">
			    <div class="col-lg-12">
			        <h1 class="page-header">
			            <?php echo $this->lang->line('CATEGORY_DETAILS') ?>
			        </h1>
			        <ol class="breadcrumb">
			            <li class="active">
			                <?php echo $this->lang->line('CATEGORY_DETAILS') ?>
			            </li>
			        </ol>
			    </div>
			</div>
			<div class="row">
				<div class="col-md-8">
					<form class="form-horizontal form-validate-jquery cat-add-form" method="post" action="<?php echo base_url(ADMIN_URL) ?>category/edit-process/<?=$catSlug?>" enctype="multipart/form-data">
						<div class="panel panel-flat">
							<div class="panel-heading">
								<div class="row">
									<div class="col-md-6">
										<!-- <h5 class="panel-title">Add Category</h5> -->
									</div>
									<div class="col-md-6">
										<div class="text-right">
											<a href="<?php echo base_url(ADMIN_URL); ?>categories" class="btn btn-primary"><?php echo $this->lang->line('BACK') ?></a>
										</div>						
									</div>
								</div>
							</div>
							<input type="hidden" name="catSlug" value="<?=$cat->catSlug?>">
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
									<label class="col-lg-3 control-label"><?php echo $this->lang->line('CATEGORY_NAME') ?> <span class="text-danger">*</span>:</label>
									<div class="col-lg-9">
										<input type="text" name="catName" class="form-control required" placeholder="<?php echo $this->lang->line('ENTER_CATEGORY_NAME') ?>" value="<?php echo $cat->catName; ?>">
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-3 control-label"><?php echo $this->lang->line('CATEGORY_PARENT') ?> <span class="text-danger">*</span>:</label>
									<div class="col-lg-9">
										<select name="parentID" class="select required" >
											<option value="0" <?=($cat->parentID==0) ? 'selected' :''?>><?php echo $this->lang->line('PARENT_CATEGORY') ?></option>
											<?php if(!empty($AllCategories)): ?>
												<optgroup label="<?php echo $this->lang->line('PARENT_CATEGORIES') ?>">
													<?php foreach ($AllCategories as $Category) { ?>
														<option value="<?php echo $Category->catId ?>" <?=($cat->parentID==$Category->catId) ? 'selected' :''?>><?php echo $Category->catName ?></option>
													<?php	} ?>
												</optgroup>
											<?php endif; ?>
										</select>
									</div>
								</div>
								<!--  -->
								<div class="text-right">
									<button type="submit" class="btn btn-primary"><?php echo $this->lang->line('UPDATE_BUTTON') ?><i class="icon-arrow-right14 position-right"></i></button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>