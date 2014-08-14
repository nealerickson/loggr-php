<?php
namespace Heedworks\Loggr;

/**
 * Class Event
 * @package Heedworks\Loggr
 */
class Event
{
	/**
	 * @var mixed
	 */
	public $Text;

	/**
	 * @var mixed
	 */
	public $Source;

	/**
	 * @var mixed
	 */
	public $User;

	/**
	 * @var mixed
	 */
	public $Link;

	/**
	 * @var mixed
	 */
	public $Data;

	/**
	 * @var mixed
	 */
	public $Value;

	/**
	 * @var mixed
	 */
	public $Tags;

	/**
	 * @var mixed
	 */
	public $Latitude;

	/**
	 * @var mixed
	 */
	public $Longitude;

	/**
	 * @var mixed
	 */
	public $Ip;

	/**
	 * @var int
	 */
	public $DataType = DataType::plaintext;
}