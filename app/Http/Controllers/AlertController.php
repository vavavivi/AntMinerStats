<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAlertRequest;
use App\Http\Requests\UpdateAlertRequest;
use App\Repositories\AlertRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class AlertController extends AppBaseController
{
    /** @var  AlertRepository */
    private $alertRepository;

    public function __construct(AlertRepository $alertRepo)
    {
        $this->alertRepository = $alertRepo;
    }

    /**
     * Display a listing of the Alert.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $alerts = \Auth::user()->alerts->sortByDesc('id');

        return view('alerts.index')
            ->with('alerts', $alerts);
    }

    /**
     * Show the form for creating a new Alert.
     *
     * @return Response
     */
    public function create()
    {
        return view('alerts.create');
    }

    /**
     * Store a newly created Alert in storage.
     *
     * @param CreateAlertRequest $request
     *
     * @return Response
     */
    public function store(CreateAlertRequest $request)
    {
        $input = $request->all();

        $alert = $this->alertRepository->create($input);

        Flash::success('Alert saved successfully.');

        return redirect(route('alerts.index'));
    }

    /**
     * Display the specified Alert.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $alert = $this->alertRepository->findWithoutFail($id);

        if (empty($alert)) {
            Flash::error('Alert not found');

            return redirect(route('alerts.index'));
        }

        return view('alerts.show')->with('alert', $alert);
    }

    /**
     * Show the form for editing the specified Alert.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $alert = $this->alertRepository->findWithoutFail($id);

        if (empty($alert)) {
            Flash::error('Alert not found');

            return redirect(route('alerts.index'));
        }

        return view('alerts.edit')->with('alert', $alert);
    }

    /**
     * Update the specified Alert in storage.
     *
     * @param  int              $id
     * @param UpdateAlertRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAlertRequest $request)
    {
        $alert = $this->alertRepository->findWithoutFail($id);

        if (empty($alert)) {
            Flash::error('Alert not found');

            return redirect(route('alerts.index'));
        }

        $alert = $this->alertRepository->update($request->all(), $id);

        Flash::success('Alert updated successfully.');

        return redirect(route('alerts.index'));
    }

    /**
     * Remove the specified Alert from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $alert = $this->alertRepository->findWithoutFail($id);

        if (empty($alert)) {
            Flash::error('Alert not found');

            return redirect(route('alerts.index'));
        }

        $this->alertRepository->delete($id);

        Flash::success('Alert deleted successfully.');

        return redirect(route('alerts.index'));
    }

    public function read($id)
    {
	    $alert = $this->alertRepository->findWithoutFail($id);

	    if (empty($alert)) {
		    Flash::error('Alert not found');

		    return redirect(route('alerts.index'));
	    }

	    if($alert->user->id != \Auth::id())
	    {
		    Flash::error('You dont have permissions to mark alert as read');

		    return redirect(route('alerts.index'));
	    }

	    $alert->update([
	    	'status' => 'read'
	    ]);

    	return redirect()->back();
    }
}
