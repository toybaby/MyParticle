<?php

namespace MyParticle;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\level\Position;
use pocketmine\level\Level;
use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\utils\Config;
use pocketmine\math\Vector3;
use pocketmine\entity\Entity;
use pocketmine\level\format\mcregion\Chunk;
use pocketmine\level\format\FullChunk;
use pocketmine\scheduler\PluginTask;
use pocketmine\scheduler\CallbackTask;
use pocketmine\block\Block;
use pocketmine\nbt\NBT;
use pocketmine\nbt\tag\Byte;
use pocketmine\nbt\tag\Compound;
use pocketmine\nbt\tag\Double;
use pocketmine\nbt\tag\Enum;
use pocketmine\nbt\tag\Float;
use pocketmine\nbt\tag\Int;
use pocketmine\nbt\tag\String;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\tile\Sign;
use pocketmine\tile\Tile;
use pocketmine\utils\TextFormat;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\Entity\EntityShootBowEvent;
use pocketmine\level\Position\getLevel;
use pocketmine\level\particle\HeartParticle;
use pocketmine\level\particle\PortalParticle;

class MyParticle extends PluginBase implements Listener{
	
	public function onEnable(){ 
		$this->getLogger()->info("MyParticle Is Loading!");
		$this->getServer()->getPluginManager()->registerEvents ( $this, $this );
		$this->getServer()->getScheduler()->scheduleRepeatingTask(new CallbackTask(
		[$this,"Particle"]),20);
		$this->getLogger()->info("MyParticle Loaded !!!!");
	}
	
	public function PlayerQuit(PlayerQuitEvent $event){
	$type = "Portal";
	$level = $event->getPlayer()->getLevel();
	$round = 2;
	$pos = $pos2 = new Vector3 ($event->getPlayer()->getX(), $event->getPlayer()->getY(),$event->getPlayer()->getZ());
	$this->addRoundParticle($pos,$type,$round,$level);
	}
	
	public function PlayerJoin(PlayerJoinEvent $event){
	$type = "Heart";
	$level = $event->getPlayer()->getLevel();
	$round = 5;
	$pos = $pos2 = new Vector3 ($event->getPlayer()->getX(), $event->getPlayer()->getY(),$event->getPlayer()->getZ());
	$this->addRoundParticle($pos,$type,$round,$level);
	}
	
	public function Particle(){
		foreach ($this->getServer()->getOnlinePlayers() as $pl) {
		$type = "Portal";
		$level = $pl->getLevel();
		$round = 5;
		$pos = $pos2 = new Vector3 ($pl->getX(), $pl->getY(),$pl->getZ());
		$this->addRoundParticle($pos,$type,$round,$level);
		$round = 1;
		$type = "Heart";
		$this->addRoundParticle($pos,$type,$round,$level);
		}
	}
	
	public function addRoundParticle($pos,$type,$round,$level){
		if($type == "Heart"){
			for($i1 = 0; $i1 <= 24; $i1 ++){
				$a = $i1 * 15 ;
				if($a != 0){
				$x = $pos->x + $round/cos($a/ 180 * M_PI);
				$z = $pos->z + $round/sin($a/ 180 * M_PI);
				}else{
				$x = $pos->x + $round;
				$z = $pos->z + $round;
				}
				$rpos = new Vector3 ($x ,$pos->y, $z);
				$w1 = new HeartParticle($rpos);
				$level->addParticle($w1);
			}
		}
		if($type == "Portal"){
			for($i1 = 0; $i1 <= 24; $i1 ++){
				$a = $i1 * 15 ;
				if($a != 0){
				$x = $pos->x + $round/cos($a/ 180 * M_PI);
				$z = $pos->z + $round/sin($a/ 180 * M_PI);
				}else{
				$x = $pos->x + $round;
				$z = $pos->z + $round;
				}
				$rpos = new Vector3 ($x ,$pos->y, $z);
				$w1 = new PortalParticle($rpos);
				$level->addParticle($w1);
			}
		}
	}
	
	public function onDisable(){
		$this->getLogger()->info("MyParticle Unload Success!");
	}
	
}
