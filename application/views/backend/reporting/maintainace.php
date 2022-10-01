<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
        <h5 class="mb-3 mb-md-0">Report Maintenance</h5>
    </div>
</div>
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-header bg-danger">
                <h6 class="text-white text-uppercase">filter data</h6>
            </div>
            <div class="card-body">
                <form action="<?= base_url('reporting/auth/' . encrypt_url('isreportmaintainace')) ?>" method="post">
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
                            <select class="select" name="errorcode" id="errorcode">
                                <option value="">- Error -</option>
                                <?php foreach ($error as $e) { ?>
                                    <option value="<?= $e['errorcode']; ?>" <?= $value['errorcode'] == $e['errorcode'] ? 'selected' : ''; ?>><?= ucwords($e['errorname']); ?></option>
                                <?php } ?>
                            </select>
                            <?php if (!empty($value['errorcode'])) {
                                foreach ($error as $e) {
                                    if ($value['errorcode'] == $e['errorcode']) {
                                        echo "<p>Status : " . $e['errorname'] . "</p>";
                                    }
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
                <div class="card-title">
                    <h6 class="card-title">Data</h6>
                    <hr>
                </div>
                <div class="table-responsive">
                    <table id="dataTableExample" class="table">
                        <thead>
                            <tr>
                                <th>tanggal</th>
                                <th>tiket</th>
                                <th>netid</th>
                                <th>lokasi</th>
                                <th>error</th>
                                <th>selesai</th>
                                <th>teknisi</th>
                                <th>aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($list as $ls) { ?>
                                <tr>
                                    <td><?= date('d-m-Y H:i:s', strtotime($ls['date'])); ?></td>
                                    <td></td>
                                    <td><?= $ls['netid']; ?></td>
                                    <td></td>
                                    <td>
                                        <?= $ls['errorname'] ?>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
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
        $(".select").select2();
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
    });
</script>