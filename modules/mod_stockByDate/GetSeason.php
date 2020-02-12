<?php
require_once '../../includes/HDatabase.php';
require_once '../../libraries/base/season/lib_season.php';

$seasonId = $_POST['printSeason'];

$season = new Season();
$seasonName = $season->getSeasonNameById($seasonId);
print $seasonName;

?>