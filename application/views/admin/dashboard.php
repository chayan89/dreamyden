<?php
$query = $this->db->query('SELECT * FROM orders WHERE `order_status` = 2');
$total_new=$query->num_rows();
?>
<!-- header -->
      <!-- Begin Page Content -->
      <div class="container-fluid">
        <!-- Page Heading -->
        <!-- Content Row -->
        <div class="row">
          <!-- Earnings (Monthly) Card Example -->
          <div class="col-xl-3 col-md-6 mb-4">
            <div class="card py-2">
              <div class="card-body">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div class="text-xs font-weight-bold mb-1 dashboxheading">Today’s Orders</div>
                    <div class="dashboxheading_number"><?php echo $todays_orders['count(order_id)']; ?></div>
                    <!-- <div class="arrow"><!-- <a href=""><img src="<?=base_url('public/admin/')?>img/white_arrow.png" alt="white_arrow"/></a></div> -->
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Earnings (Monthly) Card Example -->
          <div class="col-xl-3 col-md-6 mb-4">
            <div class="card py-2">
              <div class="card-body">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div class="text-xs font-weight-bold mb-1 dashboxheading">Tomorrow’s Orders</div>
                     <div class="dashboxheading_number"><?php echo $tomorrow_orders['count(order_id)']; ?></div>
                    <!-- <div class="arrow"><a href=""><img src="<?=base_url('public/admin/')?>img/white_arrow.png" alt="white_arrow"/></a></div> -->
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Earnings (Monthly) Card Example -->
          <div class="col-xl-3 col-md-6 mb-4">
            <div class="card py-2">
              <div class="card-body">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div class="text-xs font-weight-bold mb-1 dashboxheading">Weekly Sale</div>
                     <div class="dashboxheading_number">$<?php echo number_format($weeklytotalprice['SUM(total_amount)']); ?></div>
                    <!-- <div class="arrow"><a href=""><img src="<?=base_url('public/admin/')?>img/white_arrow.png" alt="white_arrow"/></a></div> -->
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Pending Requests Card Example -->
          <div class="col-xl-3 col-md-6 mb-4">
            <div class="card py-2">
              <div class="card-body">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div class="text-xs font-weight-bold mb-1 dashboxheading">Monthly Sale</div>
                     <div class="dashboxheading_number">$<?php echo number_format($monthlytotal['SUM(total_amount)']); ?>k</div>
                    <!-- <div class="arrow"><a href=""><img src="<?=base_url('public/admin/')?>img/white_arrow.png" alt="white_arrow"/></a></div> -->
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <div class="neworder">
          <div class="row">
                <div class="col-md-6 col-sm-12 col-xs-12">
                  <div class="neworder_l">
                      <h3>New Orders<span><?php echo $total_new; ?> Total</span></h3>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 col-xs-12">
                  <div class="neworder_r">
                         <ul>
                            <li id="hovertitle"><a id="2" href="javascript:void(0);" class="statusval ">New</a></li>
                            <li><a id="3" href="javascript:void(0);" class="statusval">Deliverd</a></li>
                            <li><a id="4" href="javascript:void(0);" class="statusval">Cancelled</a></li>
                            <li><a id="1" href="javascript:void(0);" class="statusval">All</a></li>
                         </ul>
                         
                    </div>
                </div>
            </div>
        </div>
        
        <div class="dashboard_table">
          <div class="table_panel">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Sl No.</th>
                      <th>Order Id</th>
                      <th>Price</th>
                      <th>Order Date</th>
                      <th>Delivery Date</th>
                      <th>Customer</th>
                      <th>Phone</th>
                      <th>Vendor</th>
                      <th>Status</th>
                    </tr>
                  </thead>                 
                  <tbody id="tbodyid">
                  </tbody>
                </table>  
              </div>
            </div>
        </div>
        
        
        <!-- Content Row -->
        <!-- Content Row -->
      </div>
      <!-- /.container-fluid -->
     <style>
      .neworder_r .active{
        background: #f47ea9;
        color: #fff;
      }
     </style>
      
      <script>
        $(document).ready(function(){
          $('.statusval#2').click();
        })

        //use for pass id
        $(document).on('click', '.statusval', function() {
            var status_id = $(this).attr('id');
            //Add active class to selected li
            $('.statusval').removeClass('active');
            $(this).addClass('active');
            dataTable(status_id);
          });

        function dataTable(status_id = null){
          //alert(status_id);
          let dataJson = {
            source: 'WEB',
            status_id : status_id
          };

          $.ajax({
                type: "POST",
                url: base_url + "dashboard/get",
                data: JSON.stringify(dataJson),
                datType: 'JOSN',
                success: function(res) {
                      $('#dataTable').DataTable().destroy();
                      
                    if (res.status.error_code == 0) {
                      $('#tbodyid').html('');
                      $('#tbodyid').html(res.result);

                      $('#dataTable').DataTable({
                          bPaginate: true,
                          pageLength: 10,
                        });                         
                        
                    } else {
                        swalAlert(res.message, "warning");
                    }
                },
            });
        }
      </script>
    