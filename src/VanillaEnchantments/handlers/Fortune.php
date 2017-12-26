<?php
namespace VanillaEnchantments\handlers;

use pocketmine\Player;

use pocketmine\block\Block;

use pocketmine\item\Item;
use pocketmine\item\enchantment\Enchantment;

use pocketmine\event\Listener;
use pocketmine\event\block\BlockBreakEvent;

use VanillaEnchantments\Core;

class Fortune extends VanillaEnchant implements Listener{
	
	public function __construct(Core $core){
	    $core->getServer()->getPluginManager()->registerEvents($this, $core);
	}
	
	/**
	 * @param BlockBreakEvent $event
	 */
	
	public function onBlockBreak(BlockBreakEvent $event): void{
	      $player = $event->getPlayer();
	      $block = $event->getBlock();
	      $item = $player->getInventory()->getItemInHand();
	      if(!$event->isCancelled() and $item->hasEnchantment(Enchantment::FORTUNE)){
	        $level = $this->getEnchantmentLevel($item, Enchantment::FORTUNE) + 1;
	        $rand = rand(1, $level);
	        switch($block->getId()){
	           case Block::COAL_ORE:
	              if($item->isPickaxe()){
		              $event->setDrops([Item::get(Item::COAL, 0, 1 + $rand)]);
		           }
	           break;
	           case Block::LAPIS_ORE:
	              if($item->isPickaxe() and $item->getId() !== Item::WOODEN_PICKAXE){
		             $event->setDrops([Item::get(Item::DYE, 4, rand(1, 4) + $rand)]);
		           }
	           break;
	           case Block::GLOWING_REDSTONE_ORE:
	              if($item->isPickaxe() and $item->getId() !== Item::WOODEN_PICKAXE){
		             $event->setDrops([Item::get(Item::REDSTONE, 0, rand(2, 3) + $rand)]);
		           }
	           break;
	           case Block::UNLIT_REDSTONE_ORE:
	              if($item->isPickaxe() and $item->getId() !== Item::WOODEN_PICKAXE){
		              $event->setDrops([Item::get(Item::REDSTONE, 0, rand(2, 3) + $rand)]);
		           }
	           break;
	           case Block::QUARTZ_ORE:
	              if($item->isPickaxe() and $item->getId() !== Item::WOODEN_PICKAXE){
		             $event->setDrops([Item::get(Item::QUARTZ, 0, rand(1, 2) + $rand)]);
		           }
	           break;
	           case Block::DIAMOND_ORE:
	              if($item->isPickaxe() and in_array($item->getId(), [Item::WOODEN_PICKAXE, Item::STONE_PICKAXE, Item::GOLD_PICKAXE]) == false){
		             $event->setDrops([Item::get(Item::DIAMOND, 0, 1 + $rand)]);
		           }
	           break;
	           case Block::EMERALD_ORE:
	              if($item->isPickaxe() and !in_array($item->getId(), [Item::WOODEN_PICKAXE, Item::STONE_PICKAXE, Item::GOLD_PICKAXE])){
		             $event->setDrops([Item::get(Item::EMERALD, 0, 1 + $rand)]);
		           }
	           break;
	           case Block::POTATO_BLOCK:
	              if($item->isAxe() or $item->isPickaxe()){
		              if($block->getDamage() >= 7){
			              $event->setDrops([Item::get(Item::POTATO, 0, rand(1, 3) + $rand)]);
			           }
		           }
	           break;
	           case Block::CARROT_BLOCK:
	              if($item->isAxe() or $item->isPickaxe()){
		              if($block->getDamage() >= 7){
			             $event->setDrops([Item::get(Item::CARROT, 0, rand(1, 3) + $rand)]);
			           }
		           }
	           break;
	           case Block::BEETROOT_BLOCK:
	               if($item->isAxe() or $item->isPickaxe()){
		               if($block->getDamage() >= 7){
			              $event->setDrops([Item::get(Item::BEETROOT_SEEDS, 0, rand(1, 3) + $rand), Item::get(Item::BEETROOT, 0, 1)]);
			            }
		            }
	           break;
	           case Block::WHEAT_BLOCK:
	               if($item->isAxe() or $item->isPickaxe()){
		               if($block->getDamage() >= 7){
			               $event->setDrops([Item::get(Item::SEEDS, 0, rand(1, 3) + $rand), Item::get(Item::WHEAT, 0, 1)]);
			            }
		            }
	           break;
	           case Block::MELON_BLOCK:
	              if($item->isAxe() or $item->isPickaxe()){
			           $event->setDrops([Item::get(Item::MELON_SLICE, 0, rand(3, 9) + $rand)]);
		           }
	           break;
	           case Block::LEAVES:
	              if(rand(1, 100) <= 10 + $level * 2){
		              $event->setDrops([Item::get(Item::APPLE, 0, 1)]);
		           }
	           break;
	        }
	     }
	 }
}