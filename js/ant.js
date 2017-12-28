//  Custom game object : ant
Ant = function (game, x, y, options) {
	
	options = options || {};
	
	// définition de la fourmi
	this.id = (options.id)?options.id:0;
	this.family = (options.family)?options.family:null;
	this.type = (options.type)?options.type:"normal";
	this.life = (options.life)?options.life:10;
	this.action = null;
	this.needResolveAction = false;
	

    Phaser.Sprite.call(this, game, x, y, 'ant');
	// ancre le sprite en son centre
    this.anchor.setTo(0.5, 0.5);
	
	// ajoute les animations
	if (this.family != null) {
		if (this.family == "brown") {
			this.animations.add('walkVertical', [0,1,2], 10, true);  // (key, framesarray, fps,repeat)
			this.animations.add('walkHorizontal', [8,9,10], 10, true);  // (key, framesarray, fps,repeat)
		}
		else if (this.family == "red") {
			this.animations.add('walkVertical', [3,4,5], 10, true);  // (key, framesarray, fps,repeat)
			this.animations.add('walkHorizontal', [11,12,13], 10, true);  // (key, framesarray, fps,repeat)
		}
		else if (this.family == "yellow") {
			this.animations.add('walkVertical', [32,33,34], 10, true);  // (key, framesarray, fps,repeat)
			this.animations.add('walkHorizontal', [40,41,42], 10, true);  // (key, framesarray, fps,repeat)
		}
		else if (this.family == "black") {
			this.animations.add('walkVertical', [35,36,37], 10, true);  // (key, framesarray, fps,repeat)
			this.animations.add('walkHorizontal', [43,44,45], 10, true);  // (key, framesarray, fps,repeat)
		}
	}
	
	this.destination = {x,y};
	this.destination.x = x;
	this.destination.y = y;
	
	// définition de la orientation
	this.orientation = (options.orientation)?options.orientation:"top";
	this.previousOrientation = this.orientation;
	// définition de la vitesse de déplacement
	this.speed = (options.speed)?options.speed:1;	
	
	this.animations.play('walkVertical');
	this.animations.stop();
	
	// fin de tour : on vient d'apparaitre
	this.annonceFinDeTour();
};

Ant.prototype = Object.create(Phaser.Sprite.prototype);
Ant.prototype.constructor = Ant;

/**
 * Automatically called by World.update
 */
Ant.prototype.update = function() {
	if (this.previousOrientation != this.orientation) {	
		// on stocke l'orientation pour ne pas rentrer dans l'animation
		this.previousOrientation = this.orientation;
		this.makeMove();		
	}
	if (this.needResolveAction) {
		this.needResolveAction = false;
		this.resolveAction();
	}
};


Ant.prototype.updateState = function(stateParams) {
	this.life = stateParams.life;
	if (stateParams.action != null) {
		this.action = stateParams.action;
	}
	if (stateParams.move != null) {
		var newDestination = resolveXYFromGridCell(stateParams.move[0],stateParams.move[1]);
		this.setDestination(newDestination.x, newDestination.y);
	} else if (this.action != null) {
		this.needResolveAction = true;
	}
}

Ant.prototype.setDestination = function(x,y) {	
	this.destination.x = x;
	this.destination.y = y;
		
	if (this.x < this.destination.x) { 
		this.orientation = "right";
		this.previousOrientation = null;
	}
	else if (this.x > this.destination.x) { 
		this.orientation = "left";
		this.previousOrientation = null;
	}
	else if (this.y < this.destination.y) { 
		this.orientation = "bottom";
		this.previousOrientation = null;
	}
	else if (this.y > this.destination.y) { 
		this.orientation = "top";
		this.previousOrientation = null;
	}
}

// gestion du mouvement
Ant.prototype.makeMove = function() {	
	console.log("makeMove : ant n°"+this.id);
	
	var newPositionX = this.x;
	var newPositionY = this.y;
	
	if (this.orientation == "top") {
		this.animations.play('walkVertical');
		this.scale.y = -1;
		newPositionY = this.y - (32 * this.speed);
	}
	else if (this.orientation == "bottom") {
		this.animations.play('walkVertical');
		this.scale.y = 1;
		newPositionY = this.y + (32 * this.speed);
	}
	else if (this.orientation == "right") {
		this.animations.play('walkHorizontal');
		this.scale.x = -1;
		newPositionX = this.x + (32 * this.speed);
	}
	else if (this.orientation == "left") {
		this.animations.play('walkHorizontal');
		this.scale.x = 1;
		newPositionX = this.x - (32 * this.speed);		
	}
	var tweenObject = game.add.tween(this).to({
			x: newPositionX,
			y: newPositionY
		}, 500, Phaser.Easing.Linear.None, true, 0, 0, false);
	tweenObject.onComplete.add(this.makeMoveOnComplete, this);
}
// gestion fin de mouvement
Ant.prototype.makeMoveOnComplete = function() {	
	// loop sur animation d'attente ou stop animation actuelle
	this.animations.stop();
	if (this.action != null) {
		this.needResolveAction = true;
	} else {
		// fin des mouvements et pas d'actions à traiter
		this.annonceFinDeTour();
	}
}


Ant.prototype.resolveAction = function() {	
	console.log("resolveAction : ant n°"+this.id);
	if (this.action != null) {
		if (this.action.type == "death") {
			this.kill();
		}			
	}
	// fin des actions
	this.annonceFinDeTour();
}

Ant.prototype.annonceFinDeTour = function() {
	console.log("annonceFinDeTour : ant n°"+this.id);
	var mySignal = new Phaser.Signal();
	mySignal.add(spriteTourHasEnded, this);
	mySignal.dispatch();
}