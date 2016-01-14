<?php
/**
 * Backup MySQL to Rackspace Cloud Files
 *
 * @author     Chris Mears <chris.mears@gmail.com>
 */

date_default_timezone_set('America/Chicago');

require 'vendor/autoload.php';
require 'settings.php';

use OpenCloud\Rackspace;

echo date('[r] ')."INFO: Backup initiated.\n";
echo date('[r] ')."INFO: Backing up $db on $dbserver...\n";
exec("/Applications/MAMP/Library/bin/mysqldump --opt --user=$user --password=$password --host=$dbserver $db > $file");

// Create gzip and force overwrite
echo date('[r] ')."INFO: $file created. Compressing...\n";
exec("gzip -f $file");

echo date('[r] ')."INFO: $file.gz created. Sending to Rackspace Cloud Files $rackspaceContainer container...\n";

$client = new Rackspace(Rackspace::US_IDENTITY_ENDPOINT, array(
  'username' => $rackspaceUser,
  'apiKey'   => $rackspaceApiKey,
));
$service = $client->objectStoreService(
    null,
    $rackspaceRegion,
    $rackspaceUrlType
);

try {
    $container = $service->getContainer($rackspaceContainer);
    $container->uploadObject("$file.gz", fopen("$file.gz", 'r+'));
} catch (Exception $e) {
    echo date('[r] ')."ERROR: $file.gz upload failed.\n";
    echo date('[r] ')."ERROR: ".$e->getMessage()."\n";
    echo date('[r] ')."ERROR: Backup failed.\n";
    exit;
}

echo date('[r] ')."INFO: $file.gz uploaded.\n";
echo date('[r] ')."SUCCESS: Backup complete.\n";
