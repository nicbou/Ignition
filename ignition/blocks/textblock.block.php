<?php
//Plain text blocks; escapes HTML and converts newlines to <br> tags
class TextBlock extends Block{
	function getContent(){
		return nl2br(htmlspecialchars($this->bean->content,ENT_QUOTES,'UTF-8'));
	}
}