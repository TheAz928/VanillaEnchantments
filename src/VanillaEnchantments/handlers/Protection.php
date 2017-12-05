<?php

namespace VanillaEnchantments\handlers;

use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\Player;
use VanillaEnchantments\Core;

class Protection extends VanillaEnchant implements Listener{

	public function __construct(Core $core){
		$core->getServer()->getPluginManager()->registerEvents($this, $core);
	}

	/**
	 * @void onDamage
	 * @param EntityDamageEvent $event
	 * @priority HIGHEST
	 * ignoreCancelled false
	 */
	public function onDamage(EntityDamageEvent $event): void{
		$player = $event->getEntity();
		$cause = $event->getCause();
		if ($event->isCancelled() or $cause == $event::CAUSE_STARVATION or $cause == $event::CAUSE_MAGIC){
			return;
		}
		if ($player instanceof Player) $this->useArmors($player);
		if ($player instanceof Player){
			$level = $this->getEnchantmentLevelOfArmors($player, Enchantment::PROTECTION);
			$base = $event->getDamage();
			$reduce = $this->getReducedDamage(Enchantment::PROTECTION, $base, $level);
			if ($reduce > 0){
				$event->setDamage($base - $reduce);
			}
		}
	}
}
