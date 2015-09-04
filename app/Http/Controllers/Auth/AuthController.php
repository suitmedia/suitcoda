<?php

namespace Suitcoda\Http\Controllers\Auth;

use Suitcoda\Model\User;
use Suitcoda\Http\Controllers\Controller;
use Suitcoda\Http\Requests\AuthRequest;

class AuthController extends Controller
{
    protected $loginPath = '/login';

    protected $username = 'username';

    /**
     * Show the application login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogin()
    {
        return view('auth.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  Suitcoda\Http\Requests\AuthRequest  $request
     * @return Illuminate\Http\RedirectResponse
     */
    public function postLogin(AuthRequest $request)
    {
        $credentials = $this->getCredentials($request);
        if (\Auth::attempt($credentials)) {
            return redirect()->route('user.index');
        }

        return redirect($this->loginPath())
            ->withInput($request->only($this->loginUsername()))
            ->withErrors([
                $this->loginUsername() => $this->getFailedLoginMessage(),
            ]);
    }

    /**
     * Get the failed login message.
     *
     * @return string
     */
    protected function getFailedLoginMessage()
    {
        return \Lang::get('auth.failed');
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function getCredentials(AuthRequest $request)
    {
        return $request->only($this->loginUsername(), 'password');
    }

    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogout()
    {
        \Auth::logout();

        return redirect(property_exists($this, 'redirectAfterLogout') ? $this->redirectAfterLogout : '/');
    }

    /**
     * Get the path to the login route.
     *
     * @return string
     */
    public function loginPath()
    {
        return property_exists($this, 'loginPath') ? $this->loginPath : '/auth/login';
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function loginUsername()
    {
        return property_exists($this, 'username') ? $this->username : 'email';
    }
}
