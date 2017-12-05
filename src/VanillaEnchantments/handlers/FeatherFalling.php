<?php

namespace VanillaEnchantments\handlers;

use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\Player;
use VanillaEnchantments\Core;

class FeatherFalling extends VanillaEnchant implements Listener{

	public function __construct(Core $core){
		$core->getServer()->getPluginManager()->registerEvents($this, $core);
	}

	/**
	 * @void onDamage
	 * @param EntityDamageEvent $event
	 * @priority MEDIUM
	 * ignoreCancelled false
	 */
	public function onDamage(EntityDamageEvent $event): void{
		$player = $event->getEntity();
		$cause = $event->getCause();
		if ($event->isCancelled() and $cause !== $event::CAUSE_FALL){
			return;
		}
		if ($player instanceof Player){
			$level = $this->getEnchantmentLevelOfArmors($player, Enchantment::FEATHER_FALLING);
			$base = $event->getDamage();
			$reduce = $this->getReducedDamage(Enchantment::FEATHER_FALLING, $base, $level);
			if ($reduce > 0){
				$event->setDamage($base - $reduce);
			}
		}
	}
}