<?php

namespace FlamingGenius\Lottery;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\item\Item;
use pocketmine\Player;

class Lottery extends PluginBase{
	
	public function onEnable(){
		$this->saveDefaultConfig();
	}
 
	public function onCommand(CommandSender $sender, Command $command, $label, array $args){
		$name = $sender->getName();
		$winT = $this->getConfig()->get("winning-number");
		if(strtolower($command->getName()) === "lottery"){
			$numbers = (int) $this->getConfig()->get("lotto-numbers");
			$draw = array_rand($numbers);
			$ticket = $numbers[$draw];
			$sender->sendMessage("Your ticket number is" . " " . $ticket);
			if($ticket == $winT){
				$this->getServer()->broadcastMessage($name . " got a winning lottery ticket!" . "Ticket Number:§6" . $ticket);
				$id = (int) $this->getConfig()->get("item-id");
				$damage = (int) $this->getConfig()->get("item-damage");
				$amount = (int) $this->getConfig()->get("item-amount");
				$item = Item::get($id, $damage, $amount);
				$sender->getInventory()->addItem($item);
				$sender->sendMessage("You recieved " . (string) $amount . " " . (string) $id);
			}else{
				$sender->sendMessage("Sorry your ticket is not a winning number!");
			}
		}
	}
}
