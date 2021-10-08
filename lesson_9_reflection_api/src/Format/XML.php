<?php
declare(strict_types=1);
namespace App\Format9;

class XML extends BaseFormat  {
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