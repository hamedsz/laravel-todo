<?php

namespace TodoApp\app\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TaskClosed extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct()
    {
    }

    public function build(){
        return $this->view('todo::test');
    }
}
