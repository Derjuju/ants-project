/*
* Variables Globales
*/
// référence à l'historique à lire
var gameNumber;
var historicJson;
var worldHistoryStatus;
var worldHistory = [];



// PHASER ELEMENTS
// référence à Phaser.Game
var game;
var scoreLabelBrown, scoreLabelRed, scoreLabelYellow, scoreLabelBlack;
var scoreTextBrown, scoreTextRed, scoreTextYellow, scoreTextBlack;

var map;
var spriteLayer;

// ETAT DU JEU
var tickWorld = 0;
var nbreSpritesToWait = 0;
var scores = {'brown':0,'red':0,'yellow':0,'black':0};
// référence aux ants générées
var ants = [];

/*
* Chargement du json de la partie à observer
*/
function loadGame()
{
	gameNumber = document.getElementById('gameChoice').value;
	
	var client = new XMLHttpRequest();
	client.onload = handlerGameHistory;
	client.open("GET", 'histories/'+gameNumber+'.json');
	client.send();
}
// gestion de la réponse du chargement
function handlerGameHistory() {
  if(this.status == 200) {
	  processDataGameHistory(this.response);
  } else {
    // something went wrong
	console.log("erreur de chargement du json");
  }  
}
// récupération du JSON chargé et initialisation des données
function processDataGameHistory(data) {
  // taking care of data
  historicJson = JSON.parse(data);
  initialiseNewGame();
}


/*
* Initialisation de Phaser
*/
function initialiseNewGame()
{
	document.getElementById('GameZone').innerHTML = '';
	scores.brown = 0;
	scores.red = 0;
	scores.yellow = 0;
	scores.black = 0;
	game = new Phaser.Game(1000, 672, Phaser.CANVAS, 'GameZone', { preload: preload, create: create, update: update, render: render });
}

function preload () {
	var mapToLoad = historicJson.data.attributes.status.map.name;

	// chargement de la carte
	//game.load.tilemap('map01', 'assets/tilemaps/maps/map01.json', null, Phaser.Tilemap.TILED_JSON);
	game.load.tilemap(mapToLoad, 'assets/tilemaps/maps/'+mapToLoad+'.json', null, Phaser.Tilemap.TILED_JSON);
	// charge les tiles associées
	game.load.image('map-tiles', 'assets/tilemaps/tiles/background-'+mapToLoad+'.png');
	
	// charge les sprites
    game.load.spritesheet('ant', 'assets/sprites/ants-spritesheet.png',32,32,-1,1,1); // key, sourcefile, framesize x, framesize y
}

function create () {
	// récupération des logs
	worldHistory = historicJson.data.attributes.logs;
	worldHistoryStatus = historicJson.data.attributes.status;
	
	// la carte
	map = game.add.tilemap(worldHistoryStatus.map.name);
	map.addTilesetImage('Map01', 'map-tiles');
	layer = map.createLayer('Ground');
	layer.resizeWorld();
	layer.position.set(100, 0);
	layer.fixedToCamera = false;
	
	spriteLayer = game.add.group();
	spriteLayer.position.set(100, 0);
	
	initialiseUI();

	scores.brown++;
	scoreTextBrown.setText(scores.brown);	
	
	// on se débarasse du json
	historicJson = null;
		
	// lance première résolution de l'état du monde
	resolveWorldState();
}
function initialiseUI()
{
	for(var i = 0; i< worldHistoryStatus.opponents.length; i++)
	{
		switch (worldHistoryStatus.opponents[i])
		{
			case "brown" : 
							scoreLabelBrown = game.add.text(0, 0, 'score', { fontSize: '20px', fill: '#996530', boundsAlignH: "center", boundsAlignV: "middle" });
							scoreLabelBrown.setTextBounds(0, 0, 100, 20);
							scoreTextBrown = game.add.text(0, 0, scores.brown, { fontSize: '20px', fill: '#996530', boundsAlignH: "center", boundsAlignV: "middle" });
							scoreTextBrown.setTextBounds(0, 20, 100, 20);
							break;
			case "red" : 
							scoreLabelRed = game.add.text(0, 0, 'score', { fontSize: '20px', fill: '#f00', boundsAlignH: "center", boundsAlignV: "middle" });
							scoreLabelRed.setTextBounds(900, 0, 100, 20);
							scoreTextRed = game.add.text(0, 0, scores.red, { fontSize: '20px', fill: '#f00', boundsAlignH: "center", boundsAlignV: "middle" });
							scoreTextRed.setTextBounds(900, 20, 100, 20);
							break;
			case "yellow" : 
							scoreLabelYellow = game.add.text(0, 0, 'score', { fontSize: '20px', fill: '#FF9900', boundsAlignH: "center", boundsAlignV: "middle" });
							scoreLabelYellow.setTextBounds(900, 332, 100, 20);
							scoreTextYellow = game.add.text(0, 0, scores.yellow, { fontSize: '20px', fill: '#FF9900', boundsAlignH: "center", boundsAlignV: "middle" });
							scoreTextYellow.setTextBounds(900, 352, 100, 20);
							break;
			case "black" : 
							scoreLabelBlack = game.add.text(0, 0, 'score', { fontSize: '20px', fill: '#fff', boundsAlignH: "center", boundsAlignV: "middle" });
							scoreLabelBlack.setTextBounds(0, 332, 100, 20);
							scoreTextBlack = game.add.text(0, 0, scores.black, { fontSize: '20px', fill: '#fff', boundsAlignH: "center", boundsAlignV: "middle" });
							scoreTextBlack.setTextBounds(0, 352, 100, 20);
							break;
		}
	}	
}

function update() {
}

function render () {
}

/*
* Toolbox
*/
// Chargement de contenu par URL
function Get(url){
    var Httpreq = new XMLHttpRequest(); // a new request
    Httpreq.open("GET",url,false);
    Httpreq.send(null);
    return Httpreq.responseText;          
}