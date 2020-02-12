<?php
global $import;
$import->importLib("project");
$import->importLib("pattern");
class OptionalArrivalPatternMaker{
	
	public static function managerPlan($post){
		$numOfWeeks = $post['numofweeks-plandata'];
        $project = $post['project-plandata'];
        $season = $post['season-plandata'];
        $weeks = $weekValues = $seeds = array();

        for($i=0;$i<$numOfWeeks;$i++) {
            $weekValues[$i]=$post['input-'.$i];
            $seeds[$i]=$post['seededFlag-plandata-'.$i];
            $weeks[$i]=$post['hidden-input-'.$i];
        }
        //creating pattern handler
        $pHandler = new PatternHandler();
        //get Scheme
        $scheme = $pHandler->getScheme($project, $season);
        //get YPA
        $ypa = $pHandler->getYPA($project, $season);
        //send data to pattern handler and get graph values
        $graphValues = $pHandler->getCalculation($weekValues, $scheme, $ypa);
        $data = $pHandler->getGradeWiseCalculation($project, $season, $graphValues);
        
        //get grades and grade wise values
        $gradeWiseValues = $data[0];
        $grades = $data[1];
        //setting week length of cropping
        $weeksLength = 5+count($graphValues);
        $weekListAll = self::getWeekList($weeks[0], $weeksLength);
        $weekList = array_slice($weekListAll, 5,$weeksLength);
        $prjct = new Project();
        $projectdata = $prjct->getProjectNameById($project);
        $projectName = $projectdata['areaName'];
        $err = false;
        $db = HDatabase::getInstance();
        $db->delete("qa_arrivalData","project='$projectName'");

        for($i=0;$i<count($weekList);$i++) {
            for($j=0;$j<count($gradeWiseValues[$i]);$j++) {
                $weekNo = $weekList[$i];
                $weekSep = self::getWeekSeperable($weekList[$i]);
                $from = $weekSep[0];
                $to = $weekSep[1];
                $insertArray = array($weekNo,$projectName,$project,$grades[$i][$j],$season,$from,$to,$gradeWiseValues[$i][$j]);

                if($db->insert("qa_arrivalData", $insertArray)) {
                    $err = false;
                }
                else{
                    $err = true;
                }
            }
        }
        return $err ? false : true;
      		
	}
	
	public static function manager($post) {
		$numOfWeeks = $post['numOfweeks-hidden'];
		$project = $post['project-revisiondata'];
		$season = $post['season-revisiondata'];
		
		$weeks = array();
		$weekValues = array();
		$seeds = array();
		for($i=0;$i<$numOfWeeks;$i++){
			$weekValues[$i] = $post['revisionData-insert-'.$i];
			$seeds[$i] = $post['seededFlag-plandata-'.$i];
			$weeks[$i] = $post['hidden-revisionData-insert-'.$i];
		}
		
		$pHandler = new PatternHandler();
		$scheme = $pHandler->getScheme($project, $season);
		$ypa = $pHandler->getYPA($project, $season);
		
		$graphValues = $pHandler->getCalculation($weekValues, $scheme, $ypa);
		$data = $pHandler->getGradeWiseCalculation($project, $season, $graphValues);
		$gradeWiseValues = $data[0];
		$grades = $data[1];
		$weeksLength = 5 + count($graphValues);
		$weekListAll = self::getWeekList($weeks[0], $weeksLength);
		$weekList = array_slice($weekListAll, 5,$weeksLength);
		$prjct = new Project();
		$projectdata = $prjct->getProjectNameById($project);
		$projectName = $projectdata['areaName'];
		$err = false;
		$db = HDatabase::getInstance();
		$db->delete("qa_arrivalData","project='$projectName'");
		
		for($i=0;$i<count($weekList);$i++){
			for($j=0;$j<count($gradeWiseValues[$i]);$j++){
				$weekNo = $weekList[$i];
				$weekSep = self::getWeekSeperable($weekList[$i]);
				$from = $weekSep[0];
				$to = $weekSep[1];
				$insertArray = array($weekNo,$projectName,$project,$grades[$i][$j],$season,$from,$to,$gradeWiseValues[$i][$j]);
				if($db->insert("qa_arrivalData", $insertArray)) {
					$err = false;
				}
				else {
					$err = true;
				}
			}
		}
		return $err ? false : true;
	}
	
	private static function getWeekSeperable($week) {
		$sp1 = explode("/", $week);
		$y = $sp1[2];
		$sp2 = explode("-",$sp1[0]);
		$sp3 = explode("-",$sp1[1]);
		$fd = $sp2[0];$fm=$sp2[1];
		$ld = $sp3[0];
		$lm = $sp3[1];
		$weekSep = array();
		$weekSep[0] = $y."-".$fm."-".$fd;
		$weekSep[1] = $y."-".$lm."-".$ld;
		return $weekSep;
	}
	
	private static function getWeekList($startWeek,$numOfWeeks) {
		$week = self::getWeekSeperable($startWeek);
		$start_week = $week[0];
		$end_week = $week[1];
		$weekList = array();
		$s = $start_week;
		$e = $end_week;
		
		for($i=0;$i<($numOfWeeks-1);$i++) {
			$timeStamp = StrToTime($e);
            $e_d = StrToTime('+7 days', $timeStamp);
			$s_d = StrToTime('+1 days', $timeStamp);
			$e = date('Y-m-d',$e_d);
			$s = date('Y-m-d',$s_d);;
			$weekList[$i] = date('d',$s_d).'-'.date('m',$s_d)."/".date('d',$e_d)."-".date('m',$e_d)."/".date('Y',$s_d);
			
		}
		array_unshift($weekList,$startWeek);
		return $weekList;
	}
}
?>