<div class="container-fluid">
	<div class="container clearfix game-stats">
		<div class="col-6" id="game-gold">
			<div class="page-header align-center" style="color: #ffeb04;">
				<h1 id="gold">Gravelock Clicker</h1>
				<p>Summoning Gravelocks will increase DPS.</p>
				<p>Current idol health: 10</p>
			</div>
		</div>
		<div class="col-4 hidden" id="game-res">
			<div class="page-header align-center">
				<h1 id="resources"><span id="res-energy">0</span> <i class="icon-energy"></i></h1>
				<p>Cast Powerful spells with Resources</p>
			</div>
		</div>
		<div class="col-6" id="game-dps">
			<div class="page-header align-center">
				<h1 id="total_dps">Total DPS</h1>
				<p>Destroy Idols to get more gold.</p>
				<p>Receive 20 gold per idol destroyed.</p>
			</div>
		</div>
	</div>
</div>
<div class="container">
	<div class="row">
		<div class="col-12">
			
			<div class="col-12 game">
				<div class="page-header">
					<h2>Gravelock Clicker <small>By: Orangee & Atmaz</small>  <button class="btn hidden" id="debug">Debug</button></h2>
				</div>
				<div class="col-12">
					<button class="menu-toggle btn" data-show="units" data-hide="game-div">Units</button>
					<button class="menu-toggle btn" data-show="spells" data-hide="game-div">Spells</button>
					
					
				</div>
				<div class="col-12" name="game-div" id="units"></div>
				<div class="col-12 hidden" name="game-div" id="spells"></div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-12">
			<?php if ($_SESSION['ign']) { ?>
				<button class="btn danger" id="save-game">Save Game</button></span> 
			<?php }  else { ?>
				<p><span style="color: #ffeb04;">Login to save... all progress will be lost when leaving page</span></p>
			<?php } ?>
			<small id="save-notify"></small>
			 <div id="game-ascend-box">
			 	<p>When ascending you will gain <span id="game-shards-gain"></span><i class="icon-shard"></i></p>
			 	<button class="btn danager" id="game-ascend">Ascend Now(WiP)</button>
			 	<p>1000 Units = 1<i class="icon-shard"></i></p>	
			 </div>
		</div>
		<div class="col-12">
			<button class="btn small danger" id="reset-game">Reset Everything</button></span> 
		</div>
	</div>
</div>
<script src="/js/game/gravelock.js"></script>