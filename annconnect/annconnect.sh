#!/bin/bash
# annconnect.sh - WD5M
# custom node connect/disconnect localplay announcements
# call this script from supermon smlogger with arguments:
# $1 - same as smlogger [0=disconnecting/1=connecting]
# $2 - same as smlogger [local node]
# $3 - same as smlogger [remote node]
# $4 - node connection direction [IN/OUT] from $chkINOUT in smlogger
#
# Example:  add this line to smlogger at bottom of script just before trap - exit...
# [ -x /usr/local/sbin/supermon/annconnect.sh ] && /usr/local/sbin/supermon/annconnect.sh "${@}" "${chkINOUT}" &
# Note the trailing "&" runs the script in background.
#
declare -A IGN
# Ignore these nodes...
# uncomment and replace node number inside quotes
# replicate for each node you want to ignore
# IGN['555550']=1
# IGN['555551']=1
# IGN['555552']=1

Prgm=`basename $0`
PID=$$
N="${3,,}"
[[ ${IGN[${N}]} == 1 ]] && exit 0	# Ignored node
SP="/var/lib/asterisk/sounds"
# [[ ${1} == 0 ]] && exit 0	# uncomment to silence disconnect announcements
# [[ ${4} == "OUT" ]] && exit 0	# uncomment to silence outbound announcements
[[ ${1} == 0 ]] && CD="${SP}/disconnected.gsm"
[[ ${1} == 1 ]] && CD="${SP}/connected.gsm"
[[ ${4} == "OUT" ]] && INOUT="${SP}/outbound.gsm"
[[ ${4} == "IN" ]] && INOUT="${SP}/inbound.gsm"
re='^[0-9]+$'	# numberic regex test values
rel='^[a-z\.\*\+\@\-]+$'	# letter character regex test values
declare -i L
declare -i i
let L=${#N}-1	# length of node string minus 1
for ((i=0;i<=${L};i++))	# loop through node characters
do
	unset CP
	C=${N:$i:1}
	# set a sound subdirectory name based on number/letter character
	[[ ${C} =~ ${rel} ]] && CP="letters"
	[[ ${C} =~ ${re} ]] && CP="digits"
	[[ ! ${CP} ]] && continue	# skip unknown characters
	# convert some known characters to word sound file names
	[[ ${C} == '+' ]] && C="plus"
	[[ ${C} == '@' ]] && C="at"
	[[ ${C} == '.' ]] && C="dot"
	[[ ${C} == '*' ]] && C="asterisk"
	[[ ${C} == '-' ]] && C="dash"
	if [ $i -eq 0 ]
	then
		SOUNDS="${SP}/${CP}/${C}.gsm"
	else
		SOUNDS="${SOUNDS} ${SP}/${CP}/${C}.gsm"
	fi
done
# create an audio file
/usr/bin/cat \
	${SP}/silence/1.gsm \
	${SP}/node.gsm \
	${SOUNDS} \
	${CD} \
	${INOUT} \
	${SP}/silence/1.gsm \
	>/tmp/annconnect"${PID}".gsm
# queue the audio file to play locally
/usr/bin/asterisk -rx "rpt localplay 51540 /tmp/annconnect${PID}"
/usr/bin/sleep 10	# allow 10 seconds to play audio before removing audio file
/usr/bin/rm -f /tmp/annconnect"${PID}".gsm
exit 0
