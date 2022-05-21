<?php

namespace App\Http\Traits;

trait Utilities
{
    public $response = [];

    public function flashPrompt($status, $message, $data = null)
    {
        return session()->flash('prompt', [
            'status' => $status,
            'message' => $message,
            'data' => $data
        ]);
    }
}
