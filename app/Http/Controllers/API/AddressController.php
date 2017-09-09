<?php 

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class AddressController extends APIController
{
    /**
     * Returns a the requested user object
     *
     * @return array
     */
    public function get(Request $request)
    {
        $records = DB::table('portland_addresses')
            ->select('add_full', 'city', 'state_abbr', 'lat', 'lng')
            ->where(
                'add_full', 'like', "{$request->input('q')}%"
            )->limit(10);

        return $records->get();
    }
}

