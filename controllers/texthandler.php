<?php 

class TextHandler {

	public function removeText($r, $t) {
		return preg_replace('#('.$r.')#iUs', '', $t);
	}
	
}