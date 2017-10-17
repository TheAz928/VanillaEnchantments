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
		    if($deflect > 0){
			   $deflect *= 2;
			   $deflect /= 1.5;
			   $deflect = round($deflect);
			   $damager->attack(new EntityDamageByEntityEvent($player, $damager, 0, $deflect));
			 }
		 }
	}
}