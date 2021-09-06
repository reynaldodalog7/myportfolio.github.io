(function() {
   jQuery(document).ready(function(){

if (typeof fb_mess_position === 'undefined') {
  var fb_mess_position = 'center';
}
if (typeof fb_mess_position_space === 'undefined') {
  var fb_mess_position_space = 10;
}
// enable vibration support
navigator.vibrate = navigator.vibrate || navigator.webkitVibrate || navigator.mozVibrate || navigator.msVibrate;

// requestAnimationFrame polyfill
    jQuery("body").click(function(event){
        if ( !jQuery(event.target).hasClass('facebook-messenger-avatar') && jQuery(".drag-wrapper .thing .content:visible").length) {
            jQuery(".drag-wrapper .thing .content").hide(400);
			x = xold;
			y = yold;
         }
    });
    var lastTime = 0;
    var vendors = ['ms', 'moz', 'webkit', 'o'];
    for(var x = 0; x < vendors.length && !window.requestAnimationFrame; ++x) {
        window.requestAnimationFrame = window[vendors[x]+'RequestAnimationFrame'];
        window.cancelAnimationFrame = window[vendors[x]+'CancelAnimationFrame']
                                   || window[vendors[x]+'CancelRequestAnimationFrame'];
    }

    if (!window.requestAnimationFrame)
        window.requestAnimationFrame = function(callback, element) {
            var currTime = new Date().getTime();
            var timeToCall = Math.max(0, 16 - (currTime - lastTime));
            var id = window.setTimeout(function() { callback(currTime + timeToCall); },
              timeToCall);
            lastTime = currTime + timeToCall;
            return id;
        };

    if (!window.cancelAnimationFrame)
        window.cancelAnimationFrame = function(id) {
            clearTimeout(id);
		};

var draggableEl = document.querySelector('[data-drag]'),
    magnet = document.querySelector('.magnet-zone');

// create a SpringSystem and a Spring with a bouncy config.
var springSystem = new rebound.SpringSystem(),
    spring = springSystem.createSpring(100, 7.5),
    magnetSpring = springSystem.createSpring(450, 13),
    x = 10,
    //alert( jQuery( window ).height() );
    y = (fb_mess_position == 'top') ? fb_mess_position_space : ((fb_mess_position == 'bottom') ? (jQuery(window).height() - 60 - fb_mess_position_space) : (jQuery(window).height()/2  + 10) ),
	xold = 0, yold = 0,
    springDestX,
    springDestY,
    magnetX,
    magnetY,
    events = [];

spring.setCurrentValue(1).setAtRest();
magnetSpring.setCurrentValue(1).setAtRest();

function getCenteredCoordinates(el1, el2) {
  var rect1 = el1.getBoundingClientRect(),
      rect2 = el2.getBoundingClientRect(),
      x1 = (rect1.width / 2) + rect1.left,
      y1 = (rect1.height / 2) + rect1.top;

  return {
    x: x1 - (rect2.width / 2),
    y: y1 - (rect2.height / 2)
  };
}

// Add a listener to the spring. Every time the physics
// solver updates the Spring's value onSpringUpdate will
// be called.
function onSpringUpdate(spring) {
  // drop the spring when the user has let go
  // otherwise update x/y with springy values
  if (!jQuery(draggableEl).hasClass('edge')) {
    var val = spring.getCurrentValue(),
        coords = getCenteredCoordinates(magnet, draggableEl),
        elRect = draggableEl.getBoundingClientRect();

    x = rebound.MathUtil.mapValueInRange(val, 0, 1, coords.x, springDestX || elRect.left);
    y = rebound.MathUtil.mapValueInRange(val, 0, 1, coords.y, springDestY || elRect.top);
    moveToPos(x, y);
  }
}

spring.addListener({ onSpringUpdate: onSpringUpdate });
magnetSpring.addListener({ onSpringUpdate: onSpringUpdate });

function vibrate(ms) {
    if (navigator.vibrate) {
        // vibration API supported
        navigator.vibrate(ms || 50);
    }
}

// the draw function
function moveToPos(newX, newY) {
  var el = draggableEl;

  newX = newX || x;
  newY = newY || y;

  // finally apply the x, y to the top, left of the circle
  el.style.transform =
  el.style.webkitTransform =
  el.style.MozTransform = 'translate(' + Math.round(newX, 10) + 'px, ' + Math.round(newY, 10) + 'px)';
}

function animate() {
  window.requestAnimationFrame( animate );
  moveToPos();
}

// kick off animate
animate();

function isOverlapping(el1, el2) {
  var rect1 = el1.getBoundingClientRect(),
    rect2 = el2.getBoundingClientRect();

  return !(
      rect1.top > rect2.bottom ||
      rect1.right < rect2.left ||
      rect1.bottom < rect2.top ||
      rect1.left > rect2.right
  );
}

function moveMagnet(x, y) {
  var dist = 12,
      width = jQuery('body').width() / 2,
      height = jQuery('body').height(),
      direction = x > width ? 1 : -1,
      percX = x > width ? (x - width) / width : -(width - x) / width,
      percY = Math.min(1, (height - y) / (height / 2));

  magnet.style.marginLeft = Math.round(dist * percX) + 'px';
  magnet.style.marginBottom = Math.round(dist * percY) + 'px';
}

function trackEvent(event) {

  if (events.length > 5) {
    events.pop();
  }

  events.push(event);

}

function move(event) {
	var selector = jQuery(event.target), check = true;
	if (jQuery(".drag-wrapper .thing").hasClass("showContent")){
		if (selector.hasClass("circle") || selector.parents(".circle").length){
			jQuery(".drag-wrapper .thing").removeClass("showContent");
			jQuery(".drag-wrapper .thing .content").hide(400);
			x = xold;
			y = yold;
		}else{
			check = false;
		}
	}

	if (check){
  var el = draggableEl,
      magnetRect = magnet.getBoundingClientRect(),
      elRect = el.getBoundingClientRect();

  newX = this._posOrigin.x + event.pageX - this._touchOrigin.x;
  newY = this._posOrigin.y + event.pageY - this._touchOrigin.y;

  moveMagnet(newX + (elRect.width / 2), newY + (elRect.height / 2));

  startMoving();

  var touchPos = {
    top: newY,
    right: newX + elRect.width,
    bottom: newY + elRect.height,
    left: newX
  };

  overlapping = !(
    touchPos.top > magnetRect.bottom ||
    touchPos.right < magnetRect.left ||
    touchPos.bottom < magnetRect.top ||
    touchPos.left > magnetRect.right
  );

  springDestX = newX;
  springDestY = newY;

  if (overlapping) {
    // center the circle in the magnetic zone
    var mx = (magnetRect.width / 2) + magnetRect.left;
    var my = (magnetRect.height / 2) + magnetRect.top;
    newX = mx - (elRect.width / 2);
    newY = my - (elRect.height / 2);

    if (!jQuery(el).hasClass('overlap')) {
      // set magnetSpring
      magnetSpring.setVelocity(5).setEndValue(0);
      spring.setCurrentValue(0).setAtRest();

      vibrate(25);
    }

    jQuery(magnet).toggleClass('overlap', true);
    jQuery(el).toggleClass('overlap', true);

    // if the spring is still moving then dont set x/y
    if (!springSystem.getIsIdle()) return;
  } else {

    if (jQuery(el).hasClass('overlap')) {
      spring.setEndValue(1);
      magnetSpring.setCurrentValue(1).setAtRest();
    }

    jQuery(magnet).removeClass('overlap');
    jQuery(el).removeClass('overlap');
  }

  // update x/y values
  x = newX;
  y = newY;
	}
};

jQuery(draggableEl)
	.on('movestart', onTouchStart)
	.on('move', trackEvent)
	.on('move', move)
	.on('moveend', onTouchEnd)
	.on('click', onClick);

function onTouchStart(event) {
	var selector = jQuery(event.target), check = true;
	if (jQuery(".drag-wrapper .thing").hasClass("showContent")){
		if (selector.hasClass("circle") || selector.parents(".circle").length){
			jQuery(".drag-wrapper .thing").removeClass("showContent");
			jQuery(".drag-wrapper .thing .content").hide(400);
			x = xold;
			y = yold;
		}else{
			check = false;
		}
	}
	if (check){
		var rect = this.getBoundingClientRect();
		startTouching();

		this._touchOrigin = {
			x: event.pageX,
			y: event.pageY
		};
		this._posOrigin = {
			x: rect.left,
			y: rect.top
		};
	}
}

function onClick(event){
	var selector = jQuery(event.target);
	if (selector.hasClass("content") || selector.parents(".content").length){

	}else{
		var window_width = jQuery(window).width();
		if (jQuery(".drag-wrapper .thing .content:visible").length){
			x = xold;
			y = yold;
		}else{
			xold = x;
			yold = y;
			x = 24;
			y = 20;
		}
		jQuery(".drag-wrapper .thing .content").toggle(400);
		jQuery(this).toggleClass("showContent");
		jQuery(".drag-wrapper .thing .content").css({
			"max-height" : jQuery(window).height() - 116
		});
	}
}

function getVelocity() {
	if (jQuery(".drag-wrapper .thing").hasClass("showContent")){
		return false
	}else{
  var event = events[events.length - 1];
  return {
    x: event.velocityX,
    y: event.velocityY
  };

  }
}

function stopTouching() {
  jQuery('body').removeClass('touching');
}

function startTouching() {
  jQuery('body').addClass('touching');
}

function startMoving() {
  jQuery('body').addClass('moving');
}

function stopMoving() {
  jQuery('body').removeClass('moving');
  magnet.style.marginBottom = magnet.style.marginLeft = '0px';
}

function onTouchEnd(event) {
	if (jQuery(".drag-wrapper .thing").hasClass("showContent")){

	}else{
		var el = jQuery(draggableEl),
			velocity = getVelocity();

		if (!el.hasClass('overlap')) {
			flingWithVelocity(velocity);
			stopTouching();
			stopMoving();
		}else{
			stopTouching();
			stopMoving();
			jQuery(".drag-wrapper").remove();
		}
	}
}

function distanceOverTime(velocity, ms) {
  return velocity * ms;
}

function decelerate(speed) {
  return speed > 0.01 || speed < -0.01  ? (speed - (speed * .05)) : 0;
}

// simulate gravitational pull
function addGravity(deltaTimeInMs) {
  var gravity = -9.5 / 2000;
  return gravity * deltaTimeInMs;
}

var timer;

function flingWithVelocity(velocity) {
	var center_width = jQuery(window).width() / 2;
	if (x < center_width){
		x = 5;
	}else{
		x = center_width * 2 - 60;
	}

	if (y < 0){
		y = 20;
	}
}


})

}());