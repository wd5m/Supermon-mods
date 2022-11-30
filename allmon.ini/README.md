; The "allmon.ini" file in Supermon is carried forward from Allmon's "allmon.ini.php" file. The "allmon.ini" file defines a set of variable names and values in a format that is parsed by Supermon into an associative array. The array provides variable/value pairs used to create a menu in Supermon and connect to Allstar manager services. NOTE: The variable names are case-sensitive. Some values like the passwd may be case sensitive.

; The following documents the format and variables used in "allmon.ini" for Supermon as of Version 7.2+ (November 2022).

; The ";" semicolon defines the start of a comment. Text following the semicolon is ignored. Empty or blank lines are also ignored.

; A value containing spaces will need to be enclosed in double quotes. Some characters have special meaning in double-quoted strings and must be escaped by the "\\" backslash prefix.  

; The "[...]" backeted line labels and begins a menu name or item section in the file. The text inside the brackets "[...]" sets the menu name for this item. Node sections use the node number as the value inside the barackets. Following lines in the file contain "variable = value" pairs defining details used by this Menu Item or section. This may be a simple URL, node, menu drop down item or nodes group definition section.

[<MENU Item/Section Name>]

; The "url" line sets a web link URL value of this menu item. Any URL valid for use by web browsers should be acceptible.

url = 

; The "menu" line contains a value of "no" if this menu section is NOT to be displayed. A value of "yes" or if the "menu" line is not included will cause this enu item section to be displayed in the menu. The "menu" setting might be used to hide a menu item for future use or as an example template section that is copied in future edits of the allmon.ini file.

menu = 

; The "system" line contains a text value that defines the name of a drop down sub menu item to be associated to this menu item. Each Menu Item section that conains this same system value is placed under this sub menu drop down. For example, you have five nodes you want listed under a drop down menu button named "Local". For each node menu item stanza, include the line "system = Local".

system = 

; The "host" line defines the host name or IP address and port number that an Allstar node manager service is listening on to administrative connections. This value would normally be found in the /etc/asterisk/manager.conf file of the Allstar node. If the Allstar node is on the same host as this Supermon instance, then the localhost or 127.0.0.1 IP address may be used.  Port 5038 is normally the default port used by Allstar.

host = 127.0.0.1:5038

; The "admin" line contains the Allstar manager service user name. This must match the value in the Allstar /etc/asterisk/manager.conf file used by the "[admin]" section. "admin" is the default in Allstar installations.

user =	admin

; The "passwd" line contains the password used by the Allstar manager "user" name. This must match the value set in the Allstar node /etc/asterisk/manager.conf file. 

passswd = 

; The "hideNodeURL" line value is set to "yes" if this node menu item is to be displayed as "Private Node" in the Supermon link page.

hideNodeURL = no

; The "nodes" line defines a list of Allstar node numbers to be displayed as a group in the Supermon links page. These node numbers would need to match menu item node sections in the allmon.ini file.

nodes = 12346,23456,34567


The "rtcmnode" line defines a voter node number.

rtcmnode = 

; Examples:

      [Google Web Site]
      url = "http://google.com/"

      ; Allstar node 123456
      [123456]
      user = admin
      passwd = mysecretpassword
      host = 127.0.0.1:5038

      ; Inside a drop down sub menu named "Special" provide a descriptive menu name for node 654321 using the system and menu features.
      [Special node 654321]
      system = Special
      menu = yes
      nodes = 654321
      [654321]
      system = Special
      menu = no   ; We hide this menu item since the "Special node 654321" menu item uses "nodes" to access this item.
      hideNodeURL = no
      user = admin
      passwd = mySecretPassword
      host = 127.0.0.1:5038

      ; Another node for the Special drop down sub menu.
      [345543]
      system = Special
      menu = yes
      hideNodeURL = no
      user = admin
      passwd = mySecretPassword
      host = 10.0.0.1:5038


; References:

; PHP Parse a configuration file - parse_ini_file: https://www.php.net/manual/en/function.parse-ini-file.php
