<?php 

namespace TStark\Xbox\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use TStark\Xbox\Main;

class XboxProfileCommand extends Command {
    
    private $plugin;

    public function __construct(Main $plugin, string $name, string $description, array $aliases = []) {
        parent::__construct($name, $description, null, $aliases);
        $this->plugin = $plugin;
        $this->setPermission("xbox.command.profile");
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

        // Utilizar el argumento TargetPlayerArgument
        $targetPlayerArgument = new TargetPlayerArgument();
        if (!$targetPlayerArgument->canParse($args[0], $sender)) {
            $sender->sendMessage("Invalid player name. Please use a valid player name.");
            return;
        }

        Main::xboxProfileForm($sender, $targetPlayerArgument->parse($args[0], $sender));
    }
}
