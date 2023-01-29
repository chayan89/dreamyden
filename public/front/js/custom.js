 $(document).ready(function() {
$('.flexslider').flexslider({
animation: "slide",
start: function(slider){
$('body').removeClass('loading');
}
});
});
	$(document).ready(function(){
			//Examples of how to assign the Colorbox event to elements
			$(".group1").colorbox({rel:'group1',maxWidth:'95%', maxHeight:'90%'});
			$('.non-retina').colorbox({rel:'group5', transition:'none'})
			$('.retina').colorbox({rel:'group5', transition:'none', retinaImage:true, retinaUrl:true});
			
			//Example of preserving a JavaScript event for inline calls.
			$("#click").click(function(){ 
				$('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
				return false;
			});
		});

 $(document).ready(function() {
    $("#owl-demo").owlCarousel({
	    lazyLoad : true,
        lazyFollow : true,
		loop: true,
        mouseDrag: true,
        touchDrag: true,
        pullDrag: false,
        rewind: true,
        autoplay: true,
        margin: 0,
	    rtl: false,
		dots: false,
		slideSpeed : 100,
        paginationSpeed : 800,
        rewindSpeed : 2000,
	    responsive: true,
        responsiveRefreshRate : 200,
        responsiveBaseWidth: window,
	    /* animateOut: 'slideOutUp',
        animateIn: 'slideInUp', */
		nav: true,
        navText: ["<i class='fal fa-angle-left'></i>","<i class='fal fa-angle-right'></i>"],
		 responsive: {
			  0: {
				items: 1
			  },
			  600: {
				items: 2
			  },
			  1000: {
				items: 5
			  }
			}
	});

});


	$(document).ready(function() {
    $("#new-arrievel").owlCarousel({
	    lazyLoad : true,
        lazyFollow : true,
		loop: true,
        mouseDrag: true,
        touchDrag: true,
        pullDrag: false,
        rewind: true,
        autoplay: true,
        margin: 0,
	    rtl: false,
		dots: false,
		slideSpeed : 100,
        paginationSpeed : 800,
        rewindSpeed : 2000,
	    responsive: true,
        responsiveRefreshRate : 200,
        responsiveBaseWidth: window,
	    animateOut: 'slideOutUp',
        animateIn: 'slideInUp', 
		nav: false,
        responsive: {
			  0: {
				items: 1
			  },
			  600: {
				items: 1
			  },
			  1000: {
				items: 1
			  }
			}
	});

});	
	
	
	 $(document).ready(function() {
    $("#Category").owlCarousel({
	    lazyLoad : true,
        lazyFollow : true,
		loop: true,
        mouseDrag: true,
        touchDrag: true,
        pullDrag: false,
        rewind: true,
        autoplay: false,
        margin: 0,
	    rtl: false,
		dots: false,
		slideSpeed : 100,
        paginationSpeed : 800,
        rewindSpeed : 2000,
	    responsive: true,
        responsiveRefreshRate : 200,
        responsiveBaseWidth: window,
	    nav: false,
        responsive: {
			  0: {
				items: 1			  },
			  600: {
				items: 2
			  },
			  1000: {
				items: 4
			  }
			}
	});

});	
	
	
	
	 $(document).ready(function() {
    $("#inspiration-Category").owlCarousel({
	    lazyLoad : true,
        lazyFollow : true,
		loop: true,
        mouseDrag: true,
        touchDrag: true,
        pullDrag: false,
        rewind: true,
        autoplay: false,
        margin: 0,
	    rtl: false,
		dots: false,
		slideSpeed : 100,
        paginationSpeed : 800,
        rewindSpeed : 2000,
	    responsive: true,
        responsiveRefreshRate : 200,
        responsiveBaseWidth: window,
	    nav: false,
        responsive: {
			  0: {
				items: 1			  },
			  600: {
				items: 2
			  },
			  1000: {
				items: 4
			  }
			}
	});

});		
	
	
	
	
	 $(document).ready(function() {
    $("#white-slider").owlCarousel({
	    lazyLoad : true,
        lazyFollow : true,
		loop: true,
        mouseDrag: true,
        touchDrag: true,
        pullDrag: false,
        rewind: true,
        autoplay: false,
        margin: 0,
	    rtl: false,
		dots: false,
		slideSpeed : 100,
        paginationSpeed : 800,
        rewindSpeed : 2000,
	    responsive: true,
        responsiveRefreshRate : 200,
        responsiveBaseWidth: window,
	    nav: false,
        responsive: {
			  0: {
				items: 1			  },
			  600: {
				items: 2
			  },
			  1000: {
				items: 4
			  }
			}
	});

});	
	
 $(document).ready(function() {	
var btn = $('#button');

$(window).scroll(function() {
  if ($(window).scrollTop() > 300) {
    btn.addClass('show');
  } else {
    btn.removeClass('show');
  }
});

btn.on('click', function(e) {
  e.preventDefault();
  $('html, body').animate({scrollTop:0}, '300');
});
	
});	

     $(document).ready(function() {	     
         //// slide out search
         var sliBtn = '.search-btn',
         		sliCont = '.search-slide',
         		sliTxt = '.search-slide input[type=text]',
         		sliDis = '.search-close',
         		sliSpd = 300;
         
         $(sliBtn).click(function(){
         	$(sliCont).animate(
         		{'width':'15.5625em'}, sliSpd
         	);
         	$(sliTxt).focus();
         });
         $(sliDis).click(function(){
         	$(sliCont).animate(
         		{'width':0}, sliSpd
         	);
         });	

	});	
	

 $(document).ready(function() {
    $("#match-slider").owlCarousel({
	    lazyLoad : true,
        lazyFollow : true,
		loop: true,
        mouseDrag: true,
        touchDrag: true,
        pullDrag: false,
        rewind: true,
        autoplay: true,
        margin: 0,
	    rtl: false,
		dots: false,
		slideSpeed : 100,
        paginationSpeed : 800,
        rewindSpeed : 2000,
	    responsive: true,
        responsiveRefreshRate : 200,
        responsiveBaseWidth: window,
	    /* animateOut: 'slideOutUp',
        animateIn: 'slideInUp', */
		nav: true,
        navText: ["<i class='fal fa-angle-left'></i>","<i class='fal fa-angle-right'></i>"],
		 responsive: {
			  0: {
				items: 1
			  },
			  600: {
				items: 2
			  },
			  1000: {
				items: 3
			  }
			}
	});

});
    	
	$(document).ready(function() {
    $("#recently").owlCarousel({
	    lazyLoad : true,
        lazyFollow : true,
		loop: true,
        mouseDrag: true,
        touchDrag: true,
        pullDrag: false,
        rewind: true,
        autoplay: true,
        margin: 0,
	    rtl: false,
		dots: false,
		slideSpeed : 100,
        paginationSpeed : 800,
        rewindSpeed : 2000,
	    responsive: true,
        responsiveRefreshRate : 200,
        responsiveBaseWidth: window,
	    /* animateOut: 'slideOutUp',
        animateIn: 'slideInUp', */
		nav: true,
        navText: ["<i class='fal fa-angle-left'></i>","<i class='fal fa-angle-right'></i>"],
		 responsive: {
			  0: {
				items: 1
			  },
			  600: {
				items: 2
			  },
			  1000: {
				items: 5
			  }
			}
	});

});	 
		 
		 
$(".input").focus(function() {
  $("#search").addClass("move");
});
$(".input").focusout(function() {
  $("#search").removeClass("move");
  $(".input").val("");
});

$(".fa-search").click(function() {
  $(".input").toggleClass("active");
  $("#search").toggleClass("active");
});
   $(document).ready(function(){
        // Add down arrow icon for collapse element which is open by default
        $(".collapse.show").each(function(){
        	$(this).prev(".card-header").find(".fa").addClass("fa-angle-down").removeClass("fa-angle-right");
        });
        
        // Toggle right and down arrow icon on show hide of collapse element
        $(".collapse").on('show.bs.collapse', function(){
        	$(this).prev(".card-header").find(".fa").removeClass("fa-angle-right").addClass("fa-angle-down");
        }).on('hide.bs.collapse', function(){
        	$(this).prev(".card-header").find(".fa").removeClass("fa-angle-down").addClass("fa-angle-right");
        });
    });
	
	
	   $(document).ready(function(){
       var totalWidth = 0;
       var positions = [];
      
       $('#slides .slide').each( function(i) {
           
           // Get slider widths
           positions[i] = totalWidth;
           totalWidth += $(this).width();
           
           // check widths
           if( !$(this).width() ) {
               alert('Please make sure all images have widths!');
               return false;
           }
       });
       
       // set width
       $('#slides').width(totalWidth);
       
       // menu item click handler
       $('#menu ul li a').click( function(e, keepScroll) {
           
           // remove active calls and add inactive
           $('li.product').removeClass('active').addClass('inactive');
           
           // Add active class to the partent
           $(this).parent().addClass('active');
           
           var pos = $(this).parent().prevAll('.product').length;
           
           $('#slides').stop().animate({marginLeft:-positions[pos] + 'px'}, 450);
           
           // Prevent default
           e.preventDefault();
           
           // Stopping the autoscroll
           if(!autoScroll) {
               clearInterval(itvl);
           }   
       });
       
       // Make first image active.
       $('.product').first().addClass('active').siblings().addClass('inactive');
       
       // Auto scroll
       var current = 1;
       
       function autoScroll() {
           if (current == -1) {
               return false;
           }
           
           $( '#menu ul li a' ).eq( current % $('#menu ul li a').length ).trigger('click', true);
           current++;
       }
       
       // Durration for auto scroll
       var duration = 5;
       var itvl = setInterval( function() {
           autoScroll();
       }, duration * 1000);
       
      });