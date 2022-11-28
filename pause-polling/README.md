Modify link.php to enable optional pausing of server polling/refresh while the browser window/tab is hidden. This enhancement may reduce network data load or usage on systems with multiple Supermon sessions. 

To enable:

  replace the link.php file with this modified version
  
  add this line to global.inc
  
    $PAUSE_HIDDEN="YES";

Setting the META REFRESH value to a very long time may avoid page/reload conflicts with this modification. IF the page auto refresh fires while the page is hidden, you may need to manually reload the page when you view/unhide it. The META REFRESH method is discouraged by the W3C standards body, as it can cause other issues. 

    $REFRESH_DELAY = "172800";
