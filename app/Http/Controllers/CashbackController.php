<?php

namespace App\Http\Controllers;

use App\Models\Cashback;
use Illuminate\Http\Request;
use Illuminate\Log\LogManager;
use Carbon\Carbon;
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

    public function getLastInsert()
    {
        return Cashback::orderBy('sale_date','DESC')->select('sale_date')->first();
    }

    public function cashbacksDate()
    {
        $data=Cashback::all()
        // ->where('payment_status','Approuvé')
        // ->where('page','>','110')
        // ->take(20)
        // ->select('sale_date')
        ->groupBy(function($val) {
            return Carbon::parse($val->sale_date)->format('m');
        // orderBy('sale_date','DESC')->select('sale_date')->first();
        });
        // return response()->json(
        //     [
        //     'val' => 'test',
        //     ]);
        
        return $data;
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

    return response()->json(
        [
        'status' => 'success',
        'lines_inserted' => sizeof($data_insertion),
        ]);
    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}