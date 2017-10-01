<?php

namespace App\Http\Controllers;

use Excel;
use Illuminate\Http\Request;
use App\Models\Post;

/**
 * Various pages for admins
 */
class AdminPagesController extends Controller
{

    /*
     * Index pages that list all admin pages
     *
     * NOTES: This is a first draft of this controller method.
     * It's definitely a little messy and can use some clean up
     * later. 
     *
     * @param $request Request
     */
    public function response_data(Request $request)
    {
        $fields = [
            'post' => [
                'content',
                'tree_id',
                'tree_location',
                'flagged',
                'created_at',
                'updated_at',
                'language',
                'deleted_at'
            ],
            'user' => [
                'email'
            ]
        ];
        $now = new \Datetime();
        $now_stamp = $now->format(\Datetime::ISO8601);
        $query_res = Post::with('user')->get()->all();
        $export = [];

        foreach($query_res as $post){
            $row = [];
            foreach($fields as $grp => $field_g){
                if( $grp === 'user' ){
                    foreach($field_g as $field){
                        $row[$field] = $post->user->$field; 
                    }
                } else {
                    foreach($field_g as $field){
                        $row[$field] = $post->$field; 
                    }
                }
            }
            $export[] = $row;
        }

        $excel = Excel::create('post_dump_' . $now_stamp, function($excel) use($export) {
            $excel->sheet('Sheetname', function($sheet) use($export) {
                $sheet->fromArray($export);
            });
        });

        if( $request->input('type') === 'csv' ){
            $excel->export('csv');
        } elseif( $request->input('type') === 'xls' ){
            $excel->export('xls');
        } else {
            return abort(400, 'Unknown parameter for type');
        }
    }
}
