<?php

namespace Heedworks\Loggr;

use Heedworks\Loggr\Event;

/**
 * Class FluentEvent
 * @package Heedworks\Loggr
 */
class FluentEvent
{
	/**
	 * @var \Heedworks\Loggr\Event
	 */
	public $Event;

	/**
	 * The Loggr log key
	 *
	 * @var string
	 */
	private $_logKey;

	/**
	 * The Loggr API key
	 *
	 * @var string
	 */
	private $_apiKey;

	/**
	 * @param $logKey
	 * @param $apiKey
	 */
	function __construct($logKey, $apiKey)
	{
		$this->_logKey = $logKey;
		$this->_apiKey = $apiKey;
		$this->Event = new Event();
	}

	/**
	 * @return $this
	 */
	public function Post()
	{
		$client = new LogClient($this->_logKey, $this->_apiKey);
		$client->Post($this->Event);
		return $this;
	}

	/**
	 * @param $text
	 * @return $this
	 */
	public function Text($text)
	{
		$this->Event->Text = $this->AssignWithMacro($text, $this->Event->Text);
		return $this;
	}

	/**
	 * @return $this
	 */
	public function TextF()
	{
		$args = func_get_args();
	    return $this->Text(vsprintf(array_shift($args), array_values($args)));
	}

	/**
	 * @param $text
	 * @return $this
	 */
	public function AddText($text)
	{
		$this->Event->Text .= $this->AssignWithMacro($text, $this->Event->Text);
		return $this;
	}

	/**
	 * @return $this
	 */
	public function AddTextF()
	{
		$args = func_get_args();
	    return $this->AddText(vsprintf(array_shift($args), array_values($args)));
	}

	/**
	 * @param $source
	 * @return $this
	 */
	public function Source($source)
	{
		$this->Event->Source = $this->AssignWithMacro($source, $this->Event->Source);
		return $this;
	}

	/**
	 * @return $this
	 */
	public function SourceF()
	{
		$args = func_get_args();
	    return $this->Source(vsprintf(array_shift($args), array_values($args)));
	}

	/**
	 * @param $user
	 * @return $this
	 */
	public function User($user)
	{
		$this->Event->User = $this->AssignWithMacro($user, $this->Event->User);
		return $this;
	}

	/**
	 * @return $this
	 */
	public function UserF()
	{
		$args = func_get_args();
	    return $this->User(vsprintf(array_shift($args), array_values($args)));
	}

	/**
	 * @param $link
	 * @return $this
	 */
	public function Link($link)
	{
		$this->Event->Link = $this->AssignWithMacro($link, $this->Event->Link);
		return $this;
	}

	/**
	 * @return $this
	 */
	public function LinkF()
	{
		$args = func_get_args();
	    return $this->Link(vsprintf(array_shift($args), array_values($args)));
	}

	/**
	 * @param $data
	 * @return $this
	 */
	public function Data($data)
	{
		$this->Event->Data = $this->AssignWithMacro($data, $this->Event->Data);
		return $this;
	}

	/**
	 * @return $this
	 */
	public function DataF()
	{
		$args = func_get_args();
	    return $this->Data(vsprintf(array_shift($args), array_values($args)));
	}

	/**
	 * @param $data
	 * @return $this
	 */
	public function AddData($data)
	{
		$this->Event->Data .= $this->AssignWithMacro($data, $this->Event->Data);
		return $this;
	}

	/**
	 * @return $this
	 */
	public function AddDataF()
	{
		$args = func_get_args();
	    return $this->AddData(vsprintf(array_shift($args), array_values($args)));
	}

	/**
	 * @param $value
	 * @return $this
	 */
	public function Value($value)
	{
		$this->Event->Value = $value;
		return $this;
	}

	/**
	 * @return $this
	 */
	public function ValueClear()
	{
		$this->Event->Value = "";
		return $this;
	}

	/**
	 * @param $tags
	 * @return $this
	 */
	public function Tags($tags)
	{
		$this->Event->Tags = $tags;
		return $this;
	}

	/**
	 * @param $tags
	 * @return $this
	 */
	public function AddTags($tags)
	{
		$this->Event->Tags .= " " . $tags;
		return $this;
	}

	/**
	 * @param $lat
	 * @param $lon
	 * @return $this
	 */
	public function Geo($lat, $lon)
	{
		$this->Event->Latitude = $lat;
		$this->Event->Longitude = $lon;
		return $this;
	}

	/**
	 * @param $ip
	 * @return $this
	 */
	public function GeoFromIp($ip)
	{
		$this->Event->Ip = $ip;
		return $this;
	}

	/**
	 * @param int $datatype
	 * @return $this
	 */
	public function DataType($datatype)
	{
		$this->Event->DataType = $datatype;
		return $this;
	}

	/**
	 * @return $this
	 */
	public function DataTypeHtml()
	{
		return $this->DataType(DataType::html);
	}

	/**
	 * @return $this
	 */
	public function DataTypePlaintext()
	{
		return $this->DataType(DataType::plaintext);
	}

	/**
	 * @param $input
	 * @param $baseStr
	 * @return mixed
	 */
	private function AssignWithMacro($input, $baseStr)
	{
		return str_replace("$$", $baseStr, $input);
	}
}