<?php

namespace App2\Format2;

class JSON
{
    // example of a constant declaration (by default, all constants are public)
    // constants can also be declared as private
    const DATA = [
        "success" => true
    ];
    // example of a field
    public $data;

    // example of a constructor
    public function __construct($data)
    {
        $this->data = $data;
    }

    // function to return the JSON encoding of $data
    // array_merge() - merge arrays into a new one
    // self::constantName - way of accessing constants
    public function convert()
    {
        return json_encode(
            array_merge(
                self::DATA,
                $this->data
            )
        );
    }

    public static function convertData(){
        return json_encode(self::DATA);
    }
}