<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
        <h5 class="mb-3 mb-md-0">BILLING</h5>
    </div>
</div>
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-header bg-danger">
                <h6 class="text-white text-uppercase">filter data</h6>
            </div>
            <div class="card-body">
                <form action="<?= base_url('billing/auth/' . encrypt_url('isbilling')) ?>" method="post">
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
                            <select class="form-control" name="statbilling" id="statbilling">
                                <option value="">- status -</option>
                                <option value="1" <?= $value['statbilling'] == '1' ? 'selected' : ''; ?>>Online</option>
                                <option value="2" <?= $value['statbilling'] == '2' ? 'selected' : ''; ?>>Over Due</option>
                            </select>
                            <?php if (!empty($value['statbilling'])) {
                                if ($value['statbilling'] == 1) {
                                    echo "<p>Status : Online</p>";
                                } else {
                                    echo "<p>Status : Over Due</p>";
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
                <h6 class="card-title">Data Billing Period : <?= date('F'); ?></h6>
                <hr>
                <div class="table-responsive">
                    <table id="dataarea" class="table">
                        <thead>
                            <tr>
                                <th>date</th>
                                <th>netid</th>
                                <th>client</th>
                                <th>location</th>
                                <th>map</th>
                                <th>product</th>
                                <th>stat online</th>
                                <th>due date</th>
                                <th>over due</th>
                                <th>billing</th>
                                <th>action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($list as $ls) { ?>
                                <tr>
                                    <td><?= date('d-m-Y H:i:s', strtotime($ls['start_at'])); ?></td>
                                    <td><?= $ls['netid']; ?></td>
                                    <td class="text-wrap">
                                        <?= ucwords($ls['name']); ?>
                                    </td>
                                    <td class="text-wrap">
                                        <?= ucwords($ls['address']); ?>
                                    </td>
                                    <td>
                                        <a href="<?= $ls['location']; ?>">lihat map</a>
                                    </td>
                                    <td>
                                        <?= strtoupper($ls['kode']); ?>
                                    </td>
                                    <td>
                                        <?php
                                        if ($ls['netstatus'] == 1) {
                                            echo '<span class="badge badge-pill badge-success">ONLINE</span>';
                                        } else {
                                            echo '<span class="badge badge-pill badge-danger">OFFLINE</span>';
                                        }
                                        ?>
                                    </td>
                                    <td><?= date('d-m-Y H:i:s', strtotime($ls['end_at'])); ?></td>
                                    <td>
                                        <?php
                                        date_default_timezone_set('Asia/Jakarta');
                                        $now = date('Y-m-d H:i:s');
                                        if ($ls['end_at'] >= $now) {
                                            echo "-";
                                        } else {
                                            $date = $ls['end_at'];
                                            $datetime1 = new DateTime($date);
                                            $datetime2 = new DateTime();
                                            $difference = $datetime2->diff($datetime1);
                                            echo $difference->days . " Hari";
                                        }

                                        ?>
                                    </td>
                                    <td><?= "Rp " . number_format($ls['bill'], 2, ',', '.'); ?> </td>
                                    <td>
                                        <div class="dropdown mb-2">
                                            <button class="btn p-0" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                                <?php if ($ls['stat'] == '1') { ?>
                                                    <a class="dropdown-item d-flex align-items-center" href="<?= base_url('billing/detail/' . encrypt_url($ls['netid'])); ?>"><i data-feather="file" class="icon-sm mr-2"></i> <span class="">Invoice</span></a>
                                                <?php } ?>
                                                <a class="dropdown-item d-flex align-items-center" href="<?= base_url('network/edit/' . encrypt_url($ls['netid'])); ?>"><i data-feather="cloud-off" class="icon-sm mr-2 text-danger"></i> <span class="text-danger">Set OFF</span></a>
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