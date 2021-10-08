<?php

namespace App4\Format4;

class XML extends BaseFormat {
    public function convert(): string
    {
        $result ='';
        foreach ($this->data as $key => $value){
            $result.='<'.$key.'>'.$value.'</'.$key.'>';
        }

        return htmlspecialchars($result);
    }
}