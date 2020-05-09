<?php

return [

    // 'user_model' => App\Models\User::class,

    'message_model' => Dmark\Messenger\Models\Message::class,

    'participant_model' => Dmark\Messenger\Models\Participant::class,

    'thread_model' => Dmark\Messenger\Models\Thread::class,

    /**
     * Define custom database table names - without prefixes.
     */
    'messages_table' => 'messages',

    'participants_table' => 'message_participants',

    'threads_table' => 'message_thread',
];