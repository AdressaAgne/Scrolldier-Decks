$(function() {

	var allScrolls = [];
	
	$("[id=addScrollScroll]").click(function() {
		var	id = $(this).attr("data-id");
		var image = $(this).attr("data-image");
		var faction = $(this).attr("data-faction");
		var name = $(this).attr("data-name");
		
		addScroll(parseInt(id), parseInt(image), faction, name);
	});
	
	
	
	$("#deck-scrolls").on("click", "div[data-id]",function() {
		console.log("Removing Scroll");
		removeScroll($(this).attr("data-id"));
	});
	
	
	
	$(".scroll-front").hover(function() {
		changePreview($(this).attr("data-name"));
	});
	
	function changePreview(name) {
		console.log("changing preview to "+name);
		$("#previewImage").attr("src", "http://a.scrollsguide.com/image/screen?name="+name+"&size=large");
	}
	
	function getHTML(id, image, faction, name, count) {
		return '<div class="col-2 col-phone-6 col-tab-3 hand scrolls" data-name="'+name+'" data-id="'+id+'" data-count="'+count+'" data-faction="'+faction+'" data-image="'+image+'">' +
				'<div class="col-12 scroll scroll-stack-'+count+'" style="background-image: url(/img/scrolls/'+image+'.png)">' +
					'<i class="icon-'+faction+'"></i>' +
				'</div>' +
				'<div class="col-12 scroll-content">' +
					'<span id="count">'+count+'x</span> <span id="name">'+name+'</span>' +
				'</div>' +
			'</div>';
	}
	
	function getInnerHTML(id, image, faction, name, count) {
		return '<div class="col-12 scroll scroll-stack-'+count+'" style="background-image: url(/img/scrolls/'+image+'.png)">' +
					'<i class="icon-'+faction+'"></i>' +
				'</div>' +
				'<div class="col-12 scroll-content">' +
					'<span id="count">'+count+'x</span> <span id="name">'+name+'</span>' +
				'</div>';
	}
	
	function addScroll(id, image, faction, name) {
		if ($("#deck-scrolls [data-id="+id+"]").length) {
			var scrollID = $("#deck-scrolls").find("[data-id="+id+"]");
			var dataCount = $(scrollID).attr("data-count");
			var newCount = parseInt(dataCount)+1;
			
			if (dataCount != 3) {
				console.log("Adding 1 scroll to "+name+"("+(newCount)+")");
				$(scrollID).html(getInnerHTML(id, image, faction, name, newCount));
				$(scrollID).attr("data-count", newCount);
			} else{
				console.log("Already got 3 scrolls of "+name);
			}
			
		} else {
			$("#deck-scrolls").append(getHTML(id, image, faction, name, 1));
		}
	}
	
	function removeScroll(id) {
		var scrollID = $("#deck-scrolls").find("[data-id="+id+"]");
		var dataCount = $(scrollID).attr("data-count");
		var name = $(scrollID).find("#name").text();
		var faction = $(scrollID).attr("data-faction");
		var image = $(scrollID).attr("data-image");
		
		var newCount = parseInt(dataCount)-1;
		
		if (dataCount != 1) {
			console.log("Adding 1 scroll to "+name+"("+(newCount)+")");
			$(scrollID).html(getInnerHTML(id, image, faction, name, newCount));
			$(scrollID).attr("data-count", newCount);
		} else{
			$(scrollID).remove();
		}
	}
});