$(window).load(function(){
	$("#loginTitle").delay(1000).animate({ opacity: 1 },1000,"easeOutQuart",function(){
		setTimeout(function(){
			$({ progress:0 }).stop().animate({ progress: 1 },{
				 duration:3000
				,easing:"easeOutQuart"
				,step:function(progress){
					console.log(progress);
					$("#loginBox").css("background-color","rgba(0,0,0," + progress*0.05 + ")");
					$("#loginBox").css("border","1px solid rgba(0,0,0," + progress*0.1 + ")");
					$("#loginContainer").css("opacity",progress);
				}
				,complete:function(){
					
				}
			})		
		}, 500)
	})
});