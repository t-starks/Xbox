<?php

namespace TStark\Xbox;

use pocketmine\form\Form;
use pocketmine\player\Player;

class SimpleForm implements Form {

    private string $title = "";
    private string $content = "";
    private array $buttons = [];
    private $callback;

    public function __construct(callable $callback) {
        $this->callback = $callback;
    }

    public function setTitle(string $title): void {
        $this->title = $title;
    }

    public function setContent(string $content): void {
        $this->content = $content;
    }

    public function addButton(string $text): void {
        $this->buttons[] = ["text" => $text];
    }

    public function handleResponse(Player $player, $data): void {
        call_user_func($this->callback, $player, $data);
    }

    public function jsonSerialize(): array {
        return [
            "type" => "form",
            "title" => $this->title,
            "content" => $this->content,
            "buttons" => $this->buttons
        ];
    }
}
