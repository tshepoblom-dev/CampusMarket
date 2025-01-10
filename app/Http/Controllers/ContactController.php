<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page_title = translate('Contact List');
        if ($request->search) {
            $contacts = Contact::where('name', 'LIKE', '%' . $request->search . '%')
                ->orWhere('email', 'LIKE', '%' . $request->search . '%')
                ->orWhere('phone', 'LIKE', '%' . $request->search . '%')
                ->orWhere('subject', 'LIKE', '%' . $request->search . '%')
                ->orWhere('message', 'LIKE', '%' . $request->search . '%')
                ->latest()->paginate(12);
        } else {
            $contacts = Contact::latest()->paginate(12);
        }

        return view('backend.contact.index', compact('page_title', 'contacts'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $page_title = translate('Contact Show');
        $contactSingle = Contact::findOrFail($id);
        $contactSingle->status = 2;
        $contactSingle->update();

        return view('backend.contact.view', compact('page_title', 'contactSingle'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //

        Contact::findOrFail($id)->delete();
        return redirect()->back()->with('success', translate('Your Message has been Delete Successfully'));

    }
}
