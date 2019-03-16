<?php

namespace App\Http\Controllers;

use App\Model\Admin;
use App\Model\Gym;
use App\Model\ClassModel;
use App\Model\Company;
use App\Model\Book;
use App\Model\Review;
use App\Model\Plan;
use App\Model\Category;
use App\Model\Activity;
use App\Model\Studio;
use App\Model\Location;
use App\Model\BookGym;
use App\Model\Consumer;
use App\Model\Amenity;
use App\Model\CategoryClass;
use App\Model\City;
use App\Model\GymActivity;
use App\Model\GymAmenity;
use App\Model\GymCategory;
use App\Model\GymLocation;
use App\Model\GymStudio;
use App\Model\Payment;
use App\Model\Coupon;
use Illuminate\Http\Request;
use App\Engine\EngineClass;
use App\Engine\AdminEngine;
use App\Http\Controllers\AdminController;

class AdminImageController extends AdminMenuController
{

    public function ajaxUploadCompanyLogo(Request $request)
    {
        $file          = $request->file('uploadLogo');
        $uploadFile    = $file->getPathName();
        $thumbFilename = $this->uploadPicture($uploadFile, $file, "/uploads/company/", "company_");
        $json          = [];
        $json['path']  = $thumbFilename;
        echo json_encode($json);
    }

    public function uploadPicture($uploadFile, $file, $basePath, $pattern)
    {
        $timestamp = time();
        $filename  = "";
        if ($uploadFile != '') {
            $filename = $pattern . $timestamp . "." . $file->getClientOriginalExtension();
        }
        $file->move(public_path().$basePath, $filename);
        $mImgPath      = public_path().$basePath . $filename;
        $thumbFilename = public_path().$basePath . $filename;
        //$this->resizeThumbnailImageAlbum($thumbFilename, $mImgPath);
        return $basePath . $filename;
    }

    public function ajaxUploadGymLogo(Request $request)
    {
        $file          = $request->file('uploadLogo');
        $uploadFile    = $file->getPathName();
        $thumbFilename = $this->uploadPicture($uploadFile, $file, "/uploads/gym/", "gym_");
        $json          = [];
        $json['path']  = $thumbFilename;
        echo json_encode($json);
    }

    public function ajaxUploadGymImage(Request $request)
    {
        $file          = $request->file('uploadImage');
        $uploadFile    = $file->getPathName();
        $thumbFilename = $this->uploadPicture($uploadFile, $file, "/uploads/gym/", "gym_");
        $json          = [];
        $json['path']  = $thumbFilename;
        echo json_encode($json);
    }
    public function resizeThumbnailImageAlbum($thumbPath, $orgImagePath)
    {
        list($imagewidth, $imageheight, $imageType) = getimagesize($orgImagePath);
        $imageType                                  = image_type_to_mime_type($imageType);

        $newImageWidth  = 615;
        $newImageHeight = 283;
        $newImage       = imagecreatetruecolor($newImageWidth, $newImageHeight);
        $source         = $this->engine->createImageFromFormat($imageType, $orgImagePath);
        $rate           = 715.01 / $imagewidth;
        imagecopyresampled(
            $newImage,
            $source,
            0,
            0,
            0,
            0,
            $newImageWidth,
            $newImageHeight,
            $imagewidth,
            (223.0 / ($imageheight * $rate)) * $imageheight
        );
        switch ($imageType) {
            case "image/gif":
                imagegif($newImage, $thumbPath);
                break;
            case "image/pjpeg":
            case "image/jpeg":
            case "image/jpg":
                imagejpeg($newImage, $thumbPath, 90);
                break;
            case "image/png":
            case "image/x-png":
                imagepng($newImage, $thumbPath);
                break;
        }
        chmod($thumbPath, 0777);
        return $thumbPath;
    }
}
