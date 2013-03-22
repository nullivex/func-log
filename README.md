openlss/func-log
========

Logging functions; also handles CLI output

The logger will automatically open and close its log file without any extra setup by the user

Usage
----

```php
ld('func/log');

dolog('This is an info message');
dolog('This is an ERROR',LOG_ERROR);
dolog('This is a warning',LOG_WARN);
```

COnfiguration
----
The log package ships with the following configuration

```php
$config['log']['level'] = LOG_INFO;
$config['log']['file'] = false;
$config['log']['format'] = '[%s] %s - %s'; //%s - date %s - level %s - message
$config['log']['date_format'] = 'm/d/Y g:i:sA';
```
  * $config['log']['level']			The level to log at, if a message is higher than the level it will be discarded
  * $config['log']['file']			The file to log to, this must be writable by the PHP program
  * $config['log']['format']		A sprintf style format of the log message
   * %s		Log level
   * %s		Date of the message
   * %s		The actual message
  * $config['log']['date_format']	A date format compatible with PHP's date() function

Reference
----

### (int bool) dolog($msg,$level=LOG_INFO)
This will log the desired message at the desired level to the configured log file.
  * $msg		The message to be logged
  * $level		The level to be logged
   * LOG_ERROR	Error message
   * LOG_WARN	Warning message
   * LOG_NOTICE	Notice message
   * LOG_INFO   Informational message
   * LOG_DEBUG  Debugging information

