<?php
class AreaController extends Controller {
	private $_areas = array();
	/**
	 * @access private
	 */
	public function index() {
		
		if($this->hasParam('view') && $this->getParam('view') == 'centers') {
			$template = __DIR__.'/../views/area/section_center.content.php';
			$project = $this->hasParam('area') ? Project::get($this->getParam('area')) : null;
			
			if(!$project instanceof Project) { header('Location:/v/area'); exit(); }
			$centers = $project->getCenters();
		}
		else {
			$presentSeason = Season::getPresentSeason();
			$seasons = Season::getSeasons();
			$areas = $presentSeason->getProjects();
			$template = __DIR__.'/../views/area/section_area.content.php';
		}		
		
		$__page = (object)array('title' => 'Quality Analysis System',
				'sections' => array($template),
				'assets' => array(
						array('STYLE', APP_CDN.'/css/select2.css','HEAD'),
						array('STYLE', APP_CDN.'/css/datepicker.css','HEAD'),
						array('STYLE', APP_CDN.'/css/base.css','HEAD'),
						array('STYLE', APP_CDN.'/css/quality.css','HEAD'),
						array('SCRIPT', APP_CDN.'/js/bootstrap-datepicker.js','HEAD'),
						array('SCRIPT', APP_CDN.'/js/jquery.validate.js','HEAD'),
						array('SCRIPT', APP_CDN.'/js/jquery.form.js','HEAD'),
						array('SCRIPT', APP_CDN.'/js/select2.min.js','HEAD'),
						array('SCRIPT', APP_CDN.'/js/bootbox.js','HEAD'),
						array('SCRIPT', APP_CDN.'/js/base.js','HEAD'),
				)
		
		);
		require_once APP_TEMPLATE_PATH.'/base.php';
		
	}
	
	public function update_center() {
		header('Content-type:application/json');
		try { 
			
		}
		catch (Exception $e) {
			echo json_encode(array());
		}
	}
	/**
	 * @access private
	 * @throws Exception
	 */
	public function edit_center() {
		try {
			$center = $this->hasParam('id') ? Center::get($this->getParam('id')) : null;
			$project = $center->getProject();	
			if(!$center instanceof Center) { throw  new Exception('Not a valid center'); }
			ob_start();
			require_once __DIR__.'/../views/area/popbox_center.edit.php';
			$buffered_data = ob_get_contents();
			ob_end_clean();
			header('Content-type:application/json');
			echo json_encode(array('success' => true, 'html' => $buffered_data));
				
		}
		catch(Exception $e) {
			header('Content-type:application/json');
			echo json_encode(array('success' => false, 'message' => $e->getMessage()));
		}
	}
	/**
	 * @access private
	 */
	public function remove_center() {
		header('Content-type:application/json');
		try {
			$center = $this->hasParam('id') ? Center::get($this->getParam('id')) : null;
			
			if(!$center instanceof  Center) { throw new Exception('Not a valid Center'); }
			$center->remove();
			echo json_encode(array('success' => true,'message' => 'Center '.$center->getName().' removed successfully.'));
		}
		catch (Exception $e) {
			echo json_encode(array('success' => false,'message' => $e->getMessage()));
		}
	}
	/**
	 * @access private
	 * @throws Exception
	 */	
	public function save_center() {
		header('Content-type:application/json');
		try {
			$project = $this->hasParam('project') ? Project::get($this->getParam('project')) : null;
			$centerName = $this->hasParam('name') && $this->getParam('name') != ''  ? $this->getParam('name') : null;
			
			if(is_null($centerName)) { throw new Exception('Not a valid name'); }
			
			if(!$project instanceof  Project) { throw new Exception('Not a valid project'); }
			$center = new Center();
			$center->setName($centerName)
					->setProject($project)
					->save();
			echo json_encode(array('success' => true, 'message' => '','html' => $this->getCenterList($project)));
			
		}
		catch (Exception $e) {
			echo json_encode(array('success' => false,'message' => $e->getMessage()));
		}
	}
	
	private function getCenterList(Project $project) {
		$centers = $project->getCenters();
		ob_start();
		include_once __DIR__.'/../views/area/section_centers.list.php';
		$buffer_content = ob_get_contents();
		ob_end_clean();
		return $buffer_content;
	}
	/**
	 * @access private
	 * @throws Exception
	 * @return boolean
	 */
	public function add_center() {
		header('Content-type:application/json');
		try {
			$project = $this->hasParam('id') ? Project::get($this->getParam('id')) : null;

			if(!$project instanceof  Project) { throw new Exception('Not a valid project'); }
			ob_start();
			require_once __DIR__.'/../views/area/popbox_center.add.php';
			$buffer_content = ob_get_contents();
			ob_end_clean();
			echo json_encode(array('success' => true,'message' => '', 'html' => $buffer_content));
			
		}
		catch (Exception $e) {
			echo json_encode(array('success' => false,'message' => $e->getMessage()));
		}
		return true;
	}
	/**
	 * @access private
	 */
	public function get_areas() {
		header('Content-type:application/json');
		try {
			$season = $this->hasParam('season') ? Season::get($this->getParam('season')) : null;
			
			if(!$season instanceof  Season) { throw new Exception('Not a valid Season'); }
			$projects = $season->getProjects();
			ob_start();
			require_once __DIR__.'/../views/area/section_area.list.php';
			$buffer_content = ob_get_contents();
			ob_end_clean();
			echo json_encode(array('success' => true,'html' => $buffer_content));
		}
		catch (Exception $e) {
			echo json_encode(array('success' => false,'html' => $e->getMessage()));
		}
		
	}
	
