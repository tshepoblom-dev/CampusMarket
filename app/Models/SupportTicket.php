<?php

namespace App\Models;

use App\Models\TicketReply;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SupportTicket extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function users()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function support_attachments(){
    	return $this->hasMany(SupportTicketAttachment::class);
    }

    public function ticketReplies(){

        return $this->hasMany(TicketReply::class);

    }
}
