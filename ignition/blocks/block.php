<?php
//Define the default block interface

abstract class Block{
	protected $bean;

	//The constructor takes a name to either fetch or create a block
	protected function __construct($name){
		$name = strtolower($name);

		//Find a record named $name in the block's table, or create an empty one
		$this->bean = R::findOne( strtolower(get_class($this)), ' name=? ', array($name) );
		if( is_null($this->bean) ){
			$this->bean = R::dispense( strtolower(get_class($this)) );
			$this->setName($name);
			$this->setContent(_('This block has no content yet'));
			R::store($this->bean);
		}
	}


	//The block's name is a human-readable identifier used to fetch the block from the database
	function getName(){
		return $this->bean->name;
	}
	function setName($name){
		$this->bean->name = $name;
	}

	//Beans are the storage units used by redbean
	function getBean(){
		return $this->bean;
	}

	function getContent(){
		return $this->bean->content;
	}
	function setContent($content){
		$this->bean->content = $content;
	}

	//Return a block with a given name, instead of outputting it
	static function get($name){
		$block_type = get_called_class();
		return new $block_type($name);
	}

	//Echo or return a the block, or its editor if the user is connected
	static function show($name, $echo = true){
		$block_type = get_called_class();
		$block = $block_type::get($name);

		$output = "";
		/* By default, blocks have three states:
		** - getDisplayable() returns the public version of the block
		** - getEditable() returns the editable version of the block
		** - getEditor() returns the form used to edit this block type
		** processEditor() is called when the block editor is submitting its
		** changes, then calls getEditor with a list of errors.
		**
		** It's entirely possible to override any of these functions
		*/
		if( isAdmin() && isEditing($name) ){
			$errors = $block->processEditor();
			if( !is_array($errors) )
				$output = $block->getEditor();
			elseif ( count($errors) == 0 )
				$output = $block->getEditable();
			else
				$output = $block->getEditor($errors);
		}
		elseif( isAdmin() && !isEditing($name) ){
			$output = $block->getEditable($block);
		}
		else{
			$output = $block->getDisplayable($block);
		}

		if($echo)
			echo $output;

		return $output;
	}

	//Get an editor for this block. This can be a form or a WYSIWYG editor, for instance
	protected function getEditor($errors = array()){
		return "
			<form class='ignition-editor' method='post'>
				<textarea name='content'>".$this->getContent()."</textarea>
				<input type='submit' value='Save'/>
			</form>
		";
	}

	//Process the editor's content, return an associative array of errors, or false if
	//there's nothing to process. If dry run is true, do not save changes.
	protected function processEditor($dry_run = false){
		$errors = array();
		if( isset($_POST['content']) ){
			if($dry_run == false){
				$this->setContent($_POST['content']);
				R::store($this->bean);
			}
			return $errors;
		}
		else{
			return false;
		}
	}

	//Show this block as editable
	protected function getEditable(){
		$block_type = get_class($this);
		return
			'<div class="ignition-editable">
				<a href="?edit='.$this->getName().'" class="ignition-edit-link">'._('Edit this block').'</a>
				'.$block_type::getDisplayable($this).'
			</div>';
	}

	//Show this block
	protected function getDisplayable(){
		return "
			<p>".$this->getContent()."</p>
		";
	}
}
