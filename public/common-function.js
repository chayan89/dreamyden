function swalAlert(text, type, timer = '') {
    Swal.fire({
        html: '<img src="'+logo_url+'public/admin/img/nav_icon2.png">',
        type: type,
        title: text,
        timer: timer != ''?timer:10000
    });
}

function swalAlertThenRedirect(text, type, url, showCancelButton = false) {
    if (showCancelButton == false) {
        var confirmButtonColor = "#e3683b";
        var cancelButtonColor = "#ef1a1a";
    } else {
        var confirmButtonColor = "#ef1a1a";
        var cancelButtonColor = "#e3683b";
    }
    Swal.fire({
        html: '<img src="'+logo_url+'public/admin/img/nav_icon2.png">',
        title: text,
        type: type,
        showCancelButton: showCancelButton, // true or false
        confirmButtonColor: confirmButtonColor,
        cancelButtonColor: cancelButtonColor,
        confirmButtonText: "OK",
        cancelButtonText: "Cancel"
    }).then(result => {
        if (result.value) {
            window.location = url;
        }
        /* else if (result.dismiss === Swal.DismissReason.cancel) {}*/
    });
}

function commonFormChecking(flag, cls = "", msgbox = "") {
    if (cls == "") {
        cls = "requiredCheck";
    }
    $("." + cls).each(function() {
        if ($.trim($(this).val()) == "") {
            if (msgbox != "") {
                $("." + msgbox).text($(this).attr("data-check") + " is mandatory !!!");
            } else {
                swalAlert($(this).attr("data-check") + " is mandatory !!!", "warning");
            }
            flag = "false";
            return false;
        } else {
            if ($(this).attr("data-check") == "Email") {
                var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
                if (reg.test($.trim($(this).val())) == false) {
                    if (msgbox != "") {
                        $("." + msgbox).text("Enter valid Email address!!!");
                    } else {
                        swalAlert("Enter valid Email address !!!", "warning");
                    }
                    flag = "false";
                    return false;
                }
            }
            if ($(this).attr("data-check") == "Phone") {
                if (parseInt($(this).val().trim().substr(0, 1)) < 5) {
                    var txt = "Enter a valid phone number !!!";
                    if (msgbox != "") {
                        $("." + msgbox).text("Enter a valid phone number !!!");
                    } else {
                        swalAlert("Enter a valid phone number !!!", "warning");
                    }
                    flag = "false";
                    return false;
                }
                if ($.trim($(this).val()).length != 10) {
                    var txt = "Enter 10 digit phone number !!!";
                    if (msgbox != "") {
                        $("." + msgbox).text("Enter 10 digit phone number !!!");
                    } else {
                        swalAlert("Enter 10 digit phone number !!!", "warning");
                    }
                    flag = "false";
                    return false;
                }
            }
            if ($(this).attr("data-check") == "Zip") {
                if ($.trim($(this).val()).length != 6) {
                    if (msgbox != "") {
                        $("." + msgbox).text("Enter 6 digit Postcode !!!");
                    } else {
                        swalAlert("Enter 6 digit Postcode !!!", "warning");
                    }
                    flag = "false";
                    return false;
                }
            }
        }
    });
    return flag;
}

function isNumber(evt) {
    evt = evt ? evt : window.event;
    var charCode = evt.which ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        if (charCode == 43 || charCode == 45 || charCode == 4) {
            return true;
        }
        return false;
    }
    return true;
}

function isChar(evt) {
    evt = evt ? evt : window.event;
    var charCode = evt.which ? evt.which : evt.keyCode;
    if ((charCode >= 65 && charCode <= 122) || charCode == 32 || charCode == 0) {
        return true;
    }
    return false;
}

