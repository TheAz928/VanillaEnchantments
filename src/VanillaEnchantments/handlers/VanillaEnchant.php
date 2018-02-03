<?php

namespace VanillaEnchantments\handlers;

use pocketmine\Player;

use pocketmine\item\Item;
use pocketmine\item\enchantment\Enchantment;

class VanillaEnchant{
	
	# ToDo: Move these values into Item const
	
	const HELMET =  [
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
	      Item::PUMPKIN,
	      Item::AIR
	];
	
	/**
	 * @param Player $player
	 * @param Int $id
	 * @return Int 
	 */
	
	protected function getEnchantmentLevelOfArmors(Player $player, Int $id): Int{
		 $return = 0;
	    foreach($player->getArmorInventory()->getContents() as $armor){
	       if($armor->hasEnchantment($id)){
		      $return += $armor->getEnchantment($id)->getLevel();
		    }
	    }
	    return $return;
	}
	
	/**
	 * @param Item $item
	 * @param Int $id
	 * @return Int 
	 */
	
	protected function getEnchantmentLevel(Item $item, Int $id): Int{
	    if($item->hasEnchantment($id)){
		   return $item->getEnchantment($id)->getLevel();
		 }
	return 0;
	}
	
	/**
	 * @param Int $id enchantment id
	 * @param Int $base
	 * @param Int $level
	 * @return Int|float
	 */
	
	protected function getExtraDamage(Int $id, Int $base, Int $level): float{
	     switch($id){
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
	           $dmg = (($base * (25 / 100))  * $level) + 1;
	        break;    
	     }
	     return isset($dmg) ? $dmg : 0.0;
	}
	
	/**
	 * @param Int $id
	 * @param Int $level
	 * @param Int $base
	 * @return Int|float
	 */
	
	protected function getReducedDamage(Int $id, Int $base, Int $level): float{
	     switch($id){
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
	 * @param Player $player
	 * @param Int $dur
	 */
	
	protected function addHelmetDurability(Player $player, Int $dur): void{
	    $inv = $player->getArmorInventory();
	    if(in_array($inv->getHelmet()->getId(), self::REJECTED)){
		    return;
		 }
		 $helmet = $inv->getHelmet();
		 $helmet->setDamage($helmet->getDamage() - $dur > 0 ? $helmet->getDamage() - $dur : 0);
		 $inv->setHelmet($helmet);
		 $breakAt = self::HELMET[$helmet->getId()];
		 if($helmet->getDamage() >= $breakAt){
			$inv->setHelmet(Item::get(0, 0, 0));
		 }
	}
	
	/**
	 * @param Player $player
	 * @param Int $dur
	 */
	
	protected function addChestplateDurability(Player $player, Int $dur): void{
	    $inv = $player->getArmorInventory();
	    if($inv->getChestplate()->getId() == 0){
		   return;
		 }
		 $chestplate = $inv->getChestplate();
		 $chestplate->setDamage($chestplate->getDamage() - $dur > 0 ? $chestplate->getDamage() - $dur : 0);
		 $inv->setChestplate($chestplate);
		 $breakAt = self::CHESTPLATE[$chestplate->getId()];
		 if($chestplate->getDamage() >= $breakAt){
			$inv->setChestplate(Item::get(0, 0, 0));
		 }
	}
	
	/**
	 * @param Player $player
	 * @param Int $dur
	 */
	
	protected function addLeggingsDurability(Player $player, Int $dur): void{
	    $inv = $player->getArmorInventory();
	    if($inv->getLeggings()->getId() == 0){
		   return;
		 }
		 $leggings = $inv->getLeggings();
		 $leggings->setDamage($leggings->getDamage() - $dur > 0 ? $leggings->getDamage() - $dur : 0);
		 $inv->setLeggings($leggings);
		 $breakAt = self::LEGGINGS[$leggings->getId()];
		 if($leggings->getDamage() >= $breakAt){
			$inv->setLeggings(Item::get(0, 0, 0));
		 }
	}
	
	/**
	 * @param Player $player
	 * @param Int $dur
	 */
	
	protected function addBootsDurability(Player $player, Int $dur): void{
	    $inv = $player->getArmorInventory();
	    if($inv->getBoots()->getId() == 0){
		   return;
		 }
		 $boots = $inv->getBoots();
		 $boots->setDamage($boots->getDamage() - $dur > 0 ? $boots->getDamage() - $dur : 0);
		 $inv->setBoots($boots);
		 $breakAt = self::BOOTS[$boots->getId()];
		 if($boots->getDamage() >= $breakAt){
			$inv->setBoots(Item::get(0, 0, 0));
		 }
	}
	
	/**
	 * @param Player $player
	 * @param Int $dmg
	 */
	
	public function useArmors(Player $player, Int $dmg = 1): void{
		 abs($dmg); # Make sure no negative value comes in since it gets negative on this function
	    $this->addHelmetDurability($player, -$dmg);
	    $this->addChestplateDurability($player, -$dmg);
	    $this->addLeggingsDurability($player, -$dmg);
	    $this->addBootsDurability($player, -$dmg);
	}
}
