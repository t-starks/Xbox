<?php

namespace TStark\Xbox;

use TStark\Xbox\commands\XboxProfileCommand;
use TStark\Xbox\tasks\GetInfoTask;
use pocketmine\Server;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase {

    public function onEnable(): void {
        $this->getServer()->getCommandMap()->register($this->getName(), new XboxProfileCommand($this, "xboxprofile", "View player's Xbox profile", ["xp"]));
    }

    public static function xboxProfileForm(Player $player, string $gt): void {
        $gt_nospace = str_replace(' ', '%20', $gt);
        Server::getInstance()->getAsyncPool()->submitTask(new GetInfoTask($gt_nospace, function (int $results, array $data, ?string $error = null) use ($player, $gt) {      
            if ($data["code"] !== "player.found") {
                $player->sendMessage("§cError, there is no Xbox gamertag called: " . $gt);
                return;
            }
            
            $xProfile = (
                "§aUserName: §f" . $data["data"]["player"]["username"] . "\n" .
                "§aId: §f" . $data["data"]["player"]["id"] . "\n" .
                "§aGamerScore: §f" . $data["data"]["player"]["meta"]["gamerscore"] . "\n" .
                "§aAccountTier: §f" . $data["data"]["player"]["meta"]["accountTier"] . "\n" .    
                "§aXboxOneRep: §f" . $data["data"]["player"]["meta"]["xboxOneRep"] . "\n" .
                "§aRealName: §f" . $data["data"]["player"]["meta"]["realName"] . "\n" .
                "§aBio: §f" . $data["data"]["player"]["meta"]["bio"] . "\n"
            );

            $form = new SimpleForm(function (Player $player, $data) {
                if ($data === null) {
                    return true;
                }
            });
            $form->setTitle("§2Xbox Profile");
            $form->setContent($xProfile);
            $form->addButton("§bOK");
            $player->sendForm($form);
        }));
    }
}
