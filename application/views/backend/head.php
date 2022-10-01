<li class="nav-item dropdown nav-messages">
    <a class="nav-link dropdown-toggle" href="#" id="messageDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i data-feather="message-square"></i>
    </a>
    <div class="dropdown-menu" aria-labelledby="messageDropdown">
        <div class="dropdown-header d-flex align-items-center justify-content-between">
            <p class="mb-0 font-weight-medium">1 New Messages</p>
            <a href="javascript:;" class="text-muted">Clear all</a>
        </div>
        <div class="dropdown-body">
            <a href="javascript:;" class="dropdown-item">
                <div class="figure">
                    <img src="https://via.placeholder.com/30x30" alt="userr">
                </div>
                <div class="content">
                    <div class="d-flex justify-content-between align-items-center">
                        <p>#87621109</p>
                        <p class="sub-text text-muted">2 min ago</p>
                    </div>	
                    <p class="sub-text text-muted">Jaringan Putus</p>
                </div>
            </a>
        </div>
    </div>
</li>
<li class="nav-item dropdown nav-notifications">
    <a class="nav-link dropdown-toggle" href="#" id="notificationDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i data-feather="bell"></i>
        <div class="indicator">
            <div class="circle"></div>
        </div>
    </a>
    <div class="dropdown-menu" aria-labelledby="notificationDropdown">
        <div class="dropdown-header d-flex align-items-center justify-content-between">
            <p class="mb-0 font-weight-medium">2 New Notifications</p>
            <a href="javascript:;" class="text-muted">Clear all</a>
        </div>
        <div class="dropdown-body">
            <a href="javascript:;" class="dropdown-item">
                <div class="icon">
                    <i data-feather="send"></i>
                </div>
                <div class="content">
                    <p>Invoice Berhasil Di Kirim</p>
                    <p class="sub-text text-muted">2 sec ago</p>
                </div>
            </a>
            <a href="javascript:;" class="dropdown-item">
                <div class="icon">
                    <i data-feather="user-plus"></i>
                </div>
                <div class="content">
                    <p>#7871109 Jatuh Tempo Pembayaran</p>
                    <p class="sub-text text-muted">15 min ago</p>
                </div>
            </a>
        </div>
    </div>
</li>
<li class="nav-item dropdown nav-profile">
    <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <img src="<?php echo base_url();?>uploads/users/user.png" alt="userr">
    </a>
    <div class="dropdown-menu" aria-labelledby="profileDropdown">
        <div class="dropdown-header d-flex flex-column align-items-center">
            <div class="figure mb-3">
                <img src="<?php echo base_url();?>uploads/users/user.png" alt="img-profile">
            </div>
            <div class="info text-center">
                <p class="name font-weight-bold mb-0 text-capitalize"><?php echo $this->session->userdata('name');?></p>
                <p class="email text-muted mb-3">
                    <?php 
                        $group = $this->session->userdata('group');
                        $nmgroup = $this->db->get_where('groups_menu',array('idgroups'=>$group))->row()->groups;
                        echo ucwords($nmgroup);
                    ?>
                </p>
            </div>
        </div>
        <div class="dropdown-body">
            <ul class="profile-nav p-0 pt-3">
                <!-- <li class="nav-item">
                    <a href="<?php echo base_url();?>user/profile" class="nav-link">
                        <i data-feather="user"></i>
                        <span>Profile</span>
                    </a>
                </li> -->
                <li class="nav-item">
                    <?php
                        $id     = $this->session->userdata('login_user_id');
                        $nik    = $this->db->get_where('useradmin',array('idadminuser'=>$id))->row()->nik;
                         
                    ?>
                    <a href="<?php echo base_url('profile/auth/'.encrypt_url('isprofile'));?>" class="nav-link">
                        <i data-feather="edit"></i>
                        <span>Edit Profile</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo base_url('login/auth/'.encrypt_url('islogouts'));?>" class="nav-link">
                        <i data-feather="log-out"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</li>