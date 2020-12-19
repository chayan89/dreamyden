<!-- Header section -->
<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- Page Heading -->        
  <!-- Content Row -->
  <div class="neworder">
    <div class="row">
          <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="neworder_l_inner">
                <h3>Material</h3>
              </div>
          </div>
          <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="neworder_r">
                <ul>
                    <li><a href="<?= base_url('admin/material/add')?>">Add Material</a></li>                          
                  </ul>
              </div>
          </div>
      </div>
  </div>        
  <div class="dashboard_table">
    <div class="table_panel">
        <div class="table-responsive">
          <table class="table table-bordered caltable" id="dataTable1" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Sl No.</th>
                <th>Material name</th>
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
<script>
  adminPage = "material";
  $(document).ready(function(){
    drawTable();
  })
  function drawTable(){
    let dataJson = {
      source: 'WEB'
    };
    $.ajax({
          type: "POST",
          url: base_url + "material/get",
          data: JSON.stringify(dataJson),
          datType: 'JOSN',
          success: function(res) {
              if (res.status.error_code == 0) {                      
                  $('tbody').html('');
                  $('tbody').html(res.result);
                  $('#dataTable1').DataTable({
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