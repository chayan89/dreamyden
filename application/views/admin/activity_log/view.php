<!-- Header section -->
      <!-- Begin Page Content -->
      <div class="container-fluid">
        <!-- Page Heading -->        
        <!-- Content Row -->
        <div class="neworder">
        	<div class="row">
                <div class="col-md-6 col-sm-12 col-xs-12">
                	<div class="neworder_l_inner">
                    	<h3>Order Details</h3>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 col-xs-12">
                	<div class="neworder_r">
                    	<ul>
                        	<li><a href="<?= base_url('admin/activity_log')?>">Activity Log List</a></li>                         
                        </ul>
                    </div>
                </div>
            </div>
        </div>        
        <div class="view_panel">
          <div class="row">
              <div class="col-md-4 col-sm-12 col-xs-12">
                  <div class="form-group">
                      <label>Order Id</label>
                        <span><?=isset($details)?$details[0]['order_id']:''?></span>
                    </div>
                </div>
                
                <div class="col-md-4 col-sm-12 col-xs-12">
                  <div class="form-group">
                      <label>Customer</label>
                        <span><?=isset($details)?$details[0]['fname']:''?></span>
                    </div>
                </div>
                
                 <div class="col-md-4 col-sm-12 col-xs-12">
                    <div class="form-group">
                      <label>Order Date</label>
                        <span><?php $dateValue=strtotime($details[0]['order_date']); 
                      $yr = date("Y", $dateValue) ." "; $mon = date("m", $dateValue)." ";
                      $date = date("d", $dateValue); echo $date.' '.date('M', $dateValue).' ,'.$yr.' ,'.date("h.i A", $dateValue); ?>
                       </span>
                    </div>
                </div>
                
                 <div class="col-md-4 col-sm-12 col-xs-12">
                  <div class="form-group">
                      <label>Delivery Date</label>
                        <span><?php $dateValue2=strtotime($details[0]['delivery_date']); 
                      $yr = date("Y", $dateValue2) ." "; $mon = date("m", $dateValue2)." ";
                      $date = date("d", $dateValue2); echo $date.' '.date('M', $dateValue2).' ,'.$yr.' ,'.date("h.i A", $dateValue2); ?>
                       </span>
                    </div>
                </div>
                
                <div class="col-md-4 col-sm-12 col-xs-12">
                  <div class="form-group">
                      <label>Phone</label>
                        <span><?=isset($details)?$details[0]['mobile']:''?></span>
                    </div>
                </div>
                
                 <div class="col-md-4 col-sm-12 col-xs-12">
                  <div class="form-group">
                      <label>Status</label>
                        <?php if($details[0]['order_status']==1){ ?>
                          <span>Schedule</span>
                         <?php } else if($details[0]['order_status']==2){ ?>
                          <span>New</span>
                         <?php } else if($details[0]['order_status']==3){ ?>
                          <span>Deliverd</span>
                         <?php } else if($details[0]['order_status']==4){ ?>
                          <span>Cancelled</span>
                         <?php } ?>
                    </div>
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
      