<?php

namespace App\Services;

final class AnimalCatalog
{
    public static function all(): array
    {
        $names = ['Avestruz', 'Águia', 'Burro', 'Borboleta', 'Cachorro', 'Cabra', 'Carneiro', 'Camelo', 'Cobra', 'Coelho', 'Cavalo', 'Elefante', 'Galo', 'Gato', 'Jacaré', 'Leão', 'Macaco', 'Porco', 'Pavão', 'Peru', 'Touro', 'Tigre', 'Urso', 'Veado', 'Vaca'];
        $icons = ['🪶', '🦅', '🫏', '🦋', '🐕', '🐐', '🐏', '🐪', '🐍', '🐇', '🐎', '🐘', '🐓', '🐈', '🐊', '🦁', '🐒', '🐖', '🦚', '🦃', '🐂', '🐅', '🐻', '🦌', '🐄'];
        return array_map(fn ($index) => ['group' => $index + 1, 'name' => $names[$index], 'icon' => $icons[$index],
            'numbers' => array_map(fn ($n) => sprintf('%02d', $n % 100), range($index * 4 + 1, $index * 4 + 4))], range(0, 24));
    }

    public static function prize(int $position, string $number): array
    {
        $ending = (int) substr($number, -2);
        $group = $ending === 0 ? 25 : (int) ceil($ending / 4);
        $animal = self::all()[$group - 1];
        return ['position' => $position, 'number' => $number, 'group' => $group, 'animal' => $animal['name'], 'icon' => $animal['icon']];
    }
}
