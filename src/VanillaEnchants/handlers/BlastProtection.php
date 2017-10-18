<?php
namespace VanillaEnchants\handlers;

use pocketmine\Player;

use pocketmine\event\Listener;
use pocketmine\event\entity\EntityDamageEvent;

class BlastProtection extends VanillaEnchant implements Listener{
	
	public function __construct(){
	  # Maybe link core?
	}
	
	public function onDamage(EntityDamageEvent $event){
	    $player = $event->getEntity();
	    if($player instanceof Player && ($event->getCause() == EntityDamageEvent::CAUSE_BLOCK_EXPLOSION or $event->getCause() == EntityDamageEvent::CAUSE_ENTITY_EXPLOSION)){
		    $reduce = $this->getArmorPoints($player, 3);
		    if($reduce > 0){
			   $reduce *= 2;
			   $reduce /= 1.5;
			   $reduce = round($reduce);
			   $dmg = $event->getDamage() - $reduce;
			   $dmg = $dmg < 0 ? 0 : $dmg;
			   $event->setDamage($dmg);
			 }
		 }
	}
}
