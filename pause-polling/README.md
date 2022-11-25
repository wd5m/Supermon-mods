Modify link.php to enable optional pausing of server polling/refresh while the browser window/tab is hidden. This enhancement may reduce network data load or usage on systems with multiple Supermon sessions. 

To enable:

  replace the link.php file with this modified version
  
  add this line to global.inc
  
    $PAUSE_HIDDEN="YES";
