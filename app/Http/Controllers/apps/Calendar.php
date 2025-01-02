<?php

namespace App\Http\Controllers\apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tanggal_libur;

class Calendar extends Controller
{
  public function index()
  {
    return view('content.apps.app-calendar');
  }

  public function getEvents()
  {
      $events = Tanggal_libur::all()->map(function ($event) {
          return [
              'title' => $event->nama,
              'start' => $event->tanggal,
              'allDay' => true,
          ];
      });

      return response()->json($events);
  }


  public function storeEvent(Request $request)
  {
      $request->validate([
          'nama' => 'required|string|max:255',
          'tanggal' => 'required|date',
      ]);

      Tanggal_libur::create([
          'nama' => $request->nama,
          'tanggal' => $request->tanggal,
      ]);

      return response()->json(['message' => 'Event added successfully'], 201);
  }
}
