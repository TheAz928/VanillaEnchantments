<?php
namespace vanilla;

use pocketmine\Player;

use pocketmine\scheduler\PluginTask;

class DamageArmorTask extends PluginTask{
	
	/** @var int[] */
	private $armor = [];
	
	/** @var int[] */
	private $helmet = [];
	
	/** @var int[] */
	private $leggings = [];
	
	/** @var int[] */
	private $chestplate = [];
	
	/** @var int[] */
	private $boots = [];
	
	/**
	 * DamageArmorTask constructor
	 *
	 * @param Core $core
	 */
	
	public function __construct(Core $core){
			parent::__construct($core);
			$core->getServer()->getScheduler()->scheduleRepeatingTask($this, $core->getConfig()->get("check.time", 2) * 20);
	}
	
	/**
	 * @param Player $player
	 * @param int $damage
	 */
	
	public function addArmorQueue(Player $player, int $damage = 1) : void{
			if(isset($this->armor[$player->getName()]) == false){
				$this->armor[$player->getName()] = 0;
			}
			$this->armor[$player->getName()] += $damage;
	}
	
	/**
	 * @param Player $player
	 * @param int $damage
	 */
	
	public function addHelmetQueue(Player $player, int $damage = 1) : void{
			if(isset($this->helmet[$player->getName()]) == false){
				$this->helmet[$player->getName()] = 0;
			}
			$this->helmet[$player->getName()] += $damage;
	}
	
	/**
	 * @param Player $player
	 * @param int $damage
	 */
	
	public function addChestplateQueue(Player $player, int $damage = 1) : void{
			if(isset($this->chestplate[$player->getName()]) == false){
				$this->chestplate[$player->getName()] = 0;
			}
			$this->chestplate[$player->getName()] += $damage;
	}
	
	/**
	 * @param Player $player
	 * @param int $damage
	 */
	
	public function addBootsQueue(Player $player, int $damage = 1) : void{
			if(isset($this->boots[$player->getName()]) == false){
				$this->boots[$player->getName()] = 0;
			}
			$this->boots[$player->getName()] += $damage;
	}
	
	/**
	 * @param int $tick
	 */
	
	public function onRun(int $tick){
			foreach($this->armor as $name => $dat){
				if($dat == 0){
					unset($this->armor[$name]);
					continue;
				}
				if(($player = $this->getOwner()->getServer()->getPlayer($name)) == null){
					unset($this->armor[$name]);
					continue;
				}
				$this->getOwner()->useArmors($player, $dat);
				$this->armor[$name] = 0;
			}
			foreach($this->helmet as $name => $dat){
				if($dat == 0){
					unset($this->helmet[$name]);
					continue;
				}
				if(($player = $this->getOwner()->getServer()->getPlayer($name)) == null){
					unset($this->helmet[$name]);
					continue;
				}
				$this->getOwner()->damageHelmet($player, $dat);
				$this->helmet[$name] = 0;
			}
			foreach($this->chestplate as $name => $dat){
				if($dat == 0){
					unset($this->chestplate[$name]);
					continue;
				}
				if(($player = $this->getOwner()->getServer()->getPlayer($name)) == null){
					unset($this->chestplate[$name]);
					continue;
				}
				$this->getOwner()->damageChestplate($player, $dat);
				$this->chestplate[$name] = 0;
			}
			foreach($this->leggings as $name => $dat){
				if($dat == 0){
					unset($this->leggings[$name]);
					continue;
				}
				if(($player = $this->getOwner()->getServer()->getPlayer($name)) == null){
					unset($this->leggings[$name]);
					continue;
				}
				$this->getOwner()->damageLeggings($player, $dat);
				$this->leggings[$name] = 0;
			}
			foreach($this->boots as $name => $dat){
				if($dat == 0){
					unset($this->boots[$name]);
					continue;
				}
				if(($player = $this->getOwner()->getServer()->getPlayer($name)) == null){
					unset($this->boots[$name]);
					continue;
				}
				$this->getOwner()->damageBoots($player, $dat);
				$this->boots[$name] = 0;
			}
	}
}