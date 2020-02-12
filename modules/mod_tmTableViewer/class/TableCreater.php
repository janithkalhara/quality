<?php
require_once 'includes/HDatabase.php';
require_once 'libraries/base/project/lib_project.php';
require_once 'libraries/base/grade/lib_grade.php';

class TableCreater{
private $stationId;
private $seasonId;
private $project;
public $startDate;
private $endDate;
private $date;
private $vehicleNo;
private $category;
private $DQ;
private $AQ;
private $RQ;
private $PQ;
private $totDQ;
private $totAQ;
private $totPQ;
private $center;
private $tmNo;
private $grades;
private $dqTotal;
private $aqTotal;
private $rqTotal;
private $pqTotal;
private $smallGradeArr;
private $smallQuantityDQ;
private $smallQuantityAQ;
private $smallQuantityRQ;
private $smallQuantityPQ;
private $projCat;
private $seasonObj;
private $gradeObj;
private $season;
private $stDate;
private $enDate;

function TableCreater($postArray)
{
    $this->stationId = $postArray['stationId'];
    $this->seasonId  = $postArray['season'];
    $this->project   = $postArray['project'];
    $this->stDate    = $postArray['startDate'];
    $this->enDate    = $postArray['endDate'];
    $this->startDate = $postArray['startDate'] . " 00:00:00";
    $this->endDate   = $postArray['endDate'] . " 23:59:59";
    $projectObj      = new Project();
    $this->gradeObj  = new Grade();

    $this->seasonObj = new Season();
    $this->season    = $this->seasonObj->getSeasonNameById($this->seasonId);

    $projCatId     = $projectObj->getGradeByProjectId($this->project);
    $this->projCat = $projCatId;

    $proNameArr = $projectObj->getProjectNameById($this->project);
    $proName    = $proNameArr['areaName'];

    $gradeNameArr = $this->gradeObj->getGradeCategoryNameById($this->projCat);
    $gradeName    = $gradeNameArr['name'];

    if ($this->projCat != "5") {
        settype($this->DQ, "double");
        settype($this->AQ, "double");
        settype($this->RQ, "double");
        settype($this->PQ, "double");
        settype($this->totDQ, "double");
        settype($this->totAQ, "double");
        settype($this->totPQ, "double");
        settype($this->dqTotal, "double");
        settype($this->aqTotal, "double");
        settype($this->rqTotal, "double");
        settype($this->pqTotal, "double");

        if ($this->stationId != "Total") {
            if ($this->project != "") {
                $projectId = $this->project;
                $con       = new HDatabase();
                $con->connect();
                $con->select('qa_stockUpdates', '*',
                    "stationId='$this->stationId' AND date>='$this->startDate' AND date<='$this->endDate' AND areaId='$projectId'",
                    "date ASC");
                $result = $con->getResult();

            } else {
                $con = new HDatabase();
                $con->connect();
                $con->select('qa_stockUpdates', '*',
                    "stationId='$this->stationId' AND date>='$this->startDate' AND date<='$this->endDate'", "date ASC");
                $result = $con->getResult();
            }
        } else {
            $projectId = $this->project;

            $con = new HDatabase();
            $con->connect();
            $con->select('qa_stockUpdates', '*',
                "date>='$this->startDate' AND date<='$this->endDate' AND areaId='$projectId'", "date ASC");
            $result = $con->getResult();
        }

        $db = new HDatabase();
        $db->connect();

        if ($result) {
            $k           = 0;
            $latestArray = array();
            foreach ($result as $r) {
                $newProjectId    = $r['areaId'];
                $this->date      = $r['date'];
                $this->vehicleNo = $r['vehicleNo'];

                $this->project  = $newProjectId;
                $this->category = $projectObj->getGradeByProjectId($newProjectId);

                $this->grades = $this->gradeObj->getGradesByCat($this->category);

                $db->resetResult();
                $db->select('qa_centerQuantity', '*',
                    "id='$this->project' AND date='$this->date' And vehicleNo='$this->vehicleNo'", "center ASC");
                $newResult = $db->getResult();

                $finalArray = array();
                $dataArray  = array();

                if ($newResult) {
                    $j = 0;
                    foreach ($newResult as $p) {
                        $gradeData  = array();
                        $gradeCount = count($this->grades);

                        $this->center = $p['center'];
                        $this->tmNo   = $p['tmNo'];
                        $gradeData[0] = $p['grade1'];
                        $gradeData[1] = $p['grade2'];
                        $gradeData[2] = $p['grade3'];
                        $gradeData[3] = $p['grade4'];

                        $finalArray[$j][0] = $this->vehicleNo;
                        $finalArray[$j][1] = $this->date;
                        $finalArray[$j][2] = $this->center;
                        $finalArray[$j][3] = $this->tmNo;

                        $d = 4;
                        for ($i = 0; $i < $gradeCount; $i++) {
                            if ($gradeData[$i] != 0) {
                                $gradeNo = $this->grades[$i];

                                $db->resetResult();
                                $db->select('qa_gradeStock', '*',
                                    "id='$this->project' AND date='$this->date' And vehicleNo='$this->vehicleNo' AND gradeId='$gradeNo'");
                                $rr          = $db->getResult();
                                $this->totDQ = $rr[0]['notedWeight'];
                                $this->totAQ = $rr[0]['trueWeight'];
                                $this->totPQ = $rr[0]['payableQuantity'];

                                $this->DQ = round($gradeData[$i], 2);
                                $this->AQ = round((($this->totAQ / $this->totDQ) * $this->DQ), 2);
                                $this->PQ = round((($this->totPQ / $this->totDQ) * $this->DQ), 2);
                                $this->RQ = round(($this->DQ - $this->PQ), 2);

                                $this->dqTotal += $this->DQ;
                                $this->aqTotal += $this->AQ;
                                $this->rqTotal += $this->RQ;
                                $this->pqTotal += $this->PQ;

                            } else {
                                $this->DQ = 0;
                                $this->AQ = 0;
                                $this->RQ = 0;
                                $this->PQ = 0;
                            }

                            $finalArray[$j][$d]     = $this->DQ;
                            $finalArray[$j][$d + 1] = $this->AQ;
                            $finalArray[$j][$d + 2] = $this->RQ;
                            $finalArray[$j][$d + 3] = $this->PQ;

                            $d = $d + 4;

                        }
                        $finalArray[$j][$d]     = round($this->dqTotal, 2);
                        $finalArray[$j][$d + 1] = round($this->aqTotal, 2);
                        $finalArray[$j][$d + 2] = round($this->rqTotal, 2);
                        $finalArray[$j][$d + 3] = round($this->pqTotal, 2);

                        $this->dqTotal = 0;
                        $this->aqTotal = 0;
                        $this->rqTotal = 0;
                        $this->pqTotal = 0;

                        $j++;

                    }

                    $latestArray[$k] = $finalArray;
                    //print_r($latestArray[$k][0]);
                    $k++;
                }

            }
            $this->printTable($latestArray, $proName, $gradeName);
        } else {
            $this->errorAlert();

        }
    }// end of checking small

    else {
        $this->createSmallTable($proName, $gradeName);
    }
}


//small table creater
function createSmallTable($proName, $gradeName){
settype($this->DQ, "double");
settype($this->AQ, "double");
settype($this->RQ, "double");
settype($this->PQ, "double");
settype($this->totDQ, "double");
settype($this->totAQ, "double");
settype($this->totPQ, "double");
settype($this->dqTotal, "double");
settype($this->aqTotal, "double");
settype($this->rqTotal, "double");
settype($this->pqTotal, "double");

$projectObj     = new Project();
$this->gradeObj = new Grade();

if ($this->stationId != "Total") {
    $projectId = $this->project;

    $con = new HDatabase();
    $con->connect();
    $con->select('qa_stockUpdates_small', '*',
        "stationId='$this->stationId' AND date>='$this->startDate' AND date<='$this->endDate' AND areaId='$projectId'",
        "date ASC");
    $result = $con->getResult();

} else {
    $projectId = $this->project;

    $con = new HDatabase();
    $con->connect();
    $con->select('qa_stockUpdates_small', '*',
        "date>='$this->startDate' AND date<='$this->endDate' AND areaId='$projectId'", "date ASC");
    $result = $con->getResult();
}
$this->smallGradeArr = array('11-14', '14-17', '17-29', '29-44', 'CRS');
$gradez              = array('grade1', 'grade2', 'grade3', 'grade4', 'grade5');
$this->grades        = array('11-14', '14-17', '17-29', '29-44', 'CRS');

$db = new HDatabase();
$db->connect();

if ($result){ ?>

<div id="smallTableDiv">

    <div id="dataDiv">
        <table>
            <tr>
                <td>Season</td>
                <td> : <?php print $this->season; ?></td>
            </tr>
            <tr>
                <td>Project</td>
                <td> : <?php print $proName; ?> </td>
            </tr>
            <tr>
                <td>Grade</td>
                <td> : <?php print $gradeName; ?> </td>
            </tr>
            <tr>
                <td>Period</td>
                <td> : <?php print $this->stDate . " : " . $this->enDate; ?> </td>
            </tr>

        </table>

    </div>

    <table id="signTable">
        <tr>
            <td>.................................</td>
            <td>.................................</td>
            <td>.................................</td>

        </tr>
        <tr>
            <td>Checked by</td>
            <td>Executive's Signature</td>
            <td>Factory Manager's Signature</td>

        </tr>
    </table>

    <table id="smallDataTable">

        <tr style="background-color: #627AAD; font-weight: bold;">
            <th rowspan="2">Vehicle No</th>
            <th rowspan="2">Date</th>
            <th rowspan="2">Center</th>
            <th rowspan="2">TMNo</th>

            <?php for ($n = 0; $n < count($this->grades); $n++) {

                print '<th rowspan="1" colspan="4">' . $this->grades[$n] . '</th>';

            } ?>

            <th rowspan="1" colspan="4">Total</th>
        </tr>

        <tr style="background-color: #627AAD; font-weight: bold;">
            <?php for ($n = 0; $n < (count($this->grades) + 1); $n++) { ?>
                <th>DQ</th>
                <th>AQ</th>
                <th>RQ</th>
                <th>PQ</th>
            <?php } ?>
        </tr>


        <?php

        $totDQ = array();
        for ($p = 0; $p < 24; $p++) {
            $totDQ[$p] = 0;
        }

        foreach ($result as $r) {
            $newProjectId    = $r['areaId'];
            $this->date      = $r['date'];
            $this->vehicleNo = $r['vehicleNo'];

            $db->select('qa_centerQuantitySmall', '*',
                "id='$this->project' AND date='$this->date' AND vehicleNo='$this->vehicleNo'", "center ASC");
            $newResult = $db->getResult();

            $dataArray = array();
            $k         = 0;
            foreach ($newResult as $nn) {
                print '<tr style="text-align:center;color:#000">';
                print '<td>' . $nn['vehicleNo'] . '</td>';
                print '<td>' . $nn['date'] . '</td>';
                print '<td>' . $nn['center'] . '</td>';
                print '<td>' . $nn['tmNo'] . '</td>';

                for ($l = 0; $l < 5; $l++) {
                    settype($this->smallQuantityPQ[$l], "double");
                    $this->smallQuantityPQ[$l] = 0;
                }

                for ($j = 0; $j < 5; $j++) {
                    $grade = $this->smallGradeArr[$j];
                    $db->resetResult();
                    $db->select('qa_small_belongs', '*',
                        "id='$this->project' AND date='$this->date' AND vehicleNo='$this->vehicleNo' AND gradeName='$grade'");
                    $resultSet = $db->getResult();

                    $this->smallQuantityDQ[$j] = $resultSet[0]['DQ'];
                    $this->smallQuantityAQ[$j] = $resultSet[0]['AQ'];
                    $this->smallQuantityRQ[$j] = $resultSet[0]['reject'];
                    //$this->smallQuantityPQ[$j] = $resultSet[0]['11-14'] + $resultSet[0]['14-17'] + $resultSet[0]['17-29'] + $resultSet[0]['29-44'] + $resultSet[0]['CRS'];

                    //changes
                    $this->smallQuantityPQ[0] += $resultSet[0]['11-14'];
                    $this->smallQuantityPQ[1] += $resultSet[0]['14-17'];
                    $this->smallQuantityPQ[2] += $resultSet[0]['17-29'];
                    $this->smallQuantityPQ[3] += $resultSet[0]['29-44'];
                    $this->smallQuantityPQ[4] += $resultSet[0]['CRS'];

                }


                /* for($s=0;$s<5;$s++){
                    $grade = $this->smallGradeArr[$s];
                    $db->resetResult();
                    $db->select('qa_small_belongs','*',"project='$this->project' AND date='$this->date' AND vehicleNo='$this->vehicleNo' AND gradeName='$grade'");
                    $resultSet = $db->getResult();

                } */


                $quanDQ = 0;
                $quanAQ = 0;
                $quanRQ = 0;
                $quanPQ = 0;

                for ($i = 0; $i < count($gradez); $i++) {
                    $gradeQuantity[$i] = $nn[$gradez[$i]];

                    $this->DQ = round($gradeQuantity[$i], 2);
                    $this->AQ = round((($this->smallQuantityAQ[$i] / $this->smallQuantityDQ[$i]) * $this->DQ), 2);
                    $this->PQ = round((($this->smallQuantityPQ[$i] / $this->smallQuantityDQ[$i]) * $this->DQ), 2);
                    $this->RQ = round(($this->DQ - $this->PQ), 2);

                    print '<td>' . $this->DQ . '</td>';
                    print '<td>' . $this->AQ . '</td>';
                    print '<td>' . $this->RQ . '</td>';
                    print '<td>' . $this->PQ . '</td>';

                    $quanDQ += $this->DQ;
                    $quanAQ += $this->AQ;
                    $quanRQ += $this->RQ;
                    $quanPQ += $this->PQ;

                    $totDQ[$k] += $this->DQ;
                    $totDQ[$k + 1] += $this->AQ;
                    $totDQ[$k + 2] += $this->RQ;
                    $totDQ[$k + 3] += $this->PQ;

                    $k = $k + 4;

                }
                print '<td>' . $quanDQ . '</td>';
                print '<td>' . $quanAQ . '</td>';
                print '<td>' . $quanRQ . '</td>';
                print '<td>' . $quanPQ . '</td>';

                $totDQ[$k] += $quanDQ;
                $totDQ[$k + 1] += $quanAQ;
                $totDQ[$k + 2] += $quanRQ;
                $totDQ[$k + 3] += $quanPQ;

                print '</tr>';
                $k = 0;
            }

        }
        print '<tr style="font-weight:bold;text-align:center;color:#000">';
        for ($l = 0; $l < 4; $l++) {
            print '<td></td>';
        }

        for ($e = 0; $e < count($totDQ); $e++) {
            print '<td>' . $totDQ[$e] . '</td>';

        }
        print '</tr></table> <div id="printButtonSmall"> Print Report </div></div>';

        } else {
            $this->errorAlert();
        }
        }


