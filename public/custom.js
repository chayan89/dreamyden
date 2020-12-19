$(window).bind("load", function() {
    window.setTimeout(function() {
        $("#flashdata")
            .fadeTo(500, 0)
            .slideUp(500, function() {
                $(this).remove();
            });
    }, 2000);
});

/**
 * End Company Checked
 */
$(document).on("click", ".change-p-status", function(e) {
    e.preventDefault();
    var status = $(this).attr("data-status");
    var m = "change status";
    if (status == 3) {
        m = "delete";
    }
    Swal.fire({
        title: "Are you sure want to " + m + "?",
        type: "warning",
        showCancelButton: true, // true or false
        confirmButtonColor: "#dd6b55",
        cancelButtonColor: "#48cab2",
        confirmButtonText: "Yes !!!",
    }).then((result) => {
        if (result.value) {
            let id = $(this).attr("data-id");
            let indexKey = $(this).attr("data-key-id");
            let table = $(this).attr("data-table");

            let dataJson = {
                id: id,
                indexKey: indexKey,
                table: table,
                status: status,
            };
            if (id && table) {
                $.ajax({
                    type: "POST",
                    url: base_url + "change-status",
                    data: JSON.stringify(dataJson),
                    success: function(res) {
                        console.log(res);
                        if (res.status.error_code == 0) {
                            if (status == 3) {
                                // for delete activity
                                swalAlert("Data Deleted Successfully", "success");
                                location.reload();
                            } else {
                                if (status == 0) {
                                    $("#" + id).attr("data-status", "1");
                                    $("#" + id).removeClass("text-success");
                                    $("#" + id).addClass("text-danger");
                                    $("#" + id).html("Inactive");
                                } else {
                                    $("#" + id).attr("data-status", "0");
                                    $("#" + id).removeClass("text-danger");
                                    $("#" + id).addClass("text-success");
                                    $("#" + id).html("Active");
                                }
                                swal("Good job!", "You clicked the button!", "success");
                            }
                        } else {
                            swalAlert(res.message, "warning");
                        }
                    },
                });
            }
        }
    });
});
$(window).bind("load", function() {
    //alert(adminPage)
    if (adminPage) {
        switch (adminPage) {
            //alert("dfgdfg");
            case "Rolelist":
                roleList();
                break;
            case "Commissionlist":
                commissionList();
                break;
            case "Companylist":
                companyList();
                break;
            case "Campaignlist":    
                campaignList();
                break;
            case "leadList":
                companyList('MOB');
                getUserList(new Array(4, 5));
                break;
        }   
    }
    
});
function roleList(){
    $.ajax({
        type: "POST",
        url: base_url + "role/get-list",
        beforeSend: function() {},
        success: function(res) {
            console.log(res);
            $("#role_list_div").html(res.result);
            var now = new Date();
            var date = now.getFullYear() + "-" + now.getMonth() + "-" + now.getDate();
            $("#tablerole").DataTable({
                pageLength: 10,                
                dom:'Bfrtip',
                buttons:[{ 
                    extend: 'excel',                        
                    filename: 'role_list_' + date,
                    className: "btn btn-round_small btn-img",
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i> Export',
                    tag:  'span',
                    exportOptions: { columns: [0,1,2] }  
                }     
                //'excel'
                ]
            });
        },
    });
}
function commissionList(){
    $.ajax({
        type: "POST",
        url: base_url + "commission/get-list",
        beforeSend: function() {},
        success: function(res) {
            console.log(res);
            $("#commission_list_div").html(res.result);
            var now = new Date();
            var date = now.getFullYear() + "-" + now.getMonth() + "-" + now.getDate();
            $("#tablecommission").DataTable({
                pageLength: 10,                
                dom:'Bfrtip',
                buttons:[{ 
                    extend: 'excel',                        
                    filename: 'user_commission_list_' + date,
                    className: "btn btn-round_small btn-img",
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i> Export',
                    tag:  'span',
                    exportOptions: { columns: [0,1,2] }  
                }     
                //'excel'
                ]
            });
        },
    });
}
function companyList(source = 'WEB'){
    console.log(source);
    $.ajax({
        type: "POST",
        url: base_url + "company/get-list",
        beforeSend: function() {},
        success: function(res) {
            if(source == 'WEB'){
                $("#company_list_div").html(res.result);
                var now = new Date();
                var date = now.getFullYear() + "-" + now.getMonth() + "-" + now.getDate();
                $("#tablecompany").DataTable({
                    pageLength: 10,                
                    dom:'Bfrtip',
                    buttons:[{ 
                        extend: 'excel',                        
                        filename: 'company_list_' + date,
                        className: "btn btn-round_small btn-img",
                        text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i> Export',
                        tag:  'span',
                        exportOptions: { columns: [0,1,2] }  
                    }     
                    //'excel'
                    ]
                });
            }else{                
                console.log(res);
                let d = res.result;
                $('.company-list').html('');
                $('.company-list').html('<option value="">Sales Company</option>');
                if(d.length > 0){                        
                    $.each(d, function(key, val){
                        $('.company-list').append('<option value="'+val.company_id+'">'+val.name+'</option>');
                    });
                }
            }
        },
    });
}
function campaignList(){
    $.ajax({
        type: "POST",
        url: base_url + "campaign/get-list",
        beforeSend: function() {},
        success: function(res) {
            console.log(res);
            $("#campaign_list_div").html(res.result);
            var now = new Date();
            var date = now.getFullYear() + "-" + now.getMonth() + "-" + now.getDate();
            $("#tablecampaign").DataTable({
                pageLength: 10,                
                dom:'Bfrtip',
                buttons:[{ 
                    extend: 'excel',                        
                    filename: 'campaign_list_' + date,
                    className: "btn btn-round_small btn-img",
                    text: '<i class="fa fa-file-excel-o" aria-hidden="true"></i> Export',
                    tag:  'span',
                    exportOptions: { columns: [0,1,2,3,4,5] }  
                }     
                //'excel'
                ]
            });
        },
    });
}
//return company users
function getUserList(roles = null){
    let jsonData = {
        role: roles
    };
    console.log(jsonData);
    $.ajax({
            type: "POST",
            url: base_url+'index/getUserList',
            data: JSON.stringify(jsonData),
            //dataType: 'json',
            success: function (res) {				
                console.log(res);
                if(res.status.error_code == 0){
                    let d = res.result.data;
                    $('.users-list').html('');
                    $('.users-list').html('<option value="">Sales Owner</option>');
                    if(d.length > 0){                        
                        $.each(d, function(key, val){
                            $('.users-list').append('<option value="'+val.id+'">'+val.name+'</option>');
                        });
                    }
                }
                // else{
                //     swalAlert(res.status.message, 'warning');
                // }
            },
            error: function (res) {
                console.log(res);
            }
        });
}