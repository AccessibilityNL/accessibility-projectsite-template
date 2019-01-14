<?php

class template
{
  private $dir = '';
  private $vars = array();

  public function __construct($_dir = TEMPLATE_DIR)
  {
    $this->dir = $_dir;
  }

  public function show($file, $returnOutput = false)
  {
    $result = false;

    // declare set variables
    foreach($this->vars as $_var => $_value)
    {
      $$_var = $_value;
    }

    $_file = $this->dir . '/' . $file . '.php';
    if(file_exists($_file))
    {
      if($returnOutput)
      {
        ob_start();
        include($_file);
        $result = ob_get_contents();
        ob_end_clean();
      }
      else
      {
        include($_file);
        $result = true;
      }
    }

    return $result;
  }

  public function set($name, $variable)
  {
    $this->vars[$name] = $variable;
  }

  private function get($name)
  {
    if(isset($this->vars[$name]))
    {
      return $this->vars[$name];
    }
    else
    {
      return false;
    }
  }

  private function truncate($string, $length = 24)
  {
    return (strlen($string) > $length)
      ? substr($string, 0, floor($length*0.5))
          .'...'
          .substr($string, strlen($string) - floor($length*0.5))
      : $string;
  }

	private function clamp($current, $min, $max)
	{
    return max($min, min($max, $current));
	}

	private function hrFilesize($bytes)
	{
		if ($bytes == 0)
		{
			return "0.00 B";
		}

    $s = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
    $e = floor(log($bytes, 1024));

    return round($bytes/pow(1024, $e), 2).' '.$s[$e];
	}
}

?>
