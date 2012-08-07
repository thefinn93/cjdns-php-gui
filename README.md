A simple GUI for editing cjdroute.conf
--------

*Installing:*

1. Drop into an http-accessable directory

2. edit cjdns.inc.php to point to your cjdroute.conf file

3. ensure that your webserver's user has read write access to cjdroute.conf - this is proly a bad idea

4. Restrict access to the directory. One way to do this is to make a `.htaccess` file that looks like this:

```
Order Deny,Allow
Deny from all
Allow from <your IP here>
```

