/**
 * 
 */

var helper=function(){
	
	this.searchArray=function(arr, obj){
		
		 for(var i=0; i<arr.length; i++) {
		        if (arr[i] == obj) return true;
		    }
		
	};
	
	
	
	
};

Array.max = function( array ){
	 return Math.max.apply( Math, array );
	 };

	 jQuery.fn.idle = function(time){  
		    var i = $(this);  
		    i.queue(function(){  
		        setTimeout(function(){  
		            i.dequeue();  
		        }, time);  
		    });  
		}; 
