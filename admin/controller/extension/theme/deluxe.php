<?php
if(extension_loaded("IonCube Loader")) {     
$php_version = PHP_MAJOR_VERSION . PHP_MINOR_VERSION;
if ($php_version == 44 ||$php_version == 52 ||$php_version == 53 ||$php_version == 54 || $php_version == 55 || $php_version == 71 || $php_version == 80 ) {
echo ("<span style='color:red;font-weight:700;'>Please change your php version to 5.6, 7.0, 7.2, 7.3 or 7.4</span>");
} else {
$ioncube_loaders = array(
    56 => 56,
    70 => 56,
    72 => 72,
    73 => 72,
    74 => 72,
);

$ioncube_loader = !empty($ioncube_loaders[$php_version]) ? $ioncube_loaders[$php_version] : 72;
require_once(DIR_SYSTEM . '/library/deluxe/php/deluxe_' . $ioncube_loader . '.php');
}
} else {
echo ("<span style='color:red;font-weight:700;'>Please install IonCube Loaders on your server</span>");
}