<?php
/**
 * Created by PhpStorm.
 * User: RTG
 * Date: 3/5/2019
 * Time: 6:29 PM
 *
 * .___   ________
 * |   | /  _____/
 * |   |/   \  ___
 * |   |\    \_\  \
 * |___| \______  /
 *              \/
 *
 * All rights reserved InspectorGadget (c) 2019
 * Anyone is allowed to redistribute, and/or modify!
 */

namespace InspectorGadget\NickPE;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat as TF;
use pocketmine\Player;

class Loader extends PluginBase {

    const PREFIX = "[NickPE] ";

    public function onEnable(): void {
        if ($this->doesDependencyExist()) {
            $this->getLogger()->info("Found PurePerms and PureChat, extending NickPE...");
        } else {
            $this->getLogger()->info("PurePerms and PureChat is missing, additional features has been disabled");
        }
    }

    public function doesDependencyExist(): bool {
        return ($this->getServer()->getPluginManager()->getPlugin('PurePerms') && $this->getServer()->getPluginManager()->getPlugin('PurePerms')) ? "true" : "false";
    }

    public function applyColors($string)
    {
        $string = str_replace("&0", TF::BLACK, $string);
        $string = str_replace("&1", TF::DARK_BLUE, $string);
        $string = str_replace("&2", TF::DARK_GREEN, $string);
        $string = str_replace("&3", TF::DARK_AQUA, $string);
        $string = str_replace("&4", TF::DARK_RED, $string);
        $string = str_replace("&5", TF::DARK_PURPLE, $string);
        $string = str_replace("&6", TF::GOLD, $string);
        $string = str_replace("&7", TF::GRAY, $string);
        $string = str_replace("&8", TF::DARK_GRAY, $string);
        $string = str_replace("&9", TF::BLUE, $string);
        $string = str_replace("&a", TF::GREEN, $string);
        $string = str_replace("&b", TF::AQUA, $string);
        $string = str_replace("&c", TF::RED, $string);
        $string = str_replace("&d", TF::LIGHT_PURPLE, $string);
        $string = str_replace("&e", TF::YELLOW, $string);
        $string = str_replace("&f", TF::WHITE, $string);
        $string = str_replace("&k", TF::OBFUSCATED, $string);
        $string = str_replace("&l", TF::BOLD, $string);
        $string = str_replace("&m", TF::STRIKETHROUGH, $string);
        $string = str_replace("&n", TF::UNDERLINE, $string);
        $string = str_replace("&o", TF::ITALIC, $string);
        $string = str_replace("&r", TF::RESET, $string);
        return $string;
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool {
        switch(strtolower($command->getName())) {
            case "nick":
                if (!$sender instanceof Player) {
                    $sender->sendMessage("In-game!");
                    return true;
                }

                if (!isset($args[0])) {
                    $sender->sendMessage(TF::GREEN . "[Usage] /nick <set | reset>");
                    return true;
                }

                switch(strtolower($args[0])) {
                    case "set":
                        if (!isset($args[1])) {
                            $sender->sendMessage(TF::GREEN . "[Usage] /nick set <nickname>");
                            return true;
                        }

                        $sender->setNameTag("~ {$this->applyColors($args[1])}");
                        $sender->setDisplayName("~ {$this->applyColors($args[1])}");
                        $sender->sendMessage(TF::GREEN . self::PREFIX . "Your nickname has been updated to {$this->applyColors($args[1])}");
                        return true;
                    break;
                    case "reset":
                        if (!isset($args[1])) {
                            $sender->setNameTag($sender->getName());
                            $sender->setDisplayName($sender->getName());
                            $sender->sendMessage(TF::GREEN . self::PREFIX . "Your Nickname has been reset!");
                            return true;
                        }

                        $player = $this->getServer()->getPlayer($args[1]);

                        if ($player instanceof Player) {
                            $player->setNameTag($player->getName());
                            $player->setDisplayName($player->getName());
                            $player->sendMessage(TF::RED . self::PREFIX . "Your Nick has been reset!");
                            $sender->sendMessage(TF::GREEN . self::PREFIX . "You have reset {$args[1]}'s Nickname!");
                            return true;
                        }

                        $sender->sendMessage(TF::RED . self::PREFIX . "Player {$args[1]} does not exist!");
                        return true;
                    break;
                }
                return true;
            break;
        }
    }


    public function onDisable(): void { }

}