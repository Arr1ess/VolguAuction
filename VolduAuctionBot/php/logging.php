<?php

function logging(string $str) : void{
	global $debugMode;
	if(!$debugMode){
		return;
	}
	echo $str . "\n";
}

logging("Файл с логами подключен");