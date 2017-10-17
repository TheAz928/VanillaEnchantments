<?php
namespace VanillaEnchants\handlers;

use pocketmine\Player;

use pocketmine\event\Listener;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;

class Punch extends VanillaEnchant implements Listener{
	
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
			if($item->hasEnchantment(20) && $item->isBow()){
			  $add = $item->getEnchantment(20)->getLevel() * 0.45;
          $event->setKnockback($event->getKnockback() + $add);
			}
	   }
	}
}