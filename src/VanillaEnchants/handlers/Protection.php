<?php
namespace VanillaEnchants\handlers;

use pocketmine\Player;

use pocketmine\event\Listener;
use pocketmine\event\entity\EntityDamageEvent;

class Protection extends VanillaEnchant implements Listener{
	
	public function __construct(){
	  # Maybe link core?
	}
	
	public function onDamage(EntityDamageEvent $event){
	    $player = $event->getEntity();
	    if($player instanceof Player){
		    $reduce = $this->getArmorPoints($player, 0);
		    if($reduce > 0){
			   $reduce /= 2;
			   $reduce += 1;
			   $dmg = $event->getDamage() - $reduce;
			   $dmg = $dmg < 0 ? 1 : $dmg;
			   $event->setDamage($dmg);
			 }
		 }
	}
}
