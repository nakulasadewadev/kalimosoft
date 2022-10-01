<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
        <h5 class="mb-3 mb-md-0">INVOICE</h5>
    </div>
</div>
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-header bg-danger">
                <h6 class="text-white text-uppercase">filter data</h6>
            </div>
            <div class="card-body">
                <form action="<?= base_url('invoice/auth/' . encrypt_url('isinvoice')) ?>" method="post">
                    <div class="row">
                        <div class="col-sm-4 form-group">
                            <!-- <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #727ce8; border-radius:10; width: 100%">
                                <i data-feather="calendar" class=" text-primary"></i>
                                <span></span> <i data-feather="chevron-down" class="text-primary"></i>
                            </div> -->
                            <input type="text" id="reportrange" name="reportrange" value="<?= $value['tgl'] ?>" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #727ce8; border-radius:10; width: 100%">
                            <br>
                            <?php if (!empty($value['tgl'])) {
                                echo "<p>current show : " . $value['tgl'] . "</p>";
                            } ?>
                        </div>
                        <div class="col-sm-4 form-group">
                            <select class="form-control" name="statinvoice" id="statinvoice">
                                <option value="">- status -</option>
                                <option value="1" <?= $value['statinvoice'] == '1' ? 'selected' : ''; ?>>Bill</option>
                                <option value="2" <?= $value['statinvoice'] == '2' ? 'selected' : ''; ?>>Paid</option>
                            </select>
                            <?php if (!empty($value['statinvoice'])) {
                                if ($value['statinvoice'] == 1) {
                                    echo "<p>Status : Bill</p>";
                                } else {
                                    echo "<p>Status : Paid</p>";
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
                <h6 class="card-title">Data Invoice Period : <?php echo date('F'); ?></h6>
                <hr>
                <div class="table-responsive">
                    <table id="dataarea" class="table">
                        <thead>
                            <tr>
                                <th>date</th>
                                <th>Invoice</th>
                                <th>Client</th>
                                <th>netid</th>
                                <th>location</th>
                                <th>product</th>
                                <th>phone</th>
                                <th>email</th>
                                <th>billing</th>
                                <th>status</th>
                                <th>action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($list as $ls) { ?>
                                <tr>
                                    <td><?php echo date('d-m-Y H:i:s', strtotime($ls['create_at'])); ?></td>
                                    <td><?php echo $ls['no_invoice']; ?></td>
                                    <td>
                                        <?php
                                        $member = $this->db->get_where('dbcustomer', array('cid' => $ls['client']))->row()->name;
                                        echo ucwords($member);
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        echo $ls['netid'];
                                        ?>
                                    </td>
                                    <td class="text-wrap">
                                        <?php
                                        $address = $this->db->get_where('dbnetwork', array('netid' => $ls['netid']))->row()->address;
                                        echo ucwords($address);
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        $product = $this->db->get_where('product', array('noproduct' => $ls['product']))->row()->kode;
                                        echo ucwords($product);
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        $phone = $this->db->get_where('dbcustomer', array('cid' => $ls['client']))->row()->handphone;
                                        echo ucwords($phone);
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        $email = $this->db->get_where('dbcustomer', array('cid' => $ls['client']))->row()->email;
                                        echo ucwords($email);
                                        ?>
                                    </td>
                                    <td>
                                        <?php echo "Rp " . number_format($ls['totalbill'], 2, ',', '.'); ?>
                                    </td>
                                    <td>
                                        <?php
                                        if ($ls['statinvoice'] == 1) {
                                            echo '<span class="badge badge-pill badge-danger">NO PAID</span>';
                                        } else {
                                            echo '<span class="badge badge-pill badge-success">PAID</span>';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <div class="dropdown mb-2">
                                            <button class="btn p-0" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                                <?php
                                                $detail = encrypt_url($ls['no_invoice']);
                                                ?>
                                                <a class="dropdown-item d-flex align-items-center" href="<?php echo base_url('invoice/detail/' . $detail); ?>"><i data-feather="eye" class="icon-sm mr-2"></i> <span class="">View</span></a>
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

<script type="text/javascript">
    $(document).ready(function() {
        datefilter();
        $("#send").submit(function(ev) {

        });
    });

    function datefilter() {
        if ($('#enddate').length) {
            var date = new Date();
            var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
            $('#enddate').datepicker({
                format: "dd-MM-yyyy",
                todayHighlight: true,
                autoclose: true
            });
            $('#enddate').datepicker('setDate', today);
        }
    }
</script>

<script type="text/javascript">
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