<?php
/*
 * Base template class.
 */

class Web extends Template{
    /*
     * @param array vars variables needs to render the template.
     * @access protected
     */

    protected $_vars = array();
    
    protected $_comp;
    /*
     * @param string controller The name of the controller
     * @access protected.
     */
    protected $_controller;
    /*
     * @param string action the action name of the controller.
     */
    protected $_action;

    function __construct($comp,$controller, $action) {
    	$this->_comp=$comp;
        $this->_action = $action;
        $this->_controller = $controller;
    }

    /* @return void import javascript and css stuff */

    function importAll() {
        
    	global $store;
    	
    	
        /*
         * importing bootstrap css stuff.
         */
        ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width-device-width,initial-scale=1.0">
    <title>Information Management System | Holcim I&A</title>

    <?
   
     /*
      * import bootstrap javascript stuff.
      */
    
	//Html::importCss("bootstrap");
	Html::importCss("base");
	Html::importCss("bootstrap-needed");
	Html::importCss("jquery-ui-1.9.2.custom");
    Html::importJs("jquery-1.8.2.min");
    //Html::importJs("bootstrap");
    //Html::importJs("bootstrap-dropdown");
    Html::importJs("jquery-ui-1.9.1");
    Html::importJs("base");
     /* 
      * Configurations for java script
      */
     ?>
                <script type="text/javascript">
                    var appServer={"name":"<?php echo APP_BASE_PATH; ?>",
						"appName":'<?php print APP_NAME; ?>'                    };

                </script>

            </head>

            <?php
        }

        function set($value) {

            $this->_vars = $value;
        }

        /*
         * @return void render the template
         */

        function render() {
            $this->importAll();
            /*
             * extracting vars variable to make easy to access
             */
            extract($this->_vars);
            /*
             * initialising the AppTemplate object
             */
            $appTemplate = new AppTemplate($this->_comp,APP_NAME);
            ?>
            <!-- Base container  -->
            <div class="container-fluid">
                <?php
                /*
                 * adding the header bar.
                 */
                $appTemplate->addHeader();
                ?>
                <!-- Inner wrapper  -->
                <div id="inner-container-fluid">
                	<div class="row-fluid">
                	<div id="side-bar">
      				<!--Sidebar content-->
      				 <?php
                    /*
                     * setting the side bar.
                     */
                   
                    if (file_exists(ROOT . DS .  "layouts" . DS . "_sidebar.php")) {
                    	
                        include_once ROOT . DS . "layouts" . DS . "_sidebar.php";
                    }
                    ?>
   				 	</div>
                    <div id="right-container">
                    <div id="breadcrumbs">You are here 
                    <?php $appTemplate->addBreadcrumb();?>
                    
                    </div>
      				<!--Body content-->
      				 <!-- Right pane container contains header,toolbar,content,footer  -->
                    <div id="app-content" class="container">
                        <!-- Header  -->

                        <!-- Tool bar  -->
                        <?php
                        /*
                         * adding tool bar.
                         */

                        $appTemplate->addToolBar($this->_vars, $this->_controller, $this->_action);
                        ?>
                        <!-- Content   -->
                        <?php
                        /*
                         * adding content block.
                         */
                        $appTemplate->addContent($this->_vars, $this->_controller, $this->_action);
                        ?>

                    </div>
    				</div>
                   
                   
					</div>
					
				</div>
                <!-- Footer  -->
                <?php
                /*
                 * adding footer.
                 */
                $appTemplate->addFooter();
                ?>

            </div>
        </body>
        </html>
        <?php
    }

    /*
     * Render the default view of the application.
     * @return void
     */

    public function renderDefault() {
        /*
         * calling parent render to include javascript and css stuff.
         */

        /*
         * getting an instance of AppTemplate class.
         */
        $appTemplate = new AppTemplate(APP_NAME);
        /*
         * setting sidebar menu
         */
        $menu = array(array("manuname" => 'one ', 'menuicon' => 'icon 1', 'menulink' => 'link 1 ', 'menuonclick' => 'dfd'),
            array("manuname" => 'two ', 'menuicon' => 'icon 2', 'menulink' => 'link 2 ', 'menuonclick' => 'd2323232')
        );
        ?>

        <body>


            <!-- Base container  -->
            <div class="container-fluid">
                <!-- Header  -->
                <?php
                /*
                 * adding the header bar.
                 */
                
                $appTemplate->addHeader();
                ?>
                <!-- Inner wrapper  -->
                <div class="row-fluid">
                    <!-- Side bar menu  -->
                    <?php
                    /*
                     * getting the base side bar.
                     */
					
                    $appTemplate->addSideBar($menu);
                    ?>
                    <!-- Right pane container contains header,toolbar,content,footer  -->
                    <div id="app-content" class="container-fluid">


                        <!-- Tool bar  -->
                        <?php
                        /*
                         * adding tool bar.
                         */
                        $appTemplate->addToolBar();
                        ?>
                        <!-- Content  -->
                        <?php
                        /*
                         * adding content block.
                         */
                        $appTemplate->addContent();
                        ?>

                    </div>


                </div>
                <!-- Footer  -->
                <?php
                /*
                 * adding footer.
                 */
                $appTemplate->addFooter();
                ?>


            </div>
        </body>
        </html>

        <?php
    }

}

