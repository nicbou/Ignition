<?php
//Unescaped text blocks. Can be used for HTML.
class RawTextBlock extends Block{
	function getContent(){
		return $this->bean->content;
	}

	protected function getEditor($errors = array()){
		return "
			<form class='ignition-editor' method='post'>
				<textarea name='content'>".htmlspecialchars($this->bean->content,ENT_QUOTES,'UTF-8')."</textarea>
				<input type='submit' value='Save'/>
			</form>
		";
	}
}