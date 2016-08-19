$(function(){

	var go = {
		popupsPrepare : function(arg){
			if (arg=="blanker") {
				$("#blanker").fadeIn();
			}else if(arg=="show"){
				$(".pop-ups").css({"transform":"translateY(10%)","transition":"1s"});
			}else{
				$("#blanker").fadeOut();
				$(".pop-ups").css({"transform":"translateY(-200%)","transition":"1s"});
			}
		},

		show : function(a){
			$(a).fadeIn();
			go.popupsPrepare("blanker");
			go.popupsPrepare("show");
		},

		hide : function(){
			$(".loginPage").fadeOut();
			$(".registerPage").fadeOut();
			go.popupsPrepare();
		}

	}

	

	$("#blanker").on("click",function(e){
		go.popupsPrepare("hide");
		go.hide();
	});

	$(".login").on("click",function(){
		go.show(".loginPage");
	});

	$(".register").on("click",function(){
		go.show(".registerPage");
	});

});