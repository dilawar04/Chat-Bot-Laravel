<?php
// namespace App\Http\Controllers;
// use Illuminate\Http\Request;
// use BotMan\BotMan\Messages\src\Incoming\Answer;
// use BotMan\BotMan;


namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\BotMan;

class BotManChatController extends Controller
{
    public function invoke(Request $request)
    {
        $botman = app('botman');
        $botman->hears('{message}', function($botman, $message) {
            if ($message != 'hello') {
                $botman->startConversation(new BotManChatConversation());
            } else {
                $botman->startConversation(new BotManChatConversation());
            }
        });
        $botman->listen();
    }
   
    public function askInfo($botman)
    {
        $botman->ask('Hey There! How are you?', function(Answer $answer) {
            $ans = $answer->getText();
            $this->say('Whats up '.$ans);
        });
    }

    public function as(){
        echo 'ass';
        exit;
    }
}