$(document).on("keyup", ".restrictSpecial", function() {
    var yourInput = $(this).val();
    var re = /[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi;
    var isSplChar = re.test(yourInput);
    if (isSplChar) {
        var no_spl_char = yourInput.replace(
            /[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi,
            ""
        );
        $(this).val(no_spl_char);
    }
});

$(".allowNumberDot").keyup(function() {
    var $this = $(this);
    $this.val($this.val().replace(/[^\d.]/g, ""));
});
/* allow only letter & space */
$(".allowOnlyLetter").keypress(function(event) {
    var inputValue = event.charCode;
    if (!(inputValue >= 65 && inputValue <= 122) &&
        inputValue != 32 &&
        inputValue != 0
    ) {
        event.preventDefault();
    }
});

/*Dwar owl carousel by ID
 Chayan
*/
function makeOwlcarouselById(id) {
    var ts = $("#" + id)
    ts.owlCarousel({
        autoplay: false,
        //autoplayTimeout:1000,
        //autoplaySpeed:700,
        loop: true,
        nav: true,
        dots: true,
        //animateOut: 'fadeOut',
        items: 1,
        navText: [
            '<img src="assets/images/treatment_L.png" alt="">',
            '<img src="assets/images/treatment_R.png" alt="">'
        ]
    });
}
/*mouse right click disable*/
/*$(document).bind("contextmenu", function (e) {
    e.preventDefault();
});*/
/*mouse right click disable*/

//$(document).keydown(function (event) {
//if (event.keyCode == 123) {
/*F12 disable*/
//return false;
//}
/*else if (event.keyCode == 116) { // f5 disable
       return false;
   } */
/*else if (event.ctrlKey && event.shiftKey && event.keyCode == 73) {
    return false; //Prevent from ctrl+shift+i
} else if (event.ctrlKey && event.shiftKey && event.keyCode == 67) {
    return false; //Prevent from ctrl+shift+c
}*/
/*else if (event.ctrlKey && event.keyCode == 116) {
       return false; //Prevent from ctrl+f5
   } */
/*else if (event.ctrlKey && event.keyCode === 85) {
    return false; //Prevent from ctrl+u
}*/
//});

// table = $("#uploadedConditionTable").DataTable({
// 	pageLength: 25,
// 	processing: true, //Feature control the processing indicator.
// 	serverSide: true, //Feature control DataTables' server-side processing mode.
// 	order: [], //Initial no order.
// 	searching: false,
// 	// Load data for the table's content from an Ajax source
// 	ajax: {
// 		url: "<?php echo site_url('admin/blog/all_content_list')?>",
// 		type: "POST"
// 	},
// 	columnDefs: [
// 		{
// 			targets: "no-sort", //1st and last column
// 			orderable: false //set not orderable
// 		}
// 	]
// });
// var dtable = $("#example1")
// 	.dataTable()
// 	.api();
// $(".dataTables_filter input")
// 	.unbind() // Unbind previous default bindings
// 	.bind("input", function(e) {
// 		// Bind our desired behavior
// 		// If the length is 3 or more characters, or the user pressed ENTER, search
// 		if (this.value.length >= 3 || e.keyCode == 13) {
// 			// Call the API search function
// 			dtable.search(this.value).draw();
// 		}
// 		// Ensure we clear the search if they backspace far enough
// 		if (this.value == "") {
// 			dtable.search("").draw();
// 		}
// 		return;
// 	});
/*
var lst = 0;
var flag = true;
$(window).on("scroll", function() {
	if (page == "tours" && $("#tourOffset").val() != "0") {
		var st = $(this).scrollTop();
		if (st > lst) {
			if (
				$(window).scrollTop() + $(window).height() >=
					$(document).height() - 1200 &&
				flag == true
			) {
				flag = false;
				load_more_tour();
			}
		}
		lst = st;
	}
});
function load_more_tour() {
	$.ajax({
		type: "POST",
		url: base_url + "load-more-tour",
		data: {
			tourOffset: $("#tourOffset").val(),
			catSlug: $("#catSlug").val()
		},
		cache: false,
		beforeSend: function() {
			$(".tourLoader").removeClass("hide");
		},
		success: function(data) {
			var res = data.split("~~");
			$(".tourLoader").addClass("hide");
			$("#tourOffset").val(res[0]);
			if (res[0] != "0") {
				$(".tourLists").append(res[1]);
				flag = true;
			}
		}
	});
}
*/