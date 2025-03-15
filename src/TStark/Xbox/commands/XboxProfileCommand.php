<?php

namespace TStark\Xbox\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\plugin\PluginOwned;
use pocketmine\plugin\PluginOwnedTrait;

use TStark\Xbox\Main;

class XboxProfileCommand extends Command implements PluginOwned {

    use PluginOwnedTrait;

    public function __construct(Main $plugin, string $name, string $description, array $aliases = []) {
        parent::__construct($name, $description, null, $aliases);
        $this->setPermission("xbox.command.profile");
        $this->owningPlugin = $plugin;
    }

    public function execute(CommandSender $sender, string $label, array $args): void {
        if (!$sender instanceof Player) {
            $sender->sendMessage("Use this command in-game");
            return;
        }
        if (count($args) < 1) {
            $sender->sendMessage("Usage: /xboxprofile <player>");
            return;    
        }

        $plugin = $this->getOwningPlugin();
        if ($plugin instanceof Main) {
            $plugin->xboxProfileForm($sender, $args[0]);
        } else {
            $sender->sendMessage("§cError: Plugin instance is invalid.");
        }
    }
}
