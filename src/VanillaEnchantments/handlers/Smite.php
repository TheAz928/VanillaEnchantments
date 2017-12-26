<?php
namespace VanillaEnchantments\handlers;

use pocketmine\Player;

use pocketmine\entity\Entity;

use pocketmine\item\enchantment\Enchantment;

use pocketmine\event\Listener;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;

use VanillaEnchantments\Core;

class Smite extends VanillaEnchant implements Listener{
	
	CONST MOBS = [
	   Entity::ZOMBIE,
	   Entity::HUSK,
	   Entity::SKELETON,
	   Entity::WITHER_SKELETON,
	   Entity::WITHER,
	   Entity::ZOMBIE_PIGMAN,
	   Entity::STRAY,
	   Entity::ZOMBIE_VILLAGER,
	   # ToDo: Add more
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
		    if($item->hasEnchantment(Enchantment::SMITE) and in_array($player::NETWORK_ID, self::MOBS)){
			    $level = $this->getEnchantmentLevel($item, Enchantment::SMITE);
		       $base = $event->getDamage();
		       $add = $this->getExtraDamage(Enchantment::SMITE, $base, $level);
		       $event->setDamage($base + $add);
			 }
		}
	}
}
