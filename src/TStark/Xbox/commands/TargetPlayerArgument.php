<?php
declare(strict_types=1);

namespace TStark\Xbox\commands;

use pocketmine\command\CommandSender;
use pocketmine\network\mcpe\protocol\AvailableCommandsPacket;
use function preg_match;

class TargetPlayerArgument {

    public function getTypeName(): string {
        return "target";
    }

    public function getNetworkType(): int {
        return AvailableCommandsPacket::ARG_TYPE_TARGET;
    }

    public function canParse(string $testString, CommandSender $sender): bool {
        return (bool) preg_match("/^(?!rcon|console)[a-zA-Z0-9_ ]{1,16}$/i", $testString);
    }

    public function parse(string $argument, CommandSender $sender): mixed {
        return $argument;
    }
}
