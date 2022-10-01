<?php
$menu  = $this->db->get('menus')->result_array();
$group = $this->db->get('mainmenu')->result_array();
?>
<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
        <h5 class="mb-3 mb-md-0">Data Group</h5>
    </div>
    <div class="d-flex align-items-center flex-wrap text-nowrap">
        <a href="<?= base_url('users/auth/' . encrypt_url('isusers/group')); ?>" class="btn btn-primary btn-icon-text mb-2 mb-md-0 d-none d-md-block text-white">Kembali</a>
    </div>
</div>
<?php foreach ($list as $ls) : ?>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">edit group</h6>
                    <hr>
                    <form id="kirim">
                        <div class="form-group form-row">
                            <label class="col-md-2 col-sm-3 col-form-label text-sm-left">
                                Nama Groups
                            </label>
                            <div class="col-md-10 col-sm-9">
                                <input type="text" class="form-control nmgroup text-uppercase" value="<?php echo $ls['groups']; ?>" name="group" id="group" readonly />
                            </div>
                        </div>
                        <hr>
                        <h6 class="card-title">Main Menu</h6>
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <!-- <tr>
                                    <td>
                                        <a href="#" id="username" data-type="checklist" data-pk="1" data-title="Enter username">superuser</a>
                                    </td>
                                </tr> -->
                                    <?php foreach ($group as $g) : ?>
                                        <?php $menu = $this->db->get_where('menus', array('kategori' => $g['id']))->result_array(); ?>
                                        <tr>
                                            <td class="text-capitalize"><?php echo $g['menu']; ?></td>
                                            <?php foreach ($menu as $m) : ?>
                                                <td>
                                                    <?php if ($m['sub'] == 'N') { ?>
                                                        <div class="form-check form-check-inline">
                                                            <label class="form-check-label">
                                                                <?php
                                                                $this->db->where('idmenu', $m['idmenus']);
                                                                $ids = $this->db->get('role_menu');
                                                                if ($ids->num_rows() == 1) { ?>
                                                                    <input type="checkbox" name="menu" id="checkmenu" value="<?php echo $m['idmenus']; ?>" class="form-check-input" checked>
                                                                    <?php echo strtoupper($m['menu']); ?>
                                                                <?php } else { ?>
                                                                    <input type="checkbox" name="menu" id="checkmenu" value="<?php echo $m['idmenus']; ?>" class="form-check-input">
                                                                    <?php echo strtoupper($m['menu']); ?>
                                                                <?php } ?>
                                                            </label>
                                                        </div>
                                                    <?php } else { ?>
                                                        <?php $sub = $this->db->get_where('submenu', array('idmenu' => $m['idmenus']))->result_array(); ?>
                                                        <?php foreach ($sub as $s) { ?>
                                                            <?php
                                                            $this->db->where('submenu', $s['idsub']);
                                                            $idsub = $this->db->get('role_menu');
                                                            if ($idsub->num_rows() == 1) { ?>
                                                                <input type="hidden" name="id" id="id" class="from-control menus" value="<?php echo $s['idmenu']; ?>">
                                                                <div class="form-check form-check-inline">
                                                                    <label class="form-check-label">
                                                                        <input type="checkbox" name="menu" id="checkmenu" value="<?php echo $s['idsub'] . "," . $s['idmenu']; ?>" class="form-check-input" checked>
                                                                        <?php echo strtoupper($s['menu']); ?>
                                                                    </label>
                                                                </div>
                                                            <?php } else { ?>
                                                                <input type="hidden" name="id" id="id" class="from-control menus" value="<?php echo $s['idmenu']; ?>">
                                                                <div class="form-check form-check-inline">
                                                                    <label class="form-check-label">
                                                                        <input type="checkbox" name="menu" id="checkmenu" value="<?php echo $s['idsub'] . "," . $s['idmenu']; ?>" class="form-check-input">
                                                                        <?php echo strtoupper($s['menu']); ?>
                                                                    </label>
                                                                </div>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </td>
                                            <?php endforeach; ?>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <hr>
                        <!-- <button class="btn btn-success" id="btn_upload" type="submit">
                        <i class="icon icon-check icon-fw icon-lg"></i>
                        Proses
                    </button>   -->
                    </form>
                </div>
                <div class="card-footer">
                    <a href="<?= base_url('users/auth/' . encrypt_url('isusers/group')); ?>" class="btn btn-primary float-right">Kembali</a>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<script type="text/javascript">
    $(document).ready(function() {
        getVal();
        $.fn.editable.defaults.mode = 'inline';
        $('#kirim').submit(function(e) {
            e.preventDefault();
            var group = $(".nmgroup").val();
            var data = new Array();
            var role = new Array();
            $("input[name='menu']:checked").each(function(i) {
                data.push($(this).val());

            });
            alert(data);
        });
        $("input[type='checkbox']").val();
        $("[type=checkbox]").change(function() {
            var clicked = $(this).val();
            var group = $(".nmgroup").val();

            if ($(this).is(':checked')) {
                var menu = $("#id").val();
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url('users/role_group'); ?>",
                    data: {
                        id: clicked,
                        group: group,
                        menu: menu
                    },
                    dataType: "JSON",
                    success: function(data) {
                        console.log(data);
                    }
                });
            } else {
                var menu = $("#id").val();
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url('users/delete_role_group'); ?>",
                    data: {
                        id: clicked,
                        group: group,
                        menu: menu
                    },
                    dataType: "JSON",
                    success: function(data) {
                        console.log(data);
                    }
                });
            }

            // console.log(clicked.val());
            // alert(clicked.text() +" === "+clicked.val());
        });
        $("#proses").on('click', function(e) {
            e.preventDefault();
            var group = $(".nmgroup").val();
            var searchIDs = $("input:checkbox:checked").map(function() {
                return this.value;
            }).toArray();

            alert('Menu : ' + searchIDs);
        });
        $('#username').editable({
            source: {
                '1': 'Enabled'
            },
            emptytext: 'Disabled',
            showbuttons: 'bottom',
            tpl: '<div class="checkbox"></div>'
            // type: 'text',
            // pk: 1,
            // name: 'username',
            // title: 'Enter username'
        });
    });

    function getVal(val) {
        var data = new Array();
        $("input[name='menu']:checked").each(function(i) {
            data.push($(this).val());
        });
    }
</script>