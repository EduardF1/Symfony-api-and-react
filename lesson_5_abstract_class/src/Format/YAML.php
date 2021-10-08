<?php

namespace App\Format5;

class YAML extends BaseFormat {
    public function convert(): string
    {
        $result = '';
        foreach ($this->data as $key => $value){
            $result .= $key.': '.$value."\n";
        }
        return htmlspecialchars($result);
    }
}