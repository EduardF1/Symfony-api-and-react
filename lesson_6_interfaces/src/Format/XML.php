<?php

namespace App\Format6;

class XML extends BaseFormat implements NamedFormatInterface {
    public function convert(): string
    {
        $result ='';
        foreach ($this->data as $key => $value){
            $result.='<'.$key.'>'.$value.'</'.$key.'>';
        }

        return htmlspecialchars($result);
    }

    public function getName(): string
    {
        return 'XML';
    }
}