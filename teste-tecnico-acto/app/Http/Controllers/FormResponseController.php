<?php

namespace App\Http\Controllers;

use App\Models\FormResponse;
use Illuminate\Support\Facades\Auth;

class FormResponseController extends Controller
{
    public function index()
    {
        $responses = FormResponse::where('user_id', Auth::id())->latest()->paginate(10);
        return view('responses.index', compact('responses'));
    }

    public function show(FormResponse $response)
    {
        abort_unless($response->user_id === Auth::id(), 403);
        return view('responses.show', compact('response'));
    }
}
