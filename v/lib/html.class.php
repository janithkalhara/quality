<?php

class Html {
	/*
	 *
	 */

	public function __construct() {

	}

	/**
	 * javascript importing function.Here, place parameter should be set if calling to base
	 * layout javascripts.if calling to application js file that'd not be needed.null is sufficient.
	 * b=> refers base layout
	 *
	 * @param string $name Name of the javascript file .
	 * @param string $place Place of the javascript file
	 */
	public static function importJs($name, $place = null) {

		/* if path is set .. */
		if ($place != null) {
			/* place parameter is set. */

			if ($place == "b") {
				/* calling to base javascript stuffs */

				$str = "<script type='text/javascript' src='" . APP_BASE_PATH . "layouts" . DS . "js" . DS . $name . ".js'></script>";
				print  $str;
			} else {
				/*
				 * at the moment param is only availabale for b=> base inclusions.In future more routings
				 * can be added.
				 */
			}
		} else {
			/* Calling to application javascript stuffs */

			$str = "<script type='text/javascript' src='"  . "public" . DS . "js" . DS . $name . ".js'></script>";
			print $str;
		}
	}

	/**
	 * css importing function.Here, place parameter should be set if calling to base
	 * layout css stuff.if calling to application css file that'd not be needed.null is sufficient.
	 * b=> refers base layout
	 *
	 * @param string $name Name of the css file .
	 * @param string $place Place of the css file
	 */
	public static function importCss($name, $place = null) {

		/* if path is set .. */
		if ($place != null) {
			/* place parameter is set. */
			if ($place == "b") {
				/* calling to base css stuffs */
				$str = "<link type='text/css' href='" . APP_BASE_PATH . "layouts" . DS . "css" . DS . $name . ".css' rel='stylesheet'>\n";
				print  $str;
			} else {
				/*
				 * at the moment param is only availabale for b => base inclusions.In future more routings
				 * can be added.
				 */
			}
		} else {
			/* Calling to application css stuffs */

			$str = "<link type='text/css' href='" . "public" . DS . "css" . DS . $name . ".css' rel='stylesheet'>";
			print  $str;
		}
	}

	

	/**
	 * generate html for button
	 *
	 * @param string $link absolute link to location
	 * @param string $text Displayed link
	 * @param string $classes optional css class string
	 * @return void
	 */
	public static function a_button($options)
	{
		$link_string = '<a type="button" class="btn ';
		if (isset($options['class']))
		{
			$link_string .= $options['class'];
		}
		$link_string .= '" ';
		if (isset($options['title']))
		{
			$link_string .= 'title="' . $options['title'] .'" ';
		}
		$link_string .= 'href="' . $options['link'] . '">' . $options['text'] . '</a>';
		echo $link_string;
	}

	/**
	 * generate html for button
	 *
	 * @param string $link absolute link to location
	 * @param string $text Displayed link
	 * @param string $class optional css class string
	 * @return void
	 */
	public static function button($options)
	{
		$btn_string = '<button type="button" class="btn ';
		if (isset($options['class']))
		{
			$btn_string .= $options['class'];
		}
		$btn_string .= '" ';
		if (isset($options['title']))
		{
			$btn_string .= 'title="' . $options['title'] .'" ';
		}
		$btn_string .=  ">{$options['text']}</button>";
		echo $btn_string;
	}

	/**
	 * generate html for select
	 *
	 * @param array $options ey value pairs for options
	 * @param string $id id of the select
	 * @return void
	 */
	public static function select($options, $id, $selected = NULL)
	{
		if ($selected === NULL)
		{
			$keys = array_keys($options);
			$selected = $keys[0];
		}

		echo "<select id=\"$id\">";
		foreach ($options as $key => $value) {
			if ($key !== $selected)
			{
				echo "<option value=\"$key\" >$value</option>";
			}
			else
			{
				echo "<option value=\"$key\" selected=\"selected\">$value</option>";
			}
		}
		echo "</select>";
	}

	/**
	 * generate html for select
	 *
	 * @param array $options ey value pairs for options
	 * @param string $id id of the select
	 *
	 * @return void
	 */
	public static function pageHeader($title, $subtitle = NULL) {
		echo '<div class="page-header">';
		if ($subtitle === NULL)
		{
			echo "<h3>$title</h3>";
		}
		else
		{
			echo "<h3>$title <small>$subtitle</small><h3>";
		}

		echo '</div>';
	}

	public static function getFormInstance($id, $path) {
		$form = new FormHelper($id, $path);
		if ($form) {
			return $form;
		} else {
			return false;
		}
	}

	/**
	 * Embed the PDF data returned from sendPDF method
	 * @param string $controller controller name
	 * @param string $action method name in the controller
	 * @return void
	 */
	public static function embedPDF($id, $controller, $action) {

		$pdfurl = APP_BASE_PATH . APP_NAME . '/' . $controller . '/' . $action;
		echo "<embed id='$id' src='$pdfurl' type='application/pdf' style='width: 100%;height: 600px;' />";
	}

	/**
	 * Create a dropdown list
	 *
	 * @param string $title Dropdown title
	 * @param array $items html item to be put in menu
	 * @return void
	 */
	public function dropdown ($title_element, $items)
	{
		echo <<<TOP
            <div class="btn-group">
            $title_element
              <button class="btn dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
              <ul class="dropdown-menu">
TOP;
            foreach ($items as $item)
            {
            	echo "<li>" . $item . "</li>";
            }

            echo <<<BOTTOM
               </ul>
            </div>
BOTTOM;
	}
	public static function table ($data,$headers=null,$class="",$title=""){
		$class="table ".$class;
		$str="";
		$keyFlag;
		$keys=array();
		$headerString="";
		//setting header array
		if(isAssoc($headers)){
			$keyFlag=false;
			foreach ($headers as $key=>$value){

				if(isset($value)){
					$headerString.="<th>".$key."</th>";
					array_push($keys, $value);

				}
			}


		}else{
			$keys=range(0, count($headers)-1);
			//setting the header
			$headerString="<th>".implode("</th><th>", $headers)."</th>";
		}
		//generating the table 
		$tableString="<table class='$class'>";
		$tableString.="<tr>".$headerString."</tr>";
		//getting the body
		$tableString.=self::getTableBody($data, $keys);
		$tableString.="</table>";
		
		print $tableString;
	}

	private static function getTableBody($data,$keys){
		
		//for($i=0;$i<count($data)){}
		
		
	
	}

}
