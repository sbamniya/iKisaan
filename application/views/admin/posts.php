<div id="wrapper">   
    <div id="page-wrapper">    
        <div class="container-fluid">    
            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        <?php echo $this->lang->line('POST') ?>
                    </h1>
                    <ol class="breadcrumb">
                        <li class="active">
                            <i class="fa fa-newspaper-o"></i> <?php echo $this->lang->line('POST') ?>
                        </li>
                    </ol>
                </div>
            </div>
           <!-- /.row -->    
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
                </div>
            </div>
            <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12 mar-top-10"></div>
           <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                <div class="table-responsive">
                    <table class="datatable">
                            <thead>
                                <tr>
                                    <th><?php echo $this->lang->line('SR_NUMBER') ?></th>
                                    <th><?php echo $this->lang->line('IMAGE') ?></th>
                                    <th><?php echo $this->lang->line('POST_TITLE') ?></th>
                                    <th><?php echo $this->lang->line('DESCRIPTION') ?></th>
                                    <th><?php echo $this->lang->line('CATEGORY') ?></th>
                                    <th><?php echo $this->lang->line('SUB_CATEGORY') ?></th>
                                    <th><?php echo $this->lang->line('CO_SUB_CATEGORY') ?></th>
                                    <th><?php echo $this->lang->line('POSTED_BY') ?></th>
                                    <th><?php echo $this->lang->line('POSTED_AT') ?></th>
                                    <th><?php echo "Add Valid Till" ?></th>
                                    <th><?php echo $this->lang->line('STATUS') ?></th>
                                    <th><?php echo $this->lang->line('ACTION') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($posts)) { 

                                    foreach ($posts as $key=>$post) { ?>
                                    <tr>
                                        <td><?php echo $key+1; ?></td>
                                        <?php
                                            if ($post->ad_images!='' && $post->ad_images!=null) {
                                                $imgPath = SHOW_IMAGE_PATH;
                                                $imgPath .= explode(',', $post->ad_images)[0];
                                            }else{
                                                $imgPath = SHOW_IMAGE_PATH.'default-thumbnail.jpg';
                                            }
                                         ?>
                                        <td><img src="<?=$imgPath?>" alt="<?=$post->ad_title?>" class="img-responsive"></td>
                                        <td><?php echo $post->ad_title; ?></td>
                                        <td><?php echo $post->ad_description; ?></td>
                                        <td><?php echo $post->category_name; ?></td>
                                        <td><?php echo $post->sub_category; ?></td>
                                        <td><?php echo $post->co_sub_category; ?></td>
                                        <td><?php echo $post->user_name; ?></td>
                                        <td><?php echo $post->ad_publise_date; ?></td>
                                        <td><?php echo ($post->ad_type_duration == '') ? 'N/A' : $post->ad_type_duration; ?></td>
                                        <td><?php echo ($post->ad_enable==1) ? '<span class="label label-success">Enabled</span>' : '<span class="label label-danger">Disabled</span>'  ?></td>
                                        <td class="text-left">
                                            <?php if($post->ad_enable!=1): ?>
                                                <a href="<?php echo base_url(ADMIN_URL) ?>post/activate/<?php echo urlencode(base64_encode($post->ad_id)); ?>" class="delete" title="Activate Ad"><i class="fa fa-check"></i></a> 
                                            <?php else: ?>
                                                <a href="<?php echo base_url(ADMIN_URL) ?>post/block/<?php echo urlencode(base64_encode($post->ad_id)); ?>" title="Block Ad" class="delete"><i class="fa fa-times"></i></a> 
                                            <?php endif; ?>
                                            | <a href="javascript:;" title="View Details" data-toggle="modal" data-target="#user-modal-<?=$key?>"><i class="fa fa-eye"></i></a>
                                            | <a href="javascript:;" title="Update Duration" data-toggle="modal" data-target="#update-duration-<?=$key?>"><i class="fa fa-edit"></i></a>
                                        </td>
                                    </tr>
                                    <!-- Modal -->
                                      <div class="modal fade" id="user-modal-<?=$key?>" role="dialog">
                                        <div class="modal-dialog">
                                        
                                          <!-- Modal content-->
                                          <div class="modal-content">
                                            <div class="modal-header">
                                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                                              <h4 class="modal-title">Ad Details</h4>
                                            </div>
                                            <div class="modal-body">
                                                <?php
                                                    $details = array(
                                                        'Title'=>'ad_title',
                                                        'Description'=>'ad_description',
                                                        'Price(INR)'=>'ad_price',
                                                        'Category'=>'category_name',
                                                        'Sub Category'=>'sub_category',
                                                        'Co Sub Category' =>'co_sub_category',
                                                        'Posted By'=>'user_name',
                                                        'Posted At'=>'ad_publise_date',
                                                        'Add Type Description'=>'ad_type_description',
                                                        'Add Type Charge'=>'ad_type_charges',
                                                        'Add Valid Till'=>'ad_type_duration',
                                                        'Village'=>'village_name',
                                                        'Tehsil'=>'tehsil_name',
                                                        'District'=>'district_name',
                                                        'State'=>'state_name',
                                                        'Status'=>'ad_enable_str'
                                                    );
                                                 ?>
                                                 <div class="row">
                                                    <div class="col-sm-6">
                                                        Image:
                                                    </div>
                                                     <div class="col-sm-3">
                                                        <img src="<?=$imgPath?>" alt="<?=$post->ad_title?>" class="img-responsive">
                                                     </div>
                                                 </div>
                                                 <?php
                                                 foreach ($details as $label => $value) {?>
                                                    <div class="row">
                                                      <div class="col-sm-6">
                                                        <?=$label?>:     
                                                      </div>
                                                      <div class="col-sm-6">
                                                          <?=($post->$value!='')? $post->$value: 'N/A'?>
                                                      </div>
                                                  </div>
                                                 <?php }
                                                  ?>
                                             </div>
                                            <div class="modal-footer">
                                              <button type="button" class="btn btn-default" data-dismiss="modal">Done</button>
                                            </div>
                                          </div>
                                          
                                        </div>
                                      </div>
                                    <!-- Modal -->
                                      <div class="modal fade" id="update-duration-<?=$key?>" role="dialog">
                                        <div class="modal-dialog">
                                        
                                          <!-- Modal content-->
                                          <div class="modal-content">
                                            <div class="modal-header">
                                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                                              <h4 class="modal-title">Update Duration</h4>
                                            </div>
                                            <div class="modal-body">
                                               <form action="<?=base_url()?>post/update-duration/<?php echo urlencode(base64_encode($post->ad_id)); ?>" method="post">
                                                   <fieldset>
                                                       <div class="form-group">
                                                           <label>Duration Date</label>
                                                           <input type="text" name="duration_date" placeholder="Select Date" class="form-control datepicker" value="<?=$post->ad_type_duration?>">
                                                       </div>
                                                       <button class="btn btn-primary">Update</button>
                                                   </fieldset>
                                               </form>
                                             </div>
                                            <div class="modal-footer">
                                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            </div>
                                          </div>
                                          
                                        </div>
                                      </div>
                                <?php }
                                }
                                ?>
                            </tbody>
                        </table>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->    
    </div>
    <!-- /#page-wrapper -->    
</div>
<!-- /#wrapper -->    
