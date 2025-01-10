<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SupportTicket;
use Illuminate\Support\Facades\Auth;
use App\Models\SupportTicketAttachment;
use App\Models\TicketReply;
use App\Models\TicketReplyDocument;
use Illuminate\Support\Facades\Validator;

class SupportTicketController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','pverify']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $page_title = translate('Ticket & Support');
        if ($user->role == 2) {
            $supports = SupportTicket::where('user_id', $user->id)->where('parent_id', 0)->latest()->paginate(10);
            $answered = SupportTicket::where('user_id', $user->id)->where('parent_id', 0)->where('status', 1)->where('replied', 1)->count();
            $opened = SupportTicket::where('user_id', $user->id)->where('parent_id', 0)->where('status', 1)->count();
            $closed = SupportTicket::where('user_id', $user->id)->where('parent_id', 0)->where('status', 2)->count();
            $total = SupportTicket::where('user_id', $user->id)->where('parent_id', 0)->count();
        } else {
            $supports = SupportTicket::where('parent_id', 0)->latest()->paginate(10);
            $answered = SupportTicket::where('parent_id', 0)->where('status', 1)->where('replied', 2)->count();
            $opened = SupportTicket::where('parent_id', 0)->where('status', 1)->count();
            $closed = SupportTicket::where('parent_id', 0)->where('status', 2)->count();
            $total = SupportTicket::where('parent_id', 0)->count();
        }
        return view('backend.support_ticket.index', compact('page_title', 'supports', 'answered', 'opened', 'closed', 'total'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->role == 2) {
            $page_title = translate('Add Ticket');
            return view('backend.support_ticket.create', compact('page_title'));
        } else {
            return redirect()->route('support.list')->with('error', translate('Support Ticket will be open only Merchant'));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'subject' => 'required|max:255',
            'description' => 'nullable',
            'department' => 'required|max:255',
            'priority' => 'required|max:255',
            'attachment' => 'nullable',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $supports = new SupportTicket;
        $supports->subject = $request->subject;
        $supports->department = $request->department;
        $supports->priority = $request->priority;
        $supports->description = prelaceScript(html_entity_decode($request->description)) ;
        $supports->type = 1;
        $supports->user_id = $user->id;
        if ($supports->save()) {
            $support_id = $supports->id;
            if ($request->attachment != null) {
                foreach ($request->attachment as $key => $val) {
                    $attachments = new SupportTicketAttachment;
                    $val_name = pathinfo($val->getClientOriginalName(), PATHINFO_FILENAME) . '-' . time() . '.' . $val->getClientOriginalExtension();
                    $val->move(public_path('uploads/supports'), $val_name);
                    $attachments->attachment = $val_name;
                    $attachments->support_ticket_id = $support_id;
                    $attachments->save();
                }
            }
        }

        return redirect()->route('support.list')->with('success', translate('Support Ticket opened successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(SupportTicket $supportTicket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $page_title = translate('Reply Ticket');
        $supports = SupportTicket::with('users', 'support_attachments', 'ticketReplies.documents', 'ticketReplies.authorInfo')->findOrFail($id);
        return view('backend.support_ticket.reply', compact('page_title', 'supports'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'answer' => 'required',
        ], [
            'answer.required' => 'Reply Answer is Required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $ticketReply =  new TicketReply();
        $ticketReply->support_ticket_id = $id;
        $ticketReply->author_reply_id = Auth::user()->id;
        $ticketReply->answer = prelaceScript(html_entity_decode($request->answer)) ;
        $ticketReply->save();
        if (!empty($request->attachment)) {
            foreach ($request->attachment as $file) {
                $attachment = new TicketReplyDocument();
                $attachment_name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '-' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/supports'), $attachment_name);
                $attachment->document = $attachment_name;
                $attachment->ticket_reply_id = $ticketReply->id;
                $attachment->save();
            }
        }
        return redirect()->back()->with('success', translate('Support Ticket reply successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $support = SupportTicket::with('support_attachments', 'ticketReplies.documents')->findOrFail($id);
        if (!empty($support->support_attachments)) {
            foreach ($support->support_attachments as $sup_attach) {
                if (file_exists(public_path('uploads/supports/' . $sup_attach->attachment))) {
                    unlink(public_path('uploads/supports/' . $sup_attach->attachment));
                }
            }
        }

        if (!empty($support->ticketReplies)) {
            foreach ($support->ticketReplies as $ticketReply) {
                if (!empty($ticketReply->documents)) {
                    foreach ($ticketReply->documents as $file) {
                        if (file_exists(public_path('uploads/supports/' . $file->document))) {
                            unlink(public_path('uploads/supports/' . $file->document));
                        }
                    }
                }
            }
        }


        $support->delete();
        return back()->with('success', translate('Support Ticket deleted successfully'));
    }



    /**
     * closeTicket
     *
     * @param  int $supportId
     * @return Response
     */
    public function closeTicket($supportId)
    {
        $support = SupportTicket::where('id', $supportId)->first();
        $support->status = 2;
        if ($support->update()) {
            return redirect()->route('support.list')->with('success', translate('Support Ticket Close successfully'));
        }
    }
}
