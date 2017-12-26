<?php
namespace VanillaEnchantments\handlers;

use pocketmine\Player;

use pocketmine\entity\Entity;

use pocketmine\item\enchantment\Enchantment;

use pocketmine\event\Listener;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;

use VanillaEnchantments\Core;

class BaneOfArthropods extends VanillaEnchant implements Listener{
	
	/* @constant MOBS */
	const MOBS = [
	   Entity::SPIDER,
	   Entity::CAVE_SPIDER,
	   Entity::SILVERFISH,
	   Entity::ENDERMITE
	   # ToDo: add more
	];

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
		      if($damager instanceof Player == false){
			      return;
			    }
		      $item = $damager->getInventory()->getItemInHand();
		      if($item->hasEnchantment(Enchantment::BANE_OF_ARTHROPODS) and in_array($player::NETWORK_ID, self::MOBS)){
			      $level = $this->getEnchantmentLevel($item, Enchantment::BANE_OF_ARTHROPODS);
		         $base = $event->getDamage();
		         $add = $this->getExtraDamage(Enchantment::BANE_OF_ARTHROPODS, $base, $level);
		         $event->setDamage($base + $add);
			  }
	    }
	}
}
