<?php
/*
Symlink from $src to $dest.  Symlink will be relative if possible.
*/
//-! Currently local only.  Will need shell-runner and some special casing for remote locations.
namespace TJM\FileTasks;
use TJM\Files\Files;
use TJM\TaskRunner\Task;

class SymlinkTask extends Task{
	protected $dest;
	protected $src;
	public function __construct($src, $dest){
		$this->dest = $dest;
		$this->src = $src;
	}
	public function do(){
		return Files::symlinkRelativelySafely($this->dest, $this->src);
	}
	public function undo(){
		if(is_link($this->dest)){
			unlink($this->dest);
		}
	}
}
