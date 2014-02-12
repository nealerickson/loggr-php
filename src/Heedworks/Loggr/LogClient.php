<?php

namespace Heedworks\Loggr;

use Heedworks\Loggr\DataType;

class LogClient
{
	private $_logKey;
	private $_apiKey;

	function __construct($logKey, $apiKey)
	{
		$this->_logKey = $logKey;
		$this->_apiKey = $apiKey;
	}

	public function Post($event)
	{
		// format data
		$qs = $this->CreateQuerystring($event);
		$data = "apikey=" . $this->_apiKey . "&" . $qs;
		
		// write without waiting for a response
		$fp = fsockopen('post.loggr.net', 80, $errno, $errstr, 30);	
		$out = "POST /1/logs/".$this->_logKey."/events HTTP/1.1\r\n";
		$out.= "Host: "."post.loggr.net"."\r\n";
		$out.= "Content-Type: application/x-www-form-urlencoded\r\n";
		$out.= "Content-Length: ".strlen($data)."\r\n";
		$out.= "Connection: Close\r\n\r\n";
		if (isset($data)) $out.= $data;
	
		fwrite($fp, $out);
		fclose($fp);
	}
	
	public function CreateQuerystring($event)
	{
		$res = "";
		$res .= "text=" . urlencode($event->Text);
		if (isset($event->Source)) $res .= "&source=" . urlencode($event->Source);
		if (isset($event->User)) $res .= "&user=" . urlencode($event->User);
		if (isset($event->Link)) $res .= "&link=" . urlencode($event->Link);
		if (isset($event->Value)) $res .= "&value=" . urlencode($event->Value);
		if (isset($event->Tags)) $res .= "&tags=" . urlencode($event->Tags);
		if (isset($event->Latitude) && isset($event->Longitude)) $res .= "&geo=" . urlencode($event->Latitude) . "," . urlencode($event->Longitude);
		if (isset($event->Ip)) $res .= "&geo=ip:" . urlencode($event->Ip);
		
		if (isset($event->Data))
		{
			if ($event->DataType == DataType::html)
				$res .= "&data=" . "@html\r\n" . urlencode($event->Data);
			else
				$res .= "&data=" . urlencode($event->Data);
		}
		
		return $res;
	}
}