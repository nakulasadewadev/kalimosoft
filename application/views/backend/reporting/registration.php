<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
        <h5 class="mb-3 mb-md-0">REGISTRATION</h5>
    </div>
</div>
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-header bg-danger">
                <h6 class="text-white text-uppercase">filter data</h6>
            </div>
            <div class="card-body">
                <form action="<?= base_url('reporting/auth/' . encrypt_url('isreportregistration')) ?>" method="post">
                    <div class="row">
                        <div class="col-sm-4 form-group">
                            <!-- <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #727ce8; border-radius:10; width: 100%">
                                <i data-feather="calendar" class=" text-primary"></i>
                                <span></span> <i data-feather="chevron-down" class="text-primary"></i>
                            </div> -->
                            <input type="text" id="reportrange" name="reportrange" value="<?= $value['tgl'] ?>" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #727ce8; border-radius:10; width: 100%">
                            <?php if (!empty($value['tgl'])) {
                                echo "<p>current show : " . $value['tgl'] . "</p>";
                            } ?>
                        </div>
                        <div class="col-sm-4 form-group">
                            <select class="form-control" name="statnetwork" id="statnetwork">
                                <option value="">- status -</option>
                                <option value="1" <?= $value['statnetwork'] == '1' ? 'selected' : ''; ?>>Online</option>
                                <option value="2" <?= $value['statnetwork'] == '2' ? 'selected' : ''; ?>>Offline</option>
                            </select>
                            <?php if (!empty($value['statnetwork'])) {
                                if ($value['statnetwork'] == 1) {
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
                <h6 class="card-title">Data Payment Period : <?php echo date('F'); ?></h6>
                <hr>
                <div class="table-responsive">
                    <table id="dataarea" class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>tanggal</th>
                                <th>member</th>
                                <th>netid</th>
                                <th>produk</th>
                                <th>biaya</th>
                                <th>lainnya</th>
                                <th>keterangan</th>
                                <th>staf</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($list as $ls) { ?>
                                <tr>
                                    <td><?php echo $ls['no_order']; ?></td>
                                    <td><?php echo date('d-m-Y H:i:s', strtotime($ls['create_at'])); ?></td>
                                    <td>
                                        <?php
                                        $member = $this->db->get_where('dbcustomer', array('cid' => $ls['member']))->row()->name;
                                        echo ucwords($member);
                                        ?>
                                    </td>
                                    <td><?php echo $ls['netid']; ?></td>
                                    <td>
                                        <?php
                                        $product   = $this->db->get_where('product', array('noproduct' => $ls['product']))->row()->kode;
                                        echo strtoupper($product);
                                        ?>
                                    </td>
                                    <td>
                                        <?php echo "Rp " . number_format($ls['biaya'], 2, ',', '.'); ?>
                                    </td>
                                    <td>
                                        <?php echo "Rp " . number_format($ls['biayalain'], 2, ',', '.'); ?>
                                    </td>
                                    <td class="text-wrap">
                                        <?php echo $ls['keterangan']; ?>
                                    </td>
                                    <td>
                                        <?php
                                        $staf = $this->db->get_where('useradmin', array('idadminuser' => $ls['staf']))->row()->nama;
                                        echo ucwords($staf);
                                        ?>
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