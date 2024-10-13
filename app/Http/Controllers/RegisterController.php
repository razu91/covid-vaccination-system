<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegistrationRequest;
use App\Services\UserService;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    // Property to hold the instance of UserService
    protected $userService;

    /**
     * Constructor to inject UserService dependency
     *
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display the vaccine registration form
     *
     * This method retrieves the list of vaccine centers and returns
     * the 'user.register' view with the available centers.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $vaccine_centers = $this->userService->registerFormView();
        return view('user.register',compact('vaccine_centers'));
    }

    /**
     * Handle the user registration and store their information.
     *
     * @param \App\Http\Requests\UserRegistrationRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserRegistrationRequest $request)
    {
        $this->userService->registerUserInfo($request);
        return redirect()->route('search.vaccination-status')->with('success','Registration for vaccination successfull');
    }
}
