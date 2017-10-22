<?php
namespace VanillaEnchantments;

use pocketmine\item\enchantment\Enchantment;

use pocketmine\plugin\PluginBase;

# Developed by TheAz928(Az928)
# Vanilla enchants implemention
# CopyRight (C) @TheAz928 (Az928)
# All rights reserved (R)
# This software is under
# GNU General Public license :v3.0.0 and later

class Core extends PluginBase{
	
	public function onLoad(){
	    $this->getServer()->getLogger()->info("§8[§aVanillaEnchants§8]§7 loading.....");
	}
	
	public function onEnable(){
	    $this->registerEnchants();
	    $this->getLogger()->info("§aVanilla Enchants§7 has been implemented and started successfully!");
	}
   
	public function registerEnchants(){
	    $this->registerProtection();
	    $this->registerFireProtection();
	    $this->registerFeatherFalling();
	    $this->registerBlastProtection();
	    $this->registerProjectileProtection();
	    $this->registerThorns();
	    $this->registerRespiration();
	    $this->registerDepthStrider();
	    $this->registerAquaAffinity();
	    $this->registerSharpness();
	    # $this->registerSmite(); 
	    # $this->registerBaneOfArthropods();
	    $this->registerKnockback();
	    $this->registerFireAspect();
	    $this->registerLooting();
	    $this->registerEfficiency();
	    $this->registerSilkTouch();
	    $this->registerUnbreaking();
	    $this->registerFortune();
	    $this->registerPower();
	    $this->registerPunch();
	    $this->registerFlame();
	    $this->registerInfinity();
	}
	
	public function registerProtection(){
	    Enchantment::registerEnchantment(new Enchantment(0, "Protection", 0, 0, Enchantment::SLOT_ARMOR));
	return new handlers\Protection($this);
	}
	
	public function registerFireProtection(){
	    Enchantment::registerEnchantment(new Enchantment(1, "Fire protection", 1, 0, Enchantment::SLOT_ARMOR));
	return new handlers\FireProtection($this);   
	}
	
	public function registerFeatherFalling(){
	    Enchantment::registerEnchantment(new Enchantment(2, "Feather falling", 1, 0, Enchantment::SLOT_FEET));
	return new handlers\FeatherFalling($this);
	}
	
	public function registerBlastProtection(){
	    Enchantment::registerEnchantment(new Enchantment(3, "Blast protection", 1, 0, Enchantment::SLOT_ARMOR));
	return new handlers\BlastProtection($this);
	}
	
	public function registerProjectileProtection(){
	    Enchantment::registerEnchantment(new Enchantment(4, "Projectile protection", 1, 0, Enchantment::SLOT_ARMOR));
	return new handlers\ProjectileProtection($this);
	}
	
	public function registerThorns(){
	    Enchantment::registerEnchantment(new Enchantment(5, "Thorns", 1, 0, Enchantment::SLOT_ARMOR));
	return new handlers\Thorns($this);
	}
	
	public function registerRespiration(){
	    Enchantment::registerEnchantment(new Enchantment(6, "Respiration", 1, 0, Enchantment::SLOT_HEAD));
	}
	
	public function registerDepthStrider(){
	    Enchantment::registerEnchantment(new Enchantment(7, "Depth strider", 1, 0, Enchantment::SLOT_FEET));
	return new handlers\DepthStrider($this);
	}
	
	public function registerAquaAffinity(){
	    Enchantment::registerEnchantment(new Enchantment(8, "Aqua Affinity", 1, 0, Enchantment::SLOT_HEAD));
	}
	
	public function registerSharpness(){
	    Enchantment::registerEnchantment(new Enchantment(9, "Sharpness", 0, 0, Enchantment::SLOT_SWORD));
	return new handlers\Sharpness($this);
	}
	
	/*
	 * ToDo: Make this work without any other plugin's support
	 */
	
	public function registerSmite(){
	    Enchantment::registerEnchantment(new Enchantment(10, "Smite", 1, 0, Enchantment::SLOT_SWORD));
	return new handlers\Smite($this);
	}
	
	/*
	 * ToDo: Make this work without any other plugin's support
	 */
	
	public function registerBaneOfArthropods(){
	    Enchantment::registerEnchantment(new Enchantment(11, "Bane of Arthropods", 1, 0, Enchantment::SLOT_SWORD));
	return new handlers\BaneOfArthropods($this);
	}
	
	public function registerKnockback(){
	    Enchantment::registerEnchantment(new Enchantment(12, "Knockback", 1, 0, Enchantment::SLOT_SWORD));
	return new handlers\Knockback($this);
   }
	
	public function registerFireAspect(){
	    Enchantment::registerEnchantment(new Enchantment(13, "Fire aspect", 1, 0, Enchantment::SLOT_SWORD));
	return new handlers\FireAspect($this);
	}
	
	public function registerLooting(){
	    Enchantment::registerEnchantment(new Enchantment(14, "Looting", 1, 0, Enchantment::SLOT_SWORD));
	return new handlers\Looting($this);
	}
	
	public function registerEfficiency(){ 
	    Enchantment::registerEnchantment(new Enchantment(15, "Efficiency", 1, 0, Enchantment::SLOT_PICKAXE));
   }
	
	public function registerSilkTouch(){
	    Enchantment::registerEnchantment(new Enchantment(16, "Silk touch", 2, 0, Enchantment::SLOT_TOOL));
	return new handlers\SilkTouch($this);
	}
	
	public function registerUnbreaking(){
	    Enchantment::registerEnchantment(new Enchantment(17, "Unbreaking", 0, 0, Enchantment::SLOT_TOOL));
	return new handlers\Unbreaking($this);
	}
	
	public function registerFortune(){
	    Enchantment::registerEnchantment(new Enchantment(18, "Fortune", 0, 0, Enchantment::SLOT_PICKAXE)); # Not sure
	return new handlers\Fortune($this);
   }
	
	public function registerPower(){
	    Enchantment::registerEnchantment(new Enchantment(19, "Power", 0, 0, Enchantment::SLOT_BOW));
	return new handlers\Power($this);
	}
	
	public function registerPunch(){
	    Enchantment::registerEnchantment(new Enchantment(20, "Punch", 1, 0, Enchantment::SLOT_BOW));
	return new handlers\Punch($this);
	}
	
	public function registerFlame(){
	    Enchantment::registerEnchantment(new Enchantment(21, "Flame", 1, 0, Enchantment::SLOT_BOW));
	return new handlers\Flame($this);
	}
	
	public function registerInfinity(){
	    Enchantment::registerEnchantment(new Enchantment(22, "Infinity", 2, 0, Enchantment::SLOT_BOW));
	return new handlers\Infinity($this);
	}
}