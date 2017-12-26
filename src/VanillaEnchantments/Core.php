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
	    $this->registerSmite(); 
	    $this->registerBaneOfArthropods();
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
	
	/**
	 * @return Protection
	 */
	
	public function registerProtection(){
	    Enchantment::registerEnchantment(new Enchantment(Enchantment::PROTECTION, "Protection", 0, Enchantment::SLOT_ARMOR, 5));
	    return new handlers\Protection($this);
	}
	
	/**
	 * @return FireProtection
	 */
	
	public function registerFireProtection(){
	    Enchantment::registerEnchantment(new Enchantment(Enchantment::FIRE_PROTECTION, "Fire protection", 1, Enchantment::SLOT_ARMOR, 5));
   	 return new handlers\FireProtection($this);   
	}
	
	/**
	 * @return FeatherFalling
	 */
	
	public function registerFeatherFalling(){
	    Enchantment::registerEnchantment(new Enchantment(Enchantment::FEATHER_FALLING, "Feather falling", 1, Enchantment::SLOT_FEET, 4));
	    return new handlers\FeatherFalling($this);
	}
	
	/**
	 * @return BlastProtection
	 */
	
	public function registerBlastProtection(){
	    Enchantment::registerEnchantment(new Enchantment(Enchantment::BLAST_PROTECTION, "Blast protection", 1, Enchantment::SLOT_ARMOR, 5));
	    return new handlers\BlastProtection($this);
	}
	
	/**
	 * @return ProjectileProtection
	 */
	
	public function registerProjectileProtection(){
	    Enchantment::registerEnchantment(new Enchantment(Enchantment::PROJECTILE_PROTECTION, "Projectile protection", 1, Enchantment::SLOT_ARMOR, 5));
	    return new handlers\ProjectileProtection($this);
	}
	
	/**
	 * @return Thorns
	 */
	
	public function registerThorns(){
	    Enchantment::registerEnchantment(new Enchantment(Enchantment::THORNS, "Thorns", 1, Enchantment::SLOT_ARMOR, 3));
	    return new handlers\Thorns($this);
	}
	
	/**
	 * @return null
	 */
	
	public function registerRespiration(){
	    Enchantment::registerEnchantment(new Enchantment(Enchantment::RESPIRATION, "Respiration", 1, Enchantment::SLOT_HEAD, 3));
	}
	
	/**
	 * @return DepthStrider
	 */
	
	public function registerDepthStrider(){
	    Enchantment::registerEnchantment(new Enchantment(Enchantment::DEPTH_STRIDER, "Depth strider", 1, Enchantment::SLOT_FEET, 3));
	    return new handlers\DepthStrider($this);
	}
	
	/**
	 * @return null
	 */
	
	public function registerAquaAffinity(){
	    Enchantment::registerEnchantment(new Enchantment(Enchantment::AQUA_AFFINITY, "Aqua Affinity", 1, Enchantment::SLOT_HEAD, 3));
	}
	
	/**
	 * @return Sharpness
	 */
	
	public function registerSharpness(){
	    Enchantment::registerEnchantment(new Enchantment(Enchantment::SHARPNESS, "Sharpness", 1, Enchantment::SLOT_TOOL, 5));
	    return new handlers\Sharpness($this);
	}
	
	/**
	 * @return Smite
	 */
	
	public function registerSmite(){
	    Enchantment::registerEnchantment(new Enchantment(Enchantment::SMITE, "Smite", 1, Enchantment::SLOT_SWORD, 5));
	    return new handlers\Smite($this);
	}
	
	/**
	 * @return BaneOfArthropods
	 */
	
	public function registerBaneOfArthropods(){
	    Enchantment::registerEnchantment(new Enchantment(Enchantment::BANE_OF_ARTHROPODS, "Bane of Arthropods", 1, Enchantment::SLOT_SWORD, 5));
	    return new handlers\BaneOfArthropods($this);
	}
	
	/**
	 * @return Knockback
	 */

	public function registerKnockback(){
	    Enchantment::registerEnchantment(new Enchantment(Enchantment::KNOCKBACK, "Knockback", 1, Enchantment::SLOT_SWORD, 2));
       return new handlers\Knockback($this);
   }

   /**
	 * @return FireAspect
	 */
	
	public function registerFireAspect(){
	    Enchantment::registerEnchantment(new Enchantment(Enchantment::FIRE_ASPECT, "Fire aspect", 1, Enchantment::SLOT_SWORD, 2));
	    return new handlers\FireAspect($this);
	}
	
	/**
	 * @return Looting
	 */
	
	public function registerLooting(){
	    Enchantment::registerEnchantment(new Enchantment(Enchantment::LOOTING, "Looting", 1, Enchantment::SLOT_SWORD, 3));
	    return new handlers\Looting($this);
	}
	
	/**
	 * @return null
	 */
	
	public function registerEfficiency(){ 
	    Enchantment::registerEnchantment(new Enchantment(Enchantment::EFFICIENCY, "Efficiency", 1, Enchantment::SLOT_PICKAXE, 5));
   }

   /**
	 * @return SilkTouch
	 */
	
	public function registerSilkTouch(){
	    Enchantment::registerEnchantment(new Enchantment(Enchantment::SILK_TOUCH, "Silk touch", 2, Enchantment::SLOT_TOOL, 1));
   	 return new handlers\SilkTouch($this);
	}
	
	/**
	 * @return Unbreaking
	 */
	
	public function registerUnbreaking(){
	    Enchantment::registerEnchantment(new Enchantment(Enchantment::UNBREAKING, "Unbreaking", 0, Enchantment::SLOT_TOOL, 3));
   	  return new handlers\Unbreaking($this);
	}
	
	/**
	 * @return Fortune
	 */
	
	public function registerFortune(){
	    Enchantment::registerEnchantment(new Enchantment(Enchantment::FORTUNE, "Fortune", 0, Enchantment::SLOT_PICKAXE, 3));
	    return new handlers\Fortune($this);
   }

   /**
	 * @return Power
	 */
	
	public function registerPower(){
	    Enchantment::registerEnchantment(new Enchantment(Enchantment::POWER, "Power", 0, Enchantment::SLOT_BOW, 5));
	    return new handlers\Power($this);
	}
	
	/**
	 * @return Punch
	 */
	
	public function registerPunch(){
	    Enchantment::registerEnchantment(new Enchantment(Enchantment::PUNCH, "Punch", 1, Enchantment::SLOT_BOW, 2));
	    return new handlers\Punch($this);
	}
	
	/**
	 * @return Flame
	 */
	
	public function registerFlame(){
	    Enchantment::registerEnchantment(new Enchantment(Enchantment::FLAME, "Flame", 1, Enchantment::SLOT_BOW, 2));
	    return new handlers\Flame($this);
	}
	
	/**
	 * @return Infinity
	 */
	
	public function registerInfinity(){
	    Enchantment::registerEnchantment(new Enchantment(Enchantment::INFINITY, "Infinity", 2, Enchantment::SLOT_BOW, 1));
	    return new handlers\Infinity($this);
	}
}