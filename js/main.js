$(function(){
	getAuthServerStatus();
	getOnlinePlayers();
	getSpecialClientMessage();
	
//    var nav = $('.menu');
//    $(window).scroll(function () {
//        if ($(this).scrollTop() > 134) {
//            nav.addClass("menu-fixed");
//        } else {
//            nav.removeClass("menu-fixed");
//        }
//    });
// 
 	$("#phone-menu").click(function() {
 		$(".menu").slideToggle();
 	});
 	
 	
 	$("#errorCloseBtn").click(function() {
 		$("#errorcontainer").hide();
 	});
 	$("#successCloseBtn").click(function() {
 		$("#successcontainer").hide();
 		copyToClipboard("123");
 	});
 	
 	$("#jsonOutput").click(function() {
 		$("#jsonoutputcontainer").toggle();
 	});
 	
 	
	 function displayAuthServerStatus(status) {
	     if(status === "red") {
	         $('#authserverstatus').html("<span><i class='ball-red'></i> Authentication servers</span>");
	     } else if (status === "green") {
	     	 $('#authserverstatus').html("<span><i class='ball-green'></i> Authentication servers</span>");
	     } else {
	         $('#authserverstatus').html("<span><i class='ball-yellow'></i> Authentication servers</span>");
	     }
	 } 
 
 //http://status.mojang.com/news?product=3
 //{ "message": "MESSAGE HERE" }
 	function getSpecialClientMessage() {
 		$.getJSON("http://status.mojang.com/news?product=3", function(data) {
	        console.log( "Successfully fetched announcements" );
	        if(typeof data.message !== 'undefined') {
	            $("#specialmessagecontainer").show();
	          //<div class="col-12"><h2>header</h2></div>
	          //<div class="col-12"><p>text</p></div>
	             $("#specialmessage").html("<div class='col-12'><h3>" + data.headline + "</h3></div>
	             							<div class='col-12'><p>"+data.message+"</p></div>");
	        }
	
	    })
 	}
 
 
	 function getAuthServerStatus() {
	     $.getJSON("http://status.mojang.com/check?service=authserver.mojang.com", function(data) {
	         console.log( "Successfully fetched Mojang Auth Server status" );
	         if(typeof data['authserver.mojang.com'] !== 'undefined') {
	         	console.log('Status: '+data['authserver.mojang.com']);
	         	displayAuthServerStatus(data['authserver.mojang.com']);
	         }
	     })
	 }
	 
	 function getOnlinePlayers() {
	     $.getJSON("http://a.scrollsguide.com/statistics", function(data) {
	         console.log( "Getting Scrolls Statistics" );
	         if(data['msg'] == 'success') {
	            console.log('Online Payers: '+data.data.online);
	            console.log('Online Today: '+data.data.onlinetoday);	 
	            $('#scrollsingame').html("<span>Online: " + data.data.online + "</span>");
	            $('#scrollstoday').html("<span>24 Hours: " + data.data.onlinetoday + "</span>");
	         }
	     })
	 }
	function showSuccess(msg) {
		$("#successMessage").text(msg);
		$("#successcontainer").show();
	}
	function showError(msg) {
		$("#errorMessage").text(msg);
		$("#errorcontainer").show();
	}
	 
	
});

