<?php
namespace TJM\FileTasks\Tests;
use PHPUnit\Framework\TestCase;
use TJM\FileTasks\SymlinkTask;

class SymlinkTaskTest extends TestCase{
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
	public function testCreateSymlink(){
		$count = count(glob('./*'));
		if($count !== 0){
			throw new Except("Empty dir should have no files in it");
		}

		//--create simple symlink
		file_put_contents('a', 'AAAAA');
		$i = 1;
		(new SymlinkTask('./a', './b'))->do();
		$this->assertEquals(++$i, count(glob('./*')), "Creating a symlink should increase count of files by one");
		$this->assertEquals('AAAAA', file_get_contents('b'), 'Symlink file should have same contents as target file.');
		file_put_contents('a', 'BBBBB');
		$this->assertEquals('BBBBB', file_get_contents('b'), 'Symlink file should have same contents as target file.');
	}
}
