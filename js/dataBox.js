App.DataBox = function(){
	//
	// On file input change (when user selects file)
	//
	$("#fileInputContainer").on("change","input",function(){
		//
		// Upload file
		//
		$("#fileInputContainer input").upload("/upload",{},function(data){
			console.log(data);
		});
	});
	
	//
	// When user clicks uploadCSV button, trigger click on file input
	// This is done so the ugly and unstyleable file input can be hidden
	//
	$("#uploadCSV").click(function(){
		$("#fileInputContainer input").click();
	})
	
	this.showChart = function(animate){
		if(animate){
			$("#pageContainer").animate({ width:"70%", height:"100%", "border-radius":0 },900,"easeOutQuart");
			setTimeout(function(){
				$("#uploadBox").show();
				$("#uploadBox").animate({ opacity:1 }, 300, "easeOutQuart");	
				$("#logoutContainer").show();
				$("#logoutContainer").animate({ opacity:1 }, 300, "easeOutQuart");
			}, 600)
		}else{
			$("#pageContainer").css("background-color","rgba(0,0,0," + 0.15 + ")");
			$("#pageContainer").css("border","1px solid rgba(0,0,0," + 0.1 + ")");
			$("#pageContainer").css({ width:"70%", height:"100%", "border-radius":0 });
			$("#uploadBox").css("opacity",1).show();
			$("#logoutContainer").css("opacity",1).show();
			$("#title").css("opacity",1).show();
		}
	}
}