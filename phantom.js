var StreamingClient = (function () {
	var purevid_id = null;
	var purevid_url = 'http://www.purevid.com/?m=video_info_embed_flv&id=';
	var enstreaming_url = 'http://enstreaming.com/film-';
	var enstreaming_player = 'http://www.enstreaming.com/class/debrideurs/player.swf';
	var init = function(id){
		purevid_id = id;
		purevid_url += id;
	};

	var req = function(server, method, data, callback){
		page = require('webpage').create();

		page.open(server, method, data, function (status) {
			if (status !== 'success') {
				console.log('Unable to get');
				return null;
			}
			callback(page);
		});

	};

	var getEnstreamingPlayerPage = function(code){
		var get_player;
		var data = '';
		enstreaming_url += purevid_id + '.html';
		console.log('get_player url:' + enstreaming_url);
		console.log('get_player data:' + data);
		get_player = req(enstreaming_url, 'post', data, function(page){
			console.log('get_player: ' + page.content);
			page.includeJs("http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js", function() {
				var player = page.evaluate(function() {
					return $('body').html();
				});
				console.log(player);
			});
		});
	};
	//<embed name="flashplayer" src="http://www.enstreaming.com/class/debrideurs/player.swf" flashvars="skin=http://www.enstreaming.com/skin.zip&amp;file=http://str9.purevid.com/get/7e65a8b5f10875c79fb339d6ed19ac56/54459253/raid1/videos/0/13/1358400/1358400.flv?token=1e511eb48d2acf6009bf1bd46c65b78dd5d03991%26uid=2273368%26id=992RTX538yz2PKP9EEQWTz716273%26sas=992RTX538yz2PKP9EEQWTz716273%26sid=9&amp;image=http://ca-static2.purevid.com/screenshots/0/13/992RTX538yz2PKP9EEQWTz716273.jpg&amp;controlbar.position=bottom&amp;dock.position=true&amp;provider=http&amp;http.startparam=start&amp;bufferlength=5&amp;overstretch=true&amp;stretching=exactfit" type="application/x-shockwave-flash" allowfullscreen="true" allowscriptaccess="always" wmode="opaque" width="840" height="520">
	var getEnstreamingPlayer = function(code){
		var get_player;

		console.log('get_player url:' + enstreaming_player);
		get_player = req(enstreaming_player, 'get', null, function(page){
			console.log('get_player: ' + page.content);
		});
	};

	var getPurevidCode = function(){
		var get_code;
		console.log(purevid_url);
		get_code = req(purevid_url, 'get', null, function(page){
			console.log('get_code: ' + page.content);
			page.includeJs("http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js", function() {
				var code = page.evaluate(function() {
					return $('body').html();
				});
				console.log(code);
				code = code.substring(0, code.indexOf('"embed":"') + 9);
				console.warn(code);
				getEnstreamingPlayer(code);
			});
		});
	};

	var exit = function(){
		phantom.exit();
	};

	return {
		init: init,
		get: getPurevidCode
	};
})();

StreamingClient.init('782ILKwu2859793xyxjkqCFD7403');
StreamingClient.get();
