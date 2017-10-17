<?php
namespace VanillaEnchants\handlers;

use pocketmine\Player;

use pocketmine\event\Listener;
use pocketmine\event\entity\EntityDeathEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;

class Looting extends VanillaEnchant implements Listener{
	
	public function __construct(){
	    # Maybe link core?
	}
	
	public function onDamage(EntityDeathEvent $event){
		  $player = $event->getEntity();
		  if($player instanceof Player){
			 return false;
	     }
		  $cause = $player->getLastDamageCause();
		  if($cause instanceof EntityDamageByEntityEvent){
			 if(($damager = $cause->getDamager()) instanceof Player === false){
				return false;
			 }else{
			   $item = $damager->getInventory()->getItemInHand();
			 }
		  }else{
		   return false;
		  }
		  if($item->hasEnchantment(14)){
			 $drops = [];
		    foreach($event->getDrops() as $drop){
			   $rand = rand(1, $item->getEnchantment(14)->getLevel() + 1);
		      $drop->setCount($drop->getCount() + $rand);
		      $drops[] = $drop;
		    }
		    $event->setDrops($drops);
		}
	}
}