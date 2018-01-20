<div id="wrapper">   
    <div id="page-wrapper">    
        <div class="container-fluid">
			<div class="row">
			    <div class="col-lg-12">
			        <h1 class="page-header">
			            <?php echo $this->lang->line('CATEGORY_PAGE') ?>
			        </h1>
			        <ol class="breadcrumb">
			            <li class="active">
			                <i class="fa fa-database"></i>&nbsp;&nbsp;&nbsp;<?php echo $this->lang->line('CATEGORY_PAGE') ?>
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
							<a href="<?php echo base_url(ADMIN_URL); ?>category/add"><button class="btn btn-primary"><i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;<?php echo $this->lang->line('ADD_NEW') ?></button></a>
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
									<th><?php echo $this->lang->line('CATEGORY_NAME') ?></th>
									<th><?php echo $this->lang->line('CATEGORY_PARENT') ?></th>
									<th><?php echo $this->lang->line('STATUS') ?></th>
									<th><?php echo $this->lang->line('ACTION') ?></th>
							</tr>
							</thead>
							<tbody>
								<?php if(!empty($AllCategories)) { 

									foreach ($AllCategories as $key=>$category) { ?>
									<tr>
										<td><?php echo $key+1; ?></td>
										<td><?php echo $category->catName; ?></td>
										<td><?php echo ($category->parentCat==NULL) ? 'Main' : $category->parentCat ; ?></td>
										<td><?php echo ($category->catStatus==1) ? '<span class="label label-success">Active</span>' : '<span class="label label-danger">Inactive</span>'  ?></td>
										<td class="text-left">
											<a href="<?php echo base_url(ADMIN_URL) ?>category/edit/<?= $category->catSlug ?>"><i class="fa fa-edit" title="Edit Category"></i></a> | <?php if($category->catStatus!=1): ?>
													<a href="<?php echo base_url(ADMIN_URL) ?>category/activate/<?php echo $category->catSlug; ?>" class="delete" title="Activate Category"><i class="fa fa-check"></i></a> 
												<?php else: ?>
													<a href="<?php echo base_url(ADMIN_URL) ?>category/block/<?php echo $category->catSlug; ?>" title="Block Category" class="delete"><i class="fa fa-times"></i></a> 
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
