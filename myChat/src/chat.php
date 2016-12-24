<?php
namespace ChatApp;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
/**
 *
 */
/**
 *
 */
class Chat implements MessageComponentInterface
{
  protected $clients;

  function __construct()
  {
    $this->clients = new \SplObjectStorage ;
  }

  public function onOpen(ConnectionInterface $conn){
      $this->clients->attach($conn);
      echo "New Connection ({$conn->resourceId})\n";
  }

  public function onMessage(ConnectionInterface $from, $message){
     $msg = json_decode($message);
     switch ($msg->type) {
       case 'message':
           foreach($this->clients as $client){
             if($client !== $from){
               $client->send($message);
             }
           }
         break;

       default:
         # code...
         break;
     }
  }

  public function onClose(ConnectionInterface $conn){
      $this->clients->detach($conn);
      echo "Connection {$conn->resourceId} has disconnected\n";
  }

  public function onError(ConnectionInterface $conn,\Exception $e){
     echo "An error has occured {$e->getMessage()}";
     $conn->close();
  }

}

?>
