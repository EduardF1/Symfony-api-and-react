<?php
declare(strict_types=1);
namespace App\Format7;

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