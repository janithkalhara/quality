<?php
require_once '../../../includes/HDatabase.php';
class Restore{
	
	private $stocks;
	private $gradeStock;
	private $samples;
	private $centerFakes;
	private $centerQuantity;
	private $updates;
	private $images;
	private $db;
	private $p,$v,$d;
	
	private $map=array( 'stocks'=>array('table'=>'qa_stock','key'=>array('id','vehicleNo','date')),
						'gradeStock'=>array('table'=>'qa_gradeStock','key'=>array('id','vehicleNo','date')),
						'samples'=>array('table'=>'qa_sample','key'=>array('id','vehicleNo','date')),
						'centerFakes'=>array('table'=>'qa_center_fakes','key'=>array('id','vehicleNo','date')),
						'centerQuantity'=>array('table'=>'qa_centerQuantity','key'=>array('id','vehicleNo','date')),
						'updates'=>array('table'=>'qa_stockUpdates','key'=>array('areaId','vehicleNo','date')),
						'images'=>array('table'=>'qa_stockImages','key'=>array('id','vehicleNo','date'))
			);
	
	public function __construct($p,$v,$d){
		
		$this->p=$p;
		$this->v=$v;
		$this->d=$d;
		$this->db=new HDatabase();
		$this->db->connect();
		
	}
	public function load(){
		error_log('loading >>> ');
		foreach ($this->map as $key=>$value){
			$keys=$value['key'];
			$where="{$keys[0]}='{$this->p}' AND {$keys[1]}='{$this->v}' AND {$keys[2]}='{$this->d}'";
			$this->db->resetResult();
			$this->db->select($value['table'],'*',$where);
			$this->$key=$this->db->getResult();
			
		}
		
	}
	
	public function restore(){
		error_log('restoring >>> ');
		
		foreach ($this->map as $key=>$value){
			$inserts=$this->$key;
			foreach ($inserts as $insert){
				$insertArray=array();
				$cols=array_keys($insert);
				
				foreach ($insert as $key=>$val){
					array_push($insertArray,$val);
				}
				if($this->db->insert($value['table'],array_values($insert))){
					error_log('inserted'.$value['table']);
				}else{
					return false;
				}
			}
		
		}
	}
	
}




