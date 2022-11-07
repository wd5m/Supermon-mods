<?php
include("common.inc");
// autcomplete.php
// Author: David McAnally WD5M (Copyright) October 13, 2022
// For ham radio use only, NOT for comercial use!
// Based on examples from //jqueryui.com/autocomplete/
// Created for use with Supermon 7.1+
$max = 100;     // Limit records matached to maximum of 100
$text = trim(strip_tags($_GET['term']));        // search term
if (substr($text,0,1) == '*') die("Entered * DTMF character\n");
if (!file_exists($ASTDB_TXT)) die("$ASTDB_TXT file does not exist.\n");
if ($text == "help" and file_exists("autocomplete.help")) {
        $help = file('autocomplete.help',FILE_IGNORE_NEW_LINES);
        $json = '[{"label":"","call":"","desc":"'.$help[0].'","qth":""}]';
        echo $json;
        exit;
}
// grep astdb.txt for matches and place in $lines
exec("$GREP -i -m $max -E -e \"$text\" $ASTDB_TXT | sort -n",$lines);
// parse and build a json result to return matches to web page.
$json = "[";
$first = true;
$c=0;
foreach ($lines as $line)
{
        $columns = explode('|', $line);
        $node = htmlspecialchars(trim($columns[0]), ENT_QUOTES);
        $call = htmlspecialchars(trim($columns[1]), ENT_QUOTES);
        $desc = htmlspecialchars(trim($columns[2]), ENT_QUOTES);
        $qth  = htmlspecialchars(trim($columns[3]), ENT_QUOTES);
        if (!$first) { $json .=  ','; } else { $first = false; }
        $json .= '{"label":"'.$node.'","call":"'.$call.'","desc":"'.$desc.'","qth":"'.$qth.'"}';
        $c++;
}
if ($c == $max) {
        $json .= ',{"label":"","call":"","desc":"Maximum '.$max.' records returned","qth":""}';
}
$json .= "]";
echo $json;
?>
