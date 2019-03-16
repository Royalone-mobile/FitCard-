<?php

namespace App\Engine;

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

class BaseEngine
{

    use \Illuminate\Foundation\Bus\DispatchesJobs;



    public function __construct()
    {
    }
    public function generatePdf()
    {
        $companyInfos = Company::all();
        $now          = new \DateTime();
        $now->setTimezone(new \DateTimeZone('Europe/Helsinki'));
        $currentDate = $now->format('d/m/Y');
        $month       = $now->format('M');

        $firstDay = new \DateTime('first day of this month');
        $lastDay  = new \DateTime('last day of this month');

        foreach ($companyInfos as $companyInfo) {
            $sum         = 0;
            $countVisit  = 0;
            $countBook   = 0;
            $gymInfos    = Gym::where('company', $companyInfo->id)->get();
            $serviceHtml = "";
            foreach ($gymInfos as $gymInfo) {
                $classes     = ClassModel::where('gym', $gymInfo->id)->get();
                $visits      = BookGym::with('gym')->where('gym_id', $gymInfo->id)
                ->whereBetween('date', [$firstDay->format('Y-m-d'), $lastDay->format('Y-m-d')])->get();
                $countVisit += count($visits);
                foreach ($visits as $visit) {
                    $serviceHtml = $serviceHtml."<tr><td>";
                    $bookTime    = \DateTime::createFromFormat('Y-m-d H:i:s', $visit->date);
                    $serviceHtml = $serviceHtml.$bookTime->format('d/m/Y-H:i')."</td>";
                    $serviceHtml = $serviceHtml."<td>".$visit->gym->name."</td></tr>";
                }
                foreach ($classes as $classItem) {
                    $books      = Book::where('class_id', $classItem->id)
                    ->whereBetween('date', [$firstDay->format('Y-m-d'), $lastDay->format('Y-m-d')])->get();
                    $countBook += count($books);
                    foreach ($books as $book) {
                        $serviceHtml = $serviceHtml."<tr><td 'width:200px;' >";
                        $bookTime    = \DateTime::createFromFormat('Y-m-d', $book->date);
                        $serviceHtml = $serviceHtml.$bookTime->format('d/m/Y').$book->classModel->starthour."</td>";
                        $serviceHtml = $serviceHtml."<td>".$book->classModel->name."</td></tr>";
                    }
                }
            }
            $sum  = 5 * $countBook + 5 * $countVisit;
            $vat1 = 0;
            $vat2 = 0;
            if ($sum > 0) {
                $vat1 = (float)$sum / 1.1;
                $vat2 = $sum - $vat1;

                $vat1 = number_format((float) $vat1, 2, '.', '');
                $vat2 = number_format((float) $vat2, 2, '.', '');
            }


            $html = "<html><style>.subTitle{
                  		font-size:16px;
                  		font-style:bold;
                  	}label,td
                  	{
                  		font-size:14px;
                  	}
                    </style><body><img src='images/logo1.png'/><br><br><br>
          <div>
            <label>Internet Group Finland Oy Oy (2655898-5)</label>
          	<label style='margin-left:118px;'> Date:".$currentDate."</label>
          </div>
          <div>
  	         <label>Henry Fordin katu 6A 00150 Helsinki</label>
  	         <label style='margin-left:150px;'> Invoice number:".$now->getTimestamp().$companyInfo->id."</label>
          </div>
          <br><br><br>
          <div>
  	         <label class='subTitle'><b>Customer</b></label>
  	         <br>
  	         <label>".$companyInfo->name."-".$companyInfo->vat."</label>
  	         <br>
  	         <label>".$companyInfo->country." "
             .$companyInfo->city." ".$companyInfo->location."</label>
  	         <br>
  	         <label>".$companyInfo->zipcode."</label>
          </div>
          <br>
          <div>
  	          <label class='subTitle'><b>Payment report: ".$month."</b></label>
  	          <br>
  	          <label>Number of bookings: <u>".$countBook."</u></label>
  	          <br>
  	          <label>Number of visits: <u>".$countVisit."</u></label>
  	          <br>
              <label>Payable sum vat: <u>".$vat1."€</u></label>
  	          <br>
              <label>Payable sum vat: <u>".$vat2."€</u></label>
  	          <br>
              <label>Total payment: <u>".$sum."€</u></label>
  	          <br>
  	          <label>Payment bank account: <u>".$companyInfo->bank."</u></label>
          </div>
          <br>
          <div>
  	         <table>";

            $html = $html.$serviceHtml.
            "</table>
  	<br>
  	<label style='width:3700px;'>If there is anyhting unclear about the payment
    please contact our customer support 045 146 3755 tai info@fitcard.fi</label>
  </div>
  </body>
  </html>";
            \PDF::loadHTML($html)->setPaper('b5', 'portrait')->setWarnings(false)
            ->save(public_path()."/uploads/"."Company_".$companyInfo->id."_".$month.".pdf");
            $this->dispatch(new \App\Jobs\SendEmail(['message' => "Invoice",
            'email' => $companyInfo->email, 'title' => "Invoice",
            'content' => "",'attach'=>"/uploads/Company_".$companyInfo->id."_".$month.".pdf"]));
        }
    }
    public function setUploadFile($uploadFile, $fName, $basePath)
    {
        //$timestamp = time();
        $tmpName  = $uploadFile->getPathName();
        $filename = "";
        if ($tmpName != '') {
            $filename = $fName. ".".$uploadFile->getClientOriginalExtension();
            $tmpName  = $uploadFile->getPathName();
        }
        $imgPath = public_path().$basePath . $filename;
        $uploadFile->move(public_path().$basePath, $filename);
        $thumbFilename = public_path().$basePath . $filename;
        $this->resizeThumbnailImageAlbum($thumbFilename, $imgPath);
        return $basePath . $filename;
    }
    public function createImageFromFormat($imageType, $orgImagepath)
    {
        switch ($imageType) {
            case "image/gif":
                $source = imagecreatefromgif($orgImagepath);
                break;
            case "image/pjpeg":
            case "image/jpeg":
            case "image/jpg":
                $source = imagecreatefromjpeg($orgImagepath);
                break;
            case "image/png":
            case "image/x-png":
                $source = imagecreatefrompng($orgImagepath);
                break;
        }
        return $source;
    }
    public function resizeThumbnailImageAlbum($thumbPath, $orgImagePath)
    {
        list($imagewidth, $imageheight, $imageType) = getimagesize($orgImagePath);
        $imageType                                  = image_type_to_mime_type($imageType);

        $newImageWidth  = 200;
        $newImageHeight = 200;
        $newImage       = imagecreatetruecolor($newImageWidth, $newImageHeight);
        $source         = $this->createImageFromFormat($imageType, $orgImagePath);

        imagecopyresampled($newImage, $source, 0, 0, 0, 0, $newImageWidth, $newImageHeight, $imagewidth, $imageheight);
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
