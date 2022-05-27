<?php

function isEmpty($arr)
{
    if (
        $arr == '' ||
        $arr == null ||
        $arr ==  [] ||
        $arr == ""
    ) {
        return true;
    }
    return false;
}

function isMatch($arr, $val)
{
    return strpos($arr, $val) === false ? false : true;
}

function extractValues($events)
{
    return array_values(($events->toArray()));
}

function get_storage_file($path)
{
    return json_decode(file_get_contents(storage_path() . $path), true);
}
