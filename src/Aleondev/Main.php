<?php

 namespace Aleondev;

 use pocketmine\utils\TextFormat as TF;
 use pocketmine\plugin\PluginBase;
 use pocketmine\plugin\Plugin;
 use pocketmine\command\Command;
 use pocketmine\command\CommandSender;
 use pocketmine\command\CommandExecutor; 
 use pocketmine\command\ConsoleCommandSender; 
 use pocketmine\Player;
 use pocketmine\Server;
 use pocketmine\utils\Config;
 use jojoe77777\FormAPI;
 use DateTime;
 use pocketmine\level\particle\FlameParticle;
 use pocketmine\math\Vector3;
 use pocketmine\event\player\PayerJoinEvent;
 use pocketmine\event\player\PlayerQuitEvent;
 use onebone\economyapi\EconomyAPI;
 use pocketmine\level\Position;


 class Main extends PluginBase {


    public $config;

   public function onEnable(){
       $this->saveResource("config.yml");
       $this->config = new Config($this->getDataFolder() . "config.yml", Config::YAML);
   }
	 
	 public function onJoin(PlayerJoinEvent $event){
		 $event->setJoinMessage("§a[+]");
	 }
	 
	 public function onQuit(PlayerQuitEvent $event){
		 $event->setQuitMessage("§c[-]");
	 }

   public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args): bool {
       if ($cmd->getName() == "tpall") {
        if ($sender instanceof Player) {
            if ($sender->hasPermission("tpall.core")) {
             foreach ($this->getServer()->getOnlinePlayers() as $player) {
             $x = $sender->getX();
             $y = $sender->getY();
             $z = $sender->getZ();
             $level = $sender->getLevel();
             $name = $sender->getName();
             $player->teleport(new Position($x, $y, $z, $level));
         
             } 
             $sender->sendMessage("§eCore §4Du hast alle zu dir Teleportiert!");
             $this->getServer()->broadcastMessage($this->getConfig()->get("tpall"));
            } else {
             $sender->sendMessage("§eCore §4Für diesen Command hast du keine Rechte!");
         }
        } else {
         $sender->sendMessage("§eCore §eDu kannst diesen Command nur InGame ausführen");
     }
     return true;
    }
    if($cmd->getName() === "tpohere"){
     if($sender instanceof Player){
         if ($sender->hasPermission("tpohere.cmd")) {
         if(isset($args[0])){
             $player = $this->getServer()->getPlayer($args[0]);
             if($player instanceof Player){
                 $x = $sender->getX();
                 $y = $sender->getY();
                 $z = $sender->getZ();
                 $level = $sender->getLevel();
                 $tpnam = $player;
                 $player8 = $sender->getName();
                 $player->teleport(new Position($x, $y, $z, $level));
                 $sender->sendMessage("§eCore §4Du hast $player zu dir Teleportiert!");
                 $player->sendMessage("§eCore §4 Du wurdest zur $player8 Teleportiert!");
                 return true;
             } else {
                 $sender->sendMessage("§eCore §4Dieser Spieler ist nicht Online!");
             }
         } else {
             $sender->sendMessage("§eCore §c Du musst §e/tpohere {playername}§c!");
         }
         } else {
             $sender->sendMessage("§eCore §eFür diesen Coommand hast du keine Rechte!");
         }
     } else {
         $sender->sendMessage("§eCore §eDu kannst diesen Command nur InGame ausführen");
     }
     return true;
 }
 
 if ($cmd->getName() == "tag") {
    if ($sender instanceof Payer) {
	if ($sender->hasPermission("tag.core")) {
	    $sender->getLevel()->setTime(6000);
	    $sender->sendMessage($this->getConfig()->get("tag"));
	}else{
            $sender->sendMessage("§cKeine Rechte");
	}
    }else{
	    $sender->getLevel()->setTime(6000);
	    $sender->sendMessage($this->getConfig()->get("tag"));
    }
    return true;
 }
	    	   
 if ($cmd->getName() == "nacht") {
    if ($sender instanceof Payer) {
	if ($sender->hasPermission("nacht.core")) {
	    $sender->getLevel()->setTime(16000);
	    $sender->sendMessage($this->getConfig()->get("nacht"));
	}else{
            $sender->sendMessage("§cKeine Rechte");
	}
    }else{
	    $sender->getLevel()->setTime(16000);
	    $sender->sendMessage($this->getConfig()->get("nacht"));
    }
    return true;
 }
	   
 if ($cmd->getName() == "flyon") {
    if ($sender instanceof Payer) {
	if ($sender->hasPermission("flyon.core")) {
	    $sender->setAllowFlight(true);
	    $sender->sendMessage($this->getConfig()->get("flyon"));
	}else{
            $sender->sendMessage("§cKeine Rechte");
	}
    }else{
	    $sender->setAllowFlight(true);
	    $sender->sendMessage($this->getConfig()->get("flyon"));
    }
    return true;
 }
	   
 if ($cmd->getName() == "flyoff") {
    if ($sender instanceof Payer) {
	if ($sender->hasPermission("flyoff.core")) {
	    $sender->setAllowFlight(false);
	    $sender->sendMessage($this->getConfig()->get("flyoff"));
	}else{
            $sender->sendMessage("§cKeine Rechte");
	}
    }else{
	    $sender->setAllowFlight(false);
	    $sender->sendMessage($this->getConfig()->get("flyoff"));
    }
    return true;
 }
	   
 if ($cmd->getName() == "gm") {
    if ($sender instanceof Player) {
        if ($sender->hasPermission("gm.core")) {
            if(!isset($args[0]) || count($args) < 1) {
                $sender->sendMessage($this->getConfig()->get("gm"));
                return true;
            }
            switch(strtolower($args[0])) {
            case "0":
            if(isset($args[1])){
                $target = $this->getServer()->getPlayer($args[1]);
                if($target instanceof Player){
                    $targetgm = $target;
                    $tgname = $targetgm->getName();
                    $player = $sender->getName();
                    $target->setGamemode(0);
                    $sender->sendMessage($this->getConfig()->get("gm0"));
                    $this->getLogger()->warning("§4 $player hat $tgname sein Spielmodus auf §eGamemode 0 §4gesetzt!");
                    return true;
                } else {
                    $sender->sendMessage("§eCore §4Dieser Spieler ist nicht Online!");
                }
            } else {
                $player = $sender->getName();
                $sender->setGamemode(0);
                $sender->sendMessage($this->getConfig()->get("gm0"));
                $this->getLogger()->warning("§4 $player hat sein Spielmodus auf §eGamemode 0 §4gesetzt!");
                return true;
            }
              break;

              
            case "1":
            if(isset($args[1])){
                $target = $this->getServer()->getPlayer($args[1]);
                if($target instanceof Player){
                    $targetgm = $target;
                    $player = $sender->getName();
                    $tname = $targetgm->getName();
                    $target->setGamemode(1);
                    $sender->sendMessage($this->getConfig()->get("gm1"));
                    $this->getLogger()->warning("§4 $player hat $tname sein Spielmodus auf §eGamemode 1 §4gesetzt!");
                    return true;
                } else {
                    $sender->sendMessage("§eCore §4Dieser Spieler ist nicht Online!");
                }
            } else {
                $player = $sender->getName();
                $sender->setGamemode(1);
                $sender->sendMessage($this->getConfig()->get("gm1"));
                $this->getLogger()->warning("§4 $player hat sein Spielmodus auf §eGamemode 1 §4gesetzt!");
                return true;
            }
           
              break;

              case "3":
              if(isset($args[1])){
                $target = $this->getServer()->getPlayer($args[1]);
                if($target instanceof Player){
                    $targetgm = $target;
                    $player = $sender->getName();                    
		    $tname = $targetgm->getName();
                    $target->setGamemode(3);
                    $sender->sendMessage($this->getConfig()->get("gm3"));
                    $this->getLogger()->warning("§4 $player hat $tname sein Spielmodus auf §eGamemode 3 §4gesetzt!");
                    return true;
                } else {
                    $sender->sendMessage("§eCore §4Dieser Spieler ist nicht Online!");
                }
            } else {
                $player = $sender->getName();
                $sender->setGamemode(3);
                $sender->sendMessage($this->getConfig()->get("gm3"));
                $this->getLogger()->warning("§4 $player hat sein Spielmodus auf §eGamemode 3 §4gesetzt!");
                return true;
            }
              return true;
           
              break;

              case "2":
              if(isset($args[1])){
                $target = $this->getServer()->getPlayer($args[1]);
                if($target instanceof Player){
                    $targetgm = $target;
                    $tname = $targetgm->getName();
                    $player = $sender->getName();
                    $target->setGamemode(2);
                    $sender->sendMessage($this->getConfig()->get("gm2"));
                    $this->getLogger()->warning("§4 $player hat $tname sein Spielmodus auf §eGamemode 2 §4gesetzt!");
                    return true;
                } else {
                    $sender->sendMessage("§eCore §4Dieser Spieler ist nicht Online!");
                }
            } else {
                $player = $sender->getName();
                $sender->setGamemode(2);
                $sender->sendMessage($this->getConfig()->get("gm2"));
                $this->getLogger()->warning("§4 $player hat sein Spielmodus auf §eGamemode 2 §4gesetzt!");
                return true;
            }
              return true;
           
              break;

            }
        } else {
            $sender->sendMessage("§eCore §eFür diesen Command hast du keine Rechte!");
        }
    } else {
            $sender->sendMessage("§eCore §4Du kannst diesen Command nur InGame ausführen");
    }
 }
 
   }
	 
 }
