h1. MoneyBlower

Code to trigger a WeMo in response to an event in Sales Force


h2. Requirements

To get this code working you'll need:
* "A Belkin WeMo":http://www.belkin.com/us/wemo
* A "Money Blower machine":http://www.set.tv/the-ultimate-media-sales-motivator/
* "Perl-Belkin-WeMo-API":https://github.com/ericblue/Perl-Belkin-WeMo-API
* "Force.com Toolkit for PHP":http://wiki.developerforce.com/page/Force.com_Toolkit_for_PHP

h2. Configuration

1. Fill in your Sales Force USERNAME, PASSWORD and SECURITY_TOKEN in check_salesforce.php
1. Decide what StageName you want to trigger alerts on, default is 'Closed Won: IO Signed'
1. Setup a CRON job to run once a minute or whatever is desired. 
1. If you run less than once a minute you may want to change the query time which is now looking back 15 minutes.

h2. Notes

* The script keeps a little SQLite DB of ids it has previously alerted for and won't alert again

