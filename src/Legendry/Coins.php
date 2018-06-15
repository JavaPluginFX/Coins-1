<?php

namespace Legendry;

use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat as Color;
use pocketmine\utils\Config;
use pocketmine\Player;
use pocketmine\tile\Sign;
use pocketmine\event\Listeners;
use pocketmine\level\Level;
use pocketmine\item\Item;
use pocketmine\block\Block;
use pocketmine\level\Position;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\player\PlayerLoginEvent;


class Coins extends PluginBase implements Listener {
	
	public $prefix = Color::WHITE . "[" . Color::GOLD . "Coins" . Color::WHITE . "] ";
	
	public function onEnable() {
		
		$this->getLogger()->info($this->prefix . Color::GREEN . "wurde erfolgreich aktiviert!");
        $this->getLogger()->info($this->prefix . Color::AQUA . "Programmierert von " . Color::DARK_PURPLE . " Legendry");
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		
    }
    
    public function onLogin(PlayerLoginEvent $event) {
    	
    	$player = $event->getPlayer();
        $uuid = $player->getClientID();
        if (!is_file("/home/Cloud/plugins/Coins/resources/" . $player->getName() . ".yml")) {
        	
        	$playerfile = new Config("/home/Cloud/plugins/Coins/resources/" . $player->getName() . ".yml", Config::YAML);
            $playerfile->set("coins", 100);
            $playerfile->save();
            
        }
        
    }
    
    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args): bool{
        if($cmd->getName() == "coins"){
            switch($args[0]){
                case "add":
                    if(!empty($args[1]) && !empty($args[2])){
                        API::addCoins($args[1], intval($args[2]));
                        $sender->sendMessage("�c".$player." hat ".$args[2]." Coins gekriegt");
                    }else{
                        $sender->sendMessage("Usage: /coins add <player> <coins>");
                    }
                    break;
                case "set":
                    if(!empty($args[1]) && !empty($args[2])){
                        API::setCoins($args[1], intval($args[2]));
                        $sender->sendMessage("�c".$player." hat nun ".$args[2]." Coins");
                    }else{
                        $sender->sendMessage("Usage: /coins set <player> <coins>");
                        }
                    break;
                case "remove":
                    if(!empty($args[1]) && !empty($args[2])){
                        API::removeCoins($args[1], intval($args[2]));
                        $sender->sendMessage("�c".$player." wurden ".$args[2]." Coins removed!");
                    }else{
                        $sender->sendMessage("Usage: /coins remove <player> <coins>");
                        }
                        break;
                    
            }
            return true;
           
    }
  }
}