	public function save() {
		try {
			$season = Season::getPresentSeason();
			$name = $this->hasParam('name') && $this->getParam('name') != '' ? $this->getParam('name') : null;
			$gradeCategory = $this->hasParam('category') ? GradeCategory::get($this->getParam('category')) : null;
			$type = $this->hasParam('type') ? $this->getParam('type') : null;
			$supplier = $this->hasParam('supplier') ? User::getUser($this->getParam('supplier')) : null;

			if(!$season instanceof  Season) { throw new Exception('Not a valid Season'); }
			if(!$gradeCategory instanceof  GradeCategory) { throw new Exception('Not a valid Category'); }
			if(!$supplier instanceof  User) { throw new Exception('Not a valid User'); }
			if(is_null($name)) { throw new Exception('Name is not valid'); }
			if(is_null($type)) { throw new Exception('Type is not valid'); }
			$project = new Project();
			$project->setAreaType($type)
					->setGradeCategory($gradeCategory)
					->setName($name)
					->setSeason($season)
					->setIncharge($supplier)
					->save();
			header('Content-type:application/json');
			echo json_encode(array('success' => true,'message' => 'Project '.$project->getName().' updated successfully!','html' => $this->getPrjectListTable()));
		}
		catch (Exception $e) {
			header('Content-type:application/json');
			echo json_encode(array('success' => true,'message' => $e->getMessage()));
		}
	}
	
	public function add() {
		$season = Season::getPresentSeason();
		$gradeCategories = GradeCategory::getCategories();
		ob_start();
		require_once __DIR__.'/../views/area/popbox_area.add.php';
		$buffer_content = ob_get_contents();
		ob_end_clean();
		header('Content-type:application/json');
		echo json_encode(array('success' => true,'message' => '', 'html' => $buffer_content));
		return true;
	}
	
	public function remove() {
		header('Content-type:application/json');
		try {
			$project = $this->hasParam('id') ? Project::get($this->getParam('id')) : null;
			
			if(!$project instanceof  Project) { throw new Exception('Not a valid Project'); }
			$project->remove();
			echo json_encode(array('success' => true,'message' => 'Project '.$project->getName().' removed successfully!'));
			
		}
		catch (Exception $e) {
			echo json_encode(array('success' => true,'message' => $e->getMessage()));
		}
		
	} 
	
	/**
	 * @access private
	 */
	public function update() {
		try {
			$project = $this->hasParam('id') ? Project::get($this->getParam('id')) : null;
			$season = $this->hasParam('season') ? Season::get($this->getParam('season')) : null;
			$name = $this->hasParam('name') && $this->getParam('name') != '' ? $this->getParam('name') : null;
			$gradeCategory = $this->hasParam('category') ? GradeCategory::get($this->getParam('category')) : null;
			$type = $this->hasParam('type') ? $this->getParam('type') : null;
			$supplier = $this->hasParam('supplier') ? User::getUser($this->getParam('supplier')) : null;
			
			if(!$project instanceof  Project) { throw new Exception('Not a valid Project'); }
			if(!$season instanceof  Season) { throw new Exception('Not a valid Season'); }
			if(!$gradeCategory instanceof  GradeCategory) { throw new Exception('Not a valid Category'); }
			if(!$supplier instanceof  User) { throw new Exception('Not a valid User'); }
			if(is_null($name)) { throw new Exception('Name is not valid'); }
			if(is_null($type)) { throw new Exception('Type is not valid'); }
			
			$project->setAreaType($type)
					->setGradeCategory($gradeCategory)
					->setName($name)
					->setSeason($season)
					->setIncharge($supplier)
					->update();
			header('Content-type:application/json');
			echo json_encode(array('success' => true,'message' => 'Project '.$project->getName().' updated successfully!','html' => $this->getPrjectListTable()));
		}
		catch (Exception $e) {
			header('Content-type:application/json');
			echo json_encode(array('success' => true,'message' => $e->getMessage())); 
		}	
	}
	
	private function getPrjectListTable() {
		$season = Season::getPresentSeason();
		$projects = $season->getProjects();
		ob_start();
		require_once __DIR__.'/../views/area/section_area.list.php';
		$buffered_content = ob_get_contents();
		ob_end_clean();
		return $buffered_content;
	}

	/**
	 * @access private
	 */
	public function edit_area() {
		try {
			$project = $this->hasParam('id') ? Project::get($this->getParam('id')) : null;
			$seasons = Season::getSeasons();
			$gradeCategories = GradeCategory::getCategories();
			
			if(!$project instanceof Project) { throw  new Exception('Not a valid project'); }
			ob_start();
			require_once __DIR__.'/../views/area/popbox_area.edit.php';
			$buffered_data = ob_get_contents();
			ob_end_clean();
			header('Content-type:application/json');
			echo json_encode(array('success' => true, 'html' => $buffered_data));
			
		}
		catch(Exception $e) {
			header('Content-type:application/json');
			echo json_encode(array('success' => false, 'message' => $e->getMessage()));
		}
	}
}