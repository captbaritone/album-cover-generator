<?php

function removePunctuation($string) {
	return str_replace(array(':', '!', '.', ';', '-', ',', '(', ')', "\'", '\\'), '', $string);
}
