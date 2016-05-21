<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Str;
use Illuminate\Support\MessageBag;
use Validator, Session, Redirect;
use App\Models\Pricing;
use App\Models\Payment;

class PricingController extends AdminController
{
    function index(){
        $result = Pricing::all();
        $plans = [
            30 => '1 tháng',
            60 => '2 tháng',
            90 => '3 tháng',
            180 => '6 tháng',
            270 => '9 tháng',
            365 => '1 năm',
        ];
        return view('admin.pricing.index', compact('result', 'plans'));
    }

    function store(Request $request){
        $data = $request->all();
        $validator = Validator::make($data, [
            'title' => 'required'
        ]);
        if ($validator->fails())
        {
            $this->throwValidationException(
                $request, $validator
            );
            return Redirect::back()->withInput()->withErrors($validator);
        }
        foreach ($data['title'] as $key => $value) {
            if($value != ''){
                if(isset($data['id'][$key])){
                    $pricing = Pricing::find($data['id'][$key]);
                    $pricing->title = $data['title'][$key];
                    $pricing->price = json_encode($data['price'][$key]);
                    $pricing->status = isset($data['status'][$key])? $data['status'][$key]: NULL;
                    $pricing->save();
                }else{
                    $pricing = Pricing::create([
                            'title' => $data['title'][$key],
                            'price' => json_encode($data['price'][$key])
                        ]);
                }
            }
        }
        Session::flash('message', 'OK!');
        return Redirect::route('backend_pricing');
    }

    function nganluong(){
        $result = Payment::where('slug', 'ngan-luong')->first();
        if(is_null($result)){
            $result = Payment::create([
                    'slug' => 'ngan-luong',
                    'status' => 1,
                    'data' => json_encode([
                            'MERCHANT_ID' => '',
                            'MERCHANT_PASS' => '',
                            'RECEIVER' => ''
                            ])
                ]);
        }
        return view('admin.pricing.nganluong', compact('result'));
    }

    function update_nganluong(Request $request){
        $data = $request->all();
        $validator = Validator::make($data, [
            'MERCHANT_ID' => 'required',
            'MERCHANT_PASS' => 'required',
            'RECEIVER' => 'required'
        ]);
        if ($validator->fails())
        {
            $this->throwValidationException(
                $request, $validator
            );
            return Redirect::back()->withInput()->withErrors($validator);
        }
        unset($data['_token']);
        $result = Payment::where('slug', 'ngan-luong')->first();
        $result->data = json_encode($data);
        $result->save();
        return Redirect::route('backend_ngan_luong');
    }

    function delete($id){
        $result = Pricing::find($id);
        $result->delete();
        Session::flash('message', 'deleted!');
        return Redirect::back();
    }
}
