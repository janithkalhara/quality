<?php

/*
 * Base template class.
 */

class Ajax extends Template {

    /*
     * @return void render the template 
     */

    function render() {
        header("Content-type:application/json");
        echo json_encode($this->_vars);
    }

}

