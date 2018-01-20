<div class="collapse navbar-collapse navbar-ex1-collapse">
    <ul class="nav navbar-nav side-nav">
        <li class="<?=($activeTab && $activeTab=='dashboard') ? 'active' : '' ?>">
            <a href="<?php echo base_url(ADMIN_URL) ?>"><i class="fa fa-fw fa-users"></i>&nbsp;&nbsp;&nbsp;<?php echo $this->lang->line('DASHBOARD') ?></a>
        </li>
        <li class="<?=($activeTab && $activeTab=='catagories') ? 'active' : '' ?>">
            <a href="<?php echo base_url(ADMIN_URL) ?>categories"><i class="fa fa-database"></i>&nbsp;&nbsp;&nbsp;<?php echo $this->lang->line('CATEGORIES') ?></a>
        </li>
        <li class="<?=($activeTab && $activeTab=='post') ? 'active' : '' ?>">
            <a href="<?php echo base_url(ADMIN_URL) ?>post"><i class="fa fa-newspaper-o"></i>&nbsp;&nbsp;&nbsp;<?php echo $this->lang->line('POST') ?></a>
        </li>
    </ul>
</div>