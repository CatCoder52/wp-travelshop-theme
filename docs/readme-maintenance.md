# Maintenance & troubleshooting

If something has changed on the pressmind model run:
````shell script
php install.php
php import.php fullimport
````

If you think that something on the data model is buggy, try:
````shell script
php integrity_check.php
````

If it is still buggy:
````shell script
mysql -u root -p;
mysql> DROP database pressmind;
mysql> CREATE database pressmind;
php install.php
php import.php fullimport
````

For pressmind sdk updates run (do not try this in production):
```shell script
composer update
php install.php
php import.php fullimport
```
Have a look at https://github.com/pressmind/sdk to check the last changes.

