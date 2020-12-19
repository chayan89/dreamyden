<!-- Header section -->
      <!-- Begin Page Content -->
      <div class="container-fluid">
        <!-- Page Heading -->        
        <!-- Content Row -->
        <div class="neworder">
        	<div class="row">
                <div class="col-md-6 col-sm-12 col-xs-12">
                	<div class="neworder_l_inner">
                    	<h3>Vendors</h3>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 col-xs-12">
                	<div class="neworder_r">
                    	<ul>
                        	<li><a href="<?= base_url('admin/Vendor/add')?>">Add Vendor</a></li>                          
                        	<li><a href="javascript:void(0)" data-toggle="modal" data-target="#vendorModal">CSV Upload</a></li>                          
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
                      <th>Vendor name</th>
                      <th>Email</th>
                      <th>Address</th>
                      <th>Image</th>
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
      <!-- Footer Area -->
      <!-- csv upload modal -->
      <div class="modal fade" id="vendorModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Ready to Upload Vendor List (.csv)</h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
            </div>
            <form id="frm-vendor" action="" mathod="post">
              <div class="modal-body">
                  <div class="form-group">
                    <label>Select Vendor List</label>
                    <input class="form-control" type="file" id="image" name="image" required />
                    <a href="<?=base_url('uploads/vendor.csv')?>">Download sample</a>
                  </div>
              </div>
              <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary" href="javascript:void(0)" id="btn-vendor-upload">Upload</button> </div>
            </div>
          </form>
        </div>
      </div>
      <script>
        adminPage = "Vendor";
        $(document).ready(function(){
          drawTable();
          //validate selected file

          $("#image").change(function () {
            //readURL(this, '#preview-product');
            if(this.files[0]['type'] != 'application/vnd.ms-excel'){
              $("#image").val('');
                swalAlert('Please select a valid CSV', 'warning');
                return false;
              }
          });
          //start uploading
          $('#frm-vendor').submit(function(e){
              e.preventDefault();
              var formData = new FormData(this);
              $.ajax({
              type: "POST",
              url: base_url + "vendor/csv-upload",
              data: formData,
                  cache: false,
                  contentType: false,
                  processData: false,
              beforeSend: function() {
                $('#vehicleAddCSV').modal('toggle');
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
        function drawTable(){
          let dataJson = {
            source: 'WEB'
          };
          $.ajax({
                type: "POST",
                url: base_url + "vendor/get",
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