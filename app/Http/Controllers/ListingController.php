<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class ListingController extends Controller
{
    // Show all listings
    public function index(Request $request)
    {
        // return view("listings.index", [
        //     'listings' => Listing::latest()->filter(request(['tag']))->get()
        // ]);

        $tag = $request->input('tag'); // Get the tag parameter from the request
        $search = $request->input('search'); // Get the search parameter from the request
        // Fetch listings based on the tag parameter using the Listing model
        $listings = Listing::filterByTag($tag, $search)->latest()->paginate(4);

        return view('listings.index', compact('listings'));
    }
    //Show single listing
    public function show(Listing $listing)
    {
        return view("listings.show", [
            'listing' => $listing
        ]);
    }


    //Show create form
    public function create()
    {
        return view("listings.create");
    }

    //Store listing data
    public function store(Request $request)
    {

        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required', Rule::unique('listings', 'company')],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        if ($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $formFields['user_id'] = auth()->id();

        Listing::create($formFields);

        return redirect("/")->with('message', 'Listing created successfully!');
    }


    //Show edit form
    public function edit(Listing $listing)
    {

        return view("listings.edit", ['listing' => $listing]);
    }

    //Update listing data
    public function update(Request $request, Listing $listing)
    {

        //check if logged in user is the owner of the listing
        if ($listing->user_id != auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
        $formFields = $request->validate([
            'title' => 'required',
            'company' => 'required',
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        if ($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $listing->update($formFields);

        return back()->with('message', 'Listing updated successfully!');
    }

    //Delete listing
    public function destroy(Listing $listing)
    {
        //check if logged in user is the owner of the listing
        if ($listing->user_id != auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
        $listing->delete();
        return redirect("/")->with('message', 'Listing deleted successfully!');
    }

    //Manage listings
    public function manage()
    {
        return view('listings.manage', ["listings" => auth()->user()->listings()->get()]);
    }
}
