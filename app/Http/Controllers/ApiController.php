<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Traits\Utilities;

use App\PhBarangay;
use App\PhMunicipality;
use App\PhProvince;
use App\Order;

class ApiController extends Controller
{
    use Utilities;

    public function fetchProvinces(Request $request)
    {
        $provinces = PhProvince::all();

        if($provinces->count() > 0) {
            $this->response['status'] = 'ok';
            $this->response['message'] = $provinces->count() . ' record(s) retrieved.';
            $this->response['data'] = $provinces;
        } else {
            $this->response['status'] = 'error';
            $this->response['message'] = 'Failed to retrieve provinces.';
        }

        return response()->json($this->response);
    }

    public function fetchMunicipalities(Request $request)
    {
        $ph_province_id = $request->input('ph_province_id');

        $municipalities = PhMunicipality::where('ph_province_id', $ph_province_id)->get();

        if($municipalities->count() > 0) {
            $this->response['status'] = 'ok';
            $this->response['message'] = $municipalities->count() . ' record(s) retrieved.';
            $this->response['data'] = $municipalities;
        } else {
            $this->response['status'] = 'error';
            $this->response['message'] = 'Failed to retrieve municipalities.';
        }

        return response()->json($this->response);
    }

    public function fetchBarangays(Request $request)
    {
        $ph_municipality_id = $request->input('ph_municipality_id');

        $barangays = PhBarangay::where('ph_municipality_id', $ph_municipality_id)->get();

        if($barangays->count() > 0) {
            $this->response['status'] = 'ok';
            $this->response['message'] = $barangays->count() . ' record(s) retrieved.';
            $this->response['data'] = $barangays;
        } else {
            $this->response['status'] = 'error';
            $this->response['message'] = 'Failed to retrieve barangays.';
        }

        return response()->json($this->response);
    }

    public function fetchNotifications(Request $request)
    {
        $user_id = base64_decode($request->input('id'));

        $pending_orders = Order::where('status', 'PENDING')
            ->get();
        $processing_orders = Order::where('status', 'PROCESSING')
            ->get();
        $delivering_orders = Order::where('status', 'DELIVERING')
            ->get();
        $completed_orders = Order::where('status', 'COMPLETED')
            ->get();

        $this->response['status'] = 'ok';
        $this->response['message'] = 'Records retrieved.';
        $this->response['data'] = [
            'pending_orders_count' => $pending_orders->count(),
            'processing_orders_count' => $processing_orders->count(),
            'delivering_orders_count' => $delivering_orders->count(),
            'completed_orders_count' => $completed_orders->count()
        ];

        return response()->json($this->response);
    }
}
