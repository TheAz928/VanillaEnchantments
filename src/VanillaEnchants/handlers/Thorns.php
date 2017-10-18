<?php
namespace VanillaEnchants\handlers;

use pocketmine\Player;

use pocketmine\event\Listener;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;

class Thorns extends VanillaEnchant implements Listener{
	
	public function __construct(){
	  # Maybe link core?
	}
	
	public function onDamage(EntityDamageEvent $event){
	    $player = $event->getEntity();
	    if($player instanceof Player && $event instanceof EntityDamageByEntityEvent){
		    $deflect = $this->getArmorPoints($player, 5);
		    $damager = $event->getDamager();
		    if($deflect > 0 && rand(1, 100) <= 10){ # 10% chance?
			   if($damager instanceof Player && $damager->isCreative()){
				  return false;
				}
			   $deflect /= 2;
			   $deflect += 1;
			   $damager->attack(new EntityDamageByEntityEvent($player, $damager, 0, $deflect));
			 }
		 }
	}
}
