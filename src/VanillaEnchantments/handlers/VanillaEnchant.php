<?php
namespace VanillaEnchantments\handlers;

use pocketmine\Player;

use pocketmine\item\Item;
use pocketmine\item\enchantment\Enchantment;

class VanillaEnchant{
	
	/*
	 * Player $player
	 * Int $id
	 * @return Int 
	 */
	
	protected function getEnchantmentLevelOfArmors(Player $player, Int $id): Int{
		 $return = 0;
	    foreach($player->getInventory()->getArmorContents() as $armor){
	       if($armor->hasEnchantment($id)){
		      $return += $armor->getEnchantment($id)->getLevel();
		    }
	    }
	return $return;
	}
	
	/*
	 * Item $item
	 * Int $id
	 * @return Int 
	 */
	
	protected function getEnchantmentLevel(Item $item, Int $id): Int{
	    if($item->hasEnchantment($id)){
		   return $item->getEnchantment($id)->getLevel();
		 }
	return 0;
	}
	
	/*
	 * Int $id enchantment id
	 * Int $base
	 * Int $level
	 * @return Int|float
	 */
	
	protected function getExtraDamage(Int $id, Int $base, Int $level): float{
	     switch($id){
	        case Enchantment::SHARPNESS:
	           $dmg = 0.4 * $level + 1;
	        break;
	        case Enchantment::SMITE:
	           $dmg = 2.5 * $level;
	        break;
	        case Enchantment::BANE_OF_ARTHROPODS:
	           $dmg = 2.5 * $level;
	        break;
	        case Enchantment::POWER:
	           $dmg = ($base * (25 / 100))  * $level + 1;
	           round($dmg);
	        break;    
	     }
	return isset($dmg) ? $dmg : 0.0;
	}
	
	/*
	 * Int $id
	 * Int $level
	 * Int $base
	 * @return Int|float
	 */
	
	protected function getReducedDamage(Int $id, Int $base, Int $level): float{
	     switch($id){
	        case Enchantment::FEATHER_FALLING:
	           $factor = (6 / 100);
              $factor *= $level;
	           $reduce = $base * $factor;
	        break;
	        case Enchantment::PROJECTILE_PROTECTION:
		        $factor = (4 / 100);
              $factor *= $level;
	           $reduce = $base * $factor;
	        break;
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
	return isset($reduce) ? round($reduce) : 0.0;
	}
	
	/*
	 * @void addHelmetDurability
	 * Player $player
	 * Int $dur
	 */
	
	protected function addHelmetDurability(Player $player, Int $dur): void{
	    $inv = $player->getInventory();
	    if($inv->getHelmet()->getId() == 0){
		   return;
		 }
		 $helmet = $inv->getHelmet();
		 $helmet->setDamage($helmet->getDamage() - $dur > 0 ? $helmet->getDamage() - $dur : 0);
		 $inv->setHelmet($helmet);
	}
	
	/*
	 * @void addChestplateDurability
	 * Player $player
	 * Int $dur
	 */
	
	protected function addChestplateDurability(Player $player, Int $dur): void{
	    $inv = $player->getInventory();
	    if($inv->getChestplate()->getId() == 0){
		   return;
		 }
		 $chestplate = $inv->getChestplate();
		 $chestplate->setDamage($chestplate->getDamage() - $dur > 0 ? $chestplate->getDamage() - $dur : 0);
		 $inv->setChestplate($chestplate);
	}
	
	/*
	 * @void addLeggingsDurability
	 * Player $player
	 * Int $dur
	 */
	
	protected function addLeggingsDurability(Player $player, Int $dur): void{
	    $inv = $player->getInventory();
	    if($inv->getLeggings()->getId() == 0){
		   return;
		 }
		 $leggings = $inv->getLeggings();
		 $leggings->setDamage($leggings->getDamage() - $dur > 0 ? $leggings->getDamage() - $dur : 0);
		 $inv->setLeggings($leggings);
	}
	
	/*
	 * @void addBootsDurability
	 * Player $player
	 * Int $dur
	 */
	
	protected function addBootsDurability(Player $player, Int $dur): void{
	    $inv = $player->getInventory();
	    if($inv->getBoots()->getId() == 0){
		   return;
		 }
		 $boots = $inv->getBoots();
		 $boots->setDamage($boots->getDamage() - $dur > 0 ? $boots->getDamage() - $dur : 0);
		 $inv->setBoots($boots);
	}
}