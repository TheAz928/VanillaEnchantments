<?php

namespace VanillaEnchantments;

use pocketmine\event\Listener;
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
	 * @void registerProtection
	 * @return Listener
	 */
	public function registerProtection(){
		Enchantment::registerEnchantment(new Enchantment(Enchantment::PROTECTION, "Protection", 0, 0, Enchantment::SLOT_ARMOR));
		return new handlers\Protection($this);
	}

	/**
	 * @void registerFireProtection
	 * @return Listener
	 */
	public function registerFireProtection(){
		Enchantment::registerEnchantment(new Enchantment(Enchantment::FIRE_PROTECTION, "Fire protection", 1, 0, Enchantment::SLOT_ARMOR));
		return new handlers\FireProtection($this);
	}

	/**
	 * @void registerFeatherFalling
	 * @return Listener
	 */
	public function registerFeatherFalling(){
		Enchantment::registerEnchantment(new Enchantment(Enchantment::FEATHER_FALLING, "Feather falling", 1, 0, Enchantment::SLOT_FEET));
		return new handlers\FeatherFalling($this);
	}

	/**
	 * @void registerBlastProtection
	 * @return Listener
	 */
	public function registerBlastProtection(){
		Enchantment::registerEnchantment(new Enchantment(Enchantment::BLAST_PROTECTION, "Blast protection", 1, 0, Enchantment::SLOT_ARMOR));
		return new handlers\BlastProtection($this);
	}

	/**
	 * @void registerProjectileProtection
	 * @return Listener
	 */
	public function registerProjectileProtection(){
		Enchantment::registerEnchantment(new Enchantment(Enchantment::PROJECTILE_PROTECTION, "Projectile protection", 1, 0, Enchantment::SLOT_ARMOR));
		return new handlers\ProjectileProtection($this);
	}

	/**
	 * @void registerThorns
	 * @return Listener
	 */
	public function registerThorns(){
		Enchantment::registerEnchantment(new Enchantment(Enchantment::THORNS, "Thorns", 1, 0, Enchantment::SLOT_ARMOR));
		return new handlers\Thorns($this);
	}

	/**
	 * @void registerRespiration
	 */
	public function registerRespiration(){
		Enchantment::registerEnchantment(new Enchantment(Enchantment::RESPIRATION, "Respiration", 1, 0, Enchantment::SLOT_HEAD));
		//returns nothing
	}

	/**
	 * @void registerDepthStrider
	 * @return Listener
	 */
	public function registerDepthStrider(){
		Enchantment::registerEnchantment(new Enchantment(Enchantment::DEPTH_STRIDER, "Depth strider", 1, 0, Enchantment::SLOT_FEET));
		return new handlers\DepthStrider($this);
	}

	/**
	 * @void registerAquaAffinity
	 */
	public function registerAquaAffinity(){
		Enchantment::registerEnchantment(new Enchantment(Enchantment::AQUA_AFFINITY, "Aqua Affinity", 1, 0, Enchantment::SLOT_HEAD));
		//returns nothing
	}

	/**
	 * @void registerSharpness
	 * @return Listener
	 */
	public function registerSharpness(){
		Enchantment::registerEnchantment(new Enchantment(Enchantment::SHARPNESS, "Sharpness", 1, 0, Enchantment::SLOT_TOOL));
		return new handlers\Sharpness($this);
	}

	/**
	 * @void registerSmite
	 * @return Listener
	 */
	public function registerSmite(){
		Enchantment::registerEnchantment(new Enchantment(Enchantment::SMITE, "Smite", 1, 0, Enchantment::SLOT_SWORD));
		return new handlers\Smite($this);
	}

	/**
	 * @void registerBaneOfArthropods
	 * @return Listener
	 */
	public function registerBaneOfArthropods(){
		Enchantment::registerEnchantment(new Enchantment(Enchantment::BANE_OF_ARTHROPODS, "Bane of Arthropods", 1, 0, Enchantment::SLOT_SWORD));
		return new handlers\BaneOfArthropods($this);
	}

	/**
	 * @void registerKnockback
	 * @return Listener
	 */
	public function registerKnockback(){
		Enchantment::registerEnchantment(new Enchantment(Enchantment::KNOCKBACK, "Knockback", 1, 0, Enchantment::SLOT_SWORD));
		return new handlers\Knockback($this);
	}

	/**
	 * @void registerFireAspect
	 * @return Listener
	 */
	public function registerFireAspect(){
		Enchantment::registerEnchantment(new Enchantment(Enchantment::FIRE_ASPECT, "Fire aspect", 1, 0, Enchantment::SLOT_SWORD));
		return new handlers\FireAspect($this);
	}

	/**
	 * @void registerLooting
	 * @return Listener
	 */
	public function registerLooting(){
		Enchantment::registerEnchantment(new Enchantment(Enchantment::LOOTING, "Looting", 1, 0, Enchantment::SLOT_SWORD));
		return new handlers\Looting($this);
	}

	/**
	 * @void registerEfficiency
	 */
	public function registerEfficiency(){
		Enchantment::registerEnchantment(new Enchantment(Enchantment::EFFICIENCY, "Efficiency", 1, 0, Enchantment::SLOT_PICKAXE));
		//returns nothing
	}

	/**
	 * @void registerSilkTouch
	 * @return Listener
	 */
	public function registerSilkTouch(){
		Enchantment::registerEnchantment(new Enchantment(Enchantment::SILK_TOUCH, "Silk touch", 2, 0, Enchantment::SLOT_TOOL));
		return new handlers\SilkTouch($this);
	}

	/**
	 * @void registerUnbreaking
	 * @return Listener
	 */
	public function registerUnbreaking(){
		Enchantment::registerEnchantment(new Enchantment(Enchantment::UNBREAKING, "Unbreaking", 0, 0, Enchantment::SLOT_TOOL));
		return new handlers\Unbreaking($this);
	}

	/**
	 * @void registerFortune
	 * @return Listener
	 */
	public function registerFortune(){
		Enchantment::registerEnchantment(new Enchantment(Enchantment::FORTUNE, "Fortune", 0, 0, Enchantment::SLOT_PICKAXE)); # Not sure
		return new handlers\Fortune($this);
	}

	/**
	 * @void registerPower
	 * @return Listener
	 */
	public function registerPower(){
		Enchantment::registerEnchantment(new Enchantment(Enchantment::POWER, "Power", 0, 0, Enchantment::SLOT_BOW));
		return new handlers\Power($this);
	}

	/**
	 * @void registerPunch
	 * @return Listener
	 */
	public function registerPunch(){
		Enchantment::registerEnchantment(new Enchantment(Enchantment::PUNCH, "Punch", 1, 0, Enchantment::SLOT_BOW));
		return new handlers\Punch($this);
	}

	/**
	 * @void registerFlame
	 * @return Listener
	 */
	public function registerFlame(){
		Enchantment::registerEnchantment(new Enchantment(Enchantment::FLAME, "Flame", 1, 0, Enchantment::SLOT_BOW));
		return new handlers\Flame($this);
	}

	/**
	 * @void registerInfinity
	 * @return Listener
	 */
	public function registerInfinity(){
		Enchantment::registerEnchantment(new Enchantment(Enchantment::INFINITY, "Infinity", 2, 0, Enchantment::SLOT_BOW));
		return new handlers\Infinity($this);
	}
}