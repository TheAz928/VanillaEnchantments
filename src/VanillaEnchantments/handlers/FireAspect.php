<?php
namespace VanillaEnchantments\handlers;

use pocketmine\Player;

use pocketmine\item\enchantment\Enchantment;

use pocketmine\event\Listener;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;

use VanillaEnchantments\Core;

class FireAspect extends VanillaEnchant implements Listener{
	
	public function __construct(Core $core){
	    $core->getServer()->getPluginManager()->registerEvents($this, $core);
	}
	
	/**
	 * @param EntityDamageEvent $event
	 */
	
	public function onDamage(EntityDamageEvent $event): void{
	      $player = $event->getEntity();
	      if($event instanceof EntityDamageByEntityEvent){
		      $damager = $event->getDamager();
		      if($damager instanceof Player == false or $event->isCancelled()){
			      return;
			   }
		     $item = $damager->getInventory()->getItemInHand();
		     if($item->hasEnchantment(Enchantment::FIRE_ASPECT)){
			     $level = $this->getEnchantmentLevel($item, Enchantment::FIRE_ASPECT);
		        $player->setOnFire($level * 20);
			   }
	     }
	 }
}
