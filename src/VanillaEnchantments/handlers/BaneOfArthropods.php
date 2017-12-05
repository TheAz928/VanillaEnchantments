<?php

namespace VanillaEnchantments\handlers;

use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\Player;
use VanillaEnchantments\Core;

class BaneOfArthropods extends VanillaEnchant implements Listener{

	/** @constant MOBS */
	CONST MOBS = ["spider", "cavespider", "silverfish", "endermite"];

	public function __construct(Core $core){
		$core->getServer()->getPluginManager()->registerEvents($this, $core);
	}

	/**
	 * @void onDamage
	 * @param EntityDamageEvent $event
	 * @priority MEDIUM
	 * ignoreCancelled true
	 */
	public function onDamage(EntityDamageEvent $event): void{
		$player = $event->getEntity();
		$ref = new \ReflectionClass($player);
		$matched = false;
		if ($event instanceof EntityDamageByEntityEvent){
			$damager = $event->getDamager();
			if (!$damager instanceof Player){
				return;
			}
			foreach (self::MOBS as $mob){
				if (stripos($mob, strtolower($ref->getShortName())) !== false){
					$matched = true;
				}
			}
			if ($matched == false){
				return;
			}
			$item = $damager->getInventory()->getItemInHand();
			if ($item->hasEnchantment(Enchantment::BANE_OF_ARTHROPODS)){
				$level = $this->getEnchantmentLevel($item, Enchantment::BANE_OF_ARTHROPODS);
				$base = $event->getDamage();
				$add = $this->getExtraDamage(Enchantment::BANE_OF_ARTHROPODS, $base, $level);
				$event->setDamage($base + $add);
			}
		}
	}
}
