<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Model\GymBase as Gym;

class ImageController extends Controller
{
    public function uploadImage(Request $request)
    {
        $image = $request->file('image');
        $data  = [
            'type'      => $request['type'],
            'entity'    => $request['entity'],
            'entity_id' => $request['entity_id'],
            'fileName'  => create_random_file_name($image->guessClientExtension())
        ];

        $this->moveToUploads($image, $data);
        return redirect()->back();
    }

    public function moveToUploads($image, $data)
    {
        $type     = $data['type'];
        $fileName = $data['fileName'];

        if ($type == 'logo') {
            $image->move(logo_path_real(), $fileName);
            flash(trans('flash.upload.logo_success'), 'success');
        } elseif ($type == 'banner') {
            $image->move(banner_path_real(), $fileName);
            flash(trans('flash.upload.banner_success'), 'success');
        } else {
            $image->move(public_path('uploads/'), $fileName);
            flash(trans('flash.upload.success'), 'success');
        }

        try {
            $this->connectToEntity($data);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex) {
            flash(trans('flash.error.connect_to_entity'), 'danger');
            return redirect()->back();
        }
    }

    public function connectToEntity($data)
    {
        $gym  = Gym::findOrFail($data['entity_id']);
        $type = $data['type'];

        if ($type == 'logo') {
            $gym->logo = $data['fileName'];
        } elseif ($type == 'banner') {
            $gym->image = $data['fileName'];
        }
        $gym->save();
    }
}
