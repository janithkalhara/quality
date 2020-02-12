$('document').ready(function(){
			var i=0;	
			var j=0;
			var k=0;
		
			$('#internalButton').css({'background':'#627AAD','color':'#fff','font-size':'20px'});
			$('#externalButton').css({'background':'#969696','color':'#003300','font-size':'17px'});
			$('#totalButton').css({'background':'#969696','color':'#003300','font-size':'17px'});
			i=1;j=0;k=0;			
			
			$('#internalButton').click(function(){
				$('#internalButton').css({'background':'#627AAD','color':'#fff','font-size':'20px'});
				$('#externalButton').css({'background':'#969696','color':'#003300','font-size':'17px'});
				$('#totalButton').css({'background':'#969696','color':'#003300','font-size':'17px'});
				i=1;j=0;k=0;
				
			});

			$('#externalButton').click(function(){
				$('#externalButton').css({'background':'#627AAD','color':'#fff','font-size':'20px'});
				$('#internalButton').css({'background':'#969696','color':'#003300','font-size':'17px'});
				$('#totalButton').css({'background':'#969696','color':'#003300','font-size':'17px'});
				j=1;i=0;k=0;
			});
			$('#totalButton').click(function(){
				$('#totalButton').css({'background':'#627AAD','color':'#fff','font-size':'20px'});
				$('#externalButton').css({'background':'#969696','color':'#003300','font-size':'17px'});
				$('#internalButton').css({'background':'#969696','color':'#003300','font-size':'17px'});
				k=1;i=0;j=0;
			});

			$('#internalButton').mouseover(function(){				
				$('#internalButton').css({'background-color':'#627AAD','color':'#fff','font-size':'20px'});
			});
			$('#internalButton').mouseout(function(){
				if(i==0){
				$('#internalButton').css({'background':'#969696','color':'#003300','font-size':'17px'});				
				}
			});

			$('#externalButton').mouseover(function(){				
				$('#externalButton').css({'background-color':'#627AAD','color':'#fff','font-size':'20px'});
			});
			$('#externalButton').mouseout(function(){
				if(j==0){
				$('#externalButton').css({'background':'#969696','color':'#003300','font-size':'17px'});				
				}
			});

			$('#totalButton').mouseover(function(){				
				$('#totalButton').css({'background-color':'#627AAD','color':'#fff','font-size':'20px'});
			});
			$('#totalButton').mouseout(function(){
				if(k==0){
				$('#totalButton').css({'background':'#969696','color':'#003300','font-size':'17px'});				
				}
			});

		});
	