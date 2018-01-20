<div id="wrapper">   
    <div id="page-wrapper">    
        <div class="container-fluid">
			<div class="row">
			    <div class="col-lg-12">
			        <h1 class="page-header">
			            <?php echo $this->lang->line('MULTI_USER_APP_PAGE') ?>
			        </h1>
			        <ol class="breadcrumb">
			            <li class="active">
			                <i class="fa fa-film"></i>&nbsp;&nbsp;&nbsp;<?php echo $this->lang->line('MULTI_USER_APP_PAGE') ?>
			            </li>
			        </ol>
			    </div>
			</div>
			<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
				<div class="row">
					<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
						<?php 
						$error_message = $this->session->flashdata('error_message'); 
						if (isset($error_message) && !empty($error_message)) { ?>
							<div class="alert alert-danger">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							    	<span aria-hidden="true">&times;</span>
							  	</button>
							  	<?=$error_message?>
							</div>
						<?php } ?>
						<?php 
						$success_message = $this->session->flashdata('success_message');
						if (isset($success_message) && $success_message!='') { ?>
							<div class="alert alert-success">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							    	<span aria-hidden="true">&times;</span>
							  	</button>
							  	<?=$success_message?>
							</div>
						<?php } ?>
					</div>
					<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
						<div class="text-right">
							<a href="<?php echo base_url(ADMIN_URL); ?>apps/multi-user/add"><button class="btn btn-primary"><i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;<?php echo $this->lang->line('ADD_NEW') ?></button></a>
						</div>
					</div>
				</div>
				
			</div>
			<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12 mar-top-10"></div>
			<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
				<div class="table-responsive">
					<table class="datatable">
							<thead>
								<tr>
									<th><?php echo $this->lang->line('SR_NUMBER') ?></th>
									<th><?php echo $this->lang->line('APP_THUMB') ?></th>
									<th><?php echo $this->lang->line('APP_TITLE') ?></th>
									<th><?php echo $this->lang->line('APP_CATEGORY') ?></th>
									<th><?php echo $this->lang->line('TAGS') ?></th>
									<th><?php echo $this->lang->line('DESCRIPTION') ?></th>
									<th><?php echo $this->lang->line('SHOW_PROFILE_IMAGE') ?></th>
									<th><?php echo $this->lang->line('SHOW_NAME') ?></th>
									<th><?php echo $this->lang->line('IS_LOCKED') ?></th>
									<th><?php echo $this->lang->line('CREATED_BY') ?></th>
									<th><?php echo $this->lang->line('CREATED_AT') ?></th>
									<th><?php echo $this->lang->line('STATUS') ?></th>
									<th><?php echo $this->lang->line('ACTION') ?></th>
							</tr>
							</thead>
							<tbody>
								<?php if(!empty($multiUserApps)) { 

									foreach ($multiUserApps as $key=>$app) { ?>
									<tr>
										<td><?php echo $key+1; ?></td>
										<td><img src="<?=SHOW_IMAGE_PATH?><?php echo $app->appFeaturedThumb; ?>" height="50px"></td>
										<td><?php echo $app->appTitle; ?></td>
										<td><?php echo $app->catName; ?></td>
										<td><?php echo $app->appTags; ?></td>
										<td><?php echo $app->appDescription; ?></td>
										<td><?php echo ($app->showImage) ? '<span class="label label-success">Yes</span>' : '<span class="label label-danger">No</span>' ; ?></td>
										<td><?php echo ($app->showName) ? '<span class="label label-success">Yes</span>' : '<span class="label label-danger">No</span>' ;; ?></td>
										<td><?php echo ($app->isLocked) ? '<span class="label label-success">Yes</span>' : '<span class="label label-danger">No</span>' ;; ?></td>
										<td><?php echo $app->createdBy; ?></td>
										<td><?php echo $app->createdAt; ?></td>
										<td><?php echo ($app->appStatus==1) ? '<span class="label label-success">Active</span>' : '<span class="label label-danger">Inactive</span>'  ?></td>
										<td class="text-left">
											<a href="<?php echo base_url(ADMIN_URL) ?>app/multi-user/edit/<?= $app->appSlug ?>"><i class="fa fa-edit"></i></a> | <?php if($app->appStatus!=1): ?>
													<a href="<?php echo base_url(ADMIN_URL) ?>app/multi-user/activate/<?php echo $app->appSlug; ?>" class="delete"><i class="fa fa-check"></i></a> 
												<?php else: ?>
													<a href="<?php echo base_url(ADMIN_URL) ?>app/multi-user/deactivate/<?php echo $app->appSlug; ?>" title="Block App" class="delete"><i class="fa fa-times"></i></a> 
												<?php endif; ?>
											| <?php if($app->isLocked): ?>
													<a href="<?php echo base_url(ADMIN_URL) ?>app/multi-user/unlock/<?php echo $app->appSlug; ?>" class="delete"><i class="fa fa-unlock"></i></a> 
												<?php else: ?>
													<a href="<?php echo base_url(ADMIN_URL) ?>app/multi-user/lock/<?php echo $app->appSlug; ?>" title="Block App" class="delete"><i class="fa fa-lock"></i></a> 
												<?php endif; ?>
										</td>
									</tr>
								<?php }
								}
								?>
							</tbody>
						</table>
				</div>
			</div>
		</div>
	</div>
</div>
