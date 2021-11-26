# Cronjobs
The following cron jobs are required.

It's absolute required to avoid running scripts twice! 
so we're using ```flock``` (https://linux.die.net/man/1/flock) to handle this.

```shell
#/etc/crontab

# {PAGENAME} replace this placeholder with a unique system/pagename
# {PATHNAME} set this placeholder as workingdir to you absolute system path to ../wp-content/themes/travelshop/cli/
# {WP_ROOT} replace this to the wordpress root directory, where wp-cron.php is located
# Check if "root" is the correct user for your purpose

# every night at five o'clock were make a complete import
0 5 * * * root cd {PATHNAME} && flock -n /tmp/{PAGENAME}-fullimport.lock php import.php fullimport

# every night at two o'clock: prune the log table or folder
0 2 * * * root cd {PATHNAME} && flock -n /tmp/{PAGENAME}-logcleanup.lock php log_cleanup.php

# every five minutes: run/rebuild the cache
*/5 * * * * root cd {PATHNAME} && flock -n /tmp/{PAGENAME}-cachecleanup.lock php cache_cleanup.php

# every 10 minutes run the wp-cron.php - don't forget to disable cron wp-config.php
*/10 * * * * root cd {WP_ROOT} && flock -n /tmp/{PAGENAME}-wpcron.lock php wp-cron.php
```


## Disable default WordPress cronjob
Add this to your wp-config.php file.
```shell
# wp-config.php
define('DISABLE_WP_CRON', true);
```

# Troubleshooting
* If you have any trouble with this, check ``/var/log/syslog`` that the cron has fired at the defined time.
* Run the every script directly from the commandline and check the results.