<?php

namespace App\Http\Controllers\front_pages;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class Landing extends Controller
{
  public function index()
  {
    $pageConfigs = ['myLayout' => 'front'];

    // Fetch the count of users who have participated in training
    $userCount = User::count(); // or PNS::count() if you have a PNS model

    return view('content.front-pages.landing-page', [
      'pageConfigs' => $pageConfigs,
      'userCount' => $userCount // Pass the count to the view
    ]);
  }
}
