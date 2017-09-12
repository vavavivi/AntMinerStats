<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLocationRequest;
use App\Http\Requests\UpdateLocationRequest;
use App\Models\AntMiner;
use App\Repositories\LocationRepository;
use Illuminate\Http\Request;
use Flash;
use Response;

class LocationController
{
    private $locationRepository;

    public function __construct(LocationRepository $locationRepo)
    {
        $this->locationRepository = $locationRepo;
    }

    public function index()
    {
	    $locations = \Auth::user()->locations;

        return view('locations.index')
            ->with('locations', $locations);
    }

    public function create()
    {
        return view('locations.create');
    }

    public function store(CreateLocationRequest $request)
    {
        $input = $request->all();
        $input['user_id'] = \Auth::id();

        $location = $this->locationRepository->create($input);

        Flash::success('Location saved successfully.');

        return redirect(route('locations.edit', $location->id));
    }

    public function show($id)
    {
        $location = $this->locationRepository->findWithoutFail($id);

        if (empty($location)) {
            Flash::error('Location not found');

            return redirect(route('locations.index'));
        }

        return view('locations.show')->with('location', $location);
    }

    public function edit($id)
    {
        $location = $this->locationRepository->findWithoutFail($id);

        if (empty($location)) {
            Flash::error('Location not found');

            return redirect(route('locations.index'));
        }

        return view('locations.edit')->with('location', $location);
    }

    public function update($id, UpdateLocationRequest $request)
    {
        $location = $this->locationRepository->findWithoutFail($id);

        if (empty($location)) {
            Flash::error('Location not found');

            return redirect(route('locations.index'));
        }

        $location = $this->locationRepository->update($request->all(), $id);

        //return $request->all();

	    if($request->has('miners'))
	    {
	    	foreach($location->miners as $miner)
		    {
		    	$miner->update(['location_id'=>null]);
		    }

		    foreach($request->miners as $miner_id)
		    {
		    	$miner = AntMiner::find($miner_id);

		    	if($miner)
			    {
				    $miner->update(['location_id'=> $location->id]);
			    }
		    }
	    }
	    else
	    {
		    foreach($location->miners as $miner)
		    {
			    $miner->update(['location_id'=>null]);
		    }
	    }

        Flash::success('Location updated successfully.');

	    if($request->has('apply'))
	    {
		    return redirect()->back();
	    }

        return redirect(route('locations.index'));
    }

    public function destroy($id)
    {
        $location = $this->locationRepository->findWithoutFail($id);

        if (empty($location)) {
            Flash::error('Location not found');

            return redirect(route('locations.index'));
        }

	    $location->delete();

        Flash::success('Location deleted successfully.');

        return redirect(route('locations.index'));
    }
}
