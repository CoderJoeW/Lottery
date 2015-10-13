<?php

namespace FlamingGenius\Lottery;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\item\Item;

class Lottery extends PluginBase{

 public function onEnable(){
  $this->saveDefaultConfig();
 }
 
 public function onCommand(CommandSender $sender, Command $command, $label, array $args){
  $cmd = $command->getName();
  $winT = $this->getConfig()->get("winning-number");
  if(strtolower($cmd) == "lottery"){
   $numbers = array(
   "4062","2332","1127","1975",
   "8458","9883","4762","3038",
   "8459","7111","3858","8814",
   );

   
   $draw = array_rand($numbers);
   
   $ticket = $numbers[$draw];
   
   $sender->sendMessage("Your ticket number is" . " " . $ticket);
   if($ticket == $winT){
    $player = $this->getServer()->getPlayer()->getName();
    $this->getServer()->broadcastMessage($player . " " . "Got a winning lottery ticket");
    $id = $this->getConfig()->get("item-id");
    $damage = $this->getConfig()->get("item-damage");
    $amount = $this->getConfig()->get("item-amount");
    $item = Item::get($id,$amount,$damage);
    $player->getInvetory()->addItem($item);
    $sender->sendMessage("You have recieved" . $amount . $id);
   }
   else{
    $sender->sendMessage("Sorry your ticket is not a winning number");
   }
  }
 }



}





?>