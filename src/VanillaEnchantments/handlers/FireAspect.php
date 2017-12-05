<?php

namespace VanillaEnchantments\handlers;

use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\Player;
use VanillaEnchantments\Core;

class FireAspect extends VanillaEnchant implements Listener{

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
		if ($event instanceof EntityDamageByEntityEvent){
			$damager = $event->getDamager();
			if (!$damager instanceof Player or $event->isCancelled()){
				return;
			}
			$item = $damager->getInventory()->getItemInHand();
			if ($item->hasEnchantment(Enchantment::FIRE_ASPECT)){
				$level = $this->getEnchantmentLevel($item, Enchantment::FIRE_ASPECT);
				$player->setOnFire($level * 80);
			}
		}
	}
}
