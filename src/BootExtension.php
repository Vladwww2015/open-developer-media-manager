<?php

namespace OpenDeveloper\Developer\Media;

use OpenDeveloper\Developer\Developer;

trait BootExtension
{
    /**
     * {@inheritdoc}
     */
    public static function boot()
    {
        static::registerRoutes();

        Developer::extend('media-manager', __CLASS__);
    }

    /**
     * Register routes for open-developer.
     *
     * @return void
     */
    protected static function registerRoutes()
    {
        parent::routes(function ($router) {
            /* @var \Illuminate\Routing\Router $router */
            $router->get('media', 'OpenDeveloper\Developer\Media\MediaController@index')->name('media-index');
            $router->get('media/download', 'OpenDeveloper\Developer\Media\MediaController@download')->name('media-download');
            $router->delete('media/delete', 'OpenDeveloper\Developer\Media\MediaController@delete')->name('media-delete');
            $router->put('media/move', 'OpenDeveloper\Developer\Media\MediaController@move')->name('media-move');
            $router->post('media/upload', 'OpenDeveloper\Developer\Media\MediaController@upload')->name('media-upload');
            $router->post('media/folder', 'OpenDeveloper\Developer\Media\MediaController@newFolder')->name('media-new-folder');
        });
    }

    /**
     * {@inheritdoc}
     */
    public static function import()
    {
        parent::createMenu('Media manager', 'media', 'icon-file');

        parent::createPermission('Media manager', 'ext.media-manager', 'media*');
    }
}
