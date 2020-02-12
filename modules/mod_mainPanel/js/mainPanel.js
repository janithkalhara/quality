$('document').ready(function(){
			var i = 0;
			var j = 0;
			var k = 0;
			var m = 0;
//$("#userManager").css({ opacity: .9});
//$("#areaManager").css({ opacity: .9});
//$("#gradeManager").css({ opacity: .9});
//$("#arrivalPatternManager").css({ opacity: .9});

	$('#list1').click(function(){
		
		if(i == 0 && j==1){			
			$('#areaManager').hide();	
			$('#gradeManager').hide();
			$('#seasonManager').hide();
			$('#userManager').show("blind", { direction: "vertical" }, 1500);		
			$('#list1').css('backgroundColor','#0078ff');
			$('#list2').css('backgroundColor','');
			$('#list1').css('color','#fff');
			$('#list2').css('color','#3366FF');	
			$('#list3').css('backgroundColor','');
			$('#list3').css('color','#3366FF');	
			$('#list5').css('backgroundColor','');
			$('#list5').css('color','#3366FF');
			j=0;					
			i = 1;
			k=0;
			m=0;
		}else if(i == 1 && j==0){
			$('#userManager').hide("blind", { direction: "vertical" }, 1500);
			$('#list1').css('backgroundColor','');
			$('#list1').css('color','#3366FF');			
			i = 0;
		}
		else if(i==0 && j==0){			
			$('#gradeManager').hide();
			$('#areaManager').hide();
			$('#seasonManager').hide();
			$('#userManager').show("blind", { direction: "vertical" }, 1500);
			$('#list1').css('backgroundColor','#0078ff');
			$('#list2').css('backgroundColor','');
			$('#list1').css('color','#fff');
			$('#list2').css('color','#3366FF');
			$('#list3').css('backgroundColor','');
			$('#list3').css('color','#3366FF');	
			i=1;
			k=0;
			m=0;
		}
		
				
		});

	$('#list2').click(function(){
		if(j == 0 && i==1){		
		$('#userManager').hide();
		$('#gradeManager').hide();
		$('#seasonManager').hide();
		$('#areaManager').show("blind", { direction: "vertical" }, 1500);
		$('#list2').css('backgroundColor','#0078ff');
		$('#list1').css('backgroundColor','');
		$('#list2').css('color','#fff');
		$('#list1').css('color','#3366FF');
		$('#list3').css('backgroundColor','');
		$('#list3').css('color','#3366FF');
		$('#list5').css('backgroundColor','');
		$('#list5').css('color','#3366FF');
		i=0;
		j = 1;
		k=0;
		m=0;
		}
		else if(j == 1 && i==0){
			$('#areaManager').hide("blind", { direction: "vertical" }, 1500);
			$('#gradeManager').hide();
			$('#list2').css('backgroundColor','');
			$('#list2').css('color','#3366FF');	
			k=0;		
			j=0;	

		}
		else if(i==0 && j==0){			
			$('#gradeManager').hide();
			$('#seasonManager').hide();
			$('#areaManager').show("blind", { direction: "vertical" }, 1500);
			$('#list2').css('backgroundColor','#0078ff');
			$('#list1').css('backgroundColor','');
			$('#list2').css('color','#fff');
			$('#list1').css('color','#3366FF');
			$('#list3').css('backgroundColor','');
			$('#list3').css('color','#3366FF');	
			$('#list5').css('backgroundColor','');
			$('#list5').css('color','#3366FF');
			j=1;
			k=0;
			m=0;
		}
		
		});

$('#list3').click(function(){
		
		if(k==0){
		$('#gradeManager').show("blind", { direction: "vertical" }, 1500);
		$('#userManager').hide();
		$('#areaManager').hide();
		$('#seasonManager').hide();
		$('#list3').css('backgroundColor','#0078ff');
		$('#list3').css('color','#fff');
		$('#list2').css('backgroundColor','');		
		$('#list2').css('color','#3366FF');
		$('#list1').css('backgroundColor','');
		$('#list1').css('color','#3366FF');
		$('#list5').css('backgroundColor','');
		$('#list5').css('color','#3366FF');
			k=1;
			i=0;
			j=0;
			m=0;
		}else{
			$('#gradeManager').hide("blind", { direction: "vertical" }, 1500);
			$('#list3').css('backgroundColor','');
			$('#list2').css('backgroundColor','');
			$('#list3').css('color','#3366FF');
			$('#list2').css('color','#3366FF');
			$('#list1').css('backgroundColor','');
			$('#list1').css('color','#3366FF');
			$('#list5').css('backgroundColor','');
			$('#list5').css('color','#3366FF');
			$('#areaManager').hide();
			$('#userManager').hide();
				k=0;
				i=0;
				j=0;
				m=0;
			}	
		});
$('#list5').click(function(){
	if(m==0){
		$('#seasonManager').show("blind", { direction: "vertical" }, 1500);
		$('#gradeManager').hide();
		$('#userManager').hide();
		$('#areaManager').hide();
		$('#list5').css('backgroundColor','#0078ff');
		$('#list5').css('color','#fff');
		$('#list3').css('backgroundColor','');
		$('#list3').css('color','#3366FF');
		$('#list2').css('backgroundColor','');		
		$('#list2').css('color','#3366FF');
		$('#list1').css('backgroundColor','');
		$('#list1').css('color','#3366FF');
			m=1;
			k=0;
			i=0;
			j=0;
		}else{
			$('#seasonManager').hide("blind", { direction: "vertical" }, 1500);
			$('#list5').css('backgroundColor','');
			$('#list5').css('color','#3366FF');
			$('#list3').css('backgroundColor','');
			$('#list2').css('backgroundColor','');
			$('#list3').css('color','#3366FF');
			$('#list2').css('color','#3366FF');
			$('#list1').css('backgroundColor','');
			$('#list1').css('color','#3366FF');
			$('#areaManager').hide();
			$('#userManager').hide();
			$('#gradeManager').hide();
				m=0;
				k=0;
				i=0;
				j=0;

			}	
});

});