        function printTable($latestArray, $proName, $gradeName)
        { ?>
            <div id="tableDiv">

                <div id="dataDiv">
                    <table>
                        <tr>
                            <td>Season</td>
                            <td> : <?php print $this->season; ?></td>
                        </tr>
                        <tr>
                            <td>Project</td>
                            <td> : <?php print $proName; ?> </td>
                        </tr>
                        <tr>
                            <td>Grade</td>
                            <td> : <?php print $gradeName; ?> </td>
                        </tr>
                        <tr>
                            <td>Period</td>
                            <td> : <?php print $this->stDate . " : " . $this->enDate; ?> </td>
                        </tr>

                    </table>

                </div>

                <table id="dataTable">

                    <tr style="background-color: #627AAD; font-weight: bold;">
                        <th rowspan="2">Vehicle No</th>
                        <th rowspan="2">Date</th>
                        <th rowspan="2">Center</th>
                        <th rowspan="2">TMNo</th>

                        <?php for ($n = 0; $n < count($this->grades); $n++) {
                            $gradeRaw = $this->gradeObj->getGradeById($this->grades[$n]);
                            $gradeFc  = $gradeRaw['fruitCount'];

                            print '<th rowspan="1" colspan="4">' . $gradeFc . '</th>';

                        } ?>

                        <th rowspan="1" colspan="4">Total</th>
                    </tr>

                    <tr style="background-color: #627AAD;">
                        <?php for ($n = 0; $n < (count($this->grades) + 1); $n++) { ?>
                            <th>DQ</th>
                            <th>AQ</th>
                            <th>DQ-PQ</th>
                            <th>PQ</th>
                        <?php } ?>
                    </tr>
                    <?php for ($m = 0; $m < count($latestArray); $m++) {
                        for ($r = 0; $r < count($latestArray[$m]); $r++) {
                            print '<tr style="text-align:center;color:#000">';
                            for ($a = 0; $a < count($latestArray[$m][$r]); $a++) {
                                print '<td>' . $latestArray[$m][$r][$a] . '</td>';
                            }
                            print '</tr>';
                        }

                    } ?>

                    <tr style="text-align: center; color: #000">
                        <?php

                        for ($cols = 0; $cols < 4; $cols++) {
                            print '<td></td>';
                        }

                        $mm = 0;
                        for ($l = 4; $l < count($latestArray[0][0]); $l++) {
                            for ($u = 0; $u < count($latestArray); $u++) {
                                for ($q = 0; $q < count($latestArray[$u]); $q++) {
                                    $mm += $latestArray[$u][$q][$l];
                                }
                            }
                            print '<td style="font-weight:bold; height:20px" >' . $mm . '</td>';
                            $mm = 0;
                        }

                        ?>

                    </tr>

                </table>
                <hr style="margin-top: 0px"/>
                <div id="printArea" style="position: relative; margin-bottom: 5px">
                    <div id="printButton">Print Report</div>
                </div>

                <table id="signTable">
                    <tr>
                        <td>.................................</td>
                        <td>.................................</td>
                        <td>.................................</td>

                    </tr>
                    <tr>
                        <td>Checked by</td>
                        <td>Executive's Signature</td>
                        <td>Factory Manager's Signature</td>

                    </tr>
                </table>

            </div>

        <?php }

        function errorAlert()
        { ?>

            <div id="submitmsg" class="ui-state-highlight ui-corner-all"
                 style="margin-top: 10px; margin-bottom: 5px; padding: 5px; position: relative;">
			<span class="ui-icon ui-icon-info"
                  style="float: left; margin-right: .3em; margin-top: 1px"></span> No
                Stocks
            </div>

        <?php }
        }

        ?>
