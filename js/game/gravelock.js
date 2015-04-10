$(function() {
	
var game = {
	gameTick	: 100,
	gameSpeed	: 1000,
	priceMultiplyer : 1.15,
	unitPriceMultiplyer : 6,
	totalUnits : 0,
	debugMode : false,
	idle 	: false,
	clock	: 0,
	clockReset : 100,
	player	: {
		level	: 0,
		gold	: 3,
		idol	: 0,
		goldSec	: 0,
		idolHealth	: 10,
		idolKillReward : 20
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
			var unit = game.units[4];
			var damage = unit.hp / unit.cd;
			var gt = game.gameTick / game.gameSpeed;
			var bonusGold = (damage / (game.player.idolHealth / gt)) * game.player.idolKillReward;
			game.player.gold += bonusGold;
			return priceDown(damage, "", "DPS") + ", " + priceDown(bonusGold, "", "G/s");
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
					unit.ap += parseInt(j);
					unit.hp += parseInt(j);
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
			goldBunus -=  game.units[6].count;
			game.player.gold += (goldBunus/10);
			return priceDown(goldBunus,"","G/s");
			}
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
			var unit = game.units[7];
			
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
			clockReset	: 150,
			lastUnit	: "",
			desc	: "Spawns a random Unit every 15 sec",
			clockEffect	: function(j) {
				var unit = game.units[8];
				unit.clock++;

				if (unit.clock >= unit.clockReset) {
					var rng = parseInt(getRNG(0, 7));
					unit.lastUnit = unit.count + "x "+ game.units[rng].name;
					buyUnit(rng, unit.count, true);
					unit.clock = 0;
				}
				
				var time = parseInt((unit.clockReset - unit.clock) / 10);
				return  unit.lastUnit + " (" + time + "s)";
			}
		}
]
}; //end game object

	init();
	function getRNG(min, max) {
	  return Math.random() * (max - min) + min;
	}
	function init() {
		game.totalUnits = game.units.length;
		for (var i = 0; i < game.totalUnits; i++) {
			if (i == 0) {
				$("#units").append(insertUnit(i, false));
			} else {
				game.units[i].price = game.units[0].price * Math.pow(game.unitPriceMultiplyer,i);
				game.units[i].basePrice = game.units[0].price * Math.pow(game.unitPriceMultiplyer,i);
				$("#units").append(insertUnit(i, true));
			}
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
		
		if (game.clock >= game.clockReset) {
			
			game.idle = true;
			game.clock = 0;
		}
		
		update();

	}
	function update() {
		var gold = Math.round(game.player.gold);
		var goldPerSec = game.player.goldSec;
		$("#gold").text(priceDown(gold, "", " g") + " " + priceDown(goldPerSec,"(", "g/Sec)"));
		var TDPS = 0;
		
		for (var i = 0; i < game.totalUnits; i++) {
			var unit = game.units[i];
			$("#count-"+i).text(priceDown(unit.count,"","x"));
			
			
			

				var DPS = (unit.ap / unit.cd) * unit.count;
				TDPS += DPS;
				$(".value-"+i).text(priceDown(DPS, "", " DPS"));
				$("#raw-"+i).text((unit.ap / unit.cd) + " Raw DPS");

			
			
			
			$("#ap-"+i).text(unit.ap);
			$("#cd-"+i).text(unit.cd);
			$("#hp-"+i).text(unit.hp);
			
			
			$("#summon-"+i).find(".price").text(priceDown(Math.round(unit.price), "(", "g)"));
			$("#xTimes-5-"+i).find(".price").text(priceDown(Math.round(intrest(unit.price, 5)), "(", "g)"));
			$("#xTimes-25-"+i).find(".price").text(priceDown(Math.round(intrest(unit.price, 25)), "(", "g)"));
			$("#xTimes-100-"+i).find(".price").text(priceDown(Math.round(intrest(unit.price, 100)), "(", "g)"));
			
		
			ShowAndHideBtn('#summon-'+i, unit.price, false);
			ShowAndHideBtn('#xTimes-5-'+i, intrest(unit.price, 5), true);
			ShowAndHideBtn('#xTimes-25-'+i, intrest(unit.price, 25), true);
			ShowAndHideBtn('#xTimes-100-'+i, intrest(unit.price, 100), true);
			
			if (unit.count > 0) {
				if ($("#level-"+(i+1))) {
					$("#level-"+(i+1)).show();
				}
			}
		}
		if (game.idle) {
			$("#total_dps").html(priceDown(TDPS,""," DPS <span style='color: #88b837'>(Idle)</span>"));
		} else {
			$("#total_dps").html(priceDown(TDPS,""," DPS"));
		}
		
	}
	function ShowAndHideBtn(btn, price, show) {
		if (game.player.gold >= price) {
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
		var shortNameMoney = ["","k","m","b","t","Qa","Qi","Sx","Sp","Oc","No","De","Un","Du"];
		
		for (var i = shortNameMoney.length; i > 0; i--) {
			if (input > Math.pow(10, (i*3) + 1)) {
				return prefix + Math.round( input/Math.pow(10, (i*3) ) ) + shortNameMoney[i] + sufix;
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
		x = parseInt(x);
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
			var price = parseInt(intrest(unit.price, x, "",""));
		} else {
			var price = parseInt(unit.price);
		}
		
		if (game.player.gold >= price || free) {
			game.idle = false;
			game.clock = 0;
			
			
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
	$("[id*=summon-]").click(function() {
		var unit = parseInt($(this).attr("data-level"));
		buyUnit(unit, 1, false);
	});
	$("[id*=xTimes-]").click(function() {
		var unit = parseInt($(this).attr("data-level"));
		var x = parseInt($(this).attr("data-times"));
		buyUnit(unit, x, false);
	});
});
