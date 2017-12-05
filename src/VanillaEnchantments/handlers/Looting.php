<?php

namespace VanillaEnchantments\handlers;

use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDeathEvent;
use pocketmine\event\Listener;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\Player;
use VanillaEnchantments\Core;

class Looting extends VanillaEnchant implements Listener{

	public function __construct(Core $core){
		$core->getServer()->getPluginManager()->registerEvents($this, $core);
	}

	/**
	 * @void onDeath
	 * @param EntityDeathEvent $event
	 * @priority LOWESR
	 * ignoreCancelled true
	 */
	public function onDeath(EntityDeathEvent $event): void{
		$player = $event->getEntity();
		if ($player instanceof Player){
			return;
		}
		$cause = $player->getLastDamageCause();
		if ($cause instanceof EntityDamageByEntityEvent){
			$damager = $cause->getDamager();
			if (!$damager instanceof Player){
				return;
			} else{
				$item = $damager->getInventory()->getItemInHand();
			}
		} else{
			return;
		}
		if ($item->hasEnchantment(Enchantment::LOOTING)){
			$drops = [];
			foreach ($event->getDrops() as $drop){
				$rand = rand(1, $this->getEnchantmentLevel($item, Enchantment::LOOTING) + 1);
				$drop->setCount($drop->getCount() + $rand);
				$drops[] = $drop;
			}
			$event->setDrops($drops);
		}
	}
}