<?php

namespace App\Events;

use App\Persona;
use App\MensajeChat;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * User that sent the message
     *
     * @var Persona
     */
    public $persona;
    public $idConversacionChat;
    /**
     * Message details
     *
     * @var Mensaje
     */
    public $mensaje;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Persona $persona, MensajeChat $mensaje, $idConversacionChat)
    {
        $this->persona = $persona;
        $this->mensaje = $mensaje;
        $this->idConversacionChat = $idConversacionChat;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('chat');
    }
}
