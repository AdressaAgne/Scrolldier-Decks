<div class="container">
<div class="row">
	<div class="progress_outer ">
		<div class="progress_inner blueprint" style="width: 50%;">50% done</div>
	</div>
</div>

<form method="post" action="">
<!--	Faction	-->
	<div class="row">
		<div class="col-6 col-offset-3">
			<div class="form-element">
				<h2>1. Resource & Cost</h2>
			</div>				
			<div class="form-element align-center">

				<label class="icon">
					<input type="radio" name="faction" value="growth" /> <span><i class="icon-white-growth huge"></i></span>
				</label>
				<label class="icon">
					<input type="radio" name="faction" value="order" /> <span><i class="icon-white-order huge"></i></span>
				</label>
				<label class="icon">
					<input type="radio" name="faction" value="energy" /> <span><i class="icon-white-energy huge"></i></span>
				</label>
				<label class="icon">
					<input type="radio" name="faction" value="decay" /> <span><i class="icon-white-decay huge"></i></span>
				</label>

			</div>
			
			<div class="form-element">
				<h2>2. Rarity</h2>
				
				<div class="form-element">
					<label class="hand">
						<input type="radio" name="rarity" value="0" checked/> Common
					</label>
					<label class="hand">
						<input type="radio" name="rarity" value="1" /> Uncommon
					</label>
					<label class="hand">
						<input type="radio" name="rarity" value="2" /> Rare
					</label>
				</div>
			</div>
			<div class="form-element">
				<h2>3. Type & Subtype</h2>
				<div class="form-element">
					<label class="hand">
						<input type="radio" name="type" value="0" checked/> Structure
					</label>
					<label class="hand">
						<input type="radio" name="type" value="1" /> Creature
					</label>
					<label class="hand">
						<input type="radio" name="type" value="2" /> Enchantment
					</label>
					<label class="hand">
						<input type="radio" name="type" value="4" /> Spell
					</label>
				</div>
				<div class="form-element">
					<label for="subtype">
						Subtype:
						<input type="text" name="subtype" id="subtype" value="" placeholder="Subtype"/>
					</label>
					
					
				</div>
				
			</div>
			<div class="form-element">
				<h2>4. Art</h2>
			</div>
			<div class="form-element">
				<h2>5. Choose your stats wisely</h2>
			</div>
			<div class="form-element">
				<h2>6. Abilities</h2>
			</div>
			<div class="form-element">
				<h2>7. Flavor text</h2>
			</div>
			<div class="form-element">
				<h2>8. Save</h2>
			</div>
			<div class="form-element align-center">
				<button class="btn big">Next</button>
			</div>
			
		</div>
	</div>
<!--	end faction	-->

</form>
</div>