<div class="container">
	<div class="row">
		<div class="col-12">
			<div class="row game-stats">
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
			<div class="col-12 game">
				<div class="page-header">
					<h2>Gravelock Clicker <small>By: Orangee & Atmaz</small> <small id="save-notify"></small> <button class="btn hidden" id="debug">Debug</button></h2>
				</div>
				<div class="col-12">
					<button class="toggle btn" id="units-div">Units</button>
					<button class="toggle btn" id="spells-div">Spells</button>
					<?php if ($_SESSION['ign']) { ?>
						<button class="btn danger" id="save-game">Save Game</button>
					<?php }  else { ?>
						<p>Login to save... all progress will be lost when leaving page</p>
					<?php } ?>
					
				</div>
				<div class="col-12" name="units-div" id="units"></div>
				<div class="col-12 hidden" name="spells-div" id="spells"></div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-12">
			<p>Bugs: Times does not go by when tab not open.</p>
			<p>Game Saves when <span style="color: #ffeb04;">[idle]</span> </p>
		</div>
	</div>
</div>
<script src="/js/game/gravelock.js"></script>