<?php $player = $account->getUserData($base->get_var(1)); 
$player['rank'] = $account->rankToString($player['rank'], true);

if ($player === false) { ?>
<div class="container">
	<div class="col-12 align-center">
		<h3>Could not fetch player data for <?= $base->get_var(1) ?></h3>
	</div>	
</div>
		
<?php	} else { ?>
		
<div class="container">
	<div class="col-12">
		<div class="page-header">
			<h2><?= $player['ign'] ?> <small><?= $player['rank'] ?></small></h2>
		</div>
	</div>	
	
	<div class="row">
		<div class="col-12" id="player-data">
			
		</div>
	</div>
</div>
<script>
	//http://a.scrollsguide.com/player?name=kbasten&fields=all&achievements&avatar
	getPlayerData("<?= $player['ign'] ?>");
	function getPlayerData(player) {
//	{"msg":"success","data":{"name":"kbasten","rating":0,"rank":6262,"badgerank":-1,"played":93,"rankedwon":18,"limitedwon":0,"won":66,"surrendered":0,"gold":2252,"scrolls":531,"lastgame":24780268,"lastupdate":10520424,"achievements":[{"aID":1,"time":1400406248},{"aID":2,"time":1400406248},{"aID":3,"time":1400406248},{"aID":4,"time":1400406248},{"aID":5,"time":1400406248},{"aID":11,"time":1400406248},{"aID":15,"time":1417823889},{"aID":16,"time":1390215785},{"aID":17,"time":1390215785},{"aID":18,"time":1390215785},{"aID":34,"time":1390215785},{"aID":38,"time":1403101032},{"aID":39,"time":1403101032},{"aID":40,"time":1403101032},{"aID":69,"time":1396599614}],"avatar":[{"head":197,"body":10,"leg":140,"armback":5,"armfront":19}]},"apiversion":1}

	    $.getJSON("http://a.scrollsguide.com/player?name="+player+"&fields=all&achievements&avatar", function(data) {
	       
	        if(data.msg == 'success') {
	           $("#player-data").html(data.data.rating);
	           
	        } else {
	           console.log("Failed to load player data");
	        }
	    })
	}
</script>
<?php
//end $player if
	}
?>