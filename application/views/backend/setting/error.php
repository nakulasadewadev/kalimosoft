<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
        <h5 class="mb-3 mb-md-0">Data Error</h5>
    </div>
    <div class="d-flex align-items-center flex-wrap text-nowrap">
        <a href="<?php echo base_url('setting/auth/'.encrypt_url('isadderrors'));?>" class="btn btn-primary btn-icon-text mb-2 mb-md-0 d-none d-md-block text-white">
            <i class="btn-icon-prepend" data-feather="plus"></i>
            Tambah Error
        </a>    
    </div>
</div>
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h6 class="card-title">Data Error</h6>
                </div>
                <div class="table-responsive">
                    <table id="dataTableExample" class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Error</th>
                                <th>Nama Error</th>
                                <th>Keterangan</th>
                                <th>Info</th>
                                <th>aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($list as $ls) { ?>
                                <tr>
                                    <td><?php echo $ls['Id'];?></td>
                                    <td class="text-capitalize"><?php echo $ls['errorcode'];?></td>
                                    <td class="text-capitalize"><?php echo $ls['errorname'];?></td>
                                    <td class="text-capitalize text-wrap"><?php echo $ls['description'];?></td>
                                    <td class="text-capitalize"><?php echo $ls['note'];?></td>
                                    <td>
                                        <div class="dropdown mb-2">
                                            <button class="btn p-0" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item d-flex align-items-center" href="<?php echo base_url('setting/detail/'.encrypt_url($ls['Id']));?>"><i data-feather="eye" class="icon-sm mr-2"></i> <span class="">View</span></a>
                                                <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="trash" class="icon-sm mr-2"></i> <span class="">Delete</span></a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>