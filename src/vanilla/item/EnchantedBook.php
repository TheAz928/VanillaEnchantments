<?php
namespace vanilla\item;

use pocketmine\item\Item;

class EnchantedBook extends Item{
	
	/**
	 * @param int $meta
	 */
	
	public function __construct(int $meta = 0){
	   	 parent::__construct(self::ENCHANTED_BOOK, $meta, "Enchanted Book");
	}
	
	/**
	 * @return int
	*/
	
	public function getMaxStackSize() : int{
			return 1;
	}
}
