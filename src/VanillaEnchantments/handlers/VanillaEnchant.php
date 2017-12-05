<?php

namespace VanillaEnchantments\handlers;

use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\Item;
use pocketmine\Player;

class VanillaEnchant{

	const HELMET = [
		298 => 56,
		314 => 78,
		302 => 166,
		306 => 166,
		310 => 364
	];

	const CHESTPLATE = [
		299 => 81,
		315 => 113,
		303 => 241,
		307 => 241,
		311 => 529
	];

	const LEGGINGS = [
		300 => 76,
		316 => 106,
		304 => 266,
		308 => 266,
		312 => 497
	];

	const BOOTS = [
		301 => 66,
		317 => 92,
		305 => 196,
		309 => 196,
		313 => 430
	];

	const REJECTED = [
		Item::SKULL,
		Item::PUMPKIN
	];

	/**
	 * @param Player $player
	 * @param int $id
	 * @return int
	 */
	protected function getEnchantmentLevelOfArmors(Player $player, int $id): int{
		$return = 0;
		foreach ($player->getInventory()->getArmorContents() as $armor){
			if ($armor->hasEnchantment($id)){
				$return += $armor->getEnchantment($id)->getLevel();
			}
		}
		return $return;
	}

	/**
	 * @param Item $item
	 * @param int $id
	 * @return int
	 */
	protected function getEnchantmentLevel(Item $item, int $id): int{
		if ($item->hasEnchantment($id)){
			return $item->getEnchantment($id)->getLevel();
		}
		return 0;
	}

	/**
	 * @param int $id enchantment id
	 * @param int $base
	 * @param int $level
	 * @return int|float
	 */
	protected function getExtraDamage(int $id, int $base, int $level): float{
		switch ($id){
			case Enchantment::SHARPNESS:
				$dmg = (0.4 * $level) + 1;
				break;
			case Enchantment::SMITE:
				$dmg = 2.5 * $level;
				break;
			case Enchantment::BANE_OF_ARTHROPODS:
				$dmg = 2.5 * $level;
				break;
			case Enchantment::POWER:
				$dmg = (($base * (25 / 100)) * $level) + 1;
				break;
		}
		return isset($dmg) ? $dmg : 0.0;
	}

	/**
	 * @param int $id
	 * @param int $level
	 * @param int $base
	 * @return int|float
	 */
	protected function getReducedDamage(int $id, int $base, int $level): float{
		switch ($id){
			case Enchantment::FEATHER_FALLING:
				$factor = (6 / 100);
				$factor *= $level;
				$reduce = $base * $factor;
				break;
			case Enchantment::PROTECTION:
				$factor = (3 / 100);
				$factor *= $level;
				$reduce = $base * $factor;
				break;
			case Enchantment::PROJECTILE_PROTECTION:
			case Enchantment::BLAST_PROTECTION:
				$factor = (4 / 100);
				$factor *= $level;
				$reduce = $base * $factor;
				break;
			case Enchantment::FIRE_PROTECTION:
				$factor = (2 / 100);
				$factor *= $level;
				$reduce = $base * $factor;
				break;
		}
		return isset($reduce) and $reduce <= $base ? $reduce : abs($base - $reduce);
	}

	/**
	 * @void addHelmetDurability
	 * @param Player $player
	 * @param int $dur
	 */
	protected function addHelmetDurability(Player $player, int $dur): void{
		$inv = $player->getInventory();
		if ($inv->getHelmet()->getId() == 0 or in_array($inv->getHelmet()->getId(), self::REJECTED)){
			return;
		}
		$helmet = $inv->getHelmet();
		$helmet->setDamage($helmet->getDamage() - $dur > 0 ? $helmet->getDamage() - $dur : 0);
		$inv->setHelmet($helmet);
		$breakAt = self::HELMET[$helmet->getId()];
		if ($helmet->getDamage() >= $breakAt){
			$inv->setHelmet(Item::get(0, 0, 0));
		}
	}

	/**
	 * @void addChestplateDurability
	 * @param Player $player
	 * @param int $dur
	 */
	protected function addChestplateDurability(Player $player, int $dur): void{
		$inv = $player->getInventory();
		if ($inv->getChestplate()->getId() == 0){
			return;
		}
		$chestplate = $inv->getChestplate();
		$chestplate->setDamage($chestplate->getDamage() - $dur > 0 ? $chestplate->getDamage() - $dur : 0);
		$inv->setChestplate($chestplate);
		$breakAt = self::CHESTPLATE[$chestplate->getId()];
		if ($chestplate->getDamage() >= $breakAt){
			$inv->setChestplate(Item::get(0, 0, 0));
		}
	}

	/**
	 * @void addLeggingsDurability
	 * @param Player $player
	 * @param int $dur
	 */
	protected function addLeggingsDurability(Player $player, int $dur): void{
		$inv = $player->getInventory();
		if ($inv->getLeggings()->getId() == 0){
			return;
		}
		$leggings = $inv->getLeggings();
		$leggings->setDamage($leggings->getDamage() - $dur > 0 ? $leggings->getDamage() - $dur : 0);
		$inv->setLeggings($leggings);
		$breakAt = self::LEGGINGS[$leggings->getId()];
		if ($leggings->getDamage() >= $breakAt){
			$inv->setLeggings(Item::get(0, 0, 0));
		}
	}

	/**
	 * @void addBootsDurability
	 * @param Player $player
	 * @param int $dur
	 */
	protected function addBootsDurability(Player $player, int $dur): void{
		$inv = $player->getInventory();
		if ($inv->getBoots()->getId() == 0){
			return;
		}
		$boots = $inv->getBoots();
		$boots->setDamage($boots->getDamage() - $dur > 0 ? $boots->getDamage() - $dur : 0);
		$inv->setBoots($boots);
		$breakAt = self::BOOTS[$boots->getId()];
		if ($boots->getDamage() >= $breakAt){
			$inv->setBoots(Item::get(0, 0, 0));
		}
	}

	/**
	 * @void useArmors
	 * @param Player $player
	 * @param int $dmg
	 */
	public function useArmors(Player $player, int $dmg = 1): void{
		abs($dmg); # Make sure no negative value comes in since it gets negative on this function
		$this->addHelmetDurability($player, -$dmg);
		$this->addChestplateDurability($player, -$dmg);
		$this->addLeggingsDurability($player, -$dmg);
		$this->addBootsDurability($player, -$dmg);
	}
}