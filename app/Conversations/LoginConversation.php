<?php

namespace App\Conversations;

use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Conversations\Conversation;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Auth;

class LoginConversation extends Conversation
{

    /**
     * Ask the user email
     */
    public function askEmail()
    {
        $this->ask('What is your email?', function (Answer $answer) {
            $validator = Validator::make(['email' => $answer->getText()], [
                'email' => 'email',
            ]);

            if ($validator->fails()) {
                $this->repeat('Please enter a valid email.');
                return;
            }

            $this->bot->userStorage()->save(['email' => $answer->getText()], 'email');
            $this->askPassword();
        });
    }

    /**
     * Ask the user password
     * @todo find a better solution to ask the password
     */
    public function askPassword()
    {
        $this->ask('Enter the password', function (Answer $answer) {
            $this->bot->userStorage()->save(['password' => $answer->getText()], 'password');
            $this->loginUser();
        });
    }

    /**
     * Login the user
     */
    public function loginUser()
    {
        $email = $this->bot->userStorage()->find('email')->get('email');
        $password = $this->bot->userStorage()->find('password')->get('password');

        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            $this->bot->userStorage()->save(['user' => Auth::id()], 'user');
            Auth::login(Auth::user(), true);
        }
        else {
            $this->say('There is something wrong, please, try again');
        }

        if (Auth::check()) {
            $this->say('Great! You are logged in.');
        }
    }

    /**
     * Start the conversation.
     *
     * @return mixed
     */
    public function run()
    {
        if ($this->bot->userStorage()->find('user')->get('user')) {
            $this->say('You are already logged in');
            return;
        }

        $this->askEmail();
    }
}
