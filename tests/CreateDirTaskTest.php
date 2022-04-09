<?php
namespace TJM\FileTasks\Tests;
use PHPUnit\Framework\TestCase;
use TJM\FileTasks\CreateDirTask;

class CreateDirTaskTest extends TestCase{
	protected $tmpPath = __DIR__ . '/tmp';
	public function setUp() :void{
		mkdir($this->tmpPath);
		chdir($this->tmpPath);
	}
	public function tearDown() :void{
		chdir(__DIR__);
		exec('rm -r ' . __DIR__ . '/tmp/*');
		rmdir(__DIR__ . '/tmp');
	}
	public function testCreateDir(){
		$count = count(glob('./*'));
		if($count !== 0){
			throw new Except("Empty dir should have no files in it");
		}

		//--create dirs
		$i = 0;
		foreach(['a','b','c','d','e','f','g','h'] as $dir){
			(new createDirTask($dir))->do();
			$this->assertEquals(++$i, count(glob('./*')), "Creating a dir should increase count of files by one");
		}

		//--create sub-dirs
		$i = 0;
		foreach(['a','b','c','d','e','f','g','h'] as $dir){
			(new createDirTask(__DIR__ . '/tmp/a/' . $dir))->do();
			$this->assertEquals(++$i, count(glob('./a/*')), "Creating a dir should increase count of files by one");
		}
	}
}
