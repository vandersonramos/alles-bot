<?php

namespace App\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;


class StartConversation extends Conversation
{

    public function startConversation()
    {
        $this->bot->reply('Hello, my name is Alles Bot, I am here to help you with the bank transactions.
        To manage transactions, you need to be logged in, please type LOGIN to log in or REGISTER to sign up.');

        $this->bot->typesAndWaits(1);

        $this->bot->reply('If you only need to convert currency, login is not required. Use the available 
        commands and choose the best one for you!');
    }

    /**
     * Start the conversation.
     *
     * @return mixed
     */
    public function run()
    {
        $this->startConversation();
    }
}
