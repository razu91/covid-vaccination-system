<?php

namespace App\Http\Controllers;

use App\Services\VaccinationService;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    // Property to hold the instance of VaccinationService
    protected $vaccinationService;

    /**
     * Constructor to inject the VaccinationService dependency
     *
     * @param VaccinationService $vaccinationService
     */
    public function __construct(VaccinationService $vaccinationService)
    {
        // Assign the injected VaccinationService instance to the property
        $this->vaccinationService = $vaccinationService;
    }

    /**
     * Search for the user's vaccination status based on their NID.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function searchVaccinationStatus(Request $request)
    {

        if($request->has('nid')){
            $nid = $request->query('nid');
            $data = $this->vaccinationService->getUserVaccinationStatus($nid);
        }

        return view('user.search', [
            'status' => $data['status'] ?? null
        ]);
    }
}
