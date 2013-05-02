#!/usr/bin/perl


use WebService::Belkin::WeMo::Device;
use WebService::Belkin::WeMo::Discover;
use Data::Dumper;
use strict;

# Note: excluding 'db' will force a search each time - expect a 1-3 second delay for UPNP discover


my $wemo = WebService::Belkin::WeMo::Device->new(ip => '192.168.2.152');


#my $wemo = WebService::Belkin::WeMo::Device->new(name => 'WeMo Switch', db => '/tmp/belkin.db');

print "Name = " . $wemo->getFriendlyName() . "\n";
print "On/Off = " . $wemo->isSwitchOn() . "\n"; 


print "Turning on...\n";
$wemo->on();	

sleep 10;

print "Turning off...\n";
$wemo->off();
