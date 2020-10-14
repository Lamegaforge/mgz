<?php

namespace App\Services;

use Storage;

class MediaService
{
    public function background(?string $name): string
    {
        return $this->get($name, 'background');
    }

    public function vignette(?string $name): string
    {
        return $this->get($name, 'vignette');
    }

    public function all(?string $name): array
    {
        return [
            'background' => $this->background($name),
            'vignette' => $this->vignette($name),
        ];
    }

    protected function get(?string $name, string $type)
    {
        list($path, $placeholder) = $this->paths($name, $type);

        $path = Storage::disk('cards')->has($path)
            ? $path
            : $placeholder;

        return Storage::disk('cards')->url($path);
    }

    protected function paths(?string $name, string $type): array
    {
        return [
            $name . '/' . $type . '.jpg',
            'placeholders/' . $type . '.jpg',
        ];
    }
}
