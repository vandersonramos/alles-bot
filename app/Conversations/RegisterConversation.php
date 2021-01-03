<?php

namespace App\Conversations;

use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Conversations\Conversation;
use Illuminate\Support\Facades\Validator;
use App\User;
use Illuminate\Support\Facades\Auth;

class RegisterConversation extends Conversation
{

    /**
     * Ask the user name
     */
    public function askName()
    {
        $this->ask('What is your name?', function (Answer $answer) {

            $this->bot->userStorage()->save(['name' => $answer->getText()], 'name');
            $this->askEmail();
        });
    }

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
     * @todo find a better solution
     */
    public function askPassword()
    {
        $this->ask('Enter the password', function (Answer $answer) {
            $this->bot->userStorage()->save(['password' => $answer->getText()], 'password');
            $this->registerUser();
        });
    }

    /**
     * Register the user
     */
    public function registerUser()
    {
        $user = User::create([
            'name' => $this->bot->userStorage()->find('name')->get('name'),
            'email' => $this->bot->userStorage()->find('email')->get('email'),
            'password' => bcrypt($this->bot->userStorage()->find('password')->get('password')),
        ]);

        Auth::login($user, true);
        $this->bot->userStorage()->save(['user' => Auth::user()->getAuthIdentifier()], 'user');

        if (Auth::check()) {
            $this->say('Great!! Your Account has been created. You are Logged in');
        } else {
            $this->say('Error! Please, try again.');
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

        $this->askName();
    }
}
