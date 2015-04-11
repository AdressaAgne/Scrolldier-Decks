$(function() {
var resources = {
	growth : 0,
	energy : 1,
	decay  : 2,
	order  : 3,
	wild	: 4
}
var game = (function() {
var game = {
	gameTick	: 100,
	gameSpeed	: 1000,
	priceMultiplyer : 1.15,
	unitPriceMultiplyer : 6,
	totalUnits : 0,
	totalSpells : 0,
	debugMode : false,
	idle 	: false,
	gameLoaded : false,
	ascendShards : 1000,
	ascend	: Math.pow(10, 43),
	clock	: 0,
	clockReset : 100,
	player	: {
		level	: 0,
		gold	: 3,
		shards	: 0,
		idol	: 0,
		goldSec	: 0,
		idolHealth	: 10,
		idolKillReward : 20,
		res : {
			growth : 0,
			energy : 0,
			decay  : 0,
			order  : 0,
			wild   : 0
		},
		resouceName : {
			0 : "Growth",
			1 : "Energy",
			3 : "Decay",
			4 : "Order",
			5 : "Wild"
		}
	},
	
	units : [{
		name	: "Gravelock Raider",
		shortName	: "Raider",
		elderBoost	: true,
		tier1 	: 0,
		tier2 	: 1000,
		tier3	: 1000*3,
		price	: 3,
		basePrice	: 3,
		ap		: 1,
		cd		: 2,
		hp		: 2,
		count	: 0,
		round	: 0
	},
	{
		name	: "Gravelock Guard",
		shortName	: "Guard",
		elderBoost	: true,
		tier1 	: 1000,
		tier2 	: 1000*3,
		tier3	: 1000*9,
		price	: 18,
		basePrice	: 18,
		ap		: 2,
		cd		: 2,
		hp		: 3,
		count	: 0,
		round	: 0
	},
	{
		name	: "Gravelock Outcast",
		shortName	: "Outcast",
		elderBoost	: true,
		tier1 	: 3000,
		tier2 	: 3000*3,
		tier3	: 3000*9,
		price	: 108,
		basePrice	: 18,
		ap		: 3,
		cd		: 2,
		hp		: 3,
		count	: 0,
		round	: 0
	},
	{
		name	: "Lockling Brood",
		shortName	: "Locklings",
		elderBoost	: true,
		tier1 	: 6000,
		tier2 	: 6000*3,
		tier3	: 6000*9,
		price	: 648,
		basePrice	: 18,
		ap		: 4,
		cd		: 1,
		hp		: 4,
		count	: 0,
		round	: 0
	},
	{
	name	: "Snargl",
	shortName	: "Snargl",
	tier1 	: 6000,
	tier2 	: 6000*3,
	tier3	: 6000*9,
	price	: 839808,
	basePrice	: 18,
	ap		: 4,
	cd		: 2,
	hp		: 5,
	count	: 0,
	round	: 0,
	hasIdle	: true,
	desc	: "<span class='effect' style='color: #ffeb04;'>[Idle]</span>: Attack increases by 10",
	clockEffect	: function(j) {	
		var unit = game.units[4];
		
			if (game.idle) {
				unit.ap = 14;
				return "+"+unit.count*10 + " Attack";
			} else {
				unit.ap = 4;
				return 0 + " Attack";
			}
		
		}
	},
	{
		name	: "Gravelock Freak",
		shortName	: "Freak",
		elderBoost	: true,
		tier1 	: 6000,
		tier2 	: 6000*3,
		tier3	: 6000*9,
		price	: 3888,
		basePrice	: 18,
		ap		: 3,
		cd		: 2,
		hp		: 6,
		count	: 0,
		round	: 0,
		desc	: "Deals additional damage per round equal to its health.",
		clockEffect	: function(j) {
			var unit = game.units[5];
			var damage = unit.hp / unit.cd;
			var gt = game.gameTick / game.gameSpeed;
			var bonusGold = (damage / (game.player.idolHealth / gt)) * game.player.idolKillReward;
			game.player.gold += bonusGold;
			return priceDown(damage, "", "DPS");
		}
	},
	{
		name	: "Gravelock Elder",
		shortName	: "Elder",
		effectValue : 1,
		tier1 	: 6000,
		tier2 	: 6000*3,
		tier3	: 6000*9,
		price	: 23328,
		basePrice	: 18,
		ap		: 3,
		cd		: 2,
		hp		: 5,
		count	: 0,
		round	: 0,
		desc	: "Increases attack and health of all Gravelocks by 1.",
		effect	: function(j) {
			for (var i = 0; i < game.totalUnits; i++) {
				var unit = game.units[i];
				
				if (unit.elderBoost) {
					unit.ap += Number(j);
					unit.hp += Number(j);
				}
			}
		}
	},
	{
		name	: "Uhu Longnose",
		shortName	: "Uhu",
		elderBoost	: true,
		effectValue : 2,
		tier	: 1,
		tier1 	: 6000,
		tier2 	: 6000*3,
		tier3	: 6000*9,
		price	: 139968,
		basePrice	: 18,
		ap		: 2,
		cd		: 2,
		hp		: 4,
		count	: 0,
		round	: 0,
		desc	: "Increases your gold each round by the number of units you control.",
		clockEffect	: function(j) {
			var goldBunus = 0;
			for (var i = 0; i < game.totalUnits; i++) {
				var unit = game.units[i];
				goldBunus += (unit.count * j);
			}
			goldBunus -=  game.units[7].count;
			game.player.gold += (goldBunus/10);
			return priceDown(goldBunus,"","G/s");
			}
		},
		{
			name	: "Snargl Omelette",
			shortName	: "Omelette",
			tier	: 1,
			tier1 	: 6000,
			tier2 	: 6000*3,
			tier3	: 6000*9,
			price	: 5038848,
			basePrice	: 18,
			ap		: 0,
			cd		: 15,
			hp		: 4,
			count	: 0,
			round	: 0,
			clock	: 0,
			clockReset	: 600,
			lastUnit	: "",
			desc	: "Spawns a random Unit of lower level every 60 sec",
			clockEffect	: function(j) {
				var unit = game.units[8];
				unit.clock++;

				if (unit.clock >= unit.clockReset) {
					var rng = parseInt(getRNG(0, 7));
					unit.lastUnit = unit.count + "x "+ game.units[rng].name;
					buyUnit(rng, unit.count, true);
					unit.clock = 0;
				}
				
				var time = Number((unit.clockReset - unit.clock) / 10)+1;
				return  unit.lastUnit + " (" + time + "s)";
			}
		},
		{
			name	: "Desert Memorial",
			shortName	: "Memorial",
			tier	: 1,
			tier1 	: 0,
			tier2 	: 0,
			tier3	: 0,
			price	: 0,
			basePrice	: 0,
			ap		: 0,
			cd		: 3,
			hp		: 4,
			count	: 0,
			round	: 0,
			clock	: 0,
			clockReset	: 200,
			lastUnit	: "",
			desc	: "Increase Energy by 1, every 20 sec",
			clockEffect	: function(j) {
				var unit = game.units[9];
				unit.clock++;

				if (unit.clock >= unit.clockReset) {
					game.player.res.energy += unit.count;
					unit.clock = 0;
				}
				
				var time = Number((unit.clockReset - unit.clock) / 10)+1;
				return  "+"+unit.count + " Energy (" + time + "s)";
			}
		},
		{
			name	: "Sand Pack Memorial",
			shortName	: "Memorial",
			tier	: 1,
			tier1 	: 0,
			tier2 	: 0,
			tier3	: 0,
			price	: 0,
			basePrice	: 0,
			ap		: 0,
			cd		: 3,
			hp		: 4,
			count	: 0,
			round	: 0,
			clock	: 0,
			clockReset	: 250,
			lastUnit	: "",
			desc	: "Increase Energy by 5, every 25 sec",
			clockEffect	: function(j) {
				var unit = game.units[10];
				unit.clock++;

				if (unit.clock >= unit.clockReset) {
					game.player.res.energy += unit.count * 5;
					unit.clock = 0;
				}
				
				var time = Number((unit.clockReset - unit.clock) / 10)+1;
				return  "+"+(unit.count*5) + " Energy (" + time + "s)";
			}
		}
],
	spells : [{
		name	: "Gravelock Burrows",
		shortName	: "Burrows",
		tier	: 1,
		tier2 	: 0,
		tier3	: 0,
		price	: 50,
		resource : resources.energy,
		basePrice	: 0,
		desc	: "All Gravelocks get +3 Attack",
		effect	: function() {
			var spell = game.spells[0];
			
			for (var i = 0; i < game.totalUnits; i++) {
				var unit = game.units[i];
				
				if (unit.elderBoost) {
					unit.ap += 3;
				}
			}
			//return void
		}
	
	},
	{
		name	: "Power Trip",
		shortName	: "Power Trip",
		tier	: 1,
		tier2 	: 0,
		tier3	: 0,
		price	: 10,
		resource : resources.energy,
		basePrice	: 0,
		cooldown : 600,
		cooldownReset : 600, 
		desc	: "<span style='color: #ffeb04;'>[Cooldown]</span> Increase Energy by 20",
		effect	: function() {
			var spell = game.spells[1];
			if (spell.cooldown <= 0) {
				game.player.res.energy += 20;
				spell.cooldown = spell.cooldownReset;				
			}
			//return void
		},
		clockEffect : function() {
			var spell = game.spells[1];
			if (spell.cooldown <= 0) {
				return "Ready";
			} else {
				return (Number((spell.cooldown) / 10)+1) + "sec";
			}
		}
	
	},
	{
	name	: "Fodder Pit",
	shortName	: "Fodder Pit",
	tier	: 1,
	tier2 	: 0,
	tier3	: 0,
	price	: 2000,
	resource : resources.energy,
	basePrice	: 0,
	desc	: "Increese Gravelocks attack",
	effect	: function() {
		var spell = game.spells[2];
		
		for (var i = 0; i < game.totalUnits; i++) {
			var unit = game.units[i];
			
			if (unit.elderBoost) {
				unit.ap *= 1.25;
			}
		}
		//return void
	}

}]
}; //end game object

return game;
})();
	init();
	function getRNG(min, max) {
	  return Math.random() * (max - min) + min;
	}
	function init() {
		loadGame();
		game.totalUnits = game.units.length;
		game.totalSpells = game.spells.length;
		for (var i = 0; i < game.totalUnits; i++) {
			if (i == 0) {
				$("#units").append(insertUnit(i, false));
			} else {
				game.units[i].price = game.units[0].price * Math.pow(game.unitPriceMultiplyer,i);
				game.units[i].tier2 = game.units[0].price * Math.pow(game.unitPriceMultiplyer,i) * 3;
				game.units[i].tier3 = game.units[0].price * Math.pow(game.unitPriceMultiplyer,i) * 9;
				game.units[i].basePrice = game.units[0].price * Math.pow(game.unitPriceMultiplyer,i);
				$("#units").append(insertUnit(i, true));
			}
		}
		
		for (var i = 0; i < game.totalSpells; i++) {
			$("#spells").append(insertSpells(i, false));
		}
		
		setInterval(newRound, game.gameTick);
		update();
	
	}
	
	function insertUnit(i, isHidden) {
		var isHidden = isHidden ? 'hidden' : "";
		var unit = game.units[i];
		var desc = unit.desc ? unit.desc : "";
		
		
		var html = '<div class="col-4 '+isHidden+'" id="level-'+i+'">' +
		'<div class="col-12 game-unit">'+
			'<h4>'+unit.name+' <small style="color: #CE0000" class="value-'+i+'"></small></h4>' +
			'<div class="col-6">'+
				'<h1 id="count-'+i+'" style="padding: 50px;">0</h1>'+
			'</div>'+
			'<div class="col-6 align-center game-unit-image-container">'+
				'<img src="/img/gravelock/'+(i+1)+'.png" class="game-unit-game" alt="" />'+
				'<h3><span id="ap-'+(i)+'">'+unit.ap+'</span> - <span id="cd-'+(i)+'">'+unit.cd+'</span> - <span id="hp-'+(i)+'">'+unit.hp+'</span></h3>'+
			'</div>'+
			'<div class="form-element align-center">'+
				'<button id="summon-'+i+'" data-level="'+i+'" class="btn">Summon '+unit.shortName+' <span class="price">('+priceDown(unit.price,"","")+'g)</span></button>'+
				'<div class="col-12">'+
				'<button id="xTimes-5-'+i+'" data-level="'+i+'" data-times="5" class="btn">x5 <span class="price">('+priceDown(intrest(unit.price,5),"","")+'g)</span></button>'+
				
				'<button id="xTimes-25-'+i+'" data-level="'+i+'" data-times="25" class="btn">x25 <span class="price">('+priceDown(intrest(unit.price,25),"","")+'g)</span></button>'+
				
				'<button id="xTimes-100-'+i+'" data-level="'+i+'" data-times="100" class="btn">x100 <span class="price">('+priceDown(intrest(unit.price,100),"","")+'g)</span></button>'+
				'</div>'+
				'<div class="align-center col-12" id="raw-'+i+'"></div>'+
				'<p id="desc-'+i+'"class="align-center col-12">'+desc+'</p>'+
				'<p style="color: #ffeb04;" id="bonus-'+i+'" class="align-center col-12"></p>'+
			'</div>'+
				'</div>'+
		'</div>';
		return html;
	}
	
	function insertSpells(i, isHidden) {
		var isHidden = isHidden ? 'hidden' : '';
		var spell = game.spells[i];
		var desc = spell.desc ? spell.desc : "";
		
		var html = '<div class="col-4 '+isHidden+'" id="spell-level-'+i+'">' +
		'<div class="col-12 game-spell">'+
			'<h4>'+spell.name+'</h4>' +
			'<div class="col-12 align-center">'+
				'<img src="/img/gravelock/s'+(i+1)+'.png" alt="" />'+
			'</div>'+
			'<div class="form-element align-center">'+
			
				'<button id="cast-'+i+'" data-level="'+i+'" class="btn">Cast '+spell.shortName+' <span class="price">('+priceDown(spell.price,""," ")+game.player.resouceName[spell.resource]+')</span></button>'+
				
				'<p id="spell-desc-'+i+'"class="align-center col-12">'+desc+'</p>'+
				'<p style="color: #ffeb04;" id="spell-bonus-'+i+'" class="align-center col-12"></p>'+
			'</div>'+
				'</div>'+
		'</div>';
		return html;
	}
	
	function newRound() {

		var damage = 0;
		var damageSec = 0;
		var gt = game.gameTick / game.gameSpeed;
		for (var i = 0; i < game.totalUnits; i++) {

				damage += ((game.units[i].ap / gt) / (game.units[i].cd / gt)) * game.units[i].count;
				damageSec += (game.units[i].ap / game.units[i].cd) * game.units[i].count;

		}
		
		game.player.gold += (damage / (game.player.idolHealth / gt)) * game.player.idolKillReward;
		game.player.goldSec = Math.round((damageSec / game.player.idolHealth) * game.player.idolKillReward);
		
		for (var i = 0; i < game.totalUnits; i++) {
			var unit = game.units[i];
			if (unit.count > 0) {
				if (unit.clockEffect && typeof unit.clockEffect == "function") {
					$("#bonus-"+i).text("Bonus: " + unit.clockEffect(unit.count));
					if (unit.hasIdle) {
						if (game.idle) {
							$("#desc-"+i).find(".effect").css("color", "#88b837");
						} else {
							$("#desc-"+i).find(".effect").css("color", "#CE0000");
						}
					}
				}
			}
			
		}
		
		game.clock++;
		
		for (var i = 0; i < game.totalSpells; i++) {
			var spell = game.spells[i];
			
			if (spell.cooldown) {
				if (!spell.cooldown <= 0) {
					spell.cooldown--;
				}
			}
			
			if (spell.clockEffect && typeof spell.clockEffect == "function") {
				$("#spell-bonus-"+i).text("Cooldown: " + spell.clockEffect());
			}
			
			
		}
		
		if (game.clock >= game.clockReset) {
			
			game.idle = true;
			game.clock = 0;
			
		}
		
		update();

	}
	setInterval(function() {
		if (game.gameLoaded) {
			save();
		}
	}, 600000)
	function toggleResources(toggle) {
		if (!toggle) {
			$("#game-gold").removeClass("col-4");	
			$("#game-gold").addClass("col-6");
			
			$("#game-dps").removeClass("col-4");	
			$("#game-dps").addClass("col-6");
			
			$("#game-res").hide();	
		} else {
			$("#game-gold").removeClass("col-6");	
			$("#game-gold").addClass("col-4");
			$("#game-dps").removeClass("col-6");	
			$("#game-dps").addClass("col-4");
			
			$("#game-res").show();			
		}
	}
	function update() {
		var gold = Math.round(game.player.gold);
		var goldPerSec = game.player.goldSec;
		$("#gold").text(priceDown(gold, "", " g") + " " + priceDown(goldPerSec,"(", "g/Sec)"));
		var TDPS = 0;
		for (var i = 0; i < game.totalSpells; i++) {
			var spell = game.spells[i];
			ShowAndHideBtn(game.player.res.energy, '#cast-'+i, spell.price, false);
		}
		if (game.player.res.energy > 0) {
			toggleResources(true);
		}
		$("#res-energy").text(priceDown(game.player.res.energy, "", ""));
		var totalUnit = 0;
		for (var i = 0; i < game.totalUnits; i++) {
			var unit = game.units[i];
			$("#count-"+i).text(priceDown(unit.count,"","x"));
			
				var DPS = (unit.ap / unit.cd) * unit.count;
				TDPS += DPS;
				$(".value-"+i).text(priceDown(DPS, "", " DPS"));
				$("#raw-"+i).text(priceDown(unit.ap / unit.cd,"","") + " Raw DPS");
			
			$("#ap-"+i).text(priceDown(unit.ap,"",""));
			$("#cd-"+i).text(priceDown(unit.cd,"",""));
			$("#hp-"+i).text(priceDown(unit.hp,"",""));
			
			
			$("#summon-"+i).find(".price").text(priceDown(Math.round(unit.price), "(", "g)"));
			$("#xTimes-5-"+i).find(".price").text(priceDown(Math.round(intrest(unit.price, 5)), "(", "g)"));
			$("#xTimes-25-"+i).find(".price").text(priceDown(Math.round(intrest(unit.price, 25)), "(", "g)"));
			$("#xTimes-100-"+i).find(".price").text(priceDown(Math.round(intrest(unit.price, 100)), "(", "g)"));
			
		
			ShowAndHideBtn(game.player.gold, '#summon-'+i, unit.price, false);
			ShowAndHideBtn(game.player.gold, '#xTimes-5-'+i, intrest(unit.price, 5), true);
			ShowAndHideBtn(game.player.gold, '#xTimes-25-'+i, intrest(unit.price, 25), true);
			ShowAndHideBtn(game.player.gold, '#xTimes-100-'+i, intrest(unit.price, 100), true);
		
			
			totalUnit += unit.count
			
			if (unit.count > 0) {
				if ($("#level-"+(i+1))) {
					$("#level-"+(i+1)).show();
				}
			}
		}
		if (TDPS > game.ascend) {
			$("#game-shards-gain").text(priceDown(totalUnit / game.ascendShards,"",""));
			$("#game-ascend-box").show();
		} else {
			$("#game-ascend-box").hide();
		}
		if (game.idle) {
			$("#total_dps").html(priceDown(TDPS,""," DPS <span style='color: #88b837'>(Idle)</span>"));
		} else {
			$("#total_dps").html(priceDown(TDPS,""," DPS"));
		}
		
	}
	function ShowAndHideBtn(currency, btn, price, show) {
		if (currency >= price) {
			$(btn).addClass("success");
			$(btn).removeClass("danger");
			if (show) {
				$(btn).show();
			}
		} else {
			$(btn).removeClass("success");
			$(btn).addClass("danger");
			if (show) {
				$(btn).hide();
			}
		}
	}
	function priceDown(input, prefix, sufix) {
		var shortNameMoney = ["","k","m","b","t","Qa","Qi","Sx","Sp","Oc","No","De","Un","Du", "Tr", "Qat", "Qit", "Sxd", "Spd", "Ocd", "Nod", "Vi", "Unvi", "Trvi", "Qavi", "Qivi", "Ss", "damn", "omg", "woho", "a lot"];
		
		for (var i = shortNameMoney.length; i > 0; i--) {
			if (input < Math.pow(10, 1000)) {
				if (input < Math.pow(10, 100)) {
					if (input > Math.pow(10, (i*3) + 1)) {
						return prefix + Math.round( input/Math.pow(10, (i*3) ) *10)/10 + shortNameMoney[i] + sufix;
					}
				} else {
					return prefix + Math.round( input/Math.pow(10, 100 )) + "Googol" + sufix;
				}
			} else {
				return prefix + Math.round( input/Math.pow(10, 1000 )) + "Googolplex" + sufix;
			}
			
		}

		return prefix + Math.round(input) + sufix;
	}
	
	$("#debug").click(function() {
			debugGame();
	});
	
	function debugGame() {
		if (!game.debugMode) {
			game.debugMode = true;
			game.priceMultiplyer = 0;
			for (var i = 0; i < game.totalUnits; i++) {
				game.units[i].price = 0;
				
			}
			
		} else {
			game.debugMode = false;
			game.priceMultiplyer = 1.15;
			for (var i = 0; i < game.totalUnits; i++) {
				game.units[i].price = game.units[i].basePrice;
				
			}
			
		}
		
	}
	
	
	function intrest(p, x) {
		var m = game.priceMultiplyer;
		x = Number(x);
		//m = Multiplyer, 1.15
		//x = Amount bought, 5
		//p = StartPrice, 3
		
		//[STARTINGCOST•1.15^([TOTALAMOUNT+.5]-1)]/(ln(1.15) - [STARTINGCOST•1.15^(0.5-1)]/(ln(1.15)
		var tp = (p * Math.pow(m, (x+.5) -1 )) / Math.log(m) - (p * Math.pow(m, .5 - 1)) / Math.log(m)
		
		return tp;
	}	
	
	function buyUnit(i, x, free) {
		var unit = game.units[i];
		
		if (x > 1) {
			var price = Number(intrest(unit.price, x, "",""));
		} else {
			var price = Number(unit.price);
		}
		
		if (game.player.gold >= price || free) {
			//reset units clock
			for (var i = 0; i < game.totalUnits; i++) {
				var unitEf = game.units[i];
				if (unitEf.clock) {
					unitEf.clock = 0;
				}
			}
			
			unit.count += x;
			
			if (!free) {
				game.player.gold -= price;
				game.idle = false;
				game.clock = 0;
			}
			
			if (x > 1) {
				unit.price = unit.price * Math.pow(game.priceMultiplyer, x);
			} else {
				unit.price *= game.priceMultiplyer;
			}
			
			if (unit.effect && typeof unit.effect == "function") {
				unit.effect(unit.effectValue * x);
			}
			
			$(this).find(".price").text(priceDown(intrest(unit.price, x), "(", "g)"));
			
			update();
		}
	}
	function castSpell(i, free) {
		var spell = game.spells[i];
		
		if (game.player.res.energy >= spell.price || free) {
			
			if (!free) {
				
				game.idle = false;
				game.clock = 0;
				
				if (spell.cooldown) {
					if (spell.cooldown <= 0) {
						game.player.res.energy -= spell.price;
					}
				} else {
					game.player.res.energy -= spell.price;
				}
			}
			
			
			
			if (spell.effect && typeof spell.effect == "function") {
				spell.effect();
			}
			
			update();
		}
	}
	$("[id*=cast-]").click(function() {
		var unit = Number($(this).attr("data-level"));
		castSpell(unit, false);
	});
	$("[id*=summon-]").click(function() {
		var unit = Number($(this).attr("data-level"));
		buyUnit(unit, 1, false);
	});
	$("[id*=xTimes-]").click(function() {
		var unit = Number($(this).attr("data-level"));
		var x = Number($(this).attr("data-times"));
		buyUnit(unit, x, false);
	});
	
	
	$("#save-game").click(function() {
		save();
	});
	$("#reset-game").click(function() {
		reset();
	});
	function reset() {
		$.ajax( {
		  type: "POST",
		  url: "/view/admin/ajax/gravelock_reset.php",
		  }).done(function() {
		  		location.reload();
		  })
		  .fail(function() {
		    console.log("Failed while saving game, with error: "+data);
		     $("#save-notify").text("Failed to save Game");
		  })
		  .always(function(data) {
		   console.log("Request done.");
		});
		
	}
	
	function save() {
		var JSON = {
			player : game.player,
			units : []
		};
		for (var i = 0; i < game.totalUnits; i++) {
			var unit = {
				price 	: game.units[i].price,
				ap		: game.units[i].ap,
				cd		: game.units[i].cd,
				hp		: game.units[i].hp,
				count	: game.units[i].count
			
			}
			JSON.units[i] = unit;
		}
		
		$.ajax( {
		  type: "POST",
		  url: "/view/admin/ajax/gravelock.php",
		  data: {json: JSON}
		  }).done(function(data) {
		  	if (data) {
		  		  $("#save-notify").text("Game Saved");
		  		  $("#save-game").addClass("success");
		  		   $("#save-game").removeClass("danger");
		  		   
		  		   setTimeout(function() {
		  		   	$("#save-game").addClass("danger");
		  		   	$("#save-game").removeClass("success");
		  		   	$("#save-notify").text("");
		  		   }, 3000);
		  		   
		  		   setTimeout(function() {
		  		     	save();
		  		     }, 60000);
		  	} else {
		  		 console.log("Error while saving game: " + data);
		  	}
		  })
		  .fail(function() {
		    console.log("Failed while saving game, with error: "+data);
		     $("#save-notify").text("Failed to save Game");
		  })
		  .always(function(data) {
		   console.log("Request done.");
		});
		
	}
	
	$("[class*=menu-toggle]").click(function() {
		var box = $(this).attr("data-show");
		var hide = $(this).attr("data-hide");
		
		$("[name*='"+hide+"']").hide();
		$("#"+box).show();
		
		
	});
	
	function loadGame() {
		$.ajax( {
		  type: "POST",
		  url: "/view/admin/ajax/gravelock_load.php",
		  data: {json: JSON}
		  }).done(function(data) {
		  	if (data) {
		  		if (data.length > 10) {
			  		 data = jQuery.parseJSON(data);
			  		 game.player.gold = Number(data.player.gold);
			  		 game.player.res.energy = Number(data.player.res.energy);
			  		 game.player.res.growth = Number(data.player.res.growth);
			  		 game.player.res.decay = Number(data.player.res.decay);
			  		 game.player.res.order = Number(data.player.res.order);
			  		  game.player.res.wild = Number(data.player.res.wild);
			  		 for (var i = 0; i < game.totalUnits; i++) {
			  		 	
			  		 	game.units[i].price = Number(data.units[i].price);
			  		 	game.units[i].ap = Number(data.units[i].ap);
			  		 	game.units[i].cd = Number(data.units[i].cd);
			  		 	game.units[i].hp = Number(data.units[i].hp);
			  		 	game.units[i].count = Number(data.units[i].count);
			  		 }
			  		 $("#save-notify").text("Game Loaded");
			  }
		  		 game.gameLoaded = true;
		  		 
		  	} else {
		  		 console.log("Error while saving game: ");
		  	}
		  })
		  .fail(function() {
		    console.log("Failed while saving game, with error: "+data);
		  })
		  .always(function(data) {
		   console.log("Request done.");
		});
	}
	
});

