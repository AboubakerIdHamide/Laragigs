<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    public function index(){
        return view('listings.index', [
            "listings"=>Listing::latest()->filter(request(['tag', 'search']))->paginate(10) // there is also simplePaginate() function
        ]);
    }

    public function show(Listing $listing){
        // route model binding (when u pass a model as a parametre that will automaticlly check in db if the route passed param is exists)
        return view('listings.show', [
            "listing"=>$listing
        ]);
    }

    public function create(){
        // route model binding (when u pass a model as a parametre that will automaticlly check in db if the route passed param is exists)
        return view('listings.create');
    }

    public function store(Request $request){

        $formFields=$request->validate([
            "title"=>"required",
            "tags"=>"required",
            "company"=>["required"],//Rule::unique("listings", "company")
            "location"=>"required",
            "email"=>["required", "email"],
            "website"=>"required",
            "description"=>"required",
        ]);

        if($request->hasFile("logo")){
            $formFields["logo"]=$request->file("logo")->store("logos", "public");
        }
        $formFields["user_id"]=auth()->id();

        Listing::create($formFields);
        return redirect("/")->with("message", "Listing Created Successfully !");
    }

    public function edit(Listing $listing){
        return view('listings.edit', ["listing"=>$listing]);
    }

    public function update(Request $request, Listing $listing){
        // Checking Listing  If It Is Your
        if($listing->user_id!=auth()->id()){
            abort(403, "You Can't Do This ^_^");
        }

        $formFields=$request->validate([
            "title"=>"required",
            "tags"=>"required",
            "company"=>["required"],//Rule::unique("listings", "company")
            "location"=>"required",
            "email"=>["required", "email"],
            "website"=>"required",
            "description"=>"required",
        ]);

        if($request->hasFile("logo")){
            $formFields["logo"]=$request->file("logo")->store("logos", "public");
        }


        $listing->update($formFields);

        // return back()->with("message", "Listing Updated Successfully !");
        return redirect("/listings/".$listing->id)->with("message", "Listing Updated Successfully !");
    }

    public function destroy(Listing $listing)
    {
        // Checking Listing  If It Is Your
        if($listing->user_id!=auth()->id()){
            abort(403, "You Can't Do This ^_^");
        }

        $listing->delete();
        return redirect("/")->with("message", "Listing Deleted Successfully !");
    }

    public function manage(){
        return view("listings.manage", ["listings"=>auth()->user()->listings()->get()]);
    }
}
