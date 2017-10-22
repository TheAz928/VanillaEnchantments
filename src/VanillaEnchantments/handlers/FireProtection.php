<?php
namespace VanillaEnchantments\handlers;

use pocketmine\Player;

use pocketmine\item\enchantment\Enchantment;

use pocketmine\event\Listener;
use pocketmine\event\entity\EntityDamageEvent;

use VanillaEnchantments\Core;

class FireProtection extends VanillaEnchant implements Listener{
	
	public function __construct(Core $core){
	    $core->getServer()->getPluginManager()->registerEvents($this, $core);
	}
	
	public function onDamage(EntityDamageEvent $event): void{
	    $player = $event->getEntity();
	    $cause = $event->getCause();
	    if($event->isCancelled() and $cause !== $event::CAUSE_FIRE and $cause !== $event::CAUSE_FIRE_TICK and $cause !== $event::CAUSE_LAVA){
		   return;
		 }
	    if($player instanceof Player){
		   $level = $this->getEnchantmentLevelOfArmors($player, Enchantment::FIRE_PROTECTION);
		   $base = $event->getDamage();
		   $reduce = $this->getReducedDamage(Enchantment::FIRE_PROTECTION, $base, $level);
		   if($reduce > 0){
			  $event->setDamage($dmg - $reduce);
			}
		}
	}
}
