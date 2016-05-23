<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2016 AOE GmbH <dev@aoe.com>
*  All rights reserved
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

require_once PATH_tx_t3deploy . 'classes/class.tx_t3deploy_databaseController.php';

/**
 * Testcase for class tx_t3deploy_databaseController.
 *
 * @package t3deploy
 * @author Oliver Hader <oliver.hader@aoe.com>
 */
class tx_t3deploy_tests_databaseController_testcase extends Tx_Phpunit_Database_TestCase {
	/**
	 * @var tx_t3deploy_databaseController
	 */
	private $controller;

	/**
	 * Sets up the test cases.
	 *
	 * @return void
	 */
	public function setUp() {
		$this->createDatabase();
		$this->useTestDatabase();
		$this->importStdDB();
		$this->importExtensions(array('testextension'));

		$expectedSchemaServiceMock = $this->getMock(
			'TYPO3\\CMS\\Install\\Service\\SqlExpectedSchemaService',
			array('getTablesDefinitionString')
		);

		$expectedSchemaServiceMock->expects($this->any())->method('getTablesDefinitionString')->with(true)->willReturn(
			file_get_contents(PATH_tx_t3deploy . 'tests/fixtures/testextension/ext_tables_fixture.sql')
		);

		$this->controller = new tx_t3deploy_databaseController();
		$this->inject($this->controller, 'expectedSchemaService', $expectedSchemaServiceMock);
	}

	/**
	 * Cleans up the test cases.
	 *
	 * @return void
	 */
	public function tearDown() {
		$this->dropDatabase();

		unset($this->testExtensionsName);
		unset($this->testLoadedExtensions);
		unset($this->controller);
	}

	/**
	 * Tests whether the updateStructure action just reports the changes
	 *
	 * @test
	 * @return void
	 */
	public function doesUpdateStructureActionReportChanges() {
		$arguments = array(
			'--verbose' => ''
		);

		$result = $this->controller->updateStructureAction($arguments);

		// Assert that nothing has been created, this is just for reporting:
		$tables = $GLOBALS['TYPO3_DB']->admin_get_tables();
		$pagesFields = $GLOBALS['TYPO3_DB']->admin_get_fields('pages');
		$this->assertFalse(isset($tables['tx_testextension_test']));
		$this->assertNotEquals('varchar(255)', strtolower($pagesFields['alias']['Type']));

		// Assert that changes are reported:
		$this->assertContains('ALTER TABLE pages ADD tx_testextension_field_test', $result);
		$this->assertContains('ALTER TABLE pages CHANGE alias alias varchar(255)', $result);
		$this->assertContains('CREATE TABLE tx_testextension_test', $result);
		$this->assertNotContains('DROP TABLE tx_testextension', $result);
	}

	/**
	 * Test whether the updateStructure action just executes the changes.
	 *
	 * @test
	 * @return void
	 */
	public function doesUpdateStructureActionExecuteChanges() {
		$arguments = array(
			'--execute' => ''
		);

		$result = $this->controller->updateStructureAction($arguments);

		// Assert that tables have been created:
		$tables = $GLOBALS['TYPO3_DB']->admin_get_tables();
		$pagesFields = $GLOBALS['TYPO3_DB']->admin_get_fields('pages');
		$this->assertTrue(isset($tables['tx_testextension']));
		$this->assertTrue(isset($tables['tx_testextension_test']));
		$this->assertTrue(isset($pagesFields['tx_testextension_field_test']));
		$this->assertEquals('varchar(255)', strtolower($pagesFields['alias']['Type']));

		// Assert that nothing is reported we just want to execute:
		$this->assertEmpty($result);
	}

	/**
	 * Test whether the updateStructure action just reports remove old database definitions.
	 *
	 * @test
	 * @return void
	 */
	public function doesUpdateStructureActionReportRemovals() {
		$arguments = array(
			'--remove' => '',
			'--verbose' => ''
		);

		$result = $this->controller->updateStructureAction($arguments);

		// Assert that nothing has been removed, this is just for reporting:
		$tables = $GLOBALS['TYPO3_DB']->admin_get_tables();
		$this->assertTrue(isset($tables['tx_testextension']));
		$pagesFields = $GLOBALS['TYPO3_DB']->admin_get_fields('pages');
		$this->assertTrue(isset($pagesFields['tx_testextension_field']));

		// Assert that removals are reported:
		$this->assertContains('DROP TABLE tx_testextension', $result);
		$this->assertContains('ALTER TABLE pages DROP tx_testextension_field', $result);
	}

