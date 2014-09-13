<?php
namespace library\App;

/**
 * Layout system implementation.
 * 
 * @author Bogdan Ghervan <bogdan.ghervan@gmail.com>
 */
class Layout extends View
{
	/**
	 * Layout file relative to the templates path.
	 * 
	 * @var string
	 */
	protected $_layoutFile = 'layout.phtml';
	
	/**
	 * JavaScript variables registry.
	 * 
	 * @var array
	 */
	protected $_vars = array();
	
	/**
	 * Renders template and injects it to the layout file.
	 * 
	 * @param string $template
	 * @param array $data
	 * @return string
	 */
	public function render($template, $data = null)
	{
		$viewContent = parent::render($template, $data);
		
		return parent::render($this->_layoutFile, array(
			'content' => $viewContent,
			'vars'	  => $this->_getVarsForOutput()
		));
	}
	
	/**
	 * Push variable $name to JavaScript.
	 * 
	 * @param string $name
	 * @param mixed $value
	 * @return \library\Extra\Layout
	 */
	public function appendVar($name, $value)
	{
		$this->_vars[$name] = $value;
		return $this;
	}
	
	/**
	 * Returns aggregated variables to send to JavaScript, with values encoded in JSON.
	 * 
	 * @return string
	 */
	protected function _getVarsForOutput()
	{
		$output = array();
		foreach ($this->_vars as $name => $value) {
			$output[] = sprintf('%s = %s', $name, json_encode($value));
		}
		
		return $output ? sprintf('var %s;', implode(', ', $output)) : null;
	}
}