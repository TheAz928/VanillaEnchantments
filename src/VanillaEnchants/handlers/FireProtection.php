<?php
namespace VanillaEnchants\handlers;

use pocketmine\Player;

use pocketmine\event\Listener;
use pocketmine\event\entity\EntityDamageEvent;

class FireProtection extends VanillaEnchant implements Listener{
	
	public function __construct(){
	  # Maybe link core?
	}
   
	public function onDamage(EntityDamageEvent $event){
	    $player = $event->getEntity();
	    if($player instanceof Player && ($event->getCause() == EntityDamageEvent::CAUSE_FIRE or $event->getCause() == EntityDamageEvent::CAUSE_FIRE_TICK)){
		    $reduce = $this->getArmorPoints($player, 1);
		    if($reduce > 0){
			   $reduce = $reduce < 1 ? 1 : $reduce;
			   $dmg = $event->getDamage() - $reduce;
			   $dmg = $dmg < 0 ? 0 : $dmg;
			   $event->setDamage($dmg);
			 }
		 }
	}
}
