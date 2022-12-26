The annconnect.sh script provides a method to announce connections with more control of the announcment than using built-in telemetry settings. Either set this program for connpgm= and discpgm in rpt.conf, or call it from the Supermon smlogger script by adding this line to smlogger near the bottom, just above the trap - exit line. 

    [ -x /usr/local/sbin/supermon/annconnect.sh ] && /usr/local/sbin/supermon/annconnect.sh "${@}" "${chkINOUT}" &
    
Note that this will run the script on the background. See the annconnect.sh script file for additional details and optional settings.
