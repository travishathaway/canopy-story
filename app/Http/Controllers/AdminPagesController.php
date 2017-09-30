<?php

namespace App\Http\Controllers;

use Excel;
use Illuminate\Http\Request;

/**
 * Various pages for admins
 */
class AdminPagesController extends Controller
{

    /*
     * Index pages that list all admin pages
     */
    public function response_data()
    {
        $data = array(
            array('data1', 'data2'),
            array('data3', 'data4')
        );

        Excel::create('Filename', function($excel) use($data) {

            $excel->sheet('Sheetname', function($sheet) use($data) {

                $sheet->fromArray($data);

            });

        })->export('xls');
    }
}
