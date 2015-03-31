<div class="container-big">
	<div class="page-header">
		<h2>Admin</h2>
	</div>
    
    <div class="row">
        <div class="col-12">
            <p>Twitch-Stream</p>
                <input type="checkbox" name="twitchactive" <?= $twitch['value_int'] == 1 ? 'checked' : ''; ?>/>
                <input type="text" name="hosted" value="<?= $twitch['value_var']; ?>"/>
                <button class="btn" id="updatestream">Change</button>
        </div>
        
    </div>
	
	<div class="row">
		<div class="col-12">
			<p>Pages </p>
			<div class="row align-center hidden" id="loading">
				<span><i class="fa fa-refresh fa-spin"></i></span>
			</div>
                        <button class="btn toggle" id="pages">Toggle</button>
                        <div name="pages" hidden>
			<table class="even divider hover border" id="page_table">
				<thead>
					<tr>
						<td><i class="fa fa-link"></i></td>
						<td>Title</td>
						<td>Name</td>
						<td>Menu</td>
						<td>Tool</td>
						<td>Restr</td>
						<td>Grade</td>
						<td><i class="fa fa-file-code-o"></i></td>
						<td colspan="2"><i class="fa fa-image"></i></td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><input type="text" class="negative col-12" required name="url" value="" id="url" placeholder="Url"/></td>
						<td><input type="text" class="negative col-12" required name="title" value="" placeholder="Title"/></td>
						<td><input type="text" class="negative col-12" required name="name" value="" placeholder="Name"/></td>
						<td colspan="2">
							<div class="form-element inline">
								<label class="icon">
									<input type="checkbox" class="negative" checked="false" name="menu" value="" /><span><i class="icon-1"></i></span>
								</label>
							</div>	
						
							<div class="form-element inline">
								<label class="icon">
									<input type="checkbox" class="negative" checked="false" name="tool" value="" /><span><i class="icon-1"></i></span>
								</label>
							</div>
						
							<div class="form-element inline">
								<label class="icon">
									<input type="checkbox" class="negative" checked="false" name="restriction" value="" /><span><i class="icon-1"></i></span>
								</label>
							</div>
						</td>
						<td colspan="2">
							<div class="form-element inline right">
								<label class="icon">
									<input type="radio" name="grade" value="1" /> <span><i class="number-1"></i></span>
								</label>
								<label class="icon">
									<input type="radio" name="grade" checked value="2" /> <span><i class="number-2"></i></span>
								</label>
								<label class="icon">
									<input type="radio" name="grade" value="3" /> <span><i class="number-3"></i></span>
								</label>
								<label class="icon">
									<input type="radio" name="grade" value="4" /> <span><i class="number-4"></i></span>
								</label>
							</div>
						</td>
						<td><input type="text" class="negative col-12" required name="file" value="" placeholder="File name"/></td>
						<td><input type="text" class="negative col-12" name="image" value="" placeholder="Image"/></td>
						<td>
							<button class="btn negative right" id="add_page"><i class="fa fa-plus"></i></button>
						</td>
					</tr>
					
					<?php foreach ($base->pagestructure as $key => $value) { ?>
						<tr class="page_tr" id="page_<?= $value['id'] ?>">
							<td><a href="<?= $key ?>"><?= $key ?></a></td>
							<td><?= substr($value['title'], 0, 10) ?>...</td>
							<td><?= $value['name'] ?></td>
							<td><?php echo($value['menu'] == 1 ? "<i class='ball-green'></i>" : "<i class='ball-red'></i>") ?></td>
							<td><?php echo($value['tool'] == 1 ? "<i class='ball-green'></i>" : "<i class='ball-red'></i>") ?></td>
							<td><?php echo($value['restricted'] == 1 ? "<i class='ball-yellow'></i>" : "<i class='ball-red'></i>") ?></td>
							<td><?= $value['grade'] ?></td>
							<td><?= $value['page'] ?></td>
							<td><?= $value['image'] ?></td>
							<td><button class="btn negative" id="deletepage" data-id="<?= $value['id'] ?>"><i class="fa fa-trash"></i></button></td>
						</tr>
						
					<?php } ?>
				</tbody>
	
			</table>
                        </div>
		</div>
		<!--<div class="col-6">
			<pre><?php print_r($base->pagestructure) ?></pre>
		</div>-->
	</div>
</div>
<script>
	$(function() {
		
		$("[id*=deletepage]").click(function() {
			var id = $(this).attr("data-id");
			console.log(id);
			
			$.ajax( {
			  type: "POST",
			  url: "/view/admin/ajax/delete_page.php",
			  data: {id: id}
			  }).done(function(data) {
			  	if (data) {
			  		 console.log("Page Deleted");
			  		 $("#page_"+id).hide();
			  	} else {
			  		 console.log("Error: " + data);
			  	}
			  })
			  .fail(function() {
			    console.log("Failed while deleting page, with error: "+data);
			  })
			  .always(function(data) {
			   console.log("Request done.");
			});
			
		});
		
		$("#add_page").click(function() {
			var url = $("[name='url']").val();
			var title = $("[name='title']").val();
			var name = $("[name='name']").val();
			var menu = $("[name='menu']").val();
			var tool = $("[name='tool']").val();
			var restriction = $("[name='restriction']").val();
			var grade = $("[name='grade']:checked").val();
			var file = $("[name='file']").val();
			var image = $("[name='image']").val();
			//"<i class='ball-yellow'></i>" : "<i class='ball-red'></i>"
			$.ajax( {
			  type: "POST",
			  url: "/view/admin/ajax/new_page.php",
			  data: {
			  	url: url,
			  	title: title,
			  	name: name,
			  	menu: menu,
			  	tool: tool,
			  	restriction: restriction,
			  	grade: grade,
			  	file: file,
			  	image: image
			  		}
			  }).done(function(data) {
			  
			   if (data) {
			   	 console.log("Page added succesfully");
			   } else {
			   	 console.log("Error: " + data);
			   }
			   
			  if(menu == 1) {  menu = "<i class='ball-green'></i>" }else{  menu = "<i class='ball-red'></i>" };
			  if(tool == 1) {  tool = "<i class='ball-green'></i>" }else{  tool = "<i class='ball-red'></i>" };
			  if(restriction == 1) {  restriction = "<i class='ball-green'></i>" }else{  restriction = "<i class='ball-red'></i>" };
			   
			   $("#page_table").prepend("<tr class='page_tr'>" +
			   	"<td><a href='"+url+"'>"+url+"</a></td>" +
			   	"<td>"+title+"</td>" +
			   	"<td>"+name+"</td>" +
			   	"<td>"+menu+"</td>" +
			   	"<td>"+tool+"</td>" +
			   	"<td>"+restriction+"</td>" +
			   	"<td>"+grade+"</td>" +
			   	"<td>"+file+"</td>" +
			   	"<td colspan='2'>"+image+"</td>" +
			   "</tr>");
			  })
			  .fail(function() {
			    console.log("Failed while adding page, with error: "+data);
			  })
			  .always(function(data) {
			   console.log("Request done.");
			});
		});
		
                $("#updatestream").click(function() {
                    var twitchactive = $("[name='twitchactive']").is(":checked")? 1 : 0;
                    var hosted = $("[name='hosted']").val();
                    
                    $.ajax( {
                        type: "POST",
                        url: "/view/admin/ajax/update_stream.php",
                        data: {
                            twitchactive : twitchactive,
                            hosted : hosted
                        }
                    }).done(function(data) {
                        
                        if (data) {
			    console.log("Updated Stream");
			} else {
			    console.log("Error: " + data);
			}
                    });
                });
		
	});
</script>