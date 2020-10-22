<?php

namespace App\Services;

use Storage;
use App\Models\User;
use App\Repositories\UserRepository;

class AccountService
{
    public function refreshBanner(User $user, string $slug): void
    {
        $this->deleteOldBanner($user);

        $attributes = [
            'banner_image_slug' => $slug,
        ];

        app(UserRepository::class)->update($attributes, $user->id);
    }

    protected function deleteOldBanner(User $user): void
    {
        if (! $user->banner_image_slug) {
            return;
        }

        Storage::disk('banners')->delete($user->banner_image_slug);
    }
}
