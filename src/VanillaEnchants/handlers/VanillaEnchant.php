<?php
namespace VanillaEnchants\handlers;

use pocketmine\Player;

class VanillaEnchant{
	
	protected function getArmorPoints(Player $player, Int $id){
		 $return = 0;
	    foreach($player->getInventory()->getArmorContents() as $armor){
	       if($armor->hasEnchantment($id)){
		      $return += $armor->getEnchantment($id)->getLevel();
		    }
	    }
	return (int) $return;
	}
}