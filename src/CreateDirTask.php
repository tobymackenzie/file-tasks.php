<?php
/*
Create a directory.  Will create interceding directories if they don't exist.
*/
namespace TJM\FileTasks;
use TJM\ShellRunner\ShellRunner;
use TJM\TaskRunner\Task;

class CreateDirTask extends Task{
	protected $location;
	protected $path;
	protected $shell;
	public function __construct($path, $location = 'localhost', ShellRunner $shell = null){
		$this->location = $location ?: 'localhost';
		$this->path = $path;
		$this->shell = $shell ?: new ShellRunner();
	}
	public function do(){
		$return = $this->shell->run('[[ -e ' . $this->path . ' ]] || mkdir -p ' . $this->path, $this->location);
		if($return){
			throw new Exception(static::class . " exited with return code {$return}");
		}
	}
	public function undo(){
		throw new Exception("Cannot undo a " . static::class);
	}
}
