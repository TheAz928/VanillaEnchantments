<?php

namespace VanillaEnchantments\handlers;

use pocketmine\entity\Entity;
use pocketmine\entity\projectile\Arrow;
use pocketmine\event\entity\EntityShootBowEvent;
use pocketmine\event\Listener;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\DoubleTag;
use pocketmine\nbt\tag\FloatTag;
use pocketmine\nbt\tag\ListTag;
use pocketmine\nbt\tag\ShortTag;
use VanillaEnchantments\Core;

class Flame extends VanillaEnchant implements Listener{

	public function __construct(Core $core){
		$core->getServer()->getPluginManager()->registerEvents($this, $core);
	}

	/**
	 * @void onShoot
	 * @param EntityShootBowEvent $event
	 * @priority HIGHEST
	 * ignoreCancelled false
	 */
	public function onShoot(EntityShootBowEvent $event): void{
		$player = $event->getEntity();
		$bow = $event->getBow();
		/** @var Arrow $arrow */
		$arrow = $event->getProjectile();
		if ($event->isCancelled()){
			return;
		}
		if ($bow->hasEnchantment(Enchantment::FLAME)){
			$level = $this->getEnchantmentLevel($bow, Enchantment::FLAME);
			$nbt = new CompoundTag("", [
				new ListTag("Pos", [
					new DoubleTag("", $player->x),
					new DoubleTag("", $player->y + $player->getEyeHeight()),
					new DoubleTag("", $player->z)
				]),
				new ListTag("Motion", [
					new DoubleTag("", $player->getDirectionVector()->x),
					new DoubleTag("", $player->getDirectionVector()->y),
					new DoubleTag("", $player->getDirectionVector()->z)
				]),
				new ListTag("Rotation", [
					new FloatTag("", ($player->yaw > 180 ? 360 : 0) - $player->yaw),
					new FloatTag("", -$player->pitch)
				]),
				new ShortTag("Fire", $player->isOnFire() ? 80 * 10 * $level : 80 * $level)
			]);
			$ent = Entity::createEntity("Arrow", $player->getLevel(), $nbt, $player, $arrow->isCritical());
			$ent->setMotion($ent->getMotion()->multiply($event->getForce()));
			$event->setProjectile($ent);
			$ent->setOnFire(80 * $level / 2);
		}
	}
}
