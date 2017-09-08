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

		    $client = new Client();

		    $q = [
			    'query' => [
				    'utf8'    => '✓',
				    'sha256f' => 'true',
				    'factor'  => [
					    'sha256_hr' => \Auth::user()->hashrate * 1024,
					    'sha256_p'  => '1400',
					    'cost'      => '0',
					    'exchanges' => [
						    '',
						    'bittrex',
						    'bleutrade',
						    'bter',
						    'c_cex',
						    'cryptopia',
						    'poloniex',
						    'yobit',
					    ],
				    ],
				    'sort'    => 'Profit',
				    'volume'  => '0',
				    'revenue' => '24h',
				    'dataset' => 'Main',
				    'commit'  => 'Calculate',
			    ]
		    ];

		    try{
			    $response = $client->request('GET', 'http://whattomine.com/asic.json', $q);
		    }
		    catch (\Exception $e){

		    }

		    if($response)
		    {
			    $reply = json_decode($response->getBody()->getContents(), true);

			    $whattomine = $reply['coins'];

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
