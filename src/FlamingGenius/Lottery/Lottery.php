<?php

namespace FlamingGenius\Lottery;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\event\event\PlayerInteractEvent;
use pocketmine\tile\Sign;
use pocketmine\event\block\SignChangeEvent;

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
   
   $draw = array_rand($numbers);
   
   $ticket = $numbers[$draw];
   
   $sender->sendMessage("§1§l[Lottery]" . "§4Your ticket number is" . " " . $ticket);
   if($ticket == $winT){
    
    $this->getServer()->broadcastMessage("§1§l[Lottery]" . "§b" . $player . " " . "§aGot a winning lottery ticket" . " " . "Ticket Number:" . "§6" . $ticket);
    $id = $this->getConfig()->get("item-id");
    $rid = array_rand($id);
    $damage = $this->getConfig()->get("item-damage");
    $amount = $this->getConfig()->get("item-amount");
    $item = Item::get($rid,$damage,$amount);
    $sender->getInventory()->addItem($item);
    $sender->sendMessage("§1§l[Lottery]" . "§aYou recieved" . " " . $amount . " " . $id);
   }
   elseif($ticket != $winT){
    $sender->sendMessage("§1§l[Lottery]" . "§4Sorry your ticket is not a winning number");
   }
  }
 }
 
 public function onSignChange(SignChangeEvent $event){
  $block = $event->getPlayer()->getLevel()->getTile($event->getBlock());
  $player = $event->getServer()->getPlayer()->getName();
  if($block instanceof Sign){
   $signtext = $block->getText();
   if($signtext[0] == "[Lottery]"){
    $block->setText(
     "§6[Lottery]",
     "§bTap to play"
    );
    $player->sendMessage("§1§l[Lottery]" . " " . "§6Lottery sign created");
   }
  }
 }
 
 public function lottoGame(PlayerInteractEvent $event){
  $block = $event->getPlayer()->getLevel()->getTile($event->getBlock());
  $player = $event->getServer()->getPlayer()->getName();
  if($block instanceof Sign){
   $signtext = $block->getText();
   
   if($signtext[0] == "§6[Lottery]"){
    if($signtext[1] == "§bTap to play"){
     $cmd = "lottery";
     $this->getServer()->dispatchCommand($sender,$cmd);
    }
   }
  }
 }





}





?>