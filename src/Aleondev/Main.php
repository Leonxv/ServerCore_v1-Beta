<?php

namespace Aleondev;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\level\Position;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat as TF;


class Main extends PluginBase {

    public $config;

    public function onEnable() {
        $this->getLogger()->info(TF::GREEN . "Das core plugin wurde erfolgreich geladen\nby Aleondev!");
        $this->saveResource("core.yml");
        $this->config = new Config($this->getDataFolder() . "core.yml", Config::YAML);
    }

    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args): bool {
        if ($cmd->getName() == "payall") {
            if ($sender->hasPermission("payall.core")) {
                $zahl = $args[0];
                foreach ($this->getServer()->getOnlinePlayers() as $player) {
                    $this->getServer()->getPluginManager()->getPlugin("EconomyAPI")->addMoney($player, $zahl);
                    $player->sendMessage("§eCore §b$sender §4hat ein Money Drop gemacht!.");
                }
                $sender->sendMessage("§eCore §b$player §4du hast nun §b$zahl §4an jeden gepayt");
            } else {
                $sender->sendMessage("§eCore §4Du hast keine Rechte um diesen befehl zu benutzen");
            }
        }

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
                    $this->getServer()->broadcastMessage("§7(§c!§7) §4§e$name §4hat jeden zu ihn Teleportiert!");
                } else {
                    $sender->sendMessage("§eCore §4Für diesen Command hast du keine Rechte!");
                }
            } else {
                $sender->sendMessage("§eCore §eDu kannst diesen Command nur InGame ausführen");
            }
            return true;
        }

        if(strtolower($cmd->getName()) == "fly") {
            if($sender instanceof Player) {
                if($this->isPlayer($sender)) { // TODO: make function
                    if ($sender->hasPermission("fly.core")) {
                        $this->removePlayer($sender); // TODO: make function
                        $sender->setAllowFlight(false);
                        $sender->sendMessage("§eCore §b >> §4Fly ist §cDisable");
                        $sender->addTitle("§eCore\n§cFly Ist Disable\n§eCore §aBy Aleondev");
                        return true;
                    }
                    else{
                        $this->addPlayer($sender); // TODO: make function
                        $sender->setAllowFlight(true);
                        $sender->sendMessage("§eCore §b >> §4Fly Ist §aEnable");
                        $sender->addTitle("§eCore\n§4Fly Ist §aEnable\n§eCore §aBy Aleondev");
                        return true;
                    }
                }
                else{
                    $sender->sendMessage("§eCore §b >> §4Fly Ist §cDisable");
                    $sender->addTitle("§eCore\n§4Fly Ist §cDisable\n§eCore §aBy Aleondev");
                    return true;
                }
            }
        }

        if($cmd->getName() === "tpohere"){
            if($sender instanceof Player){
                if ($sender->hasPermission("tpohere.cmd")) {
                    if(isset($args[0])){
                        $player = $this->getServer()->getPlayer($args[0]);
                        if($player instanceof Player) {
                            $x = $sender->getX();
                            $y = $sender->getY();
                            $z = $sender->getZ();
                            $level = $sender->getLevel();
                            $tpname = $player->getName();
                            $player8 = $sender->getName();
                            $player->teleport(new Position($x, $y, $z, $level));
                            $sender->sendMessage("§eCore §4Du hast $tpname zu dir Teleportiert!");
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

        if ($cmd->getName() == "g") {
            if ($sender instanceof Player) {
                if ($sender->hasPermission("g.core")) {
                    if(!isset($args[0]) || count($args) < 1) {
                        $sender->sendMessage("§eCore: §4/g < s | c | spec | a >");
                        return true;
                    }
                    switch(strtolower($args[0])) {
                        case "s":
                            if(isset($args[1])){
                                $target = $this->getServer()->getPlayer($args[1]);
                                if($target instanceof Player){
                                    $targetgm = $target;
                                    $tgname = $targetgm->getName();
                                    $player = $sender->getName();
                                    $target->setGamemode(0);
                                    $sender->sendMessage("§eCore Du hast §e$tgname  §4Spielmodus auf §eGamemode 0 §4gesetzt! ");
                                    $target->sendMessage("§eCore §e$player §4hat dein Spielmodus auf §eGamemode 0 §4gesetzt!");
                                    $this->getLogger()->warning("§4 $player hat $tgname sein Spielmodus auf §eGamemode 0 §4gesetzt!");
                                    return true;
                                } else {
                                    $sender->sendMessage("§eCore §4Dieser Spieler ist nicht Online!");
                                }
                            } else {
                                $player = $sender->getName();
                                $sender->setGamemode(0);
                                $sender->sendMessage("§eCore §4Du hast dein Spielmodus auf §eGamemode 0 §4gesetzt!");
                                $this->getLogger()->warning("§4 $player hat sein Spielmodus auf §eGamemode 0 §4gesetzt!");
                                return true;
                            }
                        break;


                        case "c":
                            if(isset($args[1])){
                                $target = $this->getServer()->getPlayer($args[1]);
                                if($target instanceof Player){
                                    $targetgm = $target;
                                    $player = $sender->getName();
                                    $tname = $targetgm->getName();
                                    $target->setGamemode(1);
                                    $sender->sendMessage("§eCore §4Du hast §e$tname  §4Spielmodus auf §eGamemode 1 §4gesetzt! ");
                                    $target->sendMessage("§eCore §e$player §7hat dein Spielmodus auf §eGamemode 1 §4gesetzt!");
                                    $this->getLogger()->warning("§4 $player hat $tname sein Spielmodus auf §eGamemode 1 §4gesetzt!");
                                    return true;
                                } else {
                                    $sender->sendMessage("§eCore §4Dieser Spieler ist nicht Online!");
                                }
                            } else {
                                $player = $sender->getName();
                                $sender->setGamemode(1);
                                $sender->sendMessage("§eCore §4Du hast dein Spielmodus auf §eGamemode 1 §4gesetzt!");
                                $this->getLogger()->warning("§4 $player hat sein Spielmodus auf §eGamemode 1 §4gesetzt!");
                                return true;
                            }

                        break;

                        case "spec":
                            if(isset($args[1])){
                                $target = $this->getServer()->getPlayer($args[1]);
                                if($target instanceof Player){
                                    $targetgm = $target;
                                    $player = $sender->getName();                    $tname = $targetgm->getName();
                                    $target->setGamemode(3);
                                    $sender->sendMessage("§eCore §4Du hast §e$tname  §4Spielmodus auf §eGamemode 3 §4gesetzt! ");
                                    $target->sendMessage("§e$player §4hat dein Spielmodus auf §eGamemode 3 §4gesetzt!");
                                    $this->getLogger()->warning("§4 $player hat $tname sein Spielmodus auf §eGamemode 3 §4gesetzt!");
                                    return true;
                                } else {
                                    $sender->sendMessage("§eCore §4Dieser Spieler ist nicht Online!");
                                }
                            } else {
                                $player = $sender->getName();
                                $sender->setGamemode(3);
                                $sender->sendMessage("§eCore §4Du hast dein Spielmodus auf §eGamemode 3 §4gesetzt!");
                                $this->getLogger()->warning("§4 $player hat sein Spielmodus auf §eGamemode 3 §4gesetzt!");
                                return true;
                            }
                            return true;

                        break;

                        case "a":
                            if(isset($args[1])){
                                $target = $this->getServer()->getPlayer($args[1]);
                                if($target instanceof Player){
                                    $targetgm = $target;
                                    $tname = $targetgm->getName();
                                    $player = $sender->getName();
                                    $target->setGamemode(2);
                                    $sender->sendMessage("§eCore §4 Du hast §e$tname  §4Spielmodus auf §eGamemode 2 §4gesetzt! ");
                                    $target->sendMessage("§eCore §e$player §4hat dein Spielmodus auf §eGamemode 2 §4gesetzt!");
                                    $this->getLogger()->warning("§4 $player hat $tname sein Spielmodus auf §eGamemode 2 §4gesetzt!");
                                    return true;
                                } else {
                                    $sender->sendMessage("§eCore §4Dieser Spieler ist nicht Online!");
                                }
                            } else {
                                $player = $sender->getName();
                                $sender->setGamemode(2);
                                $sender->sendMessage("§eCore §4 Du hast dein Spielmodus auf §eGamemode 2 §4gesetzt!");
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
