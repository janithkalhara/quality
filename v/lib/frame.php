<?php

/**
 * Row calling function
 */

/**
 *
 * function for convinient php echo function
 *
 * @param string $s
 */
function e($s) {
    echo $s;
}

/**
 *
 * function for convinient php print_r function
 * @param array $a
 */
function p(array $a) {
    print_r($a);
}

/**
 *
 * function for convinient php var_dump function
 * @param array|object $a
 */
function vd($a) {
    print "<pre>";
    var_dump($a);
    print "</pre>";
}

/**
 * Convert stdClass to array
 *
 * @param array $obj stdClass object to convert
 * @param array $fields required property
 * @return array
 */
function stdclass_to_list($obj, $fields, $pivot = " ") {
    $list = array();
    $last_field = end($fields);

    foreach ($obj as $item) {
        $tmp = "";
        foreach ($fields as $field) {
            $tmp .= $item->$field;
            if ($field !== $last_field)
                {
                    $tmp .= $pivot;
                }
        }
        $list[] = $tmp;
    }
    return $list;
}

/**
 *
 * Return the parameter requested in REQUEST array
 * @param string $param
 * @return array|string the requested parameter
 */
function getParam($param) {

    if (isset($_REQUEST[$param])) {

        return $_REQUEST[$param];
    } else {
        return false;
    }
}

/**
 * Return an array is associative or not
 * @param type $arr
 * @return boolean
 */
function isAssoc($arr) {
    return array_keys($arr) !== range(0, count($arr) - 1);
}
