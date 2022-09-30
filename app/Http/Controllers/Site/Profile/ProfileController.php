<?php

namespace App\Http\Controllers\Site\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProfileRequest;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('site.profile.edit');
    } // end of getChangeData

    public function update(ProfileRequest $request)
    {
        $requestData = $request->validated();

        if ($request->image) {

            if (auth()->user()->hasImage()) {
                Storage::disk('local')->delete('public/uploads/' . auth()->user()->image);
            }

            $request->image->store('public/uploads');
            $requestData['image'] = $request->image->hashName();
        } //end of if 

        auth()->user()->update($requestData);

        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('profile.edit');
    } // end of postChangeData

}//end of controller
