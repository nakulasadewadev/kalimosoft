<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
        <h5 class="mb-3 mb-md-0">Report Client</h5>
    </div>
</div>
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-header bg-danger">
                <h6 class="text-white text-uppercase">filter data</h6>
            </div>
            <div class="card-body">
                <form action="<?php base_url('reporting/auth/' . encrypt_url('isreportclient')) ?>" method="post">
                    <div class="row">
                        <!-- <div class="col-sm-4 form-group">
                            <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #727ce8; border-radius:10; width: 100%">
                                <i data-feather="calendar" class=" text-primary"></i>
                                <span></span> <i data-feather="chevron-down" class="text-primary"></i>
                            </div>
                        </div> -->
                        <div class="col-sm-4 form-group">
                            <select class="form-control" name="status" id="status">
                                <option value="">- status -</option>
                                <option value="1" <?= $value['status'] == '1' ? 'selected' : ''; ?>>Online</option>
                                <option value="2" <?= $value['status'] == '2' ? 'selected' : ''; ?>>Offline</option>
                            </select>
                            <?php if (!empty($value['status'])) {
                                if ($value['status'] == 1) {
                                    echo "<p>Status : Online</p>";
                                } else {
                                    echo "<p>Status : Offline</p>";
                                }
                            } ?>
                        </div>
                        <div class="col-sm-4">
                            <button type="submit" class="btn btn-outline-info text-capitalize">
                                show data
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Data Member</h6>
                <hr>
                <div class="table-responsive">
                    <table id="dataarea" class="table">
                        <thead>
                            <tr>
                                <th>member</th>
                                <th>netid</th>
                                <th>username</th>
                                <th>password</th>
                                <th>status</th>
                                <th>ODP</th>
                                <th>OLT</th>
                                <th>ODC</th>
                                <th>lokasi</th>
                                <th>map</th>
                                <th>action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($list as $ls) { ?>
                                <tr>
                                    <td>
                                        <?php
                                        $member = $this->db->get_where('dbcustomer', array('cid' => $ls['cid']))->row()->name;
                                        echo ucwords($member);
                                        ?>
                                    </td>
                                    <td><?php echo $ls['netid']; ?></td>
                                    <td><?php echo $ls['username']; ?></td>
                                    <td><?php echo $ls['password']; ?></td>
                                    <td>
                                        <?php if ($ls['netstatus'] == '1') {
                                            echo '<span class="badge badge-pill badge-success">ONLINE</span>';
                                        } else {
                                            echo '<span class="badge badge-pill badge-danger">OFFLINE</span>';
                                        } ?>
                                    </td>
                                    <td><?php echo $ls['odcport']; ?></td>
                                    <td><?php echo $ls['ontid']; ?></td>
                                    <td>
                                        <?php
                                        if ($ls['odpid'] != null) {
                                            $odp = $this->db->get_where('dbodp', array('odpid' => $ls['odpid']))->row()->odpcode;
                                            echo $odp;
                                        } else {
                                            echo "-";
                                        }
                                        ?>
                                    </td>
                                    <td class="text-wrap text-capitalize"><?php echo $ls['address']; ?></td>
                                    <td>
                                        <a href="#" data-lat="<?php echo $ls['latitude']; ?>" data-long="<?php echo $ls['longitude']; ?>" class="lihat-map"><i data-feather="map-pin" class="icon-sm mr-2 text-primary"></i></a>
                                    </td>
                                    <td>
                                        <div class="dropdown mb-2">
                                            <button class="btn p-0" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item d-flex align-items-center" href="<?php echo base_url('order/detail/' . encrypt_url($ls['noorder'])); ?>"><i data-feather="eye" class="icon-sm mr-2"></i> <span class="">View</span></a>
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
<div id="maps" class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title text-capitalize">lokasi pemasangan</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="bodymap"></div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $(".lihat-map").on('click', function() {
            var lat = $(this).attr('data-lat');
            var long = $(this).attr('data-long');
            $("#maps").modal('show');
            var html = '<iframe src="http://maps.google.com/maps?q=' + lat + ',' + long + '&z=16&output=embed" height="450" width="100%"></iframe>';
            $(".bodymap").html(html);
        });
    });
    $(function() {

        var start = moment().subtract(29, 'days');
        var end = moment();

        function cb(start, end) {
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }

        $('#reportrange').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);

        cb(start, end);

    });
</script>