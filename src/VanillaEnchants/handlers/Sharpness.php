<?php
namespace VanillaEnchants\handlers;

use pocketmine\Player;

use pocketmine\event\Listener;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;

class Sharpness extends VanillaEnchant implements Listener{
	
	public function __construct(){
	    # Maybe link core?
	}
	
	public function onDamage(EntityDamageEvent $event){
	    if($event instanceof EntityDamageByEntityEvent){
		   $player = $event->getEntity();
		   $damager = $event->getDamager();
		   if(!$damager instanceof Player){
			  return false;
			}
			$item = $damager->getInventory()->getItemInHand();
			if($item->hasEnchantment(9)){
			  $add = $item->getEnchantment(9)->getLevel() * 2 * 0.3 + 1;
          $event->setDamage($event->getDamage() + $add);
			}
	   }
	}
}