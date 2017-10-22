<?php
namespace VanillaEnchantments\handlers;

use pocketmine\Player;

use pocketmine\item\Item;

use pocketmine\item\enchantment\Enchantment;

use pocketmine\event\Listener;
use pocketmine\event\entity\EntityShootBowEvent;

use VanillaEnchantments\Core;

class Infinity extends VanillaEnchant implements Listener{
	
	public function __construct(Core $core){
	    $core->getServer()->getPluginManager()->registerEvents($this, $core);
	}
	
	public function onShoot(EntityShootBowEvent $event): void{
	    $player = $event->getEntity();
	    $bow = $event->getBow();
	    if($event->isCancelled()){
		   return;
		 }
		 if($bow->hasEnchantment(Enchantment::INFINITY)){
			if($player instanceof Player and $player->isSurvival()){
			 $player->getInventory()->addItem(Item::get(Item::ARROW, 0, 1));
			}
		}
	}
}
