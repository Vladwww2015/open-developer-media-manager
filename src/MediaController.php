<?php

namespace OpenDeveloper\Developer\Media;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use OpenDeveloper\Developer\Facades\Developer;
use OpenDeveloper\Developer\Layout\Content;

class MediaController extends Controller
{
    public function index(Request $request)
    {
        return Developer::content(function (Content $content) use ($request) {
            $path = $request->get('path', '/');
            $view = $request->get('view', 'table');
            $select = $request->get('select', false);
            $close = $request->get('close', false);
            $fn = $request->get('fn', 'selectFile');

            $manager = new MediaManager($path);
            $manager->select_fn = $fn;

            $content->header('Media manager');
            $content->body(view("open-developer-media::$view", [
                'list'      => $manager->ls(),
                'view'      => $view,
                'nav'       => $manager->navigation(),
                'url'       => $manager->urls(),
                'close'     => $close,
                'select'    => $select,
                'fn'        => $fn,
            ]));

            if ($select) {
                $content->addBodyClass('hide-nav');
            }
        });
    }

    public function download(Request $request)
    {
        $file = $request->get('file');

        $manager = new MediaManager($file);

        return $manager->download();
    }

    public function upload(Request $request)
    {
        $files = $request->file('files');
        $dir = $request->get('dir', '/');

        $manager = new MediaManager($dir);

        try {
            if ($manager->upload($files)) {
                developer_toastr(trans('developer.upload_succeeded'));
            }
        } catch (\Exception $e) {
            developer_toastr($e->getMessage(), 'error');
        }

        return back();
    }

    public function delete(Request $request)
    {
        $files = $request->json('files');
        $manager = new MediaManager();

        try {
            if ($manager->delete($files)) {
                return response()->json([
                    'status'  => true,
                    'message' => trans('developer.delete_succeeded'),
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status'  => true,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function move(Request $request)
    {
        $path = $request->get('path');
        $new = $request->get('new');

        $manager = new MediaManager($path);

        try {
            if ($manager->move($new)) {
                return response()->json([
                    'status'  => true,
                    'message' => trans('developer.move_succeeded'),
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status'  => true,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function newFolder(Request $request)
    {
        $dir = $request->get('dir');
        $name = $request->get('name');

        $manager = new MediaManager($dir);

        try {
            if ($manager->newFolder($name)) {
                return response()->json([
                    'status'  => true,
                    'message' => trans('developer.move_succeeded'),
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status'  => true,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
