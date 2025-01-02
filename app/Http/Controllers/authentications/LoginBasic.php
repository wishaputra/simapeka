<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use App\Models\Login_user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\User;

class LoginBasic extends Controller
{
    public function index()
    {
        $pageConfigs = ['myLayout' => 'blank'];
        return view('content.authentications.auth-login-basic', ['pageConfigs' => $pageConfigs]);
    }

    public function login(Request $request)
    {
        // Validate the input fields, including the reCAPTCHA response
        $credentials = $request->validate([
            'nip' => ['required', 'string'],
            'password' => ['required', 'string'],
            'g-recaptcha-response' => 'required' // Ensure reCAPTCHA is submitted
        ]);

        // Verify reCAPTCHA
        $recaptchaResponse = $request->input('g-recaptcha-response');
        $recaptchaSecret = config('services.recaptcha.secret'); // Fetch secret from config
        $recaptchaValidation = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => $recaptchaSecret,
            'response' => $recaptchaResponse,
            'remoteip' => $request->ip()
        ]);

        $recaptchaResult = $recaptchaValidation->json();

        if (!$recaptchaResult['success']) {
            return back()->withErrors([
                'captcha' => 'Invalid reCAPTCHA. Please try again.'
            ]);
        }

        // Proceed with API login
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://lasik.tangerangselatankota.go.id/simpeg/api/mlogin',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 't=77e1d2839fac5163b28849846209b174701846f8&u='.$credentials['nip'].'&p='.$credentials['password'],
            CURLOPT_HTTPHEADER => [
                'Cache-Control: no-cache',
                'Content-Type: application/x-www-form-urlencoded',
                'Cookie: _ga_51MP36=a3fvala8qdcf8ah6nf8q0ncfb5'
            ],
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        // Decode the JSON response
        $responseData = json_decode($response, true);

        // Check if the API response indicates a successful login
        if (isset($responseData['status']) && $responseData['status'] == 1) {
            // Get user data from the API response
            $userData = $responseData['data'];

            Login_user::create([
                'login' => json_encode($responseData) // Save the entire JSON response
            ]);

            // Find the user in your local database
            $user = User::where('nip', $credentials['nip'])->first();

            // If the user exists locally, log them in
            if ($user) {
                Auth::login($user, $request->remember);

                // Regenerate session to prevent session fixation attacks
                $request->session()->regenerate();

                // Redirect to the intended page (or a default page)
                return redirect()->intended('/app/academy/dashboard');
            }
        }

        // If login fails or API response indicates failure, return back with an error message
        return back()->withErrors([
            'nip' => 'The provided credentials do not match our records.',
        ]);
    }

public function logout(Request $request)
{
    // Get the currently authenticated user
    $user = Auth::user();

    // Retrieve the login record for the user based on `nip` from the JSON data in `login`
    $loginRecord = Login_user::where('login', 'like', '%"nip":"' . $user->nip . '"%')->first();

    // Delete the login record if it exists
    if ($loginRecord) {
        // Use the delete() method directly on the model instance to avoid `id`-based deletion
        $loginRecord->delete();
    }

    // Log the user out of the application
    Auth::logout();

    // Invalidate the session to prevent session fixation attacks
    $request->session()->invalidate();

    // Regenerate the session token
    $request->session()->regenerateToken();

    // Redirect to the login page or home page after logout
    return redirect('/');
}

}