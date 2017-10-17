<?php
namespace VanillaEnchants;

use pocketmine\item\enchantment\Enchantment;

use pocketmine\plugin\PluginBase;

# Developed by TheAz928(Az928)
# Vanilla enchants implemention
# CopyRight (C) @TheAz928 (Az928)
# All rights reserved (R)
# This software is under
# GNU General Public license :v3.0.0 and later

class Core extends PluginBase{
	
	# Store handlers in a variable for future use
	
	public $protection;
	
	public $fire_protection;
	
	public $feather_falling;
	
	public $blast_protection;
	
	public $projectile_protection;
	
	public $thorns;
	
	public $respiration;
	
	public $depth_strider;
	
	public $aqua_affinity;
	
	public $sharpness;
	
	public $smite;
	
	public $bane_of_arthropods;
	
	public $knockback;
	
	public $fire_aspect;
	
	public $looting;
	
	public $efficiency;
	
	public $silk_touch;
	
	public $unbreaking;
	
	public $fortune;
	
	public $power;
	
	public $punch;
	
	public $flame;
	
	public $infinity;
	
	public $luck_of_the_sea;
	
	public $lure;
	
	public $frost_walker;
	
	public $mending;

   private static $instance;
	
	public function onLoad(){
       self::$instance = $this;
	    $this->getServer()->getLogger()->info("§8[§aVanillaEnchants§8]§7 loading.....");
	}
	
	public function onEnable(){
	    $this->registerEnchants();
	    $this->getLogger()->info("§aVanilla Enchants§7 has been implemented and started successfully!");
	}

  public static function getInstance(){
       return self::$instance;
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
	    # $this->registerSmite(); Not needed? :P
	    # $this->registerBaneOfArthropods(); totally don't need
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
	    $this->protection = new handlers\Protection();
	    Enchantment::registerEnchantment(new Enchantment(0, "Protection", 0, 0, Enchantment::SLOT_ARMOR));
	    $this->getServer()->getPluginManager()->registerEvents($this->protection, $this);
	}
	
	public function registerFireProtection(){
	    $this->fire_protection = new handlers\FireProtection();
	    Enchantment::registerEnchantment(new Enchantment(1, "Fire protection", 1, 0, Enchantment::SLOT_ARMOR));
	    $this->getServer()->getPluginManager()->registerEvents($this->fire_protection, $this);
	}
	
	public function registerFeatherFalling(){
	    $this->feather_falling = new handlers\FeatherFalling();
	    Enchantment::registerEnchantment(new Enchantment(2, "Feather falling", 1, 0, Enchantment::SLOT_FEET));
	    $this->getServer()->getPluginManager()->registerEvents($this->feather_falling, $this);
	}
	
	public function registerBlastProtection(){
	    $this->blast_protection = new handlers\BlastProtection();
	    Enchantment::registerEnchantment(new Enchantment(3, "Blast protection", 1, 0, Enchantment::SLOT_ARMOR));
	    $this->getServer()->getPluginManager()->registerEvents($this->blast_protection, $this);
	}
	
	public function registerProjectileProtection(){
	    $this->projectile_protection = new handlers\ProjectileProtection();
	    Enchantment::registerEnchantment(new Enchantment(4, "Projectile protection", 1, 0, Enchantment::SLOT_ARMOR));
	    $this->getServer()->getPluginManager()->registerEvents($this->projectile_protection, $this);
	}
	
	public function registerThorns(){
	    $this->thorns = new handlers\Thorns();
	    Enchantment::registerEnchantment(new Enchantment(5, "Thorns", 1, 0, Enchantment::SLOT_ARMOR));
	    $this->getServer()->getPluginManager()->registerEvents($this->thorns, $this);
	}
	
	public function registerRespiration(){
	    # $this->respiration = new handlers\Respiration(); Its handled client side
	    Enchantment::registerEnchantment(new Enchantment(6, "Respiration", 1, 0, Enchantment::SLOT_HEAD));
	    # $this->getServer()->getPluginManager()->registerEvents($this->respiration, $this);
	}
	
	public function registerDepthStrider(){
	    $this->depth_strider = new handlers\DepthStrider();
	    Enchantment::registerEnchantment(new Enchantment(7, "Depth strider", 1, 0, Enchantment::SLOT_FEET));
	    $this->getServer()->getPluginManager()->registerEvents($this->depth_strider, $this);
	}
	
	public function registerAquaAffinity(){
	    # $this->aqua_affinity = new handlers\AquaAffinity(); # Its handled client side
	    Enchantment::registerEnchantment(new Enchantment(8, "Aqua Affinity", 1, 0, Enchantment::SLOT_HEAD));
	    # $this->getServer()->getPluginManager()->registerEvents($this->aqua_affinity, $this);
	}
	
