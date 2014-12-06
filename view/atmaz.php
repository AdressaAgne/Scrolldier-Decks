<!--http://imgur.com/a/fPZn9/-->
<style>
	ul {
		text-align: center;
	}
	ul li{
		display: inline-block;
		margin: 5px;
		
	}
	
	#yes, #wrong{
		position: fixed;
		
		top: 40%;
		width: 100%;
		left: 0px;
	}
	
</style>
<div class="container">

	<div class="page-header">
		<h2>Guess the scroll</h2>
	</div>

	<div class="col-12 align-center hidden" id="finished">
		<h3>You got <span id="correct">0</span> of <span id="total">0</span> images correct</h3>
		<p>Art: Atmaz</p>
	</div>

	<div class="col-12 align-center" id="menu">
		<button id="start" class="btn big">Start Game</button>
	</div>
	
	<div class="col-12 align-center hidden" id="yes">
		<h1 id="" style="color: #A0CC56;">Correct</h1>
	</div>
	
	<div class="col-12 align-center hidden" id="wrong">
		<h1 id="" style="color: #CE0000;">Wrong</h1>
	</div>
	
	
	<div class="col-12 hidden" id="game">
		<div class="col-6 col-offset-3">
			<img id="image_holder" src="" alt="" />
		</div>
		
		<div class="col-12">
			<ul id="options">
				<li>
					<label>
						<input type="radio" name="scroll" value="1" /> <span id="opt1">Option 1</span>
					</label>
				</li>
				<li>
					<label>
						<input type="radio" name="scroll" value="2" /> <span id="opt2">Option 2</span>
					</label>
				</li>
				<li>
					<label>
						<input type="radio" name="scroll" value="3" /> <span id="opt3">Option 3</span>
					</label>
				</li>
				<li>
					<label>
						<input type="radio" name="scroll" value="4" /> <span id="opt4">Option 4</span>
					</label>
				</li>
				<li>
					<label>
						<input type="radio" name="scroll" value="5" /> <span id="opt5">Option 5</span>
					</label>
				</li>
				<li>
					<label>
						<input type="radio" name="scroll" value="6" /> <span id="opt6">Option 6</span>
					</label>
				</li>
			</ul>
		</div>
	
		<div class="col-12 align-center">
			<button class="btn big" id="next">Next</button>
		</div>
	</div>
</div>

<script>

