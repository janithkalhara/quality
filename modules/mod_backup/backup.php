
<?php 
defined("HEXEC") or die("Restrited Access.");
?>
<div style='min-height:300px'>
<?php 
backup_tables(DB_HOST,DB_USER,DB_PASSWORD,DB_DATABASE);


function backup_tables($host,$user,$pass,$name,$tables = '*') {
  $link = mysql_connect($host,$user,$pass);
  mysql_select_db($name,$link);
  
  //get all of the tables
  if($tables == '*')
  {
    $tables = array();
    $result = mysql_query('SHOW TABLES');
    while($row = mysql_fetch_row($result))
    {
      $tables[] = $row[0];
    }
  }
  else
  {
    $tables = is_array($tables) ? $tables : explode(',',$tables);
  }
  $return="";
  //cycle through
  foreach($tables as $table)
  {
    $result = mysql_query('SELECT * FROM '.$table);
    $num_fields = mysql_num_fields($result);
    
   
    $row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
    $return.= "\n\n".$row2[1].";\n\n";
    
    for ($i = 0; $i < $num_fields; $i++) 
    {
      while($row = mysql_fetch_row($result))
      {
        $return.= 'INSERT INTO '.$table.' VALUES(';
        for($j=0; $j<$num_fields; $j++) 
        {
          $row[$j] = addslashes($row[$j]);
          $row[$j] = ereg_replace("\n","\\n",$row[$j]);
          if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
          if ($j<($num_fields-1)) { $return.= ','; }
        }
        $return.= ");\n";
      }
    }
    $return.="\n\n\n";
  }
  
  //save file
  $handle = fopen('DBBACKUPS/db-backup-'.time().'-'.(md5(implode(',',$tables))).'.sql','w+');
  fwrite($handle,$return);
  fclose($handle);



$files=array("DBBACKUPS/db-backup-".time()."-".(md5(implode(',',$tables))).".sql");

$result=create_zip($files,"DBBACKUPS/my-archive.zip");
print "Download Backup: <a href='DBBACKUPS/my-archive.zip'>here</a>";
//print "Download Backup: <a href='db-backup-".time()."-".(md5(implode(',',$tables))).".zip'>here</a>";
}


function create_zip($files = array(),$destination = '',$overwrite = true) {
  //if the zip file already exists and overwrite is false, return false
  if(file_exists($destination) && !$overwrite) { return false; }
  //vars
  $valid_files = array();
  //if files were passed in...
  if(is_array($files)) {
    //cycle through each file
    foreach($files as $file) {
      if(file_exists($file)) {
        $valid_files[] = $file;
      }
    }
  }
  if(count($valid_files)) {
    $zip = new ZipArchive();
    if($zip->open($destination,$overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
      return false;
    }
    //add the files
    foreach($valid_files as $file) {
      $zip->addFile($file,$file);
    }
    //debug
    //echo 'The zip archive contains ',$zip->numFiles,' files with a status of ',$zip->status;
    
    //close the zip -- done!
    $zip->close();
    
    //check to make sure the file exists
    return file_exists($destination);
  }
  else
  {
    return false;
  }
}
?>
</div >