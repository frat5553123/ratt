//configuration
var responsive = true;

var usePreloader = true; //use preloader or not

var animateBall = true; //animate the ball or not
var ballAnimationTime = 500; //ball animation speed
var ballAnimationHeight = 180; //ball decrease in altitude
var ballInertia = false; //enable inertia or not

var animateBubble = true; //enable sleep bubble animation or not
var bubbleAnimationTime = 800; //sleep bubble animation speed

var animateNose = true; //enable nose animation or not
var noseAnimationTime = 400; //nose animation speed

//prepare variables - better not touch those
var degree = 0;
var inertia = 0;
var ballAnimationInterval;
var $bubbleWidth;
var $bubbleHeight;
var $noseWidth;
var $noseHeight;

$(document).ready(function(){

	//Tipsy implementation
	$('.with-tooltip').tipsy({gravity: $.fn.tipsy.autoNS});

	if(!usePreloader)
		startAnimation();
		
	if(!responsive)
		$("#responsive").remove();

});

$(window).load(function(){

	if(usePreloader)	
		$("#universal-preloader").stop().delay(1000).animate({ "opacity" : "0"}, {duration:600, easing: 'easeInOutQuad', complete:function(){
		
			$bubble = $("#bubble > img");
			$nose = $("#nose > img");
		
			$bubbleWidth = $bubble.width();
			$bubbleHeight = $bubble.height();
	
			$noseWidth = $nose.width();
			$noseHeight = $nose.height();
		
			startAnimation();
			
		}});

});

$(window).resize(function(){

	$("#bubble > img").removeAttr("style").stop();
	$("#nose > img").removeAttr("style").stop();

	$bubbleWidth = $bubble.width();
	$bubbleHeight = $bubble.height();
	
	$noseWidth = $nose.width();
	$noseHeight = $nose.height();
	
});

//function that starts the animations
function startAnimation(){

	if(animateBall){
	
		upAndDown();
		ballAnimationInterval = setInterval(function(){upAndDown();}, ballAnimationTime*2.6);
		
	}
	
	if(animateBubble){
	
		bubble();
		setInterval(function(){bubble();}, bubbleAnimationTime*2.2);
		
	}
	
	if(animateNose){
	
		nose();
		setInterval(function(){nose();}, (Math.floor(Math.random() * 10) + 6) * 1000);
		
	}

	$("#universal-preloader").remove();

}

//function that handles the ball animation
function upAndDown(){

	$ball = $("#ball");
	
	if(inertia < ballAnimationHeight){
	
		if(ballInertia)
			inertia += 20;
		
		if(ballAnimationHeight - inertia >= 30){
		
			$ball.stop().animate({"bottom" : ballAnimationHeight - inertia +"px"}, {duration:ballAnimationTime, easing: 'easeOutCirc'});
			setTimeout(function(){$ball.stop().animate({"bottom" : "30px"}, {duration:ballAnimationTime*1.5, easing: 'easeInCirc'});}, ballAnimationTime);
			
		}
		
	}

}

//function that handles the sleeping bubble animation
function bubble(){

	$bubble = $("#bubble > img");
	
	$bubble.stop().animate({"width" : $bubbleWidth + ($bubbleWidth / 10) + "px", "height" : $bubbleHeight + ($bubbleHeight / 10) + "px", "margin-left":"-3px"}, {duration:bubbleAnimationTime, easing: 'easeInQuad'});
	setTimeout(function(){$bubble.stop().animate({"width" : $bubbleWidth + "px", "height" : $bubbleHeight + "px", "margin-left":"0px"}, {duration:bubbleAnimationTime, easing: 'easeOutQuad'});}, bubbleAnimationTime);

}

//function that handles the sleeping bubble animation
function nose(){

	$nose = $("#nose > img");
	
	$nose.stop().animate({"width" : $noseWidth + ($noseWidth / 5) + "px", "height" : $noseHeight + ($noseHeight / 5) + "px"}, {duration:noseAnimationTime, easing: 'easeInQuad'});
	setTimeout(function(){$nose.stop().animate({"width" : $noseWidth + "px", "height" : $noseHeight + "px"}, {duration:noseAnimationTime, easing: 'easeOutQuad'});}, noseAnimationTime);

}