<?php
$menu  = $this->db->get('menus')->result_array();
$group = $this->db->get('mainmenu')->result_array();
$id    = $this->session->userdata('group');
$role  = $this->db->get_where('role_menu', array('idgroups' => $id))->result_array();
$roles = $this->db->query("SELECT * FROM role_menu WHERE idgroups='$id' GROUP BY idkatmenu")->result_array();


?>
<div class="sidebar-header">
    <a href="#" class="sidebar-brand">
        Kalimo<span>soft</span>
    </a>
    <div class="sidebar-toggler not-active">
        <span></span>
        <span></span>
        <span></span>
    </div>
</div>
<?php if ($id == '1') { ?>
    <div class="sidebar-body">
        <ul class="nav">
            <li class="nav-item nav-category">main menu</li>
            <li class="nav-item">
                <a href="<?php echo base_url(); ?>main/dashboard" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Dashboard</span>
                </a>
            </li>
            <?php foreach ($group as $g) : ?>
                <?php $menu = $this->db->get_where('menus', array('kategori' => $g['id']))->result_array(); ?>
                <li class="nav-item nav-category"><?php echo $g['menu']; ?></li>
                <?php if ($menu) { ?>
                    <?php foreach ($menu as $m) : ?>
                        <?php if ($m['sub'] == 'N') { ?>
                            <li class="nav-item">
                                <a href="<?php echo base_url($m['controller'] . encrypt_url($m['link'])); ?>" class="nav-link">
                                    <i class="link-icon" data-feather="<?php echo $m['icon']; ?>"></i>
                                    <span class="link-title text-capitalize"><?php echo $m['menu']; ?></span>
                                </a>
                            </li>
                        <?php } else { ?>
                            <?php $sub = $this->db->get_where('submenu', array('idmenu' => $m['idmenus']))->result_array(); ?>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="collapse" href="#<?php echo $m['menu']; ?>" role="button" aria-expanded="false" aria-controls="uiComponents">
                                    <i class="link-icon" data-feather="<?php echo $m['icon']; ?>"></i>
                                    <span class="link-title text-capitalize"><?php echo $m['menu']; ?></span>
                                    <i class="link-arrow" data-feather="chevron-down"></i>
                                </a>
                                <div class="collapse" id="<?php echo $m['menu']; ?>">
                                    <ul class="nav sub-menu">
                                        <?php foreach ($sub as $s) : ?>
                                            <li class="nav-item">
                                                <a href="<?php echo base_url($s['controller'] . encrypt_url($s['link'])); ?>" class="nav-link text-uppercase"><?php echo $s['menu']; ?></a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </li>
                        <?php } ?>
                    <?php endforeach; ?>
                <?php } ?>
            <?php endforeach; ?>
        </ul>
    </div>
<?php } else { ?>
    <div class="sidebar-body">
        <ul class="nav">
            <li class="nav-item nav-category">main menu</li>
            <li class="nav-item">
                <a href="<?php echo base_url(); ?>main/dashboard" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Dashboard</span>
                </a>
            </li>
            <?php foreach ($group as $g) : ?>
                <?php $menu = $this->db->get_where('menus', array('kategori' => $g['id']))->result_array(); ?>
                <li class="nav-item nav-category"><?php echo $g['menu']; ?></li>
                <?php if ($menu) { ?>
                    <?php foreach ($menu as $m) : ?>
                        <?php if ($m['sub'] == 'N') { ?>
                            <li class="nav-item">
                                <a href="<?php echo base_url($m['controller'] . encrypt_url($m['link'])); ?>" class="nav-link">
                                    <i class="link-icon" data-feather="<?php echo $m['icon']; ?>"></i>
                                    <span class="link-title text-capitalize"><?php echo $m['menu']; ?></span>
                                </a>
                            </li>
                        <?php } else { ?>
                            <?php $sub = $this->db->get_where('submenu', array('idmenu' => $m['idmenus']))->result_array(); ?>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="collapse" href="#<?php echo $m['menu']; ?>" role="button" aria-expanded="false" aria-controls="uiComponents">
                                    <i class="link-icon" data-feather="<?php echo $m['icon']; ?>"></i>
                                    <span class="link-title text-capitalize"><?php echo $m['menu']; ?></span>
                                    <i class="link-arrow" data-feather="chevron-down"></i>
                                </a>
                                <div class="collapse" id="<?php echo $m['menu']; ?>">
                                    <ul class="nav sub-menu">
                                        <?php foreach ($sub as $s) : ?>
                                            <li class="nav-item">
                                                <a href="<?php echo base_url($s['controller'] . encrypt_url($s['link'])); ?>" class="nav-link text-uppercase"><?php echo $s['menu']; ?></a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </li>
                        <?php } ?>
                    <?php endforeach; ?>
                <?php } ?>
            <?php endforeach; ?>
        </ul>
    </div>
<?php } ?>