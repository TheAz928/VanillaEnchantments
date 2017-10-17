<?php
namespace VanillaEnchants\handlers;

use pocketmine\Player;

use pocketmine\item\Item;

use pocketmine\event\Listener;
use pocketmine\event\entity\EntityShootBowEvent;

class Infinity extends VanillaEnchant implements Listener{
	
	public function __construct(){
	    # Maybe link core?
	}
	
	public function onShoot(EntityShootBowEvent $event){
	    $player = $event->getEntity();
	    $bow = $event->getBow();
	    if($event->isCancelled() == false && $bow->hasEnchantment(22)){
		   if($player instanceof Player && $player->isSurvival()){
			  $player->getInventory()->addItem(Item::get(Item::ARROW, 0, 1));
			}
		}
	}
}