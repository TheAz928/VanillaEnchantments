<?php
namespace VanillaEnchantments\handlers;

use pocketmine\Player;

use pocketmine\event\Listener;

use pocketmine\item\enchantment\Enchantment;

use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityShootBowEvent;
use pocketmine\event\player\PlayerInteractEvent;

use VanillaEnchantments\Core;

class Unbreaking extends VanillaEnchant implements Listener{
	
	public function __construct(Core $core){
	    $core->getServer()->getPluginManager()->registerEvents($this, $core);
	}
	
	/**
	 * @param BlockBreakEvent $event
	 */
	
	public function onBlockBreak(BlockBreakEvent $event): void{
	      $player = $event->getPlayer();
	      $item = $player->getInventory()->getItemInHand();
	      if($event->isCancelled() == false and $item->hasEnchantment(Enchantment::UNBREAKING) and rand(1, 100) <= 15){
	         $fix = $item->getEnchantment(Enchantment::UNBREAKING)->getLevel() + 1;
	         $meta = ($item->getDamage() - $fix) >= 0 ? $item->getDamage() - $fix : 0;
	         $item->setDamage($meta);
	         $player->getInventory()->setItemInHand($item);
	      }
	}
	
	/**
	 * @param PlayerInteractEvent $event
	 */
	
	public function onInteract(PlayerInteractEvent $event): void{
	      $player = $event->getPlayer();
	      $item = $player->getInventory()->getItemInHand();
	      $block = $event->getBlock();
	      if($event->isCancelled() == false){
		      if($item->isHoe() and in_array($block->getId(), [2, 3])){
			      if($item->hasEnchantment(Enchantment::UNBREAKING) and rand(1, 100) <= 10){
				      $fix = $item->getEnchantment(Enchantment::UNBREAKING)->getLevel() + 1;
			         $meta = ($item->getDamage() - $fix) >= 0 ? $item->getDamage() - $fix : 0;
			         $item->setDamage($meta);
			         $player->getInventory()->setItemInHand($item);
				   }
		     }
		 }
	}
	
	/**
	 * @param EntityDamageEvent $event
	 */
	
	public function onDamage(EntityDamageEvent $event): void{
	      $player = $event->getEntity();
	      if($player instanceof Player and $event->isCancelled() == false){
		      $inv = $player->getInventory();
		      $helmet = $inv->getHelmet();
		      $chest = $inv->getChestplate();
		      $leg = $inv->getLeggings();
		      $boots = $inv->getBoots();
		      if($helmet->hasEnchantment(Enchantment::UNBREAKING) and rand(1, 100) <= 10){
			      $lvl = $this->getEnchantmentLevel($helmet, Enchantment::UNBREAKING) + 1;
			      $this->addHelmetDurability($player, $lvl);
			   }
			   if($chest->hasEnchantment(Enchantment::UNBREAKING) and rand(1, 100) <= 10){
			     $lvl = $this->getEnchantmentLevel($chest, Enchantment::UNBREAKING) + 1;
			     $this->addChestplateDurability($player, $lvl);
			   }
			   if($leg->hasEnchantment(Enchantment::UNBREAKING) and rand(1, 100) <= 10){
			     $lvl = $this->getEnchantmentLevel($leg, Enchantment::UNBREAKING) + 1;
			     $this->addLeggingsDurability($player, $lvl);
			   }
			   if($boots->hasEnchantment(Enchantment::UNBREAKING) and rand(1, 100) <= 10){
			     $lvl = $this->getEnchantmentLevel($boots, Enchantment::UNBREAKING) + 1;
			     $this->addBootsDurability($player, $lvl);
			   }
		 }
	}
	
	/**
	 * @param EntityDamageEvent $event
	 */
	
	public function onItemDamage(EntityDamageEvent $event): void{
	       if($event instanceof EntityDamageByEntityEvent){
		       $player = $event->getEntity();
		       $damager = $event->getDamager();
		       if($damager instanceof Player == false){
			      return;
			    }
			    $item = $damager->getInventory()->getItemInHand();
			    if($item->hasEnchantment(Enchantment::UNBREAKING) and rand(1, 100) <= 10){
			       $fix = $item->getEnchantment(Enchantment::UNBREAKING)->getLevel() + 1;
			       $meta = ($item->getDamage() - $fix) >= 0 ? $item->getDamage() - $fix : 0;
			       $item->setDamage($meta);
			       $damager->getInventory()->setItemInHand($item);
			   }
	    }
	}
	
	/**
	 * @param EntityShootBowEvent $event
	 */

   public function onShoot(EntityShootBowEvent $event): void{
         $player = $event->getEntity();
         $bow = $event->getBow();
         if($event->isCancelled() == false and $bow->hasEnchantment(Enchantment::UNBREAKING) and rand(1, 100) <= 15 and $player instanceof Player){
	         $fix = $bow->getEnchantment(Enchantment::UNBREAKING)->getLevel() + 1;
	         $meta = ($bow->getDamage() - $fix) >= 0 ? $bow->getDamage() - $fix : 0;
	         $bow->setDamage($meta);
	         $player->getInventory()->setItemInHand($bow);
	     }
    }
}