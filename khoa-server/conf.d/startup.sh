#!/bin/sh
# startup.sh

# Start the cron service in the background. Unfortunately upstart doesnt work yet.
rsyslogd &
cron -f &
touch /var/log/cron.log &
tail -F /var/log/syslog /var/log/cron.log &
# Run the apache process in the foreground, tying up this so docker doesnt ruturn.
systemctl restart apache2 &
/usr/sbin/apache2ctl -D FOREGROUND