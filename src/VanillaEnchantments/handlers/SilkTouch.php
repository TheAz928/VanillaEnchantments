<?php
namespace VanillaEnchantments\handlers;

use pocketmine\item\enchantment\Enchantment;

use pocketmine\event\Listener;
use pocketmine\event\block\BlockBreakEvent;

use VanillaEnchantments\Core;

class SilkTouch extends VanillaEnchant implements Listener{
	
	public function __construct(Core $core){
	    $core->getServer()->getPluginManager()->registerEvents($this, $core);
	}
	
	public function onBreak(BlockBreakEvent $event): void{
	    $item = $event->getItem();
	    $block = $event->getBlock();
	    if($item->hasEnchantment(Enchantment::SILK_TOUCH) && $block->getId() !== 52){
		   $event->setDrops([Item::get($block->getId(), $block->getDamage(), 1)]);
		}
	}
}