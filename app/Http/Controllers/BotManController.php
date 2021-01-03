<?php

namespace App\Http\Controllers;

use App\Conversations\LoginConversation;
use App\Conversations\RegisterConversation;
use BotMan\BotMan\BotMan;
use App\Conversations\StartConversation;
use Illuminate\Support\Facades\Auth;

class BotManController extends Controller
{
    /**
     * Place your BotMan logic here.
     */
    public function handle()
    {
        $botman = app('botman');

        $botman->listen();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function tinker()
    {
        return view('tinker');
    }

    /**
     * Start the conversation
     * @param BotMan $bot
     */
    public function startConversation(BotMan $bot)
    {
        $bot->startConversation(new StartConversation());
    }

    /**
     * Performs the log in
     * @param BotMan $bot
     */
    public function login(BotMan $bot)
    {
        $bot->startConversation(new LoginConversation());
    }

    /**
     * Performs the logout
     * @param BotMan $bot
     */
    public function logout(BotMan $bot)
    {
        if ($bot->userStorage()->find('user')->get('user')) {
            Auth::logout();
            $bot->userStorage()->delete('user');
            $bot->userStorage()->delete('email');
            $bot->userStorage()->delete('password');
            $bot->userStorage()->delete('name');
            $bot->reply("You are logged out.");
        } else {
            $bot->reply("You are not logged in.");
        }


    }

    /**
     * Register the user
     * @param BotMan $bot
     */
    public function register(BotMan $bot)
    {
        $bot->startConversation(new RegisterConversation());
    }
}
