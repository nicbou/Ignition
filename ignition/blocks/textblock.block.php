<?php
//Plain text blocks
class TextBlock extends Block{
	function getContent(){
		return nl2br(htmlspecialchars($this->bean->content,ENT_QUOTES,'UTF-8'));
	}
}
?>