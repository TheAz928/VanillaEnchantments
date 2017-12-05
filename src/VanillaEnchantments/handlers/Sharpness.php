<?php

namespace VanillaEnchantments\handlers;

use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\Player;
use VanillaEnchantments\Core;

class Sharpness extends VanillaEnchant implements Listener{

	public function __construct(Core $core){
		$core->getServer()->getPluginManager()->registerEvents($this, $core);
	}

	/**
	 * @void onDamage
	 * @param EntityDamageEvent $event
	 * @priority HIGH
	 * ignoreCancelled true
	 */
	public function onDamage(EntityDamageEvent $event): void{
		if ($event instanceof EntityDamageByEntityEvent){
			$damager = $event->getDamager();
			if (!$damager instanceof Player){
				return;
			}
			$item = $damager->getInventory()->getItemInHand();
			if ($item->hasEnchantment(Enchantment::SHARPNESS)){
				$level = $this->getEnchantmentLevel($item, Enchantment::SHARPNESS);
				$base = $event->getDamage();
				$add = $this->getExtraDamage(Enchantment::SHARPNESS, $base, $level);
				$event->setDamage($base + $add);
			}
		}
	}
}
