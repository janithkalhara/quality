<?php
class taskHandler{
	var $task;
	var $container;
	var $respond;
	public function taskHandler(){
		
		
		}
	
	public function setTask($task){
		
		$this->task=$task;
		 $this->checkTask($this->task);
		return true;
		
		} 
	public function checkTask($task){
		
		if($task){
			if($task=='feedback'){
				$this->doMail($this->container);
				
				}
			
			
			}
		
		}
	public function doMail($container){
		if($container){
		$subject=$container['feedback-subject'];
		$to=array('laleen.kp@gmail.com','pgmlmanoj@gmail.com','janithkalhara@gmail.com');
		$headers="from : ".$container['user'];
		
		for ($i=0; $i<count($to);$i++){
			
			mail($to[$i],$subject,$headers);
			
			}
		
		$this->respond="Your mail has been sent to the development team.Thank you!";
		
		}
		}
	public function respond(){
		
		return $this->respond;
		return(true);
		
		}
	
	
	
	}



?>