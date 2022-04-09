<?php
namespace TJM\FileTasks\Tests;
use PHPUnit\Framework\TestCase;
use TJM\FileTasks\ClearTask;

class ClearTaskTest extends TestCase{
	protected $tmpPath = __DIR__ . '/tmp';
	public function setUp() :void{
		mkdir($this->tmpPath);
		chdir($this->tmpPath);
	}
	public function tearDown() :void{
		chdir(__DIR__);
		rmdir(__DIR__ . '/tmp');
	}
	public function testClear(){
		mkdir('a');
		exec('touch b c d e f g h a/a');
		$count = count(glob('./*'));
		if($count !== 8){
			throw new Except("Problem creating files for ClearTaskTest");
		}

		//--clear 'a'
		$task = new ClearTask($this->tmpPath . '/a');
		$task->do();
		$count = count(glob('./a/*'));
		$this->assertEquals(0, $count, 'All files should be removed from specified directory');
		$count = count(glob('./*'));
		$this->assertEquals(8, $count, 'No files should be cleared from parent directory');

		//--clear 'tmp'
		exec('touch a/a');
		$task = new ClearTask($this->tmpPath);
		$task->do();
		$count = count(glob('./*'));
		$this->assertEquals(0, $count, 'All files should be removed from specified directory');

		//--ensure rerunning same task again works
		mkdir('a');
		exec('touch b c d e f g h a/a');
		$count = count(glob('./*'));
		if($count !== 8){
			throw new Except("Problem creating files for ClearTaskTest");
		}
		$task->do();
		$count = count(glob('./*'));
		$this->assertEquals(0, $count, 'All files should be removed from specified directory');
	}
}
