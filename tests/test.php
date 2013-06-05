<?php
require_once "GenkgoApi.php";

class ApiTest extends PHPUnit_Framework_TestCase {
	
	private function getApi () {
		require_once "test-settings.php";
		return new GenkgoApi ($settings['url'], $settings['apiKey']);
	}
	
	public function testWebmaster () {
		$api = $this->getApi();
		
		$results = $api->command('organization', 'query', array('q'=>'webmaster'));
		$this->assertEquals('array', gettype($results));
		$this->assertEquals('webmaster', $results[0]->q);
		$this->assertEquals(1, $results[1]->parentid);
	}
	
	public function testCreateDelete () {
		$api = $this->getApi();
		
		$createResult = $api->command('organization', 'create', array('name'=> 'test unit', 'objectclass'=> 'organizationalUnit'));
		$this->assertEquals('stdClass',get_class($createResult));
		$entryId = $createResult->id;
		
		$deleteResult = $api->command('organization', 'delete', array('target'=> $entryId));
		$this->assertEquals('true', $deleteResult);
	}
	
}
?>