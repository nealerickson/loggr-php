<?php
namespace Heedworks\Loggr;

use Heedworks\Loggr\FluentEvent;

/**
 * Class Events
 * @package Heedworks\Loggr
 */
class Events
{
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
	}

	/**
	 * @return FluentEvent
	 */
	public function Create()
	{
		return new FluentEvent($this->_logKey, $this->_apiKey);
	}

	/**
	 * @param \Exception $exception
	 * @return $this
	 */
	public function CreateFromException($exception)
	{
		ob_start();
		var_dump($exception->getTrace(), 5);
		$stack = str_replace("\t", "----", str_replace("\n", "<br>", ob_get_clean()));

		$data = "<b>MESSAGE:</b> " . $exception->getMessage() . "<br>";
		$data .= "<b>FILE:</b> " . $exception->getFile() . ", " . $exception->getLine() . "<br>";
		$data .= "<b>CODE:</b> " . get_class($exception) . "<br>";
		$data .= "<br><b>BACK TRACE:</b> " . $this->backtrace();

		return $this->Create()
			->Text($exception->getMessage())
			->Tags("error " . get_class($exception))
			->Data($data)
			->DataType(DataType::html);
	}

	/**
	 * @param $var
	 * @return $this
	 */
	public function CreateFromVariable($var)
	{
		ob_start();
		var_dump($var);
		$trace = str_replace("\t", "----", str_replace("\n", "<br>", ob_get_clean()));

		$data = "<pre>" . $trace . "</pre>";

		return $this->Create()
			->Data($data)
			->DataType(DataType::html);
	}

	/**
	 * @return string
	 */
	protected function backtrace()
	{
	    $output = "<div style='text-align: left; font-family: monospace;'>\n";
	    $backtrace = debug_backtrace();

	    $defaults = array(
	            'class' => '',
	            'type' => '',
	            'function' => '',
	            'line' => '',
	            'file' => ''
	        );

	    foreach ($backtrace as $bt) {
	        $args = '';
	        foreach ($bt['args'] as $a) {
	            if (!empty($args)) {
	                $args .= ', ';
	            }
	            switch (gettype($a)) {
	            case 'integer':
	            case 'double':
	                $args .= $a;
	                break;
	            case 'string':
	                $a = htmlspecialchars(substr($a, 0, 64)).((strlen($a) > 64) ? '...' : '');
	                $args .= "\"$a\"";
	                break;
	            case 'array':
	                $args .= 'Array('.count($a).')';
	                break;
	            case 'object':
	                $args .= 'Object('.get_class($a).')';
	                break;
	            case 'resource':
	                $args .= 'Resource('.strstr($a, '#').')';
	                break;
	            case 'boolean':
	                $args .= $a ? 'True' : 'False';
	                break;
	            case 'NULL':
	                $args .= 'Null';
	                break;
	            default:
	                $args .= 'Unknown';
	            }
	        }


	        $bt += $defaults;

	        $output .= "<br />\n";
	        $output .= "<b>file:</b> {$bt['line']} - {$bt['file']}<br />\n";
	        $output .= "<b>call:</b> {$bt['class']}{$bt['type']}{$bt['function']}($args)<br />\n";
	    }
	    $output .= "</div>\n";
	    return $output;
	}
}