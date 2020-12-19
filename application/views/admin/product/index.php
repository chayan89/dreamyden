<!-- header section -->
      <!-- Begin Page Content -->
      <div class="container-fluid">
        <!-- Page Heading -->
        
        <!-- Content Row -->       
        
        <div class="neworder">
        	<div class="row">
                <div class="col-md-6 col-sm-12 col-xs-12">
                	<div class="neworder_l_inner">
                    	<h3>Products</h3>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 col-xs-12">
                	<div class="neworder_r">
                    	<ul>
                          <li><a href="<?=base_url('admin/product/add')?>">Add Product</a></li>
                          <li><a href="javascript:void(0)" data-toggle="modal" data-target="#csvModal">CSV Upload</a></li>                          
                                                  
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
                      <th>Product name</th>
                      <th>Size</th>
                      <th>Price</th>
                      <th>Product Image</th>
                      <th width="20%">Description</th>
                      <th>Status</th>
                      <th>Action</th>                      
                    </tr>
                  </thead>                 
                  <tbody>
                  </tbody>
                </table>  
              </div>
            </div>
        </div> 
        <!-- Content Row -->
        <!-- Content Row -->
      </div>
      <!-- /.container-fluid -->
   <!-- footer section -->
   <!-- csv upload modal -->
   <div class="modal fade" id="csvModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Ready to Upload Product List (.csv)</h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
            </div>
            <form id="frm-csv" action="" mathod="post">
              <div class="modal-body">
                  <div class="form-group">
                    <label>Select Vendor</label>
                    <select class="form-control" id="vendor" name="vendor" required>
                      <option value="">Select Vendor</option>
                        <?php
                          $vendors = $this->common_model->select('users', ['status'=> 1, 'role_id'=> 2], 'users.*');
                          if($vendors){
                            foreach($vendors as $value){
                              echo '<option value="'.$value->user_id.'">'.$value->fname.' '.$value->lname.'</option>';
                            }
                          }
                        ?>
                      </select>
                  </div>
                  <div class="form-group">
                    <label>Select Category</label>
                    <select class="form-control" id="category" name="category" required>
                      <option value="">Select Category</option>
                        <?php
                          $categories = $this->common_model->select('categories', ['status'=> 1], '*');
                          if($categories){
                            foreach($categories as $value){
                              echo '<option value="'.$value->category_id.'">'.$value->category_name.'</option>';
                            }
                          }
                        ?>
                      </select>
                  </div>
                  <div class="form-group">
                    <label>Select Product List</label>
                    <input class="form-control" type="file" id="image" name="image" required />
                    <a href="<?=base_url('uploads/product_sample.csv')?>">Download sample</a>
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
        adminPage = "product";
        $(document).ready(function(){
          drawTable();
          // $("#image").change(function () {
          //   //readURL(this, '#preview-product');
          //   if(this.files[0]['type'] != 'application/vnd.ms-excel'){
          //     $("#image").val('');
          //       swalAlert('Please select a valid CSV', 'warning');
          //       return false;
          //     }
          // });
          //start uploading
          // $('#frm-csv').submit(function(e){
          //     e.preventDefault();
          //     let cat = $('#category').val();
          //     let vendor = $('#vendor').val();
          //     if(cat == ""){
          //       swalAlert("Please select category before save", "warning");
          //       return false;
          //     }
          //     if(vendor == ""){
          //       swalAlert("Please select vendor before save", "warning");
          //       return false;
          //     }
          //     var formData = new FormData(this);
          //     $.ajax({
          //     type: "POST",
          //     url: base_url + "product/csv-upload",
          //     data: formData,
          //         cache: false,
          //         contentType: false,
          //         processData: false,
          //     beforeSend: function() {
          //       $('#vehicleAddCSV').modal('toggle');
          //     },
          //     success: function(res) {
          //       if (res.status.error_code == 0) {
          //               swalAlert(res.status.message, "success");
          //               location.reload();
          //           } else {
          //               swalAlert(res.status.message, "warning");
          //           }
          //     }
          //   })
          // })
        })
        function drawTable(){
          let dataJson = {
            source: 'WEB'
          };
          $.ajax({
                type: "POST",
                url: base_url + "product/get",
                data: JSON.stringify(dataJson),
                datType: 'JOSN',
                success: function(res) {
                    if (res.status.error_code == 0) {                      
                        $('tbody').html('');
                        $('tbody').html(res.result);
                        $('#dataTable').DataTable({
                          //destroy: true,
                          //order: [1, 'asc'],
                        });
                    } else {
                        swalAlert(res.message, "warning");
                    }
                },
            });
        }
      </script>