<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Cashback;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Log\LogManager;
use Illuminate\Support\Facades\DB;
use Illuminate\Log\Monolog\Logger as Monolog;

class CashbackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(
            [
            'lines_inserted' => Cashback::all()->count(),
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data_insertion=[];

        for ($i=0;$i<$request[1]['length'];$i++){

            $data=Cashback::create([
                'page'=>$request[0][$i]['page'], 
                'token'=>$request[0][$i]['token'], 
                'cashback'=>$request[0][$i]['cashback'], 
                'payment_delay'=>$request[0][$i]['payment_delay'], 
                'sale_date'=>$request[0][$i]['sale_date'], 
                'sale_amount'=>$request[0][$i]['sale_amount'], 
                'cashback_rate'=>$request[0][$i]['cashback_rate'], 
                'payment_status'=>$request[0][$i]['payment_status'],
                'first_item'=>$request[0][$i]['first_item'],
                'row_id'=>$request[0][$i]['row_id']
            ]);

            array_push($data_insertion, $data);

        }

        $delete=DB::delete('
        DELETE FROM cashbacks
        WHERE id NOT IN 
            (SELECT * FROM 
                (
                SELECT MAX(id) FROM cashbacks
                GROUP BY cashback,payment_delay,sale_amount,cashback_rate,sale_date
                )tblTemp
            )'
        );

    return response()->json(
        [
        'status' => 'success',
        'lines_inserted' => sizeof($data_insertion),
        'duplicates_removed'=>$delete
        ]);
    
    }

    public function getLastInsert()
    {
        return Cashback::orderBy('sale_date','DESC')->select('sale_date')->first();
    }

    public function cashbacksDate(Request $token)
    {

        DB::connection()->enableQueryLog();

        $data=Cashback::where('token','=',$token)
        // ->take(20)
        // ->select('sale_date')
        ->groupBy(function($val) {
            return Carbon::parse($val->sale_date)->format('m');
        // orderBy('sale_date','DESC')->select('sale_date')->first();
        })->get();

        $queries = DB::getQueryLog();
        
        return compact('data','queries');
    }


    /**
     * test endpoint
     */
    public function test()
    {

         return response()->json(
            [
            'api_status'=>'ok'
            ]);
    }

    /**
     * returns user cashback data based on its token
     */
    public function cashbackUser($token)
    {
        // $data=Cashback::all()
        // // ->where('payment_status','Approuvé')
        // ->where('token','=',$token)
        // // ->take(20)
        // // ->select('sale_date')
        // ->groupBy(function($val) {
        //     return Carbon::parse($val->sale_date)->format('m');
        // // orderBy('sale_date','DESC')->select('sale_date')->first();
        // });
        
         return view('display_forecast_data',compact('token'));
    }

}
