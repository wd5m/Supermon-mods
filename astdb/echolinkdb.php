<?php
// echolinkdb.php
// Author: David McAnally WD5M (Copyright) October 13, 2022
// For ham radio use only, NOT for comercial use!
//
// The php-dom Class DOMDocument feature must be installed.
// To install php-dom on Linux Debian:
//      apt-get update
//      apt-get install php-dom
// Hamvoip Allstar appears to already have php-dom installed.
//
// When installing this script Make it executible with the command
//      chmod +x echolinkdb.php
//
// This script was created for use with Supermon 7.1+ to add EchoLink nodes
// to the privatenodes.txt file and astdb.txt
// This script will scrape the EchoLink node tables from the
// www.echoLink.org/logins.jsp web page and output records in a format compatible
// with the Supermon privatenodes.txt file record format.
//
// One optional argument can be included to select a desired EchoLink
// node type table, such as repeaters, links, users, or conferences
// Example: echolinkdb.php links
//
// The "-h" argument will display brief command syntax help information.
//
// If no argument is provided all EchoLink node records will be returned.
// The EchoLink node numbers will be formatted to prefix zeros (0) to the
// EchoLink node numbers, then truncated  to make the EchoLink number six
// digits, then the number three (3) is prefixed to make the node number
// compatible with Allstar EchoLink connect requests.
// https://wiki.allstarlink.org/wiki/Echolink.conf_-_Echolink_Channel_Driver#Connecting_to_Echolink
// All embedded vertical bars (|) from the EchoLink tables are converted
// to spaces to avoid conflict with the privatenodes.txt record field delimiter.
//
// On my Hamvoip system I have this crontab entry below . It runs
// echolinkdb.php hourly, at random times, to update the privatenodes.txt file.
// Another crontab entry runs astdb.php to update the astdb.txt file, including
// privatenodes.txt, for use with Supermon.  Remember, this crontab exampe is
// for Hamvoip. ASL Debian or other systems will likely be different.
// Note: Please do not run this script at intervals more often than 5 minutes (300 seconds).
// @hourly sleep $((RANDOM / 10)); /usr/local/sbin/supermon/echolinkdb.php > /etc/asterisk/local/privatenodes.txt 2>/dev/null
// The following example runs randomly within 10 minute intervals.
// */10 * * * * sleep $((RANDOM / 55)); /usr/local/sbin/supermon/echolinkdb.php > /etc/asterisk/local/privatenodes.txt 2>/dev/null
//

function scrape_echolink_org($thistable) {
        $col = array();
        // extract and format content of each table row
        $r = 0;
        foreach($thistable->childNodes as $child)
        {
                if( $child->hasChildNodes() )
                {
                        if ($r < 1) {   // skip header row
                                $r = $r + 1;
                                continue;
                        }
                        $r = $r + 1;
                        $i=1;
                        foreach($child->childNodes as $field)
                        {
                                $col[$i] = str_replace("|"," ",trim($field->textContent));
                                $i = $i + 1;
                        }
                        echo "3".substr("000000".$col[6],strlen("000000".$col[6])-6)."|".$col[2]."|".$col[3]."|".PHP_EOL;
                }
        }
}
if (isset($argv[1]) and $argv[1] == '-h') {
        echo "Usage: echolinkdb.php [-h][repeaters][links][users][conferences]".PHP_EOL;
        echo "  -h - display this information.".PHP_EOL;
        echo "  repeaters - extract EchoLink -R repeater nodess".PHP_EOL;
        echo "  links - extract EchoLink -L link nodess".PHP_EOL;
        echo "  users - extract EchoLink user nodess".PHP_EOL;
        echo "  conferences - extract EchoLink conference nodess".PHP_EOL;
        echo "  If no option is specified all of the EchoLink nodes are extracted.".PHP_EOL;
        exit;
}
$DOM = new DOMDocument();
libxml_use_internal_errors(true);
$DOM->loadHTMLFile("https://www.echolink.org/logins.jsp", LIBXML_NOERROR | LIBXML_NOWARNING) or die("Unable to load echolink.org/logins.jsp");
// extract outer table element
$tables = $DOM->getElementsByTagName('table');
//echo $tables->length.PHP_EOL;
$tablenbr = 0;
$tablename = 'All';
if (isset($argv[1])) {
        switch ($argv[1]) {
                case 'repeaters':
                        $tablename='Repeaters';
                        $table = $tables->item(1);
                        scrape_echolink_org($table);
                        break;
                case 'links':
                        $tablename='Links';
                        $table = $tables->item(2);
                        scrape_echolink_org($table);
                        break;
                case 'users':
                        $tablename='Users';
                        $table = $tables->item(3);
                        scrape_echolink_org($table);
                        break;
                case 'conferences':
                        $tablename='Conferences';
                        $table = $tables->item(4);
                        scrape_echolink_org($table);
                        break;
        }
} else {
        // extract all nodes
        $table = $tables->item(1);
        scrape_echolink_org($table);
        unset($table);
        $table = $tables->item(2);
        scrape_echolink_org($table);
        unset($table);
        $table = $tables->item(3);
        scrape_echolink_org($table);
        unset($table);
        $table = $tables->item(4);
        scrape_echolink_org($table);
        unset($table);
}
exit;
?>
