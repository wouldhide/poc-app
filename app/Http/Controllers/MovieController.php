<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Movie;
use Illuminate\Http\Request;
use App\Notifications\MovieAdded;

class MovieController extends Controller
{
    public function index(){
        return view('movies', ['movies'=>Movie::orderBy('release_year')->get()]);
    }

    public function store(){

        // validate data
        $input = request()->validate([
            'title' => 'required|max:255',
            'release_year' => 'required|integer|min:1900|max:2020',
            'description' => 'required|max:300',
        ]);
        
        // create movie
        Movie::create([
            'title' => $input['title'],
            'release_year' => $input['release_year'],
            'description' => $input['description'],
        ]);

        // send email
        // $user = User::find(1);
        // $user->notify(new MovieAdded());

        // set flash message
        session()->flash('status', 'Movie added successfully!');

        return redirect()->route('movies');
    }
}