	/**
	 * Test whether the updateStructure action remove old database definitions.
	 *
	 * @test
	 * @return void
	 */
	public function doesUpdateStructureActionExecuteRemovals() {
		$arguments = array(
			'--remove' => '',
			'--execute' => ''
		);

		$result = $this->controller->updateStructureAction($arguments);

		// Assert that tables and columns have been removed:
		$tables = $GLOBALS['TYPO3_DB']->admin_get_tables();
		$this->assertFalse(isset($tables['tx_testextension']));
		$pagesFields = $GLOBALS['TYPO3_DB']->admin_get_fields('pages');
		$this->assertFalse(isset($pagesFields['tx_testextension_field']));

		// Assert that nothing is reported we just want to execute:
		$this->assertEmpty($result);
	}

	/**
	 * Test whether the updateStructure action remove old database definitions.
	 *
	 * test
	 * @return void
	 */
	public function doesUpdateStructureActionReportDropKeys() {
		$arguments = array(
			'--drop-keys' => '',
			'--verbose' => ''
		);

		$result = $this->controller->updateStructureAction($arguments);

		// Assert that nothing has been removed, this is just for reporting:
		$tables = $GLOBALS['TYPO3_DB']->admin_get_tables();
		$this->assertTrue(isset($tables['tx_testextension']));
		$pagesFields = $GLOBALS['TYPO3_DB']->admin_get_fields('pages');
		$this->assertTrue(isset($pagesFields['tx_testextension_field']));

		// Assert that removals are reported:
		$this->assertContains('DROP TABLE tx_testextension', $result);
		$this->assertContains('ALTER TABLE pages DROP tx_testextension_field', $result);
	}

	/**
	 * Test whether the updateStructure action dump changes to file.
	 *
	 * @test
	 * @return void
	 */
	public function doesUpdateStructureActionDumpChangesToFile() {
		$testDumpFile = PATH_tx_t3deploy . 'tests/test_dumpfile.sql';
		if (file_exists($testDumpFile)) {
			unlink($testDumpFile);
		}
		$this->assertFileNotExists($testDumpFile);

		$arguments = array(
			'--verbose' => '',
			'--dump-file' => array($testDumpFile)
		);

		$result = $this->controller->updateStructureAction($arguments);

		$this->assertFileExists($testDumpFile);
		$testDumpFileContent = file_get_contents($testDumpFile);
		// Assert that changes are dumped:
		$this->assertContains('ALTER TABLE pages ADD tx_testextension_field_test', $testDumpFileContent);
		$this->assertContains('ALTER TABLE pages CHANGE alias alias varchar(255)', $testDumpFileContent);
		$this->assertContains('CREATE TABLE tx_testextension_test', $testDumpFileContent);

		// Assert that dump result is reported:
		$this->assertNotEmpty($result);
	}

	/**
	 * set $value into property $propertyName of $object
	 *
	 * This is a convenience method for setting a protected or private property in
	 * a test subject for the purpose of e.g. injecting a dependency.
	 *
	 * @param object $object The instance which needs the dependency
	 * @param string $propertyName Name of the property to be injected
	 * @param object $value The dependency to inject – usually an object but can also be any other type
	 * @return void
	 * @throws RuntimeException
	 * @throws InvalidArgumentException
	 */
	private function inject($object, $propertyName, $value)
	{
		if (!is_object($object)) {
			throw new InvalidArgumentException('Wrong type for argument $object, must be object.');
		}

		$objectReflection = new ReflectionObject($object);
		if ($objectReflection->hasProperty($propertyName)) {
			$property = $objectReflection->getProperty($propertyName);
			$property->setAccessible(true);
			$property->setValue($object, $value);
		} else {
			throw new RuntimeException('Could not inject ' . $propertyName . ' into object of type ' . get_class($object));
		}
	}
}