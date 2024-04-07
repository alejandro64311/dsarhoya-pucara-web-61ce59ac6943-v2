#!/bin/bash

# Start the run once job.
echo "Docker container has been started"

# declare -p | grep -Ev 'BASHOPTS|BASH_VERSINFO|EUID|PPID|SHELLOPTS|UID' > /container.env

# Setup a cron schedule
# echo "SHELL=/bin/bash
# BASH_ENV=/container.envscheduler.txt
# * * * * * /run.sh >> /var/log/cron.log 2>&1
# # This extra line makes it a valid cron" > scheduler.txt

crontab /rootcrontab

exec /usr/bin/python /usr/bin/supervisord -c /etc/supervisor/supervisord.conf
