<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\User; // Assuming you have a User model

use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;

class BotManChatConversation extends Conversation
{
    protected $userData = [];

    public function run()
    {
        $this->askName();
    }

    public function askName()
    {
        $this->ask('What is your name?', function (Answer $answer) {
            $this->userData['name'] = $answer->getText();
            $this->bot->typesAndWaits(1); // Wait for 1 second before asking the next question
            $this->askEmail();
        });
    }

    public function askEmail()
    {
        $this->ask('What is your email address?', function (Answer $answer) {
            $this->userData['email'] = $answer->getText();
            $this->bot->typesAndWaits(1); // Wait for 1 second before asking the next question
            // $this->saveUserData();
            $this->askFirstQuestion();
        });
    }

    public function askFirstQuestion()
    {
        $this->ask('What is your query ?', function (Answer $answer) {
            $this->userData['first_question'] = $answer->getText();
            
            $this->bot->typesAndWaits(1); // Wait for 1 second before asking the next question
            $this->askSecondQuestion();
        });
    }

    public function askSecondQuestion()
    {
        $this->ask('Enter your Tracking no.', function (Answer $answer) {
            $this->userData['second_question'] = $answer->getText();

            $this->saveUserData();
            $this->bot->typesAndWaits(1); // Wait for 1 second before asking the next question
            $this->askThirdQuestion();
        });
    }

    public function askThirdQuestion()
    {
        $this->ask('Conversation ended. Thank you!', function (Answer $answer) {
            // Process the answer

            // End the conversation
            // $this->say('Conversation ended. Thank you!');
            $this->bot->typesAndWaits(1); // Wait for 1 second before ending the conversation
            $this->end();
        });
    }

    public function saveUserData()
    {
        // Create a new User instance and save the data to the database
        User::create([
            'name' => $this->userData['name'],
            'email' => $this->userData['email'],
            'first_question' => $this->userData['first_question'] ?? null,
            'second_question' => $this->userData['second_question'] ?? null,
            // 'third_question' => $this->userData['third_question'] ?? null,
        ]);
    }
}