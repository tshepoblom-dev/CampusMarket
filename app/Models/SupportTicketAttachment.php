<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportTicketAttachment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function supports()
    {
        return $this->belongsTo(SupportTicket::class, 'support_ticket_id');
    }
}
