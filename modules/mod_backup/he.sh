#!/bin/bash
_now=$(date +"%Y-%m-%d")
_file="backup_$_now.sql.gz"
 mysqldump -udorz_root -p19871024 dforz_Hayleys_QA | gzip > "$_file"