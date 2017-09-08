<?php

namespace App\Http\Controllers;

use App\AntMinerLog;
use App\Models\AntMiner;
use Carbon\Carbon;
use Flash;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Kozz\Laravel\Facades\Guzzle;
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
	    $whattomine = null;

    	if(\Auth::user()->hashrate > 1)
	    {
		    $response = null;

		    try{
		    	$response = Guzzle::get('https://whattomine.com/asic.json');
		    } catch (\Exception $e){
				return $e;
		    }

		    if($response)
		    {
			    $reply = json_decode($response->getBody()->getContents(), true);



			    $i = 1;
			    $hashrate_k = \Auth::user()->hashrate / 14;

			    foreach($reply['coins'] as $coin)
			    {
				    if($coin['algorithm'] == 'SHA-256')
				    {
					    $whattomine[$i]['tag'] = $coin['tag'];
					    $whattomine[$i]['btc_revenue'] = round(doubleval($coin['btc_revenue']) * $hashrate_k  , 5) ;
					    $whattomine[$i]['btc_revenue_r'] = round($coin['btc_revenue'],8) ;
					    $whattomine[$i]['profitability'] = $coin['profitability'];
					    $whattomine[$i]['profitability24'] = $coin['profitability24'];

					    $i++;
				    }

			    }

		    }
	    }

    	return view('home')
		    ->with('whattomine',$whattomine)
		    ;
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
