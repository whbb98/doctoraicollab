<?php

namespace App\Http\Resources\v1;

use Faker\Provider\File;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if (!$this->resource) {
            return [];
        }
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_buffer($finfo, $this->file_data);
        finfo_close($finfo);
        return [
            'name' => $this->file_name,
            'extension' => $this->file_extension,
            'mime' => $mimeType,
            'base64' => "data:$mimeType;base64," . base64_encode($this->file_data)
        ];
    }
}
