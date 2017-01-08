<?php

namespace App\Http\Controllers;

use Illuminate\Database\DatabaseManager;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Aws\S3\S3Client;
use DB;	
use App;

class HolidayController extends Controller
{
    //
    public function getHolidayList()
    {
    	$array = array();
    	$array['Status'] = 'OK';
    	$array['HolidayList'] = array();

    	$db = app('db');
    	$holidayDatabase = $db ->connection('content')->getPdo();

    	$stmt = $holidayDatabase->prepare("SELECT a.*, b.category_name, c.type FROM test_holiday_details a INNER JOIN test_holiday_category b ON b.category_id = a.cat_id INNER JOIN test_holiday_type c ON c.type_id = a.ty_id ");
    	$stmt->execute();
    	while($row = $stmt->fetch())
    	{
    		$array['HolidayList'][] = array("HolidayCategory"=>$row['category_name'], "TypeName"=>$row['type'], "HolidayName"=>$row['hol_name'], "StartDate"=>$row['start_date'], "EndDate"=>$row['end_date'],"StartDay"=>$row['start_day'], "EndDay"=>$row['end_day'], "Description"=>$row['hol_desc']);
    	}
    	return json_encode($array);
    }
}
