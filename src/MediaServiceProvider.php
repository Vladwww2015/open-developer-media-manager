<?php

namespace OpenDeveloper\Developer\Media;

use Illuminate\Support\ServiceProvider;

class MediaServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'open-developer-media');

        MediaManager::boot();
    }
}
