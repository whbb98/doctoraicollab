<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Base64Format extends Model
{
    use HasFactory;

    private $base64;
    private $mime;
    private $extension;
    private $name;

    function __construct($binary, $fname, $fextension)
    {
        if (!$binary) return null;

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_buffer($finfo, $binary);
        finfo_close($finfo);
        $this->name = $this->$fname;
        $this->extension = $this->$fextension;
        $this->mime = $mimeType;
        $this->base64 = "data:$mimeType;base64," . base64_encode($binary);
    }

    public function getBase64(): string
    {
        return $this->base64;
    }

    public function getMime(): string
    {
        return $this->mime;
    }

    public function getExtension(): string
    {
        return $this->extension;
    }

    public function getName(): string
    {
        return $this->name;
    }


}
