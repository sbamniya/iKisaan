<div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="<?=base_url()?>dashboard"><?php echo isset($siteName) ? $siteName : 'IKisaan' ?></a>
</div>
<!-- Top Menu Items -->
<ul class="nav navbar-right top-nav">
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?=($_SESSION['admin'] && $_SESSION['admin']['userData'] && $_SESSION['admin']['userData']['fullName']) ? $_SESSION['admin']['userData']['fullName'] : ''?><b class="caret"></b></a>
        <ul class="dropdown-menu">
            <li>
                <a href="<?php echo base_url(ADMIN_URL) ?>logout"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
            </li>
        </ul>
    </li>
</ul>