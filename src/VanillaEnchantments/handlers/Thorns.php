<?php
namespace VanillaEnchantments\handlers;

use pocketmine\Player;

use pocketmine\item\Item;
use pocketmine\item\enchantment\Enchantment;

use pocketmine\event\Listener;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;

use VanillaEnchantments\Core;

class Thorns extends VanillaEnchant implements Listener{
	
	public function __construct(Core $core){
	    $core->getServer()->getPluginManager()->registerEvents($this, $core);
	}
	
	/**
	 * @param EntityDamageEvent $event
	 */
	
	public function onDamage(EntityDamageEvent $event): void{
	      $player = $event->getEntity();
	      if($player instanceof Player and $event instanceof EntityDamageByEntityEvent){
		      $damager = $event->getDamager();
		      if($event->isCancelled()){
			      return;
			   }
			   # ToDo: reduce spamm here
		     foreach($player->getInventory()->getArmorContents() as $armor){
		        $level = $this->getEnchantmentLevel($armor, Enchantment::THORNS);
		        if(in_array($armor->getId(), [Item::LEATHER_HELMET, Item::CHAIN_HELMET, Item::IRON_HELMET, Item::GOLD_HELMET, Item::DIAMOND_HELMET])){
			        $chance = 15 * $level;
			        $chance = $chance > 45 ? 45 : $chance;
			        if(rand(1, 100) <= $chance){
				        $this->addHelmetDurability($player, -3);
				        $damager->attack(new EntityDamageByEntityEvent($player, $damager, $event::CAUSE_CUSTOM, rand(1, 5)));
				        break;
				      }
			      }
			      if(in_array($armor->getId(), [Item::LEATHER_CHESTPLATE, Item::CHAIN_CHESTPLATE, Item::IRON_CHESTPLATE, Item::GOLD_CHESTPLATE, Item::DIAMOND_CHESTPLATE])){
				      $chance = 15 * $level;
			         $chance = $chance > 45 ? 45 : $chance;
			         if(rand(1, 100) <= $chance){
				         $this->addChestplateDurability($player, -3);
				         $damager->attack(new EntityDamageByEntityEvent($player, $damager, $event::CAUSE_CUSTOM, rand(1, 5)));
				         break;
				      }
				   }
				   if(in_array($armor->getId(), [Item::LEATHER_LEGGINGS, Item::CHAIN_LEGGINGS, Item::IRON_LEGGINGS, Item::GOLD_LEGGINGS, Item::DIAMOND_LEGGINGS])){
					   $chance = 15 * $level;
			         $chance = $chance > 45 ? 45 : $chance;
			         if(rand(1, 100) <= $chance){
				        $this->addLeggingsDurability($player, -3);
				        $damager->attack(new EntityDamageByEntityEvent($player, $damager, $event::CAUSE_CUSTOM, rand(1, 5)));
				        break;
				      }
				   }
				   if(in_array($armor->getId(), [Item::LEATHER_BOOTS, Item::CHAIN_BOOTS, Item::IRON_BOOTS, Item::GOLD_BOOTS, Item::DIAMOND_BOOTS])){
					   $chance = 15 * $level;
			         $chance = $chance > 45 ? 45 : $chance;
			         if(rand(1, 100) <= $chance){
				         $this->addBootsDurability($player, -3);
				         $damager->attack(new EntityDamageByEntityEvent($player, $damager, $event::CAUSE_CUSTOM, rand(1, 5)));
				         break;
				      }
				  }
		    }
		 }
	}
}