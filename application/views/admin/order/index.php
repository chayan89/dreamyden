<!-- Header section -->
      <!-- Begin Page Content -->
      <div class="container-fluid">
        <!-- Page Heading -->        
        <!-- Content Row -->
        <div class="neworder">
        	<div class="row">
                <div class="col-md-6 col-sm-12 col-xs-12">
                	<div class="neworder_l_inner">
                    	<h3>Orders</h3>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 col-xs-12">
                	<div class="neworder_r">
                    	<ul>
                        	<!-- <li><a href="<?= base_url('admin/order/add')?>">Add Order</a></li> -->                          
                        </ul>
                    </div>
                </div>
            </div>
        </div>        
        <div class="dashboard_table">
        	<div class="table_panel">
              <div class="table-responsive">
                <table class="table table-bordered caltable" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Sl No.</th>
                      <th>Order Id</th>
                      <th>Customer</th>
                      <th>Order Date</th>
                      <th>Delivery Date</th>                      
                      <th>Phone</th>                     
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>                 
                   <tbody>
                    <?php 
                    if(!empty($details)){
                    foreach ($details as $key => $value) { 
                    if(isset($value['order_date'])){
                          $order_date=$value['order_date'];
                         }else {
                          $order_date='null';
                         }
                    ?>
                    

                    <tr>
                      <td><?=($key+1)?></td>
                      <td><span><?php echo '#'.$value['order_id']; ?></span></td>                     
                      <td><span><?php echo $value['fname']; ?></span></td>
                      <td><?php $dateValue=strtotime($order_date); 
                      $yr = date("Y", $dateValue) ." "; $mon = date("m", $dateValue)." ";
                      $date = date("d", $dateValue); echo $date.' '.date('M', $dateValue).$yr.', '.date("h.i A", $dateValue); ?></td>
                      <td>
                        <?php
                        if($value['delivery_date']){
                          $delivery_date=$value['delivery_date'];
                          $middle = strtotime($delivery_date);            
                          $yr = date("Y", $middle) ." "; 
                          $mon = date("m", $middle)." ";
                          $date = date("d", $middle); 
                          echo $date.' '.date('M', $middle).$yr.', '.date("h.i A", $middle); 
                         }else {
                         echo "Null";
                         }
                       ?></td>                     
                      <td><?php echo $value['mobile']; ?></td>                                         
                      <td>
                        <?php if($value['order_status']==1){ ?>
                          <b class="greentext">Schedule</b>
                         <?php } else if($value['order_status']==2){ ?>
                          <b class="pendingtext">New</b>
                         <?php } else if($value['order_status']==3){ ?>
                          <b class="greentext">Deliverd</b>
                          <?php } else if($value['order_status']==4){ ?> 
                          <b class="canceltext">Cancelled</b>
                         <?php } ?>
                      </td>
                       <td>
                          <a class="view_class" href="<?=base_url('admin/order/view/'.$value['order_id'])?>"><img src="<?=base_url('public/admin/')?>img/pink_view.png" alt="pink_view"/></a>
                          <a class="edit_class" href="<?=base_url('admin/order/edit/'.$value['order_id'])?>"><img src="<?=base_url('public/admin/')?>img/pinkedit.png" alt="pinkedit"/></a>
                       </td>
                    </tr>
                    <?php            
                    }
                    } ?>
                  </tbody>
          </table>  
          </div>
          </div>
        </div>
        <!-- Content Row -->
        <!-- Content Row -->
      </div>
      <!-- /.container-fluid -->
      <!-- Footer Area -->
      <!-- csv upload modal -->
      <!-- Logout Modal-->
      <div class="modal fade" id="csvModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Ready to Upload Delivery Boy List (.csv)</h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
            </div>
            <form id="frm-csv" action="" mathod="post">
              <div class="modal-body">
                  <div class="form-group">
                    <label>Select Delivery Boy List</label>
                    <input class="form-control" type="file" id="image" name="image" required />
                    <a href="<?=base_url('uploads/delivery.csv')?>">Download sample</a>
                  </div>
              </div>
              <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary" href="javascript:void(0)" id="btn-upload">Upload</button> </div>
            </div>
          </form>
        </div>
      </div>

      <script>
        $(document).ready(function(){
           $('#dataTable').DataTable({
                        });

          $("#image").change(function () {
            //readURL(this, '#preview-product');
            if(this.files[0]['type'] != 'application/vnd.ms-excel'){
              $("#image").val('');
                swalAlert('Please select a valid CSV', 'warning');
                return false;
              }
          });
          //start uploading
          $('#frm-csv').submit(function(e){
              e.preventDefault();
              var formData = new FormData(this);
              $.ajax({
              type: "POST",
              url: base_url + "delivery/csv-upload",
              data: formData,
                  cache: false,
                  contentType: false,
                  processData: false,
              beforeSend: function() {
              },
              success: function(res) {
                if (res.status.error_code == 0) {
                        swalAlert(res.status.message, "success");
                        location.reload();
                    } else {
                        swalAlert(res.status.message, "warning");
                    }
              }
            })
          })
        })
       
      </script>
      