$(function() {
	var image = $("#image_holder");
	
	var correct = 0;
	
	var scrolls = [
					[
						'Animovore',
						'http://i.imgur.com/3y3jMkP.png',
						[
							'Potion of Resistance',
							'Pilgrims feet',
							'Inferno Blast',
							'Eclipse',
							'Animovore',
							'Thunder Surgde'
						]
					],
					[
						'Arbaleister',
						'http://i.imgur.com/IWMKDr8.png',
						[
							'Potion of Resistance',
							'Pilgrims Feet',
							'Inferno Blast',
							'Arbaleister',
							'Noaidi',
							'Thunder Surgde'
						]
					],
					[
						'Atrophy',
						'http://i.imgur.com/tnQPU9d.png',
						[
							'Ire and Bile',
							'Pilgrims Feet',
							'Inferno Blast',
							'Atrophy',
							'Noaidi',
							'Thunder Surgde'
						]
					],
					[
						'Inferno Blast',
						'http://i.imgur.com/MkZvFqa.png',
						[
							'Potion of Resistance',
							'Pilgrims Feet',
							'Desperation',
							'Arbaleister',
							'Noaidi',
							'Inferno Blast'
						]
					],
					[
						'Ire and Bile',
						'http://i.imgur.com/qRmPnI8.png',
						[
							'Machine Chant',
							'Pilgrims Feet',
							'Inferno Blast',
							'Ire and Bile',
							'Noaidi',
							'Thunder Surgde'
						]
					],
					[
						'Machine Chant',
						'http://i.imgur.com/yELkSDs.png',
						[
							'Oculus Cannon',
							'Pilgrims Feet',
							'Inferno Blast',
							'Ire and Bile',
							'Machine Chant',
							'Thunder Surgde'
						]
					],
					[
						'Morbid Curiosity',
						'http://i.imgur.com/GTkTeqU.png',
						[
							'Potion of Resistance',
							'Pilgrims Feet',
							'Inferno Blast',
							'Ire and Bile',
							'Noaidi',
							'Morbid Curiosity'
						]
					],
					[
						'Noaidi',
						'http://i.imgur.com/W9PWsVw.png',
						[
							'Potion of Resistance',
							'Pilgrims Feet',
							'Inferno Blast',
							'Atrophy',
							'Noaidi',
							'Thunder Surgde'
						]
					],
					[
						'Oculus Cannon',
						'http://i.imgur.com/CPrNhUC.png',
						[
							'Oculus Cannon',
							'Pilgrims Feet',
							'Inferno Blast',
							'Atrophy',
							'Noaidi',
							'Thunder Surgde'
						]
					]
					
					,
					[
						'Pilgrims Feet',
						'http://i.imgur.com/nRQxsCz.png',
						[
							'Oculus Cannon',
							'Pilgrims Feet',
							'Inferno Blast',
							'Atrophy',
							'Noaidi',
							'Thunder Surgde'
						]
					]
					,
					[
						'Potion of Resistance',
						'http://i.imgur.com/vjSdDGI.png',
						[
							'Oculus Cannon',
							'Pilgrims Feet',
							'Inferno Blast',
							'Potion of Resistance',
							'Noaidi',
							'Powerbound'
						]
					]
					,
					[
						'Powerbound',
						'http://i.imgur.com/ZIPlWHt.png',
						[
							'Oculus Cannon',
							'Pilgrims Feet',
							'Inferno Blast',
							'Powerbound',
							'Sister of Bear',
							'Thunder Surgde'
						]
					],
					[
						'Rosted bean Potion',
						'http://i.imgur.com/5Z8TGtV.png',
						[
							'Blessing of haste',
							'Speed',
							'Inferno Blast',
							'Rumble',
							'Rosted bean Potion',
							'Thunder Surgde'
						]
					],
					[
						'Rumble',
						'http://i.imgur.com/Vq0ZNHD.png',
						[
							'Blessing of haste',
							'Speed',
							'Sister of Bear',
							'Powerbound',
							'Rumble',
							'Tethered Recruit'
						]
					]
					,
					[
						'Sister of Bear',
						'http://i.imgur.com/sz1vzjl.png',
						[
							'Blessing of haste',
							'Speed',
							'Sister of Bear',
							'Powerbound',
							'Rosted bean Potion',
							'Thunder Surgde'
						]
					]
					,
					[
						'Tethered Recruit',
						'http://i.imgur.com/FddoV1x.png',
						[
							'Blessing of haste',
							'Speed',
							'Sister of Bear',
							'Powerbound',
							'Rosted bean Potion',
							'Tethered Recruit'
						]
					]
					,
					[
						'Viscera Sage',
						'http://i.imgur.com/SO0O2p0.png',
						[
							'Blessing of haste',
							'Speed',
							'Sister of Bear',
							'Vitriol Aura',
							'Viscera Sage',
							'Tethered Recruit'
						]
					]
					,
					[
						'Vitriol Aura',
						'http://i.imgur.com/vyWFtqt.png',
						[
							'Blessing of haste',
							'Vitriol Aura',
							'Viscera Sage',
							'Powerbound',
							'Rosted bean Potion',
							'Tethered Recruit'
						]
					]
					,
					[
						'Sinmarked Zealot',
						'http://i.imgur.com/4mk2Ujo.png',
						[
							'Viscera Sage',
							'Speed',
							'Sister of Bear',
							'Powerbound',
							'Sinmarked Zealot',
							'Tethered Recruit'
						]
					]
					,
					[
						'Baleful Witch',
						'http://i.imgur.com/Wlbs1vD.png',
						[
							'Viscera Sage',
							'Baleful Witch',
							'Witch Doctor',
							'Powerbound',
							'Sinmarked Zealot',
							'Tethered Recruit'
						]
					]
					,
						[
							'Blightbearer',
							'http://i.imgur.com/dcSxWJC.png',
							[
								'Blightbearer',
								'Baleful Witch',
								'Bloodboil',
								'Powerbound',
								'Bloodline Taint',
								'Blightseed'
							]
						]
						,
							[
								'Blightseed',
								'http://i.imgur.com/QZiRIiu.png',
								[
									'Blightbearer',
									'Baleful Witch',
									'Bloodboil',
									'Powerbound',
									'Bloodline Taint',
									'Blightseed'
								]
							]
							,
							[
								'Bloodboil',
								'http://i.imgur.com/gQmXHsp.png',
								[
									'Blightbearer',
									'Baleful Witch',
									'Bloodboil',
									'Powerbound',
									'Bloodline Taint',
									'Blightseed'
								]
							]
							,
							[
								'Bloodline Taint',
								'http://i.imgur.com/QFfH3MI.png',
								[
									'Blightbearer',
									'Baleful Witch',
									'Brain Lice',
									'Powerbound',
									'Bloodline Taint',
									'Blightseed'
								]
							],
							[
								'Brain Lice',
								'http://i.imgur.com/SumKqfn.png',
								[
									'Blightbearer',
									'Baleful Witch',
									'Brain Lice',
									'Powerbound',
									'Bloodline Taint',
									'Blightseed'
								]
							]
							,
							[
								'Callback',
								'http://i.imgur.com/0mM4ciz.png',
								[
									'Blightbearer',
									'Pushback',
									'Brain Lice',
									'Powerbound',
									'Callback',
									'Fallback'
								]
							]
							,
							[
								'Clock Library',
								'http://i.imgur.com/GnCufJD.png',
								[
									'Etherpump',
									'Pushback',
									'Charge Coil',
									'Powerbound',
									'Corpus Collector',
									'Clock Library'
								]
							]
							,
							[
								'Corpus Collector',
								'http://i.imgur.com/mL0z5On.png',
								[
									'Crimson Bull',
									'Pushback',
									'Charge Coil',
									'Powerbound',
									'Corpus Collector',
									'Clock Library'
								]
							]
							,
							[
								'Crimson Bull',
								'http://i.imgur.com/qkFgjoI.png',
								[
									'Crimson Bull',
									'Dryadic Power',
									'Charge Coil',
									'Erode',
									'Culling The Flock',
									'Earthbound'
								]
							]
							,
							[
								'Crone',
								'http://i.imgur.com/rKzpwD6.png',
								[
									'Crimson Bull',
									'Dryadic Power',
									'Charge Coil',
									'Crone',
									'Culling The Flock',
									'Earthbound'
								]
							],
							[
								'Culling The Flock',
								'http://i.imgur.com/hhGvzIJ.png',
								[
									'Crimson Bull',
									'Dryadic Power',
									'Charge Coil',
									'Crone',
									'Culling The Flock',
									'Earthbound'
								]
							]
							,
							[
								'Cursed Presence',
								'http://i.imgur.com/x3yJsBP.png',
								[
									'Cursed Presence',
									'Waking Stones',
									'Miasma well',
									'Warding Stone',
									'Mystic Alter',
									'Earthbound'
								]
							],
							[
								'Desperation',
								'http://i.imgur.com/Ll2EqNh.png',
								[
									'Desperation',
									'Spark',
									'Burn',
									'Tick Bomb',
									'Machine Chant',
									'Earthbound'
								]
							]
							,
							[
								'Destroyer',
								'http://i.imgur.com/4omDBif.png',
								[
									'Desperation',
									'Destroyer',
									'Catapult of Goo',
									'Tick Bomb',
									'HellSpitter Mortar',
									'Mangonel'
								]
							]
							,
							[
								'Dryadic Power',
								'http://i.imgur.com/vI13UAG.png',
								[
									'Earthbound',
									'Dryadic Power',
									'Erode',
									'Tick Bomb',
									'Ember Bonds',
									'Flip'
								]
							],
							[
								'Earthbound',
								'http://i.imgur.com/I2yhChs.png',
								[
									'Earthbound',
									'Dryadic Powe',
									'Erode',
									'Tick Bomb',
									'Ember Bonds',
									'Flip'
								]
							]
							,
							[
								'Eclipse',
								'http://i.imgur.com/f0NZvDl.png',
								[
									'Earthbound',
									'Dryadic Powe',
									'Erode',
									'Tick Bomb',
									'Ember Bonds',
									'Eclipse'
								]
							]
							,
							[
								'Erode',
								'http://i.imgur.com/ki5Uyf1.png ',
								[
									'Earthbound',
									'Dryadic Powe',
									'Erode',
									'Tick Bomb',
									'Ember Bonds',
									'Eclipse'
								]
							],
							[
								'Ember Bonds',
								'http://i.imgur.com/R1bnu9x.png',
								[
									'Earthbound',
									'Dryadic Powe',
									'Erode',
									'Tick Bomb',
									'Ember Bonds',
									'Eclipse'
								]
							],
							[
								'Eternal Sword',
								'http://i.imgur.com/OxXeyrT.png',
								[
									'Earthbound',
									'Eternal Sword',
									'Crown of Strenght',
									'Fleetness',
									'Stifled Addvance',
									'Eclipse'
								]
							]
							,
							[
								'Fertile Soil',
								'http://i.imgur.com/PnI6c4m.png',
								[
									'Rekindled Spirit',
									'Eternal Sword',
									'Fertile Soil',
									'Fleetness',
									'Stifled Addvance',
									'Eclipse'
								]
							],
							[
								'Flip',
								'http://i.imgur.com/4iZVpQI.png',
								[
									'Flip',
									'Pother',
									'Reversal',
									'Fleetness',
									'Rimble',
									'Transposition'
								]
							],
							[
								'Frostbeard',
								'http://i.imgur.com/dwmo71b.png',
								[
									'Frostbeard',
									'Frostneck',
									'Sister of the bear',
									'Fleetness',
									'Striped Fangbear',
									'husk'
								]
							],
							[
								'Horn of Ages',
								'http://i.imgur.com/FzhLZYU.png',
								[
									'Horn of Ages',
									'New Orders',
									'Decimation',
									'Callback',
									'Ascelon Spires',
									'Focus'
								]
							]
							,
							[
								'Husk',
								'http://i.imgur.com/iIsrRk6.png',
								[
									'Husk',
									'BladeHusk',
									'Corpus Collector',
									'Shourd of unlife',
									'Ascelon Spires',
									'Necrogeddon'
								]
							]
							,
							[
								'Hymn',
								'http://i.imgur.com/S7IW5Ky.png',
								[
									'Hymn',
									'Stag Heart',
									'Leeching Ring',
									'Shourd of unlife',
									'Essence feast',
									'Oak Blood'
								]
							],
							[
								'Illthorn',
								'http://i.imgur.com/Hflsxvx.png ',
								[
									'Illthorn',
									'Illthorn Seed',
									'Leeching Ring',
									'Shourd of unlife',
									'Essence feast',
									'Oak Blood'
								]
							]
								
					
	
				];	

	var q = 0;
	
	var total = scrolls.length;
	
	function set_score() {
		$("#total").text(total);
		$("#correct").text(correct);
	}
	
	function set_round(round) {
		
		shuffle(scrolls[round][2]);
		
		for (var i = 0; i < scrolls[round][2].length+1; i++) {
			$("#opt"+(i)).text(scrolls[round][2][i-1]);
		}
		$(image).attr('src', scrolls[round][1]);
		
	}
	
	function check() {
		var svar = $('input[name=scroll]:checked').next('span').text();
		
		round = q - 1 ;
	
		var timeout = 500;
		
		if (scrolls[round][0] == svar) {
			$("#yes").fadeIn();
			
			setTimeout(function() {
				$("#yes").fadeOut();
			}, timeout);
			
			
			correct += 1;
		} else {
			$("#wrong").fadeIn();
			
			setTimeout(function() {
				$("#wrong").fadeOut();
			}, timeout);
		}
	}
	
	function next() {
		
		if (q != 0) {
			check();
		}
		
		
		$('input[name=scroll]').prop('checked', false);
		
		
		if (q == (total)) {
			set_score();
			$("#game").hide();
			$("#finished").show();
			$("#menu").show();
		} else {
			set_round(q);
		}
		
		q += 1;
	}	
				
	function start_game() {
		q = 0;
		correct = 0;
		shuffle(scrolls);
		next();
		
		$("#finished").hide();
		$("#menu").hide();
		$("#game").show();
	}			
	
	$("#start").click(function() {
		start_game();
	});
	
	$("#next").click(function() {
		next();
	});
	
	
	function shuffle(array) {
	  var currentIndex = array.length, temporaryValue, randomIndex ;
	
	  // While there remain elements to shuffle...
	  while (0 !== currentIndex) {
	
	    // Pick a remaining element...
	    randomIndex = Math.floor(Math.random() * currentIndex);
	    currentIndex -= 1;
	
	    // And swap it with the current element.
	    temporaryValue = array[currentIndex];
	    array[currentIndex] = array[randomIndex];
	    array[randomIndex] = temporaryValue;
	  }
	
	  return array;
	}
	
});
	
</script>