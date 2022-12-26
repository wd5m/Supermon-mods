The annconnect.sh script provides a method to announce connections with more control of the announcment than using built-in telemetry settings. Either set these in rpt.conf for:

    connpgm=<path>/annconnect.sh 1
    discpgm=<path>/annconnect.sh 0

Or call it from the Supermon smlogger script by adding this line to smlogger.

    [ -x /usr/local/sbin/supermon/annconnect.sh ] && /usr/local/sbin/supermon/annconnect.sh "${@}" &

Note that this will run the script in the background. See the annconnect.sh script file for additional details and optional settings.
