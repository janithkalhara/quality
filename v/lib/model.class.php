<?php
class Model {

    /**
     *
     * Declaring model object
     * @var object $_model
     */
    protected $_model;

    /**
     *
     * Name of the model
     * @var string $_modelName
     */
    protected $_modelName;

    /**
     *
     * Declaring Request object
     * @var object $_caller
     */
    protected $_caller;

    /**
     *
     * Constructor of the Model object
     */
    function __construct() {
        $this->_model = get_class($this);
        $this->_caller = new Request();
    }

   
}
?>