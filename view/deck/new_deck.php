<div class="container">
	<div class="page-header">
		<h2>New Deck</h2>
	</div>
	
	
	<div class="row">
	
		<div class="row">
			<div class="col-6 col-tab-12">
				<div class="form-element">
					<label for="json_string">Export String</label>
					<input id="json_string" type="text" name="json_string" value="" placeholder="JSON string" />
				</div>
			</div>
			<div class="col-6 col-tab-12">
				<div class="form-element">
					<label for="name">Deck Name</label>
					<input id="name" type="text" name="name" value="" placeholder="Deck Name" />
				</div>
			</div>
		</div>
		
		
		<div class="row">
			<div class="col-6">
				<div class="form-element">
					<label for="text">Cover Image</label>
					
				</div>
				
			</div>
			<div class="col-6">
				<div class="form-element">
					<label for="text">Tags <small>comma separeted(,)</small></label>
					<input id="text" type="text" class="" name="" value="" placeholder="Write a tag" />
					<input type="hidden" id="hidden_tags" name="tags" value="" />
				</div>
				
				<div class="form-element">
					<span id="tags"></span>
				</div>
			</div>
		</div>
	
	</div>
	
</div>

<script>
	$(function() {
		var tags = [];
	
		$("#text").keyup(function() {
			if (($(this).val().slice(-1) == ",") && ($(this).val() != "" && $(this).val() != ",")) {
				tags.push($(this).val().replace(/,/,''));
				$("#tags").append("<span class='tag' style='margin: 5px; display: inline-block;'>"+$(this).val().replace(/,/,'')+"</span>");
				$(this).val("");
			}
			update()
		});
		
		$("#text").keydown(function(e) {
			
			if ((e.keyCode == 8) && ($("#text").val() == "")) {
				tags.pop();
				$("#tags").html("");
				for (var i = 0; i < tags.length; i++) {
					$("#tags").append("<span class='tag' style='margin: 5px; display: inline-block;'>"+tags[i]+"</span>");
				}
				
			}
			update()
		});
		function update() {
			$("#hidden_tags").val("");
			for (var i = 0; i < tags.length; i++) {
				$("#hidden_tags").val($("#hidden_tags").val()+tags[i]+",");
			}
			
		}
	});
</script>