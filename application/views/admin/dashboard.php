<div id="wrapper">   
    <div id="page-wrapper">    
        <div class="container-fluid">    
            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        <?php echo $this->lang->line('DASHBOARD') ?>
                    </h1>
                    <ol class="breadcrumb">
                        <li class="active">
                            <i class="fa fa-users"></i> <?php echo $this->lang->line('DASHBOARD') ?>
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
                                    <th><?php echo $this->lang->line('SHOW_NAME') ?></th>
                                    <th><?php echo $this->lang->line('REGISTERED_AT') ?></th>
                                    <th><?php echo $this->lang->line('STATUS') ?></th>
                                    <th><?php echo $this->lang->line('ACTION') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($users)) { 

                                    foreach ($users as $key=>$user) { ?>
                                    <tr>
                                        <td><?php echo $key+1; ?></td>
                                        <td><?php echo $user->user_name; ?></td>
                                        <td><?php echo $user->user_reg_date; ?></td>
                                        <td><?php echo ($user->user_enable==1) ? '<span class="label label-success">Enabled</span>' : '<span class="label label-danger">Disabled</span>'  ?></td>
                                        <td class="text-left">
                                            <?php if($user->user_enable!=1): ?>
                                                <a href="<?php echo base_url(ADMIN_URL) ?>user/activate/<?php echo urlencode(base64_encode($user->user_id)); ?>" class="delete" title="Activate User"><i class="fa fa-check"></i></a> 
                                            <?php else: ?>
                                                <a href="<?php echo base_url(ADMIN_URL) ?>user/block/<?php echo urlencode(base64_encode($user->user_id)); ?>" title="Block User" class="delete"><i class="fa fa-times"></i></a> 
                                            <?php endif; ?>
                                            | <a href="javascript:;" title="View Details" data-toggle="modal" data-target="#user-modal-<?=$key?>"><i class="fa fa-eye"></i></a>
                                        </td>
                                    </tr>
                                    <!-- Modal -->
                                      <div class="modal fade" id="user-modal-<?=$key?>" role="dialog">
                                        <div class="modal-dialog">
                                        
                                          <!-- Modal content-->
                                          <div class="modal-content">
                                            <div class="modal-header">
                                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                                              <h4 class="modal-title">User Details</h4>
                                            </div>
                                            <div class="modal-body">
                                                <?php
                                                    $details = array(
                                                        'Name'=>'user_name',
                                                        'Age'=>'user_age',
                                                        'Gender'=>'user_gender',
                                                        'Date of birth'=>'user_dob',
                                                        'Mobile number' =>'user_mobile',
                                                        'Alternate Mobile 1'=>'user_alt_mobile',
                                                        'Alternate Mobile 2'=>'user_alt_mobile1',
                                                        'Landline Number'=>'user_landline',
                                                        'Address'=>'user_address',
                                                        'Village'=>'village_name',
                                                        'Tehsil'=>'tehsil_name',
                                                        'District'=>'district_name',
                                                        'Pin'=>'user_pin',
                                                        'Registraion Date'=>'user_reg_date',
                                                        'Status'=>'user_enable_str'
                                                    );
                                                 ?>
                                                 <?php
                                                 foreach ($details as $label => $value) {?>
                                                    <div class="row">
                                                      <div class="col-sm-6">
                                                        <?=$label?>:     
                                                      </div>
                                                      <div class="col-sm-6">
                                                          <?=($user->$value!='')? $user->$value: 'N/A'?>
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
