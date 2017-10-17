<?php
namespace VanillaEnchants\handlers;

use pocketmine\Player;

use pocketmine\event\Listener;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;

class Power extends VanillaEnchant implements Listener{
	
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
			if($item->hasEnchantment(19) && $item->isBow()){
			  $add = $item->getEnchantment(19)->getLevel() * 0.5 + 3;
          $event->setFinalDamage($event->getFinalDamage() + $add);
			}
	   }
	}
}