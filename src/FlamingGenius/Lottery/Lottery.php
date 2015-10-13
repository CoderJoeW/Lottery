<?php

namespace FlamingGenius\Lottery;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\item\Item;
use pocketmine\Player;
//debug line 11
class Lottery extends PluginBase{

 public function onEnable(){
  $this->saveDefaultConfig();
 }
 
 public function onCommand(CommandSender $sender, Command $command, $label, array $args){
  $player = $sender->getName();
  $cmd = $command->getName();
  $winT = $this->getConfig()->get("winning-number");
  if(strtolower($cmd) == "lottery"){
   $numbers = $this->getConfig()->get("lotto-numbers");
   //debug line 23
   $draw = array_rand($numbers);
   
   $ticket = $numbers[$draw];
   
   $sender->sendMessage("§4Your ticket number is" . " " . $ticket);
   if($ticket == $winT){
    //debug line 30
    $this->getServer()->broadcastMessage("§b" . $player . " " . "§aGot a winning lottery ticket" . " " . "Ticket Number:" . "§6" . $ticket);
    $id = $this->getConfig()->get("item-id");
    $rid = array_rand($id);
    $damage = $this->getConfig()->get("item-damage");
    $amount = $this->getConfig()->get("item-amount");
    $item = Item::get($rid,$damage,$amount);
    $sender->getInventory()->addItem($item);
    $sender->sendMessage("§aYou recieved" . " " . $amount . " " . $id);
   }
   else{
    $sender->sendMessage("§4Sorry your ticket is not a winning number");
   }
  }
 }



}





?>