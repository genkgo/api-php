<?php
require_once __DIR__."/../vendor/autoload.php";

use Genkgo\Api\GenkgoApi;

$api = new GenkgoApi('','');
$folder = $api->command('organization', 'create', array('objectclass' => 'organizationalUnit', 'name' => 'Test Folder'));
$person = $api->command('organization', 'create', array('objectclass' => 'genkgoPerson', 'name' => 'Test Person', 'id' => $folder->id));
$api->command('organization', 'modify', array('id' => $person->id, 'properties' => array(
		'givenname'		=> 'voornaam',
		'surname'		=> 'achternaam',
		'mail'			=> 'example@example.com'
)));

$api->command('organization', 'delete', array(
	'target'	=> $folder->id
));

?>