<?php

namespace App\Http\Controllers;

use App\AntMinerLog;
use App\Models\AntMiner;
use Carbon\Carbon;
use Flash;
use Illuminate\Http\Request;
use Validator;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    	$miners = \Auth::user()->miners;

    	$st9 = $miners->where('type','bmminer');
    	$s7 = $miners->where('type','cgminer');

        $chartjs_miners = app()->chartjs
            ->name('MinersType')
            ->type('horizontalBar')
            ->size(['width' => 400, 'height' => 140])
            ->labels(['AntMiner S7', 'AntMiner S9/T9'])
            ->datasets([
                [
                    "label" => "Miners Types",
                    "backgroundColor" => ['rgb(255, 99, 132)', 'rgb(255, 205, 86)'],
                    'data' => [$s7->count(), $st9->count(),0],
                ]
            ]);

        return view('home', compact('chartjs_th','chartjs_miners'));
    }

    public function getProfile()
    {
		return view('profile');
    }

    public function postProfile(Request $request)
    {
	    $messages = [
		    'required' => 'The :attribute field is required.',
		    'chat_id.unique' => 'This telegram chat id is associated with another account.',
	    ];

	    $rules = [
		    'name' => 'required|string|max:255',
		    'email' => 'required|string|email|max:255|unique:users,email,'.\Auth::id(),
		    'chat_id' => 'nullable|integer|unique:users,chat_id,'.\Auth::id(),
		    'password' => 'nullable|string|min:6',
	    ];

	    $this->validate($request, $rules, $messages);

	    $input['name'] = $request->name;
	    $input['email'] = $request->email;
	    $input['chat_id'] = $request->chat_id;

	    if($request->has('password')) $input['password'] = \Hash::make($request->password);

	    \Auth::user()->update($input);

	    Flash::success('Profile updated successfully.');

	    return redirect(route('profile'));

    }
}
