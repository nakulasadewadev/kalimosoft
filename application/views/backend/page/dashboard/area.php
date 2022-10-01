<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h6 class="card-title">Data Area Pemasangan Bulan Ini</h6>
                </div>
                <div class="table-responsive">
                    <table id="dataarea" class="table">
                        <thead>
                            <tr>
                                <th>tanggal</th>
                                <th>customer</th>
                                <th>lokasi</th>
                                <th>map</th>
                                <th>produk</th>
                                <th>online</th>
                                <th>aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($area as $ar) { ?>
                                <tr>
                                    <td><?php echo date('d-m-Y H:i:s',strtotime($ar['create_at']));?></td>
                                    <td>
                                        <?php 
                                            $user = $this->db->get_where('dbcustomer',array('cid'=>$ar['cid']))->row()->name;
                                            echo ucwords($user);
                                        ?>
                                    </td>
                                    <td class="text-wrap">
                                        <?php echo ucwords($ar['address']);?>
                                    </td>
                                    <!--<iframe src="http://maps.google.com/maps?q=25.3076008,51.4803216&z=16&output=embed" height="450" width="600"></iframe> !-->
                                    <td>
                                        <a href="#" data-lat="<?php echo $ar['location'];?>" class="lihat-map"><i data-feather="map-pin" class="icon-sm mr-2 text-primary"></i></a>
                                    </td>
                                    <td>
                                        <?php
                                            $produk = $this->db->get_where('product',array('noproduct'=>$ar['productid']))->row()->kode;
                                            echo $produk;
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            if($ar['netstatus'] == '1'){
                                                echo '<span class="badge badge-pill badge-success">ONLINE</span>';
                                            }else{
                                                echo '<span class="badge badge-pill badge-danger">OFFLINE</span>';
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
                                                    $detail = encrypt_url($ar['netid']);
                                                ?>
                                                <a class="dropdown-item d-flex align-items-center" href="<?php echo base_url('network/detail/'.$detail);?>"><i data-feather="eye" class="icon-sm mr-2"></i> <span class="">View</span></a>
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
    $(document).ready(function(){
        $(".lihat-map").on('click',function(){
            var lat = $(this).attr('data-lat');
            //var long= $(this).attr('data-long');
            //alert(lat);
            $("#maps").modal('show');
            var html='<iframe src="http://maps.google.com/maps?q='+lat+'&z=16&output=embed" height="450" width="100%"></iframe>';
            $(".bodymap").html(html);
        });
    });
    
</script>