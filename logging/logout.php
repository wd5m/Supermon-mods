<?php
        // New php session management code -- KB4FXC 01/25/2018
        include("session.inc");
        openlog("SUPERMON",LOG_ODELAY , LOG_LOCAL0);    // WD5M 20221107 - Log to Linux syslog
        error_log($_SERVER['REMOTE_ADDR'].' '.$_SESSION['user'].' logout succeeded.');      // WD5M 20221107 - Log to Apache error.log
        syslog(LOG_INFO,$_SERVER['REMOTE_ADDR'].' '.$_SESSION['user'].' logout succeeded.');        // WD5M 20221107 - Log to Linux syslog
        closelog();     // WD5M 20221107 - Log to Linux syslog
        session_unset();
        $_SESSION['sm61loggedin'] = false;

        //`echo logout called >> /tmp/log.out`;


        print "Logged out.";
?>
