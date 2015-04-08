$(function() {
	
var game = {
	gameTick	: 100,
	gameSpeed	: 1000,
	priceMultiplyer : 1.15,
	totalUnits : 0,
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
		ap		: 3,
		cd		: 2,
		hp		: 6,
		count	: 0,
		round	: 0
	},
	{
		name	: "Gravelock Elder",
		shortName	: "Elder",
		tier1 	: 6000,
		tier2 	: 6000*3,
		tier3	: 6000*9,
		price	: 23328,
		ap		: 3,
		cd		: 2,
		hp		: 5,
		count	: 0,
		round	: 0,
		desc	: "Gives +1/0/1 to all gravelocks",
		effect	: function(j) {
			for (var i = 0; i < game.totalUnits; i++) {
				var unit = game.units[i];
				
				if (unit.elderBoost) {
					unit.ap += j;
					unit.hp += j;
				}
			}
		}
	},
	{
		name	: "Uhu Longnose",
		shortName	: "Uhu",
		elderBoost	: true,
		tier1 	: 6000,
		tier2 	: 6000*3,
		tier3	: 6000*9,
		price	: 139968,
		ap		: 2,
		cd		: 2,
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
		ap		: 4,
		cd		: 2,
		hp		: 5,
		count	: 0,
		round	: 0
	}]	
}; //end game object

	init();
	function init() {
		game.totalUnits = game.units.length;
		for (var i = 0; i < game.totalUnits; i++) {
			if (i == 0) {
				$("#units").append(insertUnit(i, false));
			} else {
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
			'<h4>'+unit.name+' <small class="value-'+i+'"></small></h4>' +
			'<p>'+desc+'</p>'+
			'<div class="col-6">'+
				'<h1 id="count-'+i+'" style="padding: 50px;">0</h1>'+
			'</div>'+
			'<div class="col-6 align-center">'+
				'<img src="/img/gravelock/'+(i+1)+'.png" height="100px" alt="" />'+
				'<h3><span id="ap-'+(i)+'">'+unit.ap+'</span> - <span id="cd-'+(i)+'">'+unit.cd+'</span> - <span id="hp-'+(i)+'">'+unit.hp+'</span></h3>'+
			'</div>'+
			'<div class="form-element align-center">'+
			
				'<button id="summon-'+i+'" data-level="'+i+'" class="btn">Summon '+unit.shortName+' <span class="price">('+priceDown(unit.price,"","")+'g)</span></button>'+
				'<div class="col-12">'+
				'<button id="xTimes-5-'+i+'" data-level="'+i+'" data-times="5" class="btn">x5 <span class="price">('+priceDown(intrest(unit.price,5),"","")+'g)</span></button>'+
				
				'<button id="xTimes-25-'+i+'" data-level="'+i+'" data-times="25" class="btn">x25 <span class="price">('+priceDown(intrest(unit.price,25),"","")+'g)</span></button>'+
				
				'<button id="xTimes-100-'+i+'" data-level="'+i+'" data-times="100" class="btn">x100 <span class="price">('+priceDown(intrest(unit.price,100),"","")+'g)</span></button>'+
				'</div>'+
				'<div class="align-center col-12" id="raw-'+i+'">Raw DPS</div>'+
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
		
		update();

	}
	function update() {
		var gold = Math.round(game.player.gold);
		var goldPerSec = game.player.goldSec;
		$("#gold").text(priceDown(gold, "", "g") + " " + priceDown(goldPerSec,"(", "g/s)"));
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
			
			if (game.player.gold >= intrest(unit.price, 5)) {
				$("#xTimes-5-"+i).show();
			} else {
				$("#xTimes-5-"+i).hide();
			}
			
			if (game.player.gold >= intrest(unit.price, 25)) {
				$("#xTimes-25-"+i).show();
			} else {
				$("#xTimes-25-"+i).hide();
			}
			if (game.player.gold >= intrest(unit.price, 100)) {
				$("#xTimes-100-"+i).show();
			} else {
				$("#xTimes-100-"+i).hide();
			}
			
			
			if (game.player.gold >= unit.price) {
				$('#summon-'+i).addClass("success");
				$('#summon-'+i).removeClass("danger");
			} else {
				$('#summon-'+i).removeClass("success");
				$('#summon-'+i).addClass("danger");
			}
			
			if (game.player.gold >= intrest(unit.price, 5)) {
				$('#xTimes-5-'+i).addClass("success");
				$('#xTimes-5-'+i).removeClass("danger");
			} else {
				$('#xTimes-5-'+i).removeClass("success");
				$('#xTimes-5-'+i).addClass("danger");
			}
			if (game.player.gold >= intrest(unit.price, 25)) {
				$('#xTimes-25-'+i).addClass("success");
				$('#xTimes-25-'+i).removeClass("danger");
			} else {
				$('#xTimes-25-'+i).removeClass("success");
				$('#xTimes-25-'+i).addClass("danger");
			}
			if (game.player.gold >= intrest(unit.price, 100)) {
				$('#xTimes-100-'+i).addClass("success");
				$('#xTimes-100-'+i).removeClass("danger");
			} else {
				$('#xTimes-100-'+i).removeClass("success");
				$('#xTimes-100-'+i).addClass("danger");
			}
			
			if (unit.count > 0) {
				if ($("#level-"+(i+1))) {
					$("#level-"+(i+1)).show();
				}
			}
		}
		
		$("#total_dps").text(priceDown(TDPS,""," DPS"));
	}
	
	function priceDown(i, prefix, sufix) {
		if (i > Math.pow(10, 43)) {
			return prefix + Math.round((i/Math.pow(10, 42))) + "Tr "+sufix;
		}
		if (i > Math.pow(10, 40)) {
			return prefix + Math.round((i/Math.pow(10, 39))) + "Du "+sufix;
		}
		if (i > Math.pow(10, 37)) {
			return prefix + Math.round((i/Math.pow(10, 36))) + "Un "+sufix;
		}
		if (i > Math.pow(10, 34)) {
			return prefix + Math.round((i/Math.pow(10, 33))) + "De "+sufix;
		}
		if (i > Math.pow(10, 31)) {
			return prefix + Math.round((i/Math.pow(10, 30))) + "No "+sufix;
		}
		if (i > Math.pow(10, 28)) {
			return prefix + Math.round((i/Math.pow(10, 27))) + "Oc "+sufix;
		}
		if (i > Math.pow(10, 25)) {
			return prefix + Math.round((i/Math.pow(10, 24))) + "Sp "+sufix;
		}
		if (i > Math.pow(10, 22)) {
			return prefix + Math.round((i/Math.pow(10, 21))) + "Sx "+sufix;
		}
		if (i > Math.pow(10, 19)) {
			return prefix + Math.round((i/Math.pow(10, 18))) + "Qi "+sufix;
		}
		if (i > Math.pow(10, 16)) {
			return prefix + Math.round((i/Math.pow(10, 15))) + "Qa "+sufix;
		}
		if (i > Math.pow(10, 13)) {
			return prefix + Math.round((i/Math.pow(10, 12))) + "t "+sufix;
		}
		if (i > Math.pow(10, 10)) {
			return prefix + Math.round((i/Math.pow(10, 9))) + "b "+sufix;
		}
		if (i > Math.pow(10, 7)) {
			return prefix + Math.round((i/Math.pow(10, 6))) + "m "+sufix;
		}
		if (i > Math.pow(10, 4)) {
			return prefix + Math.round((i/Math.pow(10, 3))) + "k "+sufix;
		} else {
			return prefix + i + sufix;
		}
	}
	
	$("#debug").click(function() {
			debugGame();
	});
	function debugGame() {
		game.priceMultiplyer = 0;
		for (var i = 0; i < game.totalUnits; i++) {
			game.units[i].price = 0;
			
		}
	}
	
	$("[id*=summon-]").click(function() {
		var unit = game.units[$(this).attr("data-level")];
		if (game.player.gold >= unit.price) {
			unit.count++;
			game.player.gold -= unit.price;
			unit.price *= game.priceMultiplyer;
			
			if (unit.effect && typeof unit.effect == "function") {
				unit.effect(1);
			}
			
			$(this).find(".price").text(priceDown(Math.round(unit.price), "(", "g)"));
			update();
		}
	});
	function intrest(p, x) {
		//return Math.round(p * Math.pow(x, (game.priceMultiplyer)));
		//console.log(p + ", " + Math.pow(game.priceMultiplyer, x) + ", " + x);
		lastp = p;
		for (var i = 0; i < x; i++) {
			p += lastp*game.priceMultiplyer
			lastP = p;
		}
		return Math.round(p);
		//p(m^x)
	}
	
	$("[id*=xTimes-]").click(function() {
		console.log(1);
		var unit = game.units[$(this).attr("data-level")];
		var x = $(this).attr("data-times");
		var price = intrest(unit.price, x, "","");
		console.log(price +"," + unit.price);
		if (game.player.gold >= price) {
			console.log(x);
			unit.count += parseInt(x);
			game.player.gold -= price;
			unit.price *= Math.pow(game.priceMultiplyer, x);
			console.log(3);
			
			if (unit.effect && typeof unit.effect == "function") {
				unit.effect(x);
			}
			
			$(this).find(".price").text(priceDown(intrest(unit.price, x,"",""), "(", "g)"));
			update();
		}
	});
});

