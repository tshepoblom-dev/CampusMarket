<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketReply extends Model
{
    use HasFactory;


    public function documents(){

        return $this->hasMany(TicketReplyDocument::class);

    }


    public function authorInfo() {

         return $this->belongsTo(User::class, 'author_reply_id', 'id')->select(['id', 'fname','lname','email','phone','username']);

    }
}
