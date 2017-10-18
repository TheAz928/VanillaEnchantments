<?php
namespace VanillaEnchants\handlers;

use pocketmine\Player;

use pocketmine\event\Listener;
use pocketmine\event\entity\EntityDamageEvent;

class FeatherFalling extends VanillaEnchant implements Listener{
	
	public function __construct(){
	  # Maybe link core?
	}
   
	public function onDamage(EntityDamageEvent $event){
	    $player = $event->getEntity();
	    if($player instanceof Player && $event->getCause() == EntityDamageEvent::CAUSE_FALL){
		    $reduce = $this->getArmorPoints($player, 2);
		    if($reduce > 0){
			   $reduce *= 2;
			   $dmg = $event->getDamage() - $reduce;
			   $dmg = $dmg < 0 ? 0 : $dmg;
			   $event->setDamage($dmg);
			 }
		 }
	}
}