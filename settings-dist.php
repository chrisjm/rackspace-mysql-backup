<?php
$date = date("Ymd");                    // Date format for file name
$file = "db-$date.sql";                 // Backup file name
$dbserver = "localhost";                // MySQL database server
$db = "db_name";                        // MySQL database name
$user = "user";                         // MySQL database user
$password = "password";                 // MySQL database password
$rackspaceRegion = 'DFW';               // 'DFW',
$rackspaceUrlType = 'internalURL';      // 'internalURL' or 'publicURL'
$rackspaceContainer = 'Container-Name'; // Name of the Cloud File container
$rackspaceUser = "rackspace_user";      // rackspace username
$rackspaceApiKey = "xxxxxxxxxxxxxxxxx"; // rackspace api key
?>
