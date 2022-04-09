<?php
/*
Clear a directory's contents.
*/
namespace TJM\FileTasks;
use TJM\ShellRunner\ShellRunner;
use TJM\TaskRunner\Task;

class ClearTask extends Task{
	protected $path;
	protected $shell;
	public function __construct($path, ShellRunner $shell = null){
		$this->path = $path;
		$this->shell = $shell ?: new ShellRunner();
	}
	public function do(){
		$return = $this->shell->run('rm -r *', $this->path);
		if($return){
			throw new Exception(static::class . " exited with return code {$return}");
		}
	}
	public function undo(){
		throw new Exception("Cannot undo a " . static::class);
	}
}
