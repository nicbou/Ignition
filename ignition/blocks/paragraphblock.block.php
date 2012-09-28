<?php
//Text blocks with paragraph breaks
class ParagraphBlock extends Block{
	protected function getEditor($errors = array()){
		return "
			<form method='post' class='ignition-editor'>
				<textarea name='content'>".$this->bean->content."</textarea>
				<input type='submit' value='Save'/>
			</form>
		";
	}
	function getContent(){
		$content = htmlspecialchars($this->bean->content,ENT_QUOTES,'UTF-8');
		$escaped_paragraphs = '<p>'. str_replace('\n\n', '</p><p>', $content) .'</p>';
		return nl2br($escaped_paragraphs);
	}
}
?>