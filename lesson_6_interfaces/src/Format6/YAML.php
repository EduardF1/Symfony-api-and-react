<?php

namespace App6\Format6;

class YAML extends BaseFormat implements NamedFormatInterface {
    public function convert(): string
    {
        $result = '';
        foreach ($this->data as $key => $value){
            $result .= $key.': '.$value."\n";
        }
        return htmlspecialchars($result);
    }

    public function getName(): string
    {
       return 'YAML';
    }
}