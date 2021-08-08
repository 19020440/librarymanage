<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AdminContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listContactYear = [];
        $listContactMonth = [];
        $listContactWeek = [];
        $listContact = Contact::get();
        foreach ($listContact as $contact) {
            if (Carbon::parse($contact->created_at)->year == Carbon::now()->year) {
                $listContactYear[] = $contact;
            }
            if (Carbon::parse($contact->created_at)->month == Carbon::now()->month) {
                $listContactMonth[] = $contact;
            }
            if (Carbon::parse($contact->created_at)->weekOfYear == Carbon::now()->weekOfYear) {
                $listContactWeek[] = $contact;
            }
        }
        return view('admin.manage_contact.index', [
            'listContactYear' => $listContactYear,
            'listContactMonth' => $listContactMonth,
            'listContactWeek' => $listContactWeek,
            'listContact' => $listContact
        ]);
    }

    public function changeReaded(Request $request)
    {
        if ($request->id) {
            $contact = Contact::find($request->id);
            if ($contact) {
                $contact['is_readed'] = Contact::STATUS_READED;
                $contact->update();
                return Response()->json([
                    'success' => '1'
                ]);
            }
        }
        return Response()->json([
            'success' => '0'
        ]);
    }

    public function deleteContact(Request $request)
    {
        if ($request->id) {
            $contact = Contact::find($request->id);
            if ($contact) {
                $contact->delete();
                return Response()->json([
                    'success' => '1'
                ]);
            }
        }
        return Response()->json([
            'success' => '0'
        ]);
    }
}
