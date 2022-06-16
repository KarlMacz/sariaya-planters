<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Traits\Utilities;

use App\Message;
use App\Order;
use App\PhBarangay;
use App\PhMunicipality;
use App\PhProvince;
use App\User;

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

    public function fetchMessages(Request $request)
    {
        $sent_by = base64_decode($request->input('sent_by'));
        $sent_to = base64_decode($request->input('sent_to'));

        $user = User::where('id', $sent_by)
            ->orWhere('id', $sent_to)
            ->first();
        $messages = Message::where(function($query) use ($sent_by, $sent_to) {
                $query->where('sent_by', $sent_by)
                    ->where('sent_to', $sent_to);
            })
            ->orWhere(function($query) use ($sent_by, $sent_to) {
                $query->where('sent_by', $sent_to)
                    ->where('sent_to', $sent_by);
            })
            ->orderBy('created_at')
            ->get();

        $this->response['status'] = 'ok';
        $this->response['message'] = $messages->count() . ' record(s) retrieved.';
        $this->response['data'] = [
            'user' => $user,
            'messages' => $messages
        ];

        return response()->json($this->response);
    }

    public function sendMessage(Request $request)
    {
        $sent_by = base64_decode($request->input('sent_by'));
        $sent_to = base64_decode($request->input('sent_to'));
        $message = $request->input('message');

        $messaging = new Message;

        $messaging->sent_by = $sent_by;
        $messaging->sent_to = $sent_to;
        $messaging->message = $message;

        if($messaging->save()) {
            $this->response['status'] = 'ok';
            $this->response['message'] = 'Message sent.';
        } else {
            $this->response['status'] = 'error';
            $this->response['message'] = 'Failed to send message.';
        }

        return response()->json($this->response);
    }
}
