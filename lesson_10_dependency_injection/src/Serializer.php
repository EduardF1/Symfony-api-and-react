<?php

<<<<<<< HEAD
namespace App10;

use App10\Format10\FormatInterface;
=======
namespace App;

use App\Format10\FormatInterface;
>>>>>>> 02e56e2cfc3bd91abf260ecf8facff9ec0fb0d16

class Serializer
{
    private $format;

    public function __construct(FormatInterface $format){
        $this->format = $format;
    }

    public function serialize($data): string {
        $this->format->setData($data);
        return $this->format->convert();
    }
}