	public function registerSharpness(){
	    $this->sharpness = new handlers\Sharpness();
	    Enchantment::registerEnchantment(new Enchantment(9, "Sharpness", 0, 0, Enchantment::SLOT_SWORD));
	    $this->getServer()->getPluginManager()->registerEvents($this->sharpness, $this);
	}
	
	public function registerSmite(){ # No need?
	    $this->smite = new handlers\Smite();
	    Enchantment::registerEnchantment(new Enchantment(10, "Smite", 1, 0, Enchantment::SLOT_SWORD));
	    $this->getServer()->getPluginManager()->registerEvents($this->smite, $this);
	}
	
	public function registerBaneOfArthropods(){ # No need?
	    $this->bane_of_arthropods = new handlers\BaneOfArthropods();
	    Enchantment::registerEnchantment(new Enchantment(11, "Bane of Arthropods", 1, 0, Enchantment::SLOT_SWORD));
	    $this->getServer()->getPluginManager()->registerEvents($this->bane_of_arthropods, $this);
	}
	
	public function registerKnockback(){
	    $this->knockback = new handlers\Knockback();
	    Enchantment::registerEnchantment(new Enchantment(12, "Knockback", 1, 0, Enchantment::SLOT_SWORD));
	    $this->getServer()->getPluginManager()->registerEvents($this->knockback, $this);
	}
	
	public function registerFireAspect(){
	    $this->fire_aspect = new handlers\FireAspect();
	    Enchantment::registerEnchantment(new Enchantment(13, "Fire aspect", 1, 0, Enchantment::SLOT_SWORD));
	    $this->getServer()->getPluginManager()->registerEvents($this->fire_aspect, $this);
	}
	
	public function registerLooting(){
	    $this->looting = new handlers\Looting();
	    Enchantment::registerEnchantment(new Enchantment(14, "Looting", 1, 0, Enchantment::SLOT_SWORD));
	    $this->getServer()->getPluginManager()->registerEvents($this->looting, $this);
	}
	
	public function registerEfficiency(){ # Handled client side
	    # $this->efficiency = new handlers\Efficiency();
	    Enchantment::registerEnchantment(new Enchantment(15, "Efficiency", 1, 0, Enchantment::SLOT_PICKAXE));
	    # $this->getServer()->getPluginManager()->registerEvents($this->efficiency, $this);
	}
	
	public function registerSilkTouch(){ # This enchantment is in beta
	    $this->silk_touch = new handlers\SilkTouch();
	    Enchantment::registerEnchantment(new Enchantment(16, "Silk touch", 2, 0, Enchantment::SLOT_PICKAXE));
	    $this->getServer()->getPluginManager()->registerEvents($this->silk_touch, $this);
	}
	
	public function registerUnbreaking(){
	    $this->unbreaking = new handlers\Unbreaking();
	    Enchantment::registerEnchantment(new Enchantment(17, "Unbreaking", 0, 0, Enchantment::SLOT_ALL));
	    $this->getServer()->getPluginManager()->registerEvents($this->unbreaking, $this);
	}
	
	public function registerFortune(){
	    $this->fortune = new handlers\Fortune();
	    Enchantment::registerEnchantment(new Enchantment(18, "Fortune", 0, 0, Enchantment::SLOT_PICKAXE)); # Not sure
	    $this->getServer()->getPluginManager()->registerEvents($this->fortune, $this);
	}
	
	public function registerPower(){
	    $this->power = new handlers\Power();
	    Enchantment::registerEnchantment(new Enchantment(19, "Power", 0, 0, Enchantment::SLOT_BOW));
	    $this->getServer()->getPluginManager()->registerEvents($this->power, $this);
	}
	
	public function registerPunch(){
	    $this->punch = new handlers\Punch();
	    Enchantment::registerEnchantment(new Enchantment(20, "Punch", 1, 0, Enchantment::SLOT_BOW));
	    $this->getServer()->getPluginManager()->registerEvents($this->punch, $this);
	}
	
	public function registerFlame(){
	    $this->flame = new handlers\Flame();
	    Enchantment::registerEnchantment(new Enchantment(21, "Flame", 1, 0, Enchantment::SLOT_BOW));
	    $this->getServer()->getPluginManager()->registerEvents($this->flame, $this);
	}
	
	public function registerInfinity(){
	    $this->infinity = new handlers\Infinity();
	    Enchantment::registerEnchantment(new Enchantment(22, "Infinity", 2, 0, Enchantment::SLOT_BOW));
	    $this->getServer()->getPluginManager()->registerEvents($this->infinity, $this);
